<?php

namespace App\DTOs\Logs;

readonly class QuorumReachedMetadata implements LogMetadata
{
    public function __construct(
        public string $subject_name,
        public string $room_name,
        public int $quorum_count
    ) {}

    public function toArray(): array
    {
        return [
            'subject_name' => $this->subject_name,
            'room_name'    => $this->room_name,
            'quorum_count' => $this->quorum_count,
        ];
    }
}
