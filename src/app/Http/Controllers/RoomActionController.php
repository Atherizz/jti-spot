<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RoomScanService;
use App\Models\Room;
use App\Events\ScanAttempted;


class RoomActionController extends Controller
{

    public function __construct(
        protected RoomScanService $roomScanService
    ) {}

    public function scanInitial($qrToken) {
        // Find room by qr_token
        $room = Room::where('qr_token', $qrToken)->first();
        
        if (!$room) {
            return redirect()->route('student.dashboard.home')
                ->with('error', 'QR Code tidak valid atau ruangan tidak ditemukan');
        }

        return view('student.scan.initial', compact('room', 'qrToken'));
    }

    public function confirmScan(Request $request, $qrToken) {
        try {
        
            $this->roomScanService->confirmScan($request->user(), $qrToken);

            event(new ScanAttempted($request->user(), $qrToken, 'success', 'Scan berhasil diverifikasi'));

            return redirect()->route('student.dashboard.home')
                ->with('success', 'Scan berhasil! Kehadiran Anda telah tercatat');

        } catch (\Exception $e) {
            event(new ScanAttempted($request->user(), $qrToken, 'failed', $e->getMessage()));

            return redirect()->route('student.dashboard.home')
                ->with('error', $e->getMessage());
        }
    }
}
