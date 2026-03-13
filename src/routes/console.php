<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Room;
use App\Models\Schedule as ScheduleModel;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {

    $now = Carbon::now();

    $logAndPrint = function ($message) {
        Log::info($message);
        echo "   -> " . $message . PHP_EOL;
    };

    // Run only during class hours (07:00 - 18:59)
    if ($now->hour >= 7 && $now->hour <= 18 && $now->isWeekday()) {
        $currentDay = $now->dayOfWeek;

        // Get today's schedules
        $schedulesToday = ScheduleModel::where('day_of_week', $currentDay)
            ->select('id', 'room_id', 'start_time', 'end_time')
            ->get();

        if ($schedulesToday->isEmpty()) {
            $logAndPrint('Cron: No schedules found for today.');
            return;
        }

        // Arrays to group rooms by target current_status
        $toWaiting = [];
        $toCancelQuorum = [];
        $toAvailable = [];

        // Process schedules in memory
        foreach ($schedulesToday as $schedule) {
            
        $startTime = Carbon::parse($schedule->start_time);
        $endTime = Carbon::parse($schedule->end_time);
        $limitQuorumTime = $startTime->copy()->addMinutes(15);

            // Class ended
            if ($now >= $endTime) {
                array_push($toAvailable, $schedule->room_id);
            } 
            // Waiting for quorum
            else if ($now >= $startTime && $now <= $limitQuorumTime) {
                array_push($toWaiting, $schedule->room_id);
            } 
            // Quorum failed
            else if ($now > $limitQuorumTime && $now < $endTime) {
                array_push($toCancelQuorum, $schedule->room_id);
            }
        }

        // Bulk update room status
        if (!empty($toWaiting)) {
            Room::whereIn('id', array_unique($toWaiting))
                ->where('current_status', 'available')
                ->update(['current_status' => 'waiting']);
            $logAndPrint('Cron: Rooms updated to [waiting] - IDs: ' . implode(', ', array_unique($toWaiting)));
        }

        if (!empty($toCancelQuorum)) {
            Room::whereIn('id', array_unique($toCancelQuorum))
                ->where('current_status', 'waiting')
                ->update(['current_status' => 'available']);
            $logAndPrint('Cron: Rooms updated to [available] (quorum failed) - IDs: ' . implode(', ', array_unique($toCancelQuorum)));
        }

        if (!empty($toAvailable)) {
            Room::whereIn('id', array_unique($toAvailable))
                ->update(['current_status' => 'available']);
            $logAndPrint('Cron: Rooms updated to [available] (class ended) - IDs: ' . implode(', ', array_unique($toAvailable)));
        }
    } else {
        $logAndPrint('Cron: Skipped (outside class hours/weekend).');
    }

})->everyMinute();