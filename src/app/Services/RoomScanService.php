<?php

namespace App\Services;

use App\Models\Room;
use App\Models\Schedule;
use App\Models\QuorumScan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class RoomScanService
{
    public function confirmScan($user, $qrToken) {
        return DB::transaction(function () use ($user, $qrToken) {
            // 2. Get user's class group
            $classGroup = $user->classGroup;
            
            if (!$classGroup) {
                throw new \Exception('Kelas tidak ditemukan!');
            }

            // 3. Get room from qr_token
            $room = Room::where('qr_token', $qrToken)->lockForUpdate()->first();
            
            if (!$room) {
                throw new \Exception('QR Code tidak valid atau ruangan tidak ditemukan!');
            }
            
            // 5. Check if schedule matches current time
            $now = Carbon::now();
            $currentDay = $now->dayOfWeek; // 0 = Sunday, 1 = Monday, etc
            $currentTime = $now->format('H:i:s');
            $currentDate = $now->format('Y-m-d');

            // Bypass flag for development
            $bypassScheduleValidation = env('BYPASS_SCHEDULE_VALIDATION', false);

            // Find schedule matching class, room, day, and current time
            $schedule = Schedule::where('room_id', $room->id)
                ->where('class_group_id', $classGroup->id)
                ->where('day_of_week', $currentDay)
                ->where('start_time', '<=', $currentTime)
                ->where('end_time', '>=', $currentTime)
                ->first();

    
            if (!$schedule) {
                // If bypass is enabled, get any schedule for this room and class
                if ($bypassScheduleValidation) {
                    $schedule = Schedule::where('room_id', $room->id)
                        ->where('class_group_id', $classGroup->id)
                        ->first();
                }
                
                // If still no schedule found, return error
                if (!$schedule) {
                    throw new \Exception('Tidak ada jadwal kuliah untuk kelas Anda di ruangan ini pada waktu sekarang!');
                }
            }

            // Check if user already scanned today for this schedule
            $existingScan = QuorumScan::where('user_id', $user->id)
                ->where('schedule_id', $schedule->id)
                ->where('scanned_date', $currentDate)
                ->first();

            if ($existingScan) {
                throw new \Exception('Anda sudah melakukan scan untuk jadwal ini hari ini!');
            }

            // 6. Count current quorum scans for this schedule
            $quorumCount = QuorumScan::where('schedule_id', $schedule->id)
                ->where('scanned_date', $currentDate)
                ->count();

            // 7. Insert scan data to database
            $quorumScan = QuorumScan::create([
                'user_id' => $user->id,
                'room_id' => $room->id,
                'schedule_id' => $schedule->id,
                'claim_id' => null, 
                'scanned_date' => $currentDate,
                'scanned_at' => $now,
            ]);

            // Recalculate quorum after insert
            $newQuorumCount = $quorumCount + 1;


            // Update room status to 'occupied' if quorum is reached
            $quorumSize = env('QUORUM_SIZE', 5);
            if ($newQuorumCount >= $quorumSize && $room->current_status !== 'occupied') {
                $room->update(['current_status' => 'occupied']);
            }

            return true;
        } 
        );
       
    }
}
