<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RoomScanService;
use App\Models\Room;
use App\Models\Schedule;

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

        if ($result['status'] === 'claim_prompt') {
            $room = Room::find($result['room_id']);

            $originalSchedules = Schedule::where('class_group_id', $request->user()->class_group_id)->get();

            $claimedSchedule = $room->schedules()
                ->where('day_of_week', now()->dayOfWeek)
                ->where('start_time', '<=', now()->format('H:i:s'))
                ->where('end_time', '>=', now()->format('H:i:s'))
                ->first();

            $claimedDate = now()->format('Y-m-d');

            return view('student.scan.claim', compact('room', 'originalSchedules', 'qrToken', 'claimedSchedule', 'claimedDate'));

        }

        return redirect()->route('student.dashboard.home')
            ->with($flashType, $result['message']);
    }

    public function initiateClaim(Request $request, $qrToken)
    {
        $validate = $request->validate([
            'original_schedule_id' => 'required|exists:schedules,id',
            'claimed_schedule_id' => 'required|exists:schedules,id'
        ]);

        $result = $this->roomScanService->initiateClaim(
            $request->user(), 
            $qrToken, 
            $validate['original_schedule_id'], 
            $validate['claimed_schedule_id']
            );

        $flashType = $result['status'] === 'success' ? 'success' : 'error';

        return redirect()->route('student.dashboard.home')
            ->with($flashType, $result['message']);
    }
}
