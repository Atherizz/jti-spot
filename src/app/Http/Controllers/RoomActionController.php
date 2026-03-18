<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RoomScanService;
use App\Models\Room;

class RoomActionController extends Controller
{

    public function __construct(
        protected RoomScanService $roomScanService
    ) {}

    public function scanInitial($qrToken)
    {
        // Find room by qr_token
        $room = Room::where('qr_token', $qrToken)->first();

        if (!$room) {
            return redirect()->route('student.dashboard.home')
                ->with('error', 'QR Code tidak valid atau ruangan tidak ditemukan');
        }

        return view('student.scan.initial', compact('room', 'qrToken'));
    }

    public function confirmScan(Request $request, $qrToken)
    {
        $result = $this->roomScanService->confirmScan($request->user(), $qrToken);

        $flashType = $result['status'] === 'success' ? 'success' : 'error';

        return redirect()->route('student.dashboard.home')
            ->with($flashType, $result['message']);
    }
}
