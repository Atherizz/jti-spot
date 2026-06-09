<?php

use App\Console\Commands\SimulateCheckin;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Room;
use App\Models\RoomClaim;
use App\Models\Schedule as ScheduleModel;
use App\Models\ScheduleCancellation;
use App\Services\WhatsAppNotificationService;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {

    $now = Carbon::now();

    $logAndPrint = function ($message) {
        Log::info($message);
        echo "   -> " . $message . PHP_EOL;
    };

    // Run only during class hours (07:00 - 18:59)
    if ($now->hour >= 7 && $now->hour <= 18 && $now->isWeekday()) {
        $currentDay = $now->dayOfWeek;

        // Cleanup expired quorum extensions
        Room::whereNotNull('quorum_extended_until')
            ->where('quorum_extended_until', '<=', $now)
            ->update(['quorum_extended_until' => null]);

        // Get today's schedules
        $schedulesToday = ScheduleModel::where('day_of_week', $currentDay)
            ->select('id', 'room_id', 'start_time', 'end_time')
            ->get();

        // Get today's cancellations
        $cancellationsToday = ScheduleCancellation::where('cancellation_date', $now->toDateString())
            ->pluck('schedule_id')
            ->toArray();

        $claimsToday = RoomClaim::where('claim_date', $now->toDateString())
            ->whereIn('status', ['pending_quorum', 'locked'])
            ->get();

        // Arrays to group rooms by target current_status
        $toWaiting = [];
        $toCancelQuorum = [];
        $toAvailable = [];

        // Process schedules in memory
        foreach ($schedulesToday as $schedule) {

            // Check if this schedule is cancelled today
            $isCancelled = in_array($schedule->id, $cancellationsToday);

            if ($isCancelled) {
                // Check if another class has claimed this room at this time
                $hasClaim = $claimsToday->first(function ($claim) use ($schedule, $now) {
                    return $claim->room_id === $schedule->room_id
                        && Carbon::parse($claim->start_time) <= $now
                        && Carbon::parse($claim->end_time) >= $now;
                });

                if (!$hasClaim) {
                    // No claim exists, make room available immediately
                    array_push($toAvailable, $schedule->room_id);
                    continue; // Skip normal schedule processing
                }
                // If claim exists, let it be processed by claimsToday loop below
                continue;
            }

            // Normal schedule processing (not cancelled)
            $startTime = Carbon::parse($schedule->start_time);
            $endTime = Carbon::parse($schedule->end_time);
            $limitQuorumTime = $startTime->copy()->addMinutes(15);

            // Class ended
            if ($now >= $endTime) {
                array_push($toAvailable, $schedule->room_id);
            }
            // Waiting for quorum
            else if ($now >= $startTime && $now <= $limitQuorumTime) {
                array_push($toWaiting, $schedule->room_id);
            }
            // Quorum failed
            else if ($now > $limitQuorumTime && $now < $endTime) {
                array_push($toCancelQuorum, $schedule->room_id);
            }
        }

        foreach ($claimsToday as $claim) {
            $claimEndTime = Carbon::parse($claim->end_time);
            $claimStartTime = Carbon::parse($claim->start_time);
            $limitClaimQuorumTime = $claimStartTime->copy()->addMinutes(15);

            if ($now >= $claimEndTime) {
                array_push($toAvailable, $claim->room_id);
                $claim->update(['status' => 'completed']);
            } else if ($claim->status === 'pending_quorum' && $now > $limitClaimQuorumTime) {
                array_push($toCancelQuorum, $claim->room_id);
                $claim->update(['status' => 'cancelled']);
            }
        }

        $activeClaimedRoomIds = RoomClaim::whereIn('status', ['pending_quorum', 'locked'])
            ->where('claim_date', $now->toDateString())
            ->whereTime('start_time', '<=', $now)
            ->whereTime('end_time', '>=', $now)
            ->pluck('room_id')
            ->toArray();

        $uniqueWaiting = array_unique($toWaiting);
        $uniqueCancel = array_unique($toCancelQuorum);
        $uniqueAvailable = array_unique($toAvailable);

        // Bulk update room status
        if (!empty($uniqueWaiting)) {
            Room::whereIn('id', $uniqueWaiting)
                ->where('current_status', 'available')
                ->update(['current_status' => 'waiting']);
            $logAndPrint('Cron: Rooms updated to [waiting] - IDs: ' . implode(', ', array_unique($uniqueWaiting)));
        }

        // Rooms with an active quorum extension (Kelas Terlambat) — excluded from both cancel and available paths
        $extendedRoomIds = Room::whereNotNull('quorum_extended_until')
            ->where('quorum_extended_until', '>', $now)
            ->pluck('id')
            ->toArray();

        if (!empty($uniqueCancel)) {
            // FILTER: Dont cancel rooms that actually have active claims, in waiting for another schedule, or have active extension
            $finalToCancel = array_diff($uniqueCancel, $activeClaimedRoomIds, $uniqueWaiting, $extendedRoomIds);

            Room::whereIn('id', array_unique($finalToCancel))
                ->where('current_status', 'waiting')
                ->update(['current_status' => 'available']);
            $logAndPrint('Cron: Rooms updated to [available] (quorum failed) - IDs: ' . implode(', ', array_unique($finalToCancel)));
        }

        if (!empty($uniqueAvailable)) {
            // FILTER: Dont make available rooms that are currently waiting for another schedule, have active claims, or have active extension
            $finalToAvailable = array_diff($uniqueAvailable, $activeClaimedRoomIds, $uniqueWaiting, $extendedRoomIds);

            Room::whereIn('id', $finalToAvailable)
                ->update(['current_status' => 'available']);
            $logAndPrint('Cron: Rooms updated to [available] (class ended) - IDs: ' . implode(', ', $finalToAvailable));
        }
    } else {
        $logAndPrint('Cron: Skipped (outside class hours/weekend).');
    }
})->everyMinute();

Schedule::call(function () {
    $service = app(WhatsAppNotificationService::class);
    $service->queueDueQuorumCriticalAlerts();
    $service->sendDueNotifications();
})->everyMinute();

// ── Simulation: auto check-in for rooms in [waiting] status ──────────
Schedule::command('simulation:checkin')
    ->everyMinute()
    ->when(fn () => (bool) env('SIMULATION_MODE', false));
