<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Room;
use App\Models\RoomClaim;
use App\Models\Schedule;
use App\Services\RoomStatusService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AdminScheduleController extends Controller
{
    public function dashboard(Request $request, RoomStatusService $roomStatusService)
    {
        try {
            $currentMoment = Carbon::now();
            $currentDate = $currentMoment->toDateString();
            $currentTime = $currentMoment->format('H:i:s');
            $currentDay = $currentMoment->dayOfWeek;
            $searchQuery = trim((string) $request->query('q', ''));
            $selectedStatus = (string) $request->query('status', 'all');
            $allowedStatuses = ['all', 'available', 'occupied', 'waiting', 'waiting_confirmation'];

            if (!in_array($selectedStatus, $allowedStatuses, true)) {
                $selectedStatus = 'all';
            }

            $allRooms = $roomStatusService->getRoomsWithStatus(null, null)
                ->sortBy(function ($room) {
                    return strtoupper((string) ($room->room_code ?? $room->name ?? ''));
                })
                ->values();

            $roomStats = $roomStatusService->calculateStats($allRooms);
            $totalRooms = $allRooms->count();

            $activeSchedulesToday = Schedule::query()
                ->where('day_of_week', $currentDay)
                ->count();

            $activeSchedulesNow = Schedule::query()
                ->with(['room', 'classGroup'])
                ->where('day_of_week', $currentDay)
                ->where('start_time', '<=', $currentTime)
                ->where('end_time', '>=', $currentTime)
                ->orderBy('start_time')
                ->take(4)
                ->get();

            $activeClaims = collect();
            $activeClaimRoomIds = collect();
            if (Schema::hasTable('room_claims')) {
                $activeClaimsQuery = RoomClaim::query()
                    ->whereIn('status', ['pending_quorum', 'locked'])
                    ->whereDate('claim_date', $currentDate)
                    ->when(
                        Schema::hasColumns('room_claims', ['start_time', 'end_time']),
                        function ($query) use ($currentTime) {
                            $query->whereTime('start_time', '<=', $currentTime)
                                ->whereTime('end_time', '>=', $currentTime);
                        },
                        function ($query) use ($currentDay, $currentTime) {
                            $query->whereHas('schedule', function ($scheduleQuery) use ($currentDay, $currentTime) {
                                $scheduleQuery->where('day_of_week', $currentDay)
                                    ->where('start_time', '<=', $currentTime)
                                    ->where('end_time', '>=', $currentTime);
                            });
                        }
                    );

                $activeClaimRoomIds = (clone $activeClaimsQuery)
                    ->pluck('room_id')
                    ->filter()
                    ->unique()
                    ->values();

                $activeClaims = (clone $activeClaimsQuery)
                    ->with(['room', 'schedule.classGroup', 'claimedByUser'])
                    ->orderByDesc('updated_at')
                    ->take(4)
                    ->get();
            }

            $rooms = $allRooms;

            if ($searchQuery !== '') {
                $normalizedQuery = Str::of($searchQuery)->lower()->replace('-', '')->value();

                $rooms = $rooms->filter(function ($room) use ($normalizedQuery) {
                    $searchableText = Str::of(implode(' ', [
                        (string) ($room->room_code ?? ''),
                        (string) ($room->name ?? ''),
                        (string) ($room->floor ?? ''),
                        (string) ($room->current_status ?? ''),
                        (string) ($room->current_schedule?->course_name ?? ''),
                        (string) ($room->current_schedule?->classGroup?->name ?? ''),
                    ]))->lower()->replace('-', '')->value();

                    return str_contains($searchableText, $normalizedQuery);
                })->values();
            }

            if ($selectedStatus === 'waiting') {
                $rooms = $rooms->filter(function ($room) use ($activeClaimRoomIds) {
                    return $room->current_status === 'waiting' && $activeClaimRoomIds->contains($room->id);
                })->values();
            } elseif ($selectedStatus === 'waiting_confirmation') {
                $rooms = $rooms->filter(function ($room) use ($activeClaimRoomIds) {
                    return $room->current_status === 'waiting' && ! $activeClaimRoomIds->contains($room->id);
                })->values();
            } elseif ($selectedStatus !== 'all') {
                $rooms = $rooms->where('current_status', $selectedStatus)->values();
            }

            $claimConflictCount = $activeClaimRoomIds->count();
            $waitingWithoutConflictCount = $allRooms
                ->where('current_status', 'waiting')
                ->pluck('id')
                ->diff($activeClaimRoomIds)
                ->count();

            $recentActivities = collect();
            if (Schema::hasTable('activity_logs')) {
                $recentActivities = ActivityLog::query()
                    ->with(['user', 'room', 'schedule.classGroup'])
                    ->latest()
                    ->take(5)
                    ->get();
            }

            $dashboardRoomRows = $rooms->map(function ($room) use ($activeClaimRoomIds) {
                $currentSchedule = $room->current_schedule;
                $status = (string) ($room->current_status ?? 'available');
                $hasClaimConflict = $status === 'waiting' && $activeClaimRoomIds->contains($room->id);

                if ($status === 'waiting' && ! $hasClaimConflict) {
                    $statusLabel = 'Menunggu Konfirmasi';
                    $statusTone = 'amber';
                    $statusFilter = 'waiting_confirmation';
                } else {
                    $statusLabel = [
                        'available' => 'Standby',
                        'waiting' => 'Konflik Jadwal',
                        'occupied' => 'Terpakai',
                    ][$status] ?? ucfirst($status);

                    $statusTone = [
                        'available' => 'emerald',
                        'waiting' => 'orange',
                        'occupied' => 'slate',
                    ][$status] ?? 'slate';
                    $statusFilter = $status;
                }

                $timeRange = $currentSchedule
                    ? Carbon::parse($currentSchedule->start_time)->format('H:i') . ' — ' . Carbon::parse($currentSchedule->end_time)->format('H:i')
                    : '—';

                $locationLabel = collect([
                    $room->floor ? 'Lantai ' . $room->floor : null,
                    $room->room_code ? $room->room_code : null,
                    $room->name,
                ])->filter()->implode(' • ');

                return [
                    'id' => $room->id,
                    'code' => $room->room_code ?? (string) $room->id,
                    'name' => $room->name,
                    'location' => $locationLabel,
                    'status' => $status,
                    'status_filter' => $statusFilter,
                    'status_label' => $statusLabel,
                    'status_tone' => $statusTone,
                    'course_name' => $currentSchedule?->course_name,
                    'class_group' => $currentSchedule?->classGroup?->name,
                    'time_range' => $timeRange,
                    'start_time' => $currentSchedule?->start_time,
                    'end_time' => $currentSchedule?->end_time,
                    'current_schedule_id' => $currentSchedule?->id,
                    'detail_url' => route('admin.room.detail', $room->room_code ?? (string) $room->id),
                    'schedule_url' => route('admin.schedules', ['room_id' => $room->id]),
                ];
            })->values();

            $dashboardRows = $roomStatusService->paginateRooms($dashboardRoomRows, 8);

            return view('admin.dashboard.home', [
                'totalRooms' => $totalRooms,
                'activeSchedulesToday' => $activeSchedulesToday,
                'activeSchedulesNow' => $activeSchedulesNow,
                'activeClaims' => $activeClaims,
                'claimConflictCount' => $claimConflictCount,
                'waitingWithoutConflictCount' => $waitingWithoutConflictCount,
                'recentActivities' => $recentActivities,
                'roomStats' => $roomStats,
                'dashboardRows' => $dashboardRows,
                'searchQuery' => $searchQuery,
                'selectedStatus' => $selectedStatus,
                'todayLabel' => $currentMoment->locale('id')->translatedFormat('l, d F Y'),
            ]);
        } catch (\Throwable $throwable) {
            report($throwable);

            abort(500, 'Dashboard admin gagal dimuat.');
        }
    }

    public function index(Request $request)
    {
        $query = Schedule::query()->with(['room', 'classGroup']);

        $selectedRoomId = $request->query('room_id');
        $selectedFloor = $request->query('floor');
        $selectedDay = $request->query('day');
        $selectedTime = $request->query('start_time');

        if (!empty($selectedRoomId)) {
            $query->where('room_id', (int) $selectedRoomId);
        }

        if ($selectedFloor !== null && $selectedFloor !== '') {
            $query->whereHas('room', function ($roomQuery) use ($selectedFloor) {
                $roomQuery->where('floor', (int) $selectedFloor);
            });
        }

        if ($selectedDay !== null && $selectedDay !== '') {
            $query->where('day_of_week', (int) $selectedDay);
        }

        if ($selectedTime !== null && $selectedTime !== '') {
            $query->whereTime('start_time', '=', $selectedTime . ':00');
        }

        if ($request->filled('q')) {
            $keyword = trim((string) $request->query('q'));
            $query->where(function ($builder) use ($keyword) {
                $builder->where('course_name', 'like', '%' . $keyword . '%')
                    ->orWhereHas('room', function ($roomQuery) use ($keyword) {
                        $roomQuery->where('name', 'like', '%' . $keyword . '%');

                        if (Schema::hasColumn('rooms', 'room_code')) {
                            $roomQuery->orWhere('room_code', 'like', '%' . $keyword . '%');
                        }
                    })
                    ->orWhereHas('classGroup', function ($classQuery) use ($keyword) {
                        $classQuery->where('name', 'like', '%' . $keyword . '%')
                            ->orWhere('major', 'like', '%' . $keyword . '%');
                    });
            });
        }

        $schedules = $query
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->paginate(15)
            ->withQueryString();

        $todayDay = Carbon::now()->dayOfWeek;

        $stats = [
            'total' => Schedule::count(),
            'today' => Schedule::where('day_of_week', $todayDay)->count(),
            'rooms' => Schedule::distinct('room_id')->count('room_id'),
            'classes' => Schedule::distinct('class_group_id')->count('class_group_id'),
        ];

        $rooms = Room::query()
            ->orderBy('room_code')
            ->orderBy('name')
            ->get(['id', 'room_code', 'name']);

        $floors = Room::query()
            ->whereNotNull('floor')
            ->distinct()
            ->orderBy('floor')
            ->pluck('floor');

        $startTimes = Schedule::query()
            ->whereNotNull('start_time')
            ->distinct()
            ->orderBy('start_time')
            ->pluck('start_time')
            ->map(function ($time) {
                return substr((string) $time, 0, 5);
            })
            ->unique()
            ->values();

        return view('admin.schedule.schedule', [
            'schedules' => $schedules,
            'stats' => $stats,
            'rooms' => $rooms,
            'floors' => $floors,
            'startTimes' => $startTimes,
            'selectedRoomId' => $selectedRoomId,
            'selectedFloor' => $selectedFloor,
            'selectedDay' => $selectedDay,
            'selectedTime' => $selectedTime,
        ]);
    }
}
