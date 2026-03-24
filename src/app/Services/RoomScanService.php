<?php

namespace App\Services;

use App\Models\Room;
use App\Models\Schedule;
use App\Models\RoomClaim;
use App\Models\QuorumScan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Events\ScanAttempted;
use App\Events\QuorumReached;
use App\DTOs\Logs\ScanSuccessMetadata;
use App\DTOs\Logs\ScanFailedMetadata;
use App\DTOs\Logs\QuorumReachedMetadata;

class RoomScanService
{
    public function confirmScan($user, $qrToken)
    {
        try {
            return DB::transaction(function () use ($user, $qrToken) {
                // 2. Get user's class group
                $classGroup = $user->classGroup;

                if (!$classGroup) {
                    return $this->handleFailedScan($user, $qrToken, 'Kelas tidak ditemukan!');
                }

                // 3. Get room from qr_token
                $room = Room::where('qr_token', $qrToken)->lockForUpdate()->first();

                if (!$room) {
                    return $this->handleFailedScan($user, $qrToken, 'QR Code tidak valid atau ruangan tidak ditemukan!');
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

                if ($schedule) {

                }

                    // // If still no schedule found, return error
                    // if (!$schedule) {
                    //     if ($user->role == 'class_rep') {
                    //         // TODO: Initiate claim process for class rep if no schedule found
                    //     } else if ($user->role == 'student') {
                    //         // TODO: find room claims where class group is same, day is same 

                    //         // TODO: if there is no claim, return error about no schedule found
                    //     //  return $this->handleFailedScan($user, $qrToken, 'Tidak ada jadwal kuliah untuk kelas Anda di ruangan ini pada waktu sekarang!', $room->id);
                    // }
                    //     }
                       
                }

                // Check if user already scanned today for this schedule
                $existingScan = QuorumScan::where('user_id', $user->id)
                    ->where('schedule_id', $schedule->id)
                    ->where('scanned_date', $currentDate)
                    ->first();

                if ($existingScan) {
                    return $this->handleFailedScan($user, $qrToken, 'Anda sudah melakukan scan untuk jadwal ini hari ini!', $room->id, $schedule->id, $classGroup->id);
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
                $isQuorumReached = false;
                if ($newQuorumCount >= $quorumSize && $room->current_status !== 'occupied') {
                    $room->update(['current_status' => 'occupied']);
                    $isQuorumReached = true;
                }

                $subjectName = $schedule->course_name ?? 'Mata Kuliah';
                $roomName = $room->name ?? 'Ruangan';

                // Dispatch Success Event
                $metadata = new ScanSuccessMetadata(
                    user_name: $user->name,
                    room_name: $roomName,
                    subject_name: $subjectName
                );

                event(new ScanAttempted(
                    eventType: 'SCAN_SUCCESS',
                    metadata: $metadata,
                    user: $user,
                    roomId: $room->id,
                    scheduleId: $schedule->id,
                    classGroupId: $classGroup->id,
                    qrToken: $qrToken
                ));

                // Dispatch Quorum Reached Event if applicable
                if ($isQuorumReached) {
                    $quorumMetadata = new QuorumReachedMetadata(
                        subject_name: $subjectName,
                        room_name: $roomName,
                        quorum_count: $newQuorumCount
                    );

                    event(new QuorumReached(
                        scheduleId: $schedule->id,
                        classGroupId: $classGroup->id,
                        roomId: $room->id,
                        metadata: $quorumMetadata
                    ));
                }

                return [
                    'status' => 'success',
                    'message' => 'Scan berhasil! Kehadiran Anda telah tercatat',
                ];
            });
        } catch (\Exception $e) {
            return $this->handleFailedScan($user, $qrToken, $e->getMessage());
        }
    }

    private function processNormalAttendance($user, $schedule, $qrToken, $room, $classGroup) {
        // Check if user already scanned today for this schedule

                $now = Carbon::now();
                $currentDate = $now->format('Y-m-d');

                $existingScan = QuorumScan::where('user_id', $user->id)
                    ->where('schedule_id', $schedule->id)
                    ->where('scanned_date', $currentDate)
                    ->first();

                if ($existingScan) {
                    return $this->handleFailedScan($user, $qrToken, 'Anda sudah melakukan scan untuk jadwal ini hari ini!', $room->id, $schedule->id, $classGroup->id);
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
                $isQuorumReached = false;
                if ($newQuorumCount >= $quorumSize && $room->current_status !== 'occupied') {
                    $room->update(['current_status' => 'occupied']);
                    $isQuorumReached = true;
                }

                $subjectName = $schedule->course_name ?? 'Mata Kuliah';
                $roomName = $room->name ?? 'Ruangan';

                // Dispatch Success Event
                $metadata = new ScanSuccessMetadata(
                    user_name: $user->name,
                    room_name: $roomName,
                    subject_name: $subjectName
                );

                event(new ScanAttempted(
                    eventType: 'SCAN_SUCCESS',
                    metadata: $metadata,
                    user: $user,
                    roomId: $room->id,
                    scheduleId: $schedule->id,
                    classGroupId: $classGroup->id,
                    qrToken: $qrToken
                ));

                // Dispatch Quorum Reached Event if applicable
                if ($isQuorumReached) {
                    $quorumMetadata = new QuorumReachedMetadata(
                        subject_name: $subjectName,
                        room_name: $roomName,
                        quorum_count: $newQuorumCount
                    );

                    event(new QuorumReached(
                        scheduleId: $schedule->id,
                        classGroupId: $classGroup->id,
                        roomId: $room->id,
                        metadata: $quorumMetadata
                    ));
                }

                return [
                    'status' => 'success',
                    'message' => 'Scan berhasil! Kehadiran Anda telah tercatat',
                ];
    }

    private function initiateClaim($user, $qrToken, $originalScheduleId, $claimedScheduleId)
    {

        $room = Room::where('qr_token', $qrToken)->lockForUpdate()->first();
        if (!$room) return $this->handleFailedScan($user, $qrToken, 'QR Code tidak valid atau ruangan tidak ditemukan!');
        if ($room->current_status !== 'available') return $this->handleFailedScan($user, $qrToken, 'Ruangan sedang digunakan atau sudah diklaim kelas lain!');

        $originalSchedule = Schedule::find($originalScheduleId);
        if (!$originalSchedule) return $this->handleFailedScan($user, $qrToken, 'Jadwal asli tidak ditemukan!');

        $claimedSchedule = Schedule::find($claimedScheduleId);
        if (!$claimedSchedule) return $this->handleFailedScan($user, $qrToken, 'Jadwal yang diklaim tidak ditemukan!');

        $now = Carbon::now();

        if ($claimedSchedule->day_of_week !== $now->dayOfWeek) {
            return $this->handleFailedScan($user, $qrToken, 'Jadwal yang ingin diclaim tidak berada di hari yang sama dengan hari ini!');
        }

        if ($now < Carbon::parse($claimedSchedule->start_time)->addMinutes(15)) {
            return $this->handleFailedScan($user, $qrToken, 'Terlalu cepat! Tunggu 15 menit dari jam mulai jadwal asli untuk memastikan kelas kosong.');
        }

        if ($now >= Carbon::parse($claimedSchedule->end_time)) {
            return $this->handleFailedScan($user, $qrToken, 'Jadwal yang ingin diklaim sudah berakhir!');
        }

        $claim = RoomClaim::create([
            'room_id' => $room->id,
            'schedule_id' => $originalSchedule->id,
            'claimer_group_id' => $originalSchedule->class_group_id,
            'claimed_by_user_id' => $user->id,
            'claim_date' => $now->toDateString(),
            'start_time' => $now->format('H:i:s'),
            'end_time' => $claimedSchedule->end_time,
            'status' => 'pending_quorum',
        ]);

        return [
            'status' => 'success',
            'message' => 'Klaim berhasil! Ruangan telah diklaim dan menunggu kuorum.',
            'claim_id' => $claim->id,
        ];
    }

    private function handleFailedScan($user, $qrToken, $message, $roomId = null, $scheduleId = null, $classGroupId = null)
    {
        $metadata = new ScanFailedMetadata(
            user_name: $user->name ?? 'Unknown User',
            reason: $message,
        );

        event(new ScanAttempted(
            eventType: 'SCAN_FAILED',
            metadata: $metadata,
            user: $user,
            roomId: $roomId,
            scheduleId: $scheduleId,
            classGroupId: $classGroupId,
            qrToken: $qrToken
        ));

        return [
            'status' => 'error',
            'message' => $message,
        ];
    }
}
