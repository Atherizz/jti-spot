<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\QuorumScan;
use App\Models\RoomClaim;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class StudentDashboardController extends Controller
{
    public function home(Request $request)
    {
        $user = $request->user();
        $classGroupId = $user->class_group_id;

        $now = Carbon::now();
        $currentDate = $now->toDateString();
        $currentTime = $now->format('H:i:s');

        $activeSchedule = Schedule::with('room')
            ->where('class_group_id', $classGroupId)
            ->where('day_of_week', $now->dayOfWeek)
            ->where('start_time', '<=', $currentTime)
            ->where('end_time', '>=', $currentTime)
            ->first();

        $activeClaim = null;
        if (!$activeSchedule) {
            $activeClaimQuery = RoomClaim::with(['room', 'schedule'])
                ->where('claimer_group_id', $classGroupId)
                ->where('claim_date', $currentDate)
                ->whereIn('status', ['pending_quorum', 'locked']);

            if (Schema::hasColumn('room_claims', 'start_time') && Schema::hasColumn('room_claims', 'end_time')) {
                $activeClaimQuery
                    ->whereTime('start_time', '<=', $currentTime)
                    ->whereTime('end_time', '>=', $currentTime);
            } else {
                $activeClaimQuery->whereHas('schedule', function ($query) use ($now, $currentTime) {
                    $query->where('day_of_week', $now->dayOfWeek)
                        ->where('start_time', '<=', $currentTime)
                        ->where('end_time', '>=', $currentTime);
                });
            }

            $activeClaim = $activeClaimQuery->first();
        }

        $targetColumn = null;
        $targetId = null;
        $sessionTitle = 'Tidak ada sesi aktif';
        $sessionMeta = 'Belum ada jadwal yang sedang berlangsung';
        $sessionLocation = '-';
        $sessionRoomUrl = null;
        $checkInPageUrl = null;

        $sessionIsOccupied      = false;
        $quorumExtendedUntil    = null;

        if ($activeSchedule) {
            $targetColumn = 'schedule_id';
            $targetId = $activeSchedule->id;
            $sessionTitle = $activeSchedule->course_name;
            $sessionMeta = ($activeSchedule->classGroup->name ?? '-') . ' • Sesi resmi';
            $sessionLocation = $activeSchedule->room?->name ?? '-';
            $sessionIsOccupied = $activeSchedule->room?->current_status === 'occupied';
            $quorumExtendedUntil = $activeSchedule->room?->quorum_extended_until;
            if (!empty($activeSchedule->room?->qr_token)) {
                $sessionRoomUrl = route('scan.initial', $activeSchedule->room->qr_token);
                $checkInPageUrl = route('student.checkin.show', $activeSchedule->room->qr_token);
            }
        } elseif ($activeClaim) {
            $targetColumn = 'claim_id';
            $targetId = $activeClaim->id;
            $sessionTitle = $activeClaim->schedule?->course_name ?? 'Klaim Ruangan';
            $sessionMeta = ($activeClaim->claimerGroup->name ?? '-') . ' • Sesi klaim';
            $sessionLocation = $activeClaim->room?->name ?? '-';
            $sessionIsOccupied = $activeClaim->status === 'locked';
            if (!empty($activeClaim->room?->qr_token)) {
                $sessionRoomUrl = route('scan.initial', $activeClaim->room->qr_token);
                $checkInPageUrl = route('student.checkin.show', $activeClaim->room->qr_token);
            }
        }

        $quorumSize = (int) env('QUORUM_SIZE', 5);
        $currentQuorum = 0;
        $progressPercent = 0;
        $alreadyScanned = false;

        if ($targetColumn && $targetId) {
            $sessionScanQuery = QuorumScan::where($targetColumn, $targetId)
                ->where('scanned_date', $currentDate);

            $currentQuorum = $sessionScanQuery->count();
            $alreadyScanned = (clone $sessionScanQuery)
                ->where('user_id', $user->id)
                ->exists();

            $progressPercent = (int) min(100, round(($currentQuorum / max($quorumSize, 1)) * 100));
        }

        $activities = [];
        $totalActivities = 0;
        $successfulScanTypes = $this->successfulScanEventTypes();

        if (Schema::hasTable('activity_logs')) {
            $totalActivities = ActivityLog::query()
                ->where('class_group_id', $classGroupId)
                ->whereIn('event_type', $successfulScanTypes)
                ->whereDate('created_at', $currentDate)
                ->count();

            $activities = ActivityLog::query()
                ->where('class_group_id', $classGroupId)
                ->whereIn('event_type', $successfulScanTypes)
                ->whereDate('created_at', $currentDate)
                ->latest()
                ->take(5)
                ->get()
                ->map(function (ActivityLog $log) {
                    return [
                        'type' => $log->event_type,
                        'title' => $this->buildActivityTitle($log),
                        'subtitle' => $this->buildActivitySubtitle($log),
                    ];
                })
                ->all();
        }

        $weekStart = $now->copy()->startOfWeek(Carbon::MONDAY)->toDateString();
        $weekEnd = $now->copy()->endOfWeek(Carbon::SUNDAY)->toDateString();

        $weeklyScans = QuorumScan::where('user_id', $user->id)
            ->whereBetween('scanned_date', [$weekStart, $weekEnd])
            ->count();

        $verifiedRooms = QuorumScan::where('user_id', $user->id)
            ->whereBetween('scanned_date', [$weekStart, $weekEnd])
            ->distinct('room_id')
            ->count('room_id');

        $streakDays = $this->calculateStreakDays($user->id, $currentDate);

        return view('student.dashboard.home', [
            'activities' => $activities,
            'totalActivities' => $totalActivities,
            'sessionTitle' => $sessionTitle,
            'sessionMeta' => $sessionMeta,
            'sessionLocation' => $sessionLocation,
            'sessionRoomUrl' => $sessionRoomUrl,
            'checkInPageUrl' => $checkInPageUrl,
            'quorumSize' => $quorumSize,
            'currentQuorum' => $currentQuorum,
            'progressPercent' => $progressPercent,
            'canManualCheckIn' => (bool) $targetId,
            'sessionIsOccupied' => $sessionIsOccupied,
            'quorumExtendedUntil' => $quorumExtendedUntil,
            'alreadyScanned' => $alreadyScanned,
            'weeklyScans' => $weeklyScans,
            'verifiedRooms' => $verifiedRooms,
            'streakDays' => $streakDays,
        ]);
    }

    private function buildActivityTitle(ActivityLog $log): string
    {
        $metadata = $log->metadata ?? [];

        if ($log->event_type === 'QUORUM_REACHED') {
            return 'Kuorum tercapai untuk ' . ($metadata['subject_name'] ?? 'sesi saat ini');
        }

        return ($metadata['user_name'] ?? 'Mahasiswa') . ' memverifikasi kehadiran di ' . ($metadata['room_name'] ?? 'ruangan');
    }

    private function buildActivitySubtitle(ActivityLog $log): string
    {
        $metadata = $log->metadata ?? [];
        $timeLabel = $log->created_at?->locale('id')->diffForHumans() ?? 'Baru saja';

        if ($log->event_type === 'QUORUM_REACHED') {
            return $timeLabel . ' • Kelas resmi dimulai';
        }

        return $timeLabel . ' • ' . ($metadata['subject_name'] ?? 'Sesi berlangsung');
    }

    private function calculateStreakDays(int $userId, string $currentDate): int
    {
        $scanDates = QuorumScan::query()
            ->where('user_id', $userId)
            ->where('scanned_date', '<=', $currentDate)
            ->orderByDesc('scanned_date')
            ->pluck('scanned_date')
            ->map(fn ($date) => Carbon::parse($date)->toDateString())
            ->unique()
            ->values();

        if ($scanDates->isEmpty()) {
            return 0;
        }

        $streak = 0;
        $cursor = Carbon::parse($currentDate);

        foreach ($scanDates as $date) {
            if ($date === $cursor->toDateString()) {
                $streak++;
                $cursor->subDay();
                continue;
            }

            if ($streak === 0) {
                $cursor->subDay();
                if ($date === $cursor->toDateString()) {
                    $streak++;
                    $cursor->subDay();
                    continue;
                }
            }

            break;
        }

        return $streak;
    }

    public function activityLog(Request $request)
    {
        $user = $request->user();
        $classGroupId = $user->class_group_id;
        $currentDate = Carbon::today()->toDateString();
        $successfulScanTypes = $this->successfulScanEventTypes();

        $activities = [];
        if (Schema::hasTable('activity_logs')) {
            $activities = ActivityLog::query()
                ->where('class_group_id', $classGroupId)
                ->whereIn('event_type', $successfulScanTypes)
                ->whereDate('created_at', $currentDate)
                ->latest()
                ->paginate(10)
                ->through(function (ActivityLog $log) {
                    return [
                        'type' => $log->event_type,
                        'title' => $this->buildActivityTitle($log),
                        'subtitle' => $this->buildActivitySubtitle($log),
                    ];
                });
        }

        return view('student.dashboard.activity-log', [
            'activities' => $activities,
        ]);
    }

    private function successfulScanEventTypes(): array
    {
        return ['SCAN_SUCCESS', 'SCAN_SUCCEED', 'Scan_Succeed'];
    }

    public function extendQuorum(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'delay_minutes' => ['required', 'integer', 'in:15,30,45'],
        ]);

        $user         = $request->user();
        $classGroupId = $user->class_group_id;
        $now          = Carbon::now();
        $currentTime  = $now->format('H:i:s');

        $activeSchedule = Schedule::with('room')
            ->where('class_group_id', $classGroupId)
            ->where('day_of_week', $now->dayOfWeek)
            ->where('start_time', '<=', $currentTime)
            ->where('end_time', '>=', $currentTime)
            ->first();

        if (!$activeSchedule?->room) {
            return redirect()->route('student.dashboard.home')
                ->with('error', 'Tidak ada jadwal aktif yang ditemukan untuk kelas Anda.');
        }

        $room = $activeSchedule->room;

        if ($room->current_status === 'occupied') {
            return redirect()->route('student.dashboard.home')
                ->with('error', 'Kelas sudah berjalan (kuorum tercapai), tidak perlu perpanjangan.');
        }

        $claimedByOther = RoomClaim::where('room_id', $room->id)
            ->where('claim_date', $now->toDateString())
            ->whereIn('status', ['pending_quorum', 'locked'])
            ->where('claimer_group_id', '!=', $classGroupId)
            ->exists();

        if ($claimedByOther) {
            return redirect()->route('student.dashboard.home')
                ->with('error', 'Ruangan sudah diklaim kelas lain. Silakan cari ruangan kosong alternatif.');
        }

        $extendedUntil = $now->copy()->addMinutes((int) $validated['delay_minutes']);

        $room->update([
            'quorum_extended_until' => $extendedUntil,
            'current_status'        => 'waiting',
        ]);

        return redirect()->route('student.dashboard.home')
            ->with('success', "Window kuorum diperpanjang hingga {$extendedUntil->format('H:i')}. Ruangan tetap dalam status Menunggu.");
    }

    public function endSession(Request $request): RedirectResponse
    {
        $user = $request->user();
        $classGroupId = $user->class_group_id;
        $now = Carbon::now();
        $currentTime = $now->format('H:i:s');
        $currentDate = $now->toDateString();

        $activeSchedule = Schedule::with('room')
            ->where('class_group_id', $classGroupId)
            ->where('day_of_week', $now->dayOfWeek)
            ->where('start_time', '<=', $currentTime)
            ->where('end_time', '>=', $currentTime)
            ->first();

        if ($activeSchedule?->room) {
            if ($activeSchedule->room->current_status !== 'occupied') {
                return redirect()->route('student.dashboard.home')
                    ->with('error', 'Sesi belum bisa diakhiri karena ruangan belum berstatus terpakai (kuorum belum tercapai).');
            }
            $activeSchedule->room->update(['current_status' => 'available']);
            return redirect()->route('student.dashboard.home')
                ->with('success', 'Sesi kelas berhasil diakhiri. Ruangan kini tersedia untuk kelas lain.');
        }

        $activeClaimQuery = RoomClaim::with('room')
            ->where('claimer_group_id', $classGroupId)
            ->where('claim_date', $currentDate)
            ->where('status', 'locked');

        if (Schema::hasColumn('room_claims', 'start_time') && Schema::hasColumn('room_claims', 'end_time')) {
            $activeClaimQuery
                ->whereTime('start_time', '<=', $currentTime)
                ->whereTime('end_time', '>=', $currentTime);
        }

        $activeClaim = $activeClaimQuery->first();

        if ($activeClaim?->room) {
            $activeClaim->room->update(['current_status' => 'available']);
            $activeClaim->update(['status' => 'completed']);
            return redirect()->route('student.dashboard.home')
                ->with('success', 'Sesi kelas berhasil diakhiri. Ruangan kini tersedia untuk kelas lain.');
        }

        return redirect()->route('student.dashboard.home')
            ->with('error', 'Tidak ada sesi aktif yang dapat diakhiri saat ini.');
    }
}
