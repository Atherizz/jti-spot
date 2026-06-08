<?php

namespace App\Console\Commands;

use App\DTOs\Logs\QuorumReachedMetadata;
use App\DTOs\Logs\ScanSuccessMetadata;
use App\Events\QuorumReached;
use App\Events\ScanAttempted;
use App\Models\QuorumScan;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SimulateCheckin extends Command
{
    protected $signature   = 'simulation:checkin';
    protected $description = 'Simulate student QR scan check-ins for rooms currently in [waiting] status';

    public function handle(): void
    {
        if (!env('SIMULATION_MODE', false)) {
            $this->line('SIMULATION_MODE is off — skipping.');
            return;
        }

        $now         = Carbon::now();
        $today       = $now->toDateString();
        $currentTime = $now->format('H:i:s');
        $quorumSize  = (int) env('QUORUM_SIZE', 5);

        $this->line("[{$now->format('H:i:s')}] simulation:checkin running...");

        $activeSchedules = Schedule::with(['room', 'classGroup.users'])
            ->where('day_of_week', $now->dayOfWeek)
            ->where('start_time', '<=', $currentTime)
            ->where('end_time', '>=', $currentTime)
            ->whereHas('room', fn ($q) => $q->where('current_status', 'waiting'))
            ->get();

        if ($activeSchedules->isEmpty()) {
            $this->line('  No rooms in [waiting] status — nothing to simulate.');
            return;
        }

        foreach ($activeSchedules as $schedule) {
            $room        = $schedule->room;
            $classGroup  = $schedule->classGroup;
            $courseName  = $schedule->course_name ?? 'Simulasi';
            $roomName    = $room->name;

            $existingCount = QuorumScan::where('schedule_id', $schedule->id)
                ->where('scanned_date', $today)
                ->count();

            if ($existingCount >= $quorumSize) {
                $this->line("  → Skip [{$courseName}] @ {$roomName}: already at quorum ({$existingCount}/{$quorumSize})");
                continue;
            }

            $needed = $quorumSize - $existingCount;

            $alreadyScannedIds = QuorumScan::where('schedule_id', $schedule->id)
                ->where('scanned_date', $today)
                ->pluck('user_id')
                ->all();

            $users = $classGroup->users()
                ->whereNotIn('id', $alreadyScannedIds)
                ->limit($needed)
                ->get();

            if ($users->isEmpty()) {
                $this->warn("  → [{$courseName}]: no eligible users left to simulate.");
                continue;
            }

            $inserted = 0;
            foreach ($users as $user) {
                QuorumScan::create([
                    'user_id'      => $user->id,
                    'room_id'      => $room->id,
                    'schedule_id'  => $schedule->id,
                    'claim_id'     => null,
                    'scanned_date' => $today,
                    'scanned_at'   => $now,
                ]);

                event(new ScanAttempted(
                    eventType: 'SCAN_SUCCESS',
                    metadata: new ScanSuccessMetadata(
                        user_name: $user->name,
                        room_name: $roomName,
                        subject_name: $courseName,
                    ),
                    user: $user,
                    roomId: $room->id,
                    scheduleId: $schedule->id,
                    claimId: null,
                    classGroupId: $classGroup->id,
                    qrToken: $room->qr_token,
                ));

                $inserted++;
            }

            $newTotal = $existingCount + $inserted;

            if ($newTotal >= $quorumSize) {
                $room->update(['current_status' => 'occupied']);

                event(new QuorumReached(
                    scheduleId: $schedule->id,
                    claimId: null,
                    classGroupId: $classGroup->id,
                    roomId: $room->id,
                    metadata: new QuorumReachedMetadata(
                        subject_name: $courseName,
                        room_name: $roomName,
                        quorum_count: $newTotal,
                    ),
                ));

                $this->info("  ✓ [{$courseName}] @ {$roomName}: {$newTotal}/{$quorumSize} scans → OCCUPIED");
            } else {
                $this->line("  ~ [{$courseName}] @ {$roomName}: {$inserted} scans added ({$newTotal}/{$quorumSize})");
            }
        }
    }
}
