<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RoomStatusService;

class GuestController extends Controller
{
    // Pastikan ini ada
    public function __construct(private RoomStatusService $roomStatusService) {}

    // INI ADALAH FUNGSI YANG DICARI OLEH LARAVEL
    public function index(Request $request)
    {
        $floor = $request->query('floor') ? (int) $request->query('floor') : null;
        $allRooms = $this->roomStatusService->getRoomsWithStatus($floor);
        
        $stats = $this->roomStatusService->calculateStats($allRooms);
        $rooms = $this->roomStatusService->paginateRooms($allRooms);

        return view('guest', compact('rooms', 'stats'));
    }

    public function map(Request $request)
    {
        $floor = $request->query('floor') ? (int) $request->query('floor') : null;
        $allRooms = $this->roomStatusService->getRoomsWithStatus($floor);
        
        $allRooms->transform(function ($room) {
            $room->display_group = $room->display_group ?? 'Tidak Ada';
            return $room;
        });

        $stats = $this->roomStatusService->calculateStats($allRooms);
        $rooms = $this->roomStatusService->paginateRooms($allRooms);

        return view('map', compact('rooms', 'stats'));
    }
}