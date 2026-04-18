<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AdminScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::query()->with(['room', 'classGroup']);

        $selectedRoomId = $request->query('room_id');

        if (!empty($selectedRoomId)) {
            $query->where('room_id', (int) $selectedRoomId);
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

        return view('admin.schedule.schedule', [
            'schedules' => $schedules,
            'stats' => $stats,
            'rooms' => $rooms,
            'selectedRoomId' => $selectedRoomId,
        ]);
    }
}
