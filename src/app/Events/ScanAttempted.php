<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use App\DTOs\Logs\LogMetadata;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ScanAttempted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public string $eventType, // 'SCAN_SUCCESS' or 'SCAN_FAILED'
        public LogMetadata $metadata, 
        public ?User $user = null,  
        public ?int $roomId = null,
        public ?int $scheduleId = null,
        public ?int $claimId = null,
        public ?int $classGroupId = null,
        public ?string $qrToken = null
    ) {}
            
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
