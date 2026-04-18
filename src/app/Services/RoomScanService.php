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
use Illuminate\Support\Facades\Schema;

class RoomScanService
{
    public function confirmWithoutScan($user)
    {
        try {
            return DB::transaction(function () use ($user) {
                $classGroup = $user->classGroup;

                if (!$classGroup) {
                    return $this->handleFailedScan($user, 'MANUAL_CHECKIN', 'Kelas tidak ditemukan!');
                }

                $now = Carbon::now();
                $currentDay = $now->dayOfWeek;
                $currentTime = $now->format('H:i:s');
                $currentDate = $now->toDateString();

                $schedule = Schedule::where('class_group_id', $classGroup->id)
                    ->where('day_of_week', $currentDay)
                    ->where('start_time', '<=', $currentTime)
                    ->where('end_time', '>=', $currentTime)
                    ->first();

                if ($schedule) {
                    $room = Room::whereKey($schedule->room_id)->lockForUpdate()->first();

                    if (!$room) {
                        return $this->handleFailedScan($user, 'MANUAL_CHECKIN', 'Ruangan tidak ditemukan untuk sesi aktif.');
                    }

                    return $this->processAttendance($user, 'MANUAL_CHECKIN', $room, $classGroup, $schedule);
                }

                $activeClaimQuery = RoomClaim::where('claimer_group_id', $classGroup->id)
                    ->where('claim_date', $currentDate)
                    ->whereIn('status', ['pending_quorum', 'locked']);

                if (Schema::hasColumn('room_claims', 'start_time') && Schema::hasColumn('room_claims', 'end_time')) {
                    $activeClaimQuery
                        ->whereTime('start_time', '<=', $currentTime)
                        ->whereTime('end_time', '>=', $currentTime);
                } else {
                    $activeClaimQuery->whereHas('schedule', function ($query) use ($currentDay, $currentTime) {
                        $query->where('day_of_week', $currentDay)
                            ->where('start_time', '<=', $currentTime)
                            ->where('end_time', '>=', $currentTime);
                    });
                }

                $activeClaim = $activeClaimQuery->first();

                if ($activeClaim) {
                    $room = Room::whereKey($activeClaim->room_id)->lockForUpdate()->first();

                    if (!$room) {
                        return $this->handleFailedScan($user, 'MANUAL_CHECKIN', 'Ruangan tidak ditemukan untuk sesi klaim.');
                    }

                    return $this->processAttendance($user, 'MANUAL_CHECKIN', $room, $classGroup, null, $activeClaim);
                }

                return $this->handleFailedScan($user, 'MANUAL_CHECKIN', 'Tidak ada sesi aktif yang bisa diverifikasi saat ini.');
            });
        } catch (\Exception $e) {
            return $this->handleFailedScan($user, 'MANUAL_CHECKIN', $e->getMessage());
        }
    }

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
                }

                if ($schedule) {
                    return $this->processAttendance($user, $qrToken, $room, $classGroup, $schedule);
                }

                $activeClaimQuery = RoomClaim::where('room_id', $room->id)
                    ->where('claimer_group_id', $classGroup->id)
                    ->where('claim_date', $currentDate)
                    ->wherein('status', ['pending_quorum', 'locked']);

                if (Schema::hasColumn('room_claims', 'start_time') && Schema::hasColumn('room_claims', 'end_time')) {
                    $activeClaimQuery
                        ->whereTime('start_time', '<=', $currentTime)
                        ->whereTime('end_time', '>=', $currentTime);
                } else {
                    $activeClaimQuery->whereHas('schedule', function ($query) use ($currentDay, $currentTime) {
                        $query->where('day_of_week', $currentDay)
                            ->where('start_time', '<=', $currentTime)
                            ->where('end_time', '>=', $currentTime);
                    });
                }

                $activeClaim = $activeClaimQuery->first();

                if ($activeClaim) {
                    return $this->processAttendance($user, $qrToken, $room, $classGroup, null, $activeClaim);
                }

                if ($user->role == 'class_rep') {

                    if ($room->current_status !== 'available') {
                        return $this->handleFailedScan($user, $qrToken, 'Ruangan sedang digunakan oleh kelas lain. Anda tidak bisa mengklaimnya saat ini!');
                    }

                    return [
                        'status' => 'claim_prompt',
                        'message' => 'Ruangan tidak memiliki jadwal untuk kelas Anda. Ingin claim ruangan ini untuk kelas pengganti?',
                        'room_id' => $room->id
                    ];
                }

                return $this->handleFailedScan($user, $qrToken, 'Tidak ada jadwal resmi atau kelas pengganti untuk kelas Anda saat ini.');
            });
        } catch (\Exception $e) {
            return $this->handleFailedScan($user, $qrToken, $e->getMessage());
        }
    }

    private function processAttendance($user, $qrToken, $room, $classGroup, $schedule = null, $claim = null)
    {
        $now = Carbon::now();
        $currentDate = $now->format('Y-m-d');

        $isClaim = !is_null($claim);
        $targetColumn = $isClaim ? 'claim_id' : 'schedule_id';
        $targetId = $isClaim ? $claim->id : ($schedule->id ?? null);

        // Check if user already scanned today for this schedule/claim
        $existingScan = QuorumScan::where('user_id', $user->id)
            ->where($targetColumn, $targetId)
            ->where('scanned_date', $currentDate)
            ->first();

        if ($existingScan) {
            return $this->handleFailedScan($user, $qrToken, 'Anda sudah melakukan scan untuk sesi ini hari ini!', $room->id, $isClaim ? null : $schedule->id, $classGroup->id);
        }

        // 6. Count current quorum scans for this schedule or claim
        $quorumCount = QuorumScan::where($targetColumn, $targetId)
            ->where('scanned_date', $currentDate)
            ->count();

        // 7. Insert scan data to database
        $scanData = [
            'user_id' => $user->id,
            'room_id' => $room->id,
            'scanned_date' => $currentDate,
            'scanned_at' => $now,
            'schedule_id' => null,
            'claim_id' => null,
        ];

        $scanData[$targetColumn] = $targetId;

        $quorumScan = QuorumScan::create($scanData);

        // Recalculate quorum after insert
        $newQuorumCount = $quorumCount + 1;

        // Update room status to 'occupied' if quorum is reached
        $quorumSize = env('QUORUM_SIZE', 5);
        $isQuorumReached = false;
        if ($newQuorumCount >= $quorumSize && $room->current_status !== 'occupied') {
            $room->update(['current_status' => 'occupied']);
            $isQuorumReached = true;
        }

        $subjectName = $isClaim ? 'Klaim Ruangan' : ($schedule->course_name ?? 'Mata Kuliah');
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
            scheduleId: $schedule?->id,
            claimId: $claim?->id,
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
                scheduleId: $schedule?->id,
                claimId: $claim?->id,
                classGroupId: $classGroup->id,
                roomId: $room->id,
                metadata: $quorumMetadata
            ));
        }

        return [
            'status' => 'success',
            'message' => 'Scan berhasil! Kehadiran Anda telah tercatat',
            'room_qr_token' => $room->qr_token,
        ];
    }

    public function initiateClaim($user, $qrToken, $originalScheduleId, $claimedScheduleId)
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

        $claimData = [
            'room_id' => $room->id,
            'schedule_id' => $originalSchedule->id,
            'claimer_group_id' => $originalSchedule->class_group_id,
            'claim_date' => $now->toDateString(),
            'status' => 'pending_quorum',
        ];

        if (Schema::hasColumn('room_claims', 'claimed_by_user_id')) {
            $claimData['claimed_by_user_id'] = $user->id;
        }

        if (Schema::hasColumn('room_claims', 'start_time')) {
            $claimData['start_time'] = $now->format('H:i:s');
        }

        if (Schema::hasColumn('room_claims', 'end_time')) {
            $claimData['end_time'] = $claimedSchedule->end_time;
        }

        $claim = RoomClaim::create($claimData);

        $room->update(['current_status' => 'waiting']);

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
