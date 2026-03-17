<?php

namespace App\DTOs\Logs;

readonly class ScanFailedMetadata implements LogMetadata
{
    public function __construct(
        public string $user_name,
        public string $reason,
        public string $qr_token
    ) {}

    public function toArray(): array
    {
        return [
            'user_name' => $this->user_name,
            'reason'    => $this->reason,
            'qr_token'  => $this->qr_token,
        ];
    }
}
