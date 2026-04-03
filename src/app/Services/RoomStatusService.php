<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class RoomStatusService
{
    public function getRoomsWithStatus(?int $floor, ?string $search = null): Collection
    {
        $now = Carbon::now();
        $dayOfWeek = $now->dayOfWeek;
        $currentTime = $now->format('H:i:s');

        return Room::with(['schedules.classGroup'])
            ->when($floor, fn ($query, $floor) => $query->where('floor', $floor))
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('room_code', 'like', '%' . $search . '%');
                });
            })
            ->get()
            ->map(function ($room) use ($dayOfWeek, $currentTime) {
                $currentSchedule = $room->schedules->first(function ($schedule) use ($dayOfWeek, $currentTime) {
                    return $schedule->day_of_week == $dayOfWeek
                        && $schedule->start_time <= $currentTime
                        && $schedule->end_time >= $currentTime;
                });

                $room->current_schedule = $currentSchedule;
                $room->display_group = $currentSchedule ? $currentSchedule->classGroup->name : null;
                $room->room_type = str_contains(strtoupper($room->name), 'STUDIO') ? 'AULA' 
                                 : (str_contains(strtoupper($room->name), 'LAB') || str_contains(strtoupper($room->room_code ?? ''), 'L') ? 'LAB' : 'KELAS');

                return $room;
            });
    }

    public function calculateStats(Collection $rooms): array
    {
        $now = Carbon::now();

        return [
            'available' => $rooms->where('current_status', 'available')->count(),
            'occupied' => $rooms->where('current_status', 'occupied')->count(),
            'soon' => $rooms->filter(function ($room) use ($now) {
                if (! $room->current_schedule) return false;
                $end = Carbon::createFromFormat('H:i:s', $room->current_schedule->end_time);
                $diffMinutes = $end->diffInMinutes($now, false);
                return $diffMinutes > 0 && $diffMinutes <= 15;
            })->count(),
            'labUsage' => $rooms->count() ? (int) round($rooms->where('room_type', 'LAB')->where('current_status', 'occupied')->count() / max($rooms->where('room_type', 'LAB')->count(), 1) * 100) : 0,
        ];
    }

    public function paginateRooms(Collection $rooms, int $perPage = 8): LengthAwarePaginator
    {
        $page = Paginator::resolveCurrentPage() ?: 1;
        $paginatedItems = $rooms->slice(($page - 1) * $perPage, $perPage)->values();
        
        return new LengthAwarePaginator(
            $paginatedItems,
            $rooms->count(),
            $perPage,
            $page,
            ['path' => Paginator::resolveCurrentPath(), 'query' => request()->query()] 
        );
    }
}