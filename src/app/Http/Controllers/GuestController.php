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

    public function map(Request $request)
    {
        $floor = $request->query('floor') ? (int) $request->query('floor') : null;
        $search = $request->query('search');

        $allRooms = $this->roomStatusService->getRoomsWithStatus($floor, $search);
        
        $allRooms->transform(function ($room) {
            $room->display_group = $room->display_group ?? 'Tidak Ada';
            return $room;
        });

        $stats = $this->roomStatusService->calculateStats($allRooms);
        $rooms = $this->roomStatusService->paginateRooms($allRooms);

        return view('map', compact('rooms', 'stats'));
    }
}