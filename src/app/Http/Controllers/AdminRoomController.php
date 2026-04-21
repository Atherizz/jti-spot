<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AdminRoomController extends Controller
{
    public function index(Request $request)
    {
        $hasFloor = Schema::hasColumn('rooms', 'floor');
        $hasRoomCode = Schema::hasColumn('rooms', 'room_code');

        $query = Room::query();

        if ($request->filled('q')) {
            $keyword = trim((string) $request->query('q'));
            $query->where(function ($q) use ($keyword, $hasRoomCode) {
                if ($hasRoomCode) {
                    $q->where('room_code', 'like', '%' . $keyword . '%');
                }
                $q->orWhere('name', 'like', '%' . $keyword . '%');
            });
        }

        $hasFloor ? $query->orderBy('floor') : null;
        $hasRoomCode ? $query->orderBy('room_code') : $query->orderBy('id');

        $rooms = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => Room::count(),
            'lab' => $hasRoomCode ? Room::where('room_code', 'like', 'L%')->count() : 0,
            'theory' => $hasRoomCode ? Room::where('room_code', 'like', 'RT%')->count() : 0,
            'waiting' => Room::where('current_status', 'waiting')->count(),
        ];

        return view('admin.room.room', compact('rooms', 'stats'));
    }

    public function show(string $roomCode)
    {
        if (Schema::hasColumn('rooms', 'room_code')) {
            $room = Room::where('room_code', strtoupper($roomCode))->firstOrFail();
        } else {
            abort_unless(ctype_digit($roomCode), 404);
            $room = Room::findOrFail((int) $roomCode);
        }

        $recentLogs = \App\Models\ActivityLog::with('user')
            ->where('room_id', $room->id)
            ->latest()
            ->take(5)
            ->get();

        return view('admin.room.detail', compact('room', 'recentLogs'));
    }
}