<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Room;
use App\Models\RoomClaim;
use App\Models\Schedule as ScheduleModel;

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

        // Get today's schedules
        $schedulesToday = ScheduleModel::where('day_of_week', $currentDay)
            ->select('id', 'room_id', 'start_time', 'end_time')
            ->get();

        $claimsToday = RoomClaim::where('claim_date', $now->toDateString())
            ->whereIn('status', ['pending_quorum', 'locked'])
            ->get();

        // Arrays to group rooms by target current_status
        $toWaiting = [];
        $toCancelQuorum = [];
        $toAvailable = [];

        // Process schedules in memory
        foreach ($schedulesToday as $schedule) {

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

        // Bulk update room status
        if (!empty($toWaiting)) {
            Room::whereIn('id', array_unique($toWaiting))
                ->where('current_status', 'available')
                ->update(['current_status' => 'waiting']);
            $logAndPrint('Cron: Rooms updated to [waiting] - IDs: ' . implode(', ', array_unique($toWaiting)));
        }

        if (!empty($toCancelQuorum)) {

            $finalToCancel = array_diff(array_unique($toCancelQuorum), $activeClaimedRoomIds);

            Room::whereIn('id', array_unique($finalToCancel))
                ->where('current_status', 'waiting')
                ->update(['current_status' => 'available']);
            $logAndPrint('Cron: Rooms updated to [available] (quorum failed) - IDs: ' . implode(', ', array_unique($finalToCancel)));
        }

        if (!empty($toAvailable)) {
            $finalToAvailable = array_diff(array_unique($toAvailable), $activeClaimedRoomIds);

            Room::whereIn('id', $finalToAvailable)
                ->update(['current_status' => 'available']);
            $logAndPrint('Cron: Rooms updated to [available] (class ended) - IDs: ' . implode(', ', $finalToAvailable));
        }
    } else {
        $logAndPrint('Cron: Skipped (outside class hours/weekend).');
    }
})->everyMinute();
