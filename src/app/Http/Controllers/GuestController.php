<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RoomStatusService;

class GuestController extends Controller
{
    public function __construct(private RoomStatusService $roomStatusService) {}

    public function index(Request $request)
    {
        $floor = $request->query('floor') ? (int) $request->query('floor') : null;
        $search = $request->query('search');

        $allRooms = $this->roomStatusService->getRoomsWithStatus($floor, $search);
        
        $stats = $this->roomStatusService->calculateStats($allRooms);
        $rooms = $this->roomStatusService->paginateRooms($allRooms);

        return view('guest', compact('rooms', 'stats'));
    }

    public function liveData(Request $request)
    {
        $floor  = $request->query('floor')  ? (int) $request->query('floor') : null;
        $search = $request->query('search');

        $allRooms = $this->roomStatusService->getRoomsWithStatus($floor, $search);
        $stats    = $this->roomStatusService->calculateStats($allRooms);
        $rooms    = $this->roomStatusService->paginateRooms($allRooms);

        $roomsData = $rooms->map(function ($room) {
            $progress    = 0;
            $durationText = 'Kosong saat ini';
            $endTime     = null;

            if ($room->current_schedule) {
                $end       = \Carbon\Carbon::createFromFormat('H:i:s', $room->current_schedule->end_time);
                $now       = \Carbon\Carbon::now();
                $remaining = max(0, round($now->diffInMinutes($end, false)));
                $durationText = $remaining > 0 ? "Selesai dalam {$remaining} mins" : 'Selesai';
                $start    = \Carbon\Carbon::createFromFormat('H:i:s', $room->current_schedule->start_time);
                $total    = max(1, $start->diffInMinutes($end));
                $progress = min(100, max(0, round((($total - $remaining) / $total) * 100)));
                $endTime  = $room->current_schedule->end_time;
            }

            $roomType = str_contains(strtoupper($room->name), 'STUDIO') ? 'AULA'
                      : (str_contains(strtoupper($room->name), 'LAB') || str_contains(strtoupper($room->room_code ?? ''), 'L') ? 'LAB' : 'KELAS');

            return [
                'name'           => $room->name,
                'room_type'      => $roomType,
                'floor'          => $room->floor,
                'room_code'      => $room->room_code,
                'current_status' => $room->current_status,
                'display_group'  => $room->display_group ?? 'Tidak ada jadwal terdaftar',
                'progress'       => $progress,
                'duration_text'  => $durationText,
                'end_time'       => $endTime,
            ];
        })->values();

        return response()->json([
            'stats'       => $stats,
            'rooms'       => $roomsData,
            'total'       => $rooms->total(),
            'last_update' => \Carbon\Carbon::now()->format('H:i:s'),
        ]);
    }

    public function map(Request $request)
    {
        $floor = $request->query('floor') ? (int) $request->query('floor') : null;
        $search = $request->query('search');
        $room = $request->query('room');

        $searchFilter = $room ? null : $search;

        $allRooms = $this->roomStatusService->getRoomsWithStatus($floor, $searchFilter);
        
        $allRooms->transform(function ($room) {
            $room->display_group = $room->display_group ?? 'Tidak Ada';
            return $room;
        });

        $allRoomsData = $this->roomStatusService->getRoomsWithStatus(null, null);
        $allRoomsData->transform(function ($room) {
            $room->display_group = $room->display_group ?? 'Tidak Ada';
            return $room;
        });

        $stats = $this->roomStatusService->calculateStats($allRooms);
        $rooms = $this->roomStatusService->paginateRooms($allRooms);

        return view('map', compact('rooms', 'stats', 'allRoomsData'));
    }
}