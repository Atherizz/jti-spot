<?php

namespace App\Listeners;

use App\Events\ScanAttempted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Room;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LogScanActivity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ScanAttempted $event): void
    {
        $roomId = Room::where('qr_token', $event->qrToken)->value('id');

        DB::table('scan_logs')->insert([
            'user_id'    => $event->user->id,
            'room_id'    => $roomId, 
            'qr_token'   => $event->qrToken,
            'status'     => $event->status,
            'message'    => $event->message,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
