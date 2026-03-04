<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class SiakadException extends Exception
{
    public function __construct(string $message, int $code)
    {
        parent::__construct($message);
        $this->message = $message;
        $this->code = $code;
    }

    public static function failedToCollectCookies(): self
    {
        return new self('Failed to collect SIAKAD cookies', 500);
    }

    public static function failedToLogin(): self
    {
        return new self('Failed to login to SIAKAD', 500);
    }

    public static function failedToCollectBiodata(): self
    {
        return new self('Failed to collect biodata from SIAKAD', 500);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'message' => $this->message,
            'code' => $this->code,
        ], $this->code);
    }
}