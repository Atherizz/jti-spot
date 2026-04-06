<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\ScanAttempted;
use App\Events\QuorumReached;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ActivityLogSubscriber
{
public function handleScanLog(ScanAttempted $event): void
    {
        $this->insertLog(
            $event->eventType,
            $event->metadata->toArray(),
            $event->user?->id,
            $event->roomId,
            $event->scheduleId,
            $event->classGroupId
        );
    }

    public function handleQuorumLog(QuorumReached $event): void
    {
        $this->insertLog(
            'QUORUM_REACHED',
            $event->metadata->toArray(),
            null, 
            $event->roomId,
            $event->scheduleId,
            $event->classGroupId
        );
    }

    private function insertLog($type, $metadata, $userId, $roomId, $scheduleId, $classId): void
    {
        if (!Schema::hasTable('activity_logs')) {
            return;
        }

        DB::table('activity_logs')->insert([
            'user_id'         => $userId,
            'room_id'         => $roomId,
            'schedule_id'     => $scheduleId,
            'class_group_id'  => $classId,
            'event_type'      => $type,
            'metadata'        => json_encode($metadata),
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
    }

    /**
     * Register the listeners for the subscriber.
     */
    public function subscribe($events): array
    {
        return [
            ScanAttempted::class => 'handleScanLog',
            QuorumReached::class => 'handleQuorumLog',
        ];
    }
}
