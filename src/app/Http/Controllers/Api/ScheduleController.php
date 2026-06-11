<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $filters = $request->validate([
            'class_group_id' => ['nullable', 'integer', 'exists:class_groups,id'],
            'room_code' => ['nullable', 'string', 'exists:rooms,room_code'],
        ]);

        $classGroupId = isset($filters['class_group_id']) ? (int) $filters['class_group_id'] : null;
        $roomCode = $filters['room_code'] ?? null;

        $schedules = Schedule::query()
            ->with(['room', 'classGroup'])
            ->when($classGroupId, function ($query, int $classGroupId) {
                $query->where('class_group_id', $classGroupId);
            })
            ->when($roomCode, function ($query, string $roomCode) {
                $query->whereHas('room', function ($roomQuery) use ($roomCode) {
                    $roomQuery->where('room_code', $roomCode);
                });
            })
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();

        return response()->json([
            'data' => $schedules->map(function (Schedule $schedule) {
                return [
                    'id' => $schedule->id,
                    'day_of_week' => $schedule->day_of_week,
                    'start_period' => $schedule->start_period,
                    'end_period' => $schedule->end_period,
                    'start_time' => $schedule->start_time,
                    'end_time' => $schedule->end_time,
                    'course_name' => $schedule->course_name,
                    'room' => [
                        'id' => $schedule->room?->id,
                        'room_code' => $schedule->room?->room_code,
                        'name' => $schedule->room?->name,
                        'floor' => $schedule->room?->floor,
                    ],
                    'class_group' => [
                        'id' => $schedule->classGroup?->id,
                        'name' => $schedule->classGroup?->name,
                        'major' => $schedule->classGroup?->major,
                    ],
                ];
            })->values(),
            'meta' => [
                'filters' => [
                    'class_group_id' => $classGroupId,
                    'room_code' => $roomCode,
                ],
            ],
        ]);
    }
}
