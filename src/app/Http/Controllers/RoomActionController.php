<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RoomScanService;
use App\Models\Room;
use App\Models\QuorumScan;
use App\Models\Schedule;
use Carbon\Carbon;

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

        if ($result['status'] === 'success') {
            return redirect()->route('student.checkin.show', $qrToken)
                ->with($flashType, $result['message']);
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

        $targetRoute = $result['status'] === 'success'
            ? 'student.schedules'
            : 'student.dashboard.home';

        return redirect()->route($targetRoute)
            ->with($flashType, $result['message']);
    }

    public function showCheckIn(Request $request, $qrToken)
    {
        $room = Room::where('qr_token', $qrToken)->first();

        if (!$room) {
            return redirect()->route('student.dashboard.home')
                ->with('error', 'Ruangan tidak ditemukan.');
        }

        $user = $request->user();
        $now = Carbon::now();
        $today = $now->toDateString();

        $activeSchedule = Schedule::where('room_id', $room->id)
            ->where('class_group_id', $user->class_group_id)
            ->where('day_of_week', $now->dayOfWeek)
            ->where('start_time', '<=', $now->format('H:i:s'))
            ->where('end_time', '>=', $now->format('H:i:s'))
            ->first();

        $latestScan = QuorumScan::where('user_id', $user->id)
            ->where('room_id', $room->id)
            ->where('scanned_date', $today)
            ->orderByDesc('scanned_at')
            ->first();

        $subjectName = $activeSchedule?->course_name ?? 'Sesi Check-in';
        $lecturerName = 'Dosen pengampu';
        $className = $user->classGroup?->name ?? '-';

        $remainingSeconds = 0;
        if ($activeSchedule) {
            $sessionEnd = Carbon::parse($today . ' ' . $activeSchedule->end_time);
            $remainingSeconds = max(0, $now->diffInSeconds($sessionEnd, false));
        }

        return view('student.scan.checkin', [
            'room' => $room,
            'subjectName' => $subjectName,
            'lecturerName' => $lecturerName,
            'className' => $className,
            'checkedInAt' => $latestScan?->scanned_at,
            'remainingSeconds' => $remainingSeconds,
        ]);
    }
}
