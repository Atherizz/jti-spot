<?php

namespace App\DTOs\Logs;

readonly class ScanFailedMetadata implements LogMetadata
{
    public function __construct(
        public string $user_name,
        public string $reason,
    ) {}

    public function toArray(): array
    {
        return [
            'user_name' => $this->user_name,
            'reason'    => $this->reason,
        ];
    }
}
