<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\ScheduleCancellation;
use App\Models\RoomClaim;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StudentScheduleController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $now = Carbon::now();
        $weekStart = $now->copy()->startOfWeek(Carbon::MONDAY);
        $weekEnd = $now->copy()->endOfWeek(Carbon::SUNDAY);

        $schedules = Schedule::with('room')
            ->where('class_group_id', $user->class_group_id)
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();

        // Ambil pembatalan untuk minggu berjalan
        $cancellations = ScheduleCancellation::whereHas('schedule', function ($query) use ($user) {
                $query->where('class_group_id', $user->class_group_id);
            })
            ->whereBetween('cancellation_date', [$weekStart->toDateString(), $weekEnd->toDateString()])
            ->get()
            ->groupBy(function ($item) {
                return $item->schedule_id . '_' . Carbon::parse($item->cancellation_date)->dayOfWeek;
            });

        // Ambil reservasi untuk minggu berjalan
        $reservations = RoomClaim::with(['schedule', 'room'])
            ->where('claimer_group_id', $user->class_group_id)
            ->whereBetween('claim_date', [$weekStart->toDateString(), $weekEnd->toDateString()])
            ->whereIn('status', ['pending_quorum', 'locked'])
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->claim_date)->dayOfWeek;
            });

        $dayLabels = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
        ];

        $todayDay = $now->dayOfWeek;
        $currentTime = $now->format('H:i:s');

        $groupedSchedules = $schedules
            ->groupBy('day_of_week')
            ->sortKeys()
            ->map(function ($items, $day) use ($dayLabels, $todayDay, $currentTime, $cancellations, $reservations) {
                return [
                    'day' => $dayLabels[(int) $day] ?? 'Hari',
                    'is_today' => (int) $day === $todayDay,
                    'items' => $items->map(function ($schedule) use ($todayDay, $currentTime, $day, $cancellations) {
                        $isOngoing = (int) $day === $todayDay
                            && $schedule->start_time <= $currentTime
                            && $schedule->end_time >= $currentTime;

                        // Cek apakah ada pembatalan untuk schedule ini di hari ini
                        $cancellationKey = $schedule->id . '_' . $day;
                        $cancellation = $cancellations->get($cancellationKey)?->first();

                        return [
                            'course_name' => $schedule->course_name,
                            'time' => substr($schedule->start_time, 0, 5) . ' - ' . substr($schedule->end_time, 0, 5),
                            'room_name' => $schedule->room?->name ?? '-',
                            'is_ongoing' => $isOngoing,
                            'cancellation' => $cancellation ? [
                                'date' => Carbon::parse($cancellation->cancellation_date)->locale('id')->isoFormat('D MMM YYYY'),
                            ] : null,
                        ];
                    })->values(),
                    'reservations' => $reservations->get((int) $day, collect())->map(function ($claim) {
                        return [
                            'course_name' => $claim->schedule?->course_name ?? 'Kelas Pengganti',
                            'room_name' => $claim->room?->name ?? '-',
                            'time' => Carbon::parse($claim->start_time)->format('H:i') . ' - ' . Carbon::parse($claim->end_time)->format('H:i'),
                            'date' => Carbon::parse($claim->claim_date)->locale('id')->isoFormat('D MMM YYYY'),
                        ];
                    })->values(),
                ];
            })
            ->values();

        return view('student.schedules.index', [
            'groupedSchedules' => $groupedSchedules,
            'classLabel' => $user->classGroup?->name ?? '-',
        ]);
    }
}
