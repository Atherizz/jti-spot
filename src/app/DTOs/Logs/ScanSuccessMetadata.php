<?php

namespace App\DTOs\Logs;

readonly class ScanSuccessMetadata implements LogMetadata
{
    public function __construct(
        public string $user_name,
        public string $room_name,
        public string $subject_name
    ) {}

    public function toArray(): array
    {
        return [
            'user_name'    => $this->user_name,
            'room_name'    => $this->room_name,
            'subject_name' => $this->subject_name,
        ];
    }
}