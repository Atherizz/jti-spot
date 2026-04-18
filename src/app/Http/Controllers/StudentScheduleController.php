<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StudentScheduleController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $schedules = Schedule::with('room')
            ->where('class_group_id', $user->class_group_id)
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();

        $dayLabels = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
        ];

        $todayDay = Carbon::now()->dayOfWeek;
        $currentTime = Carbon::now()->format('H:i:s');

        $groupedSchedules = $schedules
            ->groupBy('day_of_week')
            ->sortKeys()
            ->map(function ($items, $day) use ($dayLabels, $todayDay, $currentTime) {
                return [
                    'day' => $dayLabels[(int) $day] ?? 'Hari',
                    'is_today' => (int) $day === $todayDay,
                    'items' => $items->map(function ($schedule) use ($todayDay, $currentTime, $day) {
                        $isOngoing = (int) $day === $todayDay
                            && $schedule->start_time <= $currentTime
                            && $schedule->end_time >= $currentTime;

                        return [
                            'course_name' => $schedule->course_name,
                            'time' => substr($schedule->start_time, 0, 5) . ' - ' . substr($schedule->end_time, 0, 5),
                            'room_name' => $schedule->room?->name ?? '-',
                            'is_ongoing' => $isOngoing,
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
