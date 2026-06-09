<?php

namespace App\Services;

use App\Models\WhatsAppNotification;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Throwable;

class WhatsAppService
{
    public function send(WhatsAppNotification $notification): WhatsAppNotification
    {
        $token = config('services.fonnte.token');

        if (blank($token)) {
            return $this->markFailed($notification, 'FONNTE_TOKEN belum dikonfigurasi.');
        }

        try {
            $response = Http::asForm()
                ->timeout(20)
                ->withHeaders([
                    'Authorization' => $token,
                ])
                ->post(rtrim(config('services.fonnte.base_url'), '/') . '/send', [
                    'target' => (string) $notification->target,
                    'message' => (string) $notification->message,
                    'countryCode' => (string) config('services.fonnte.country_code', '62'),
                    'connectOnly' => (bool) config('services.fonnte.connect_only', true),
                    'preview' => false,
                ]);
        } catch (ConnectionException $exception) {
            return $this->markFailed($notification, $exception->getMessage());
        } catch (Throwable $exception) {
            return $this->markFailed($notification, $exception->getMessage());
        }

        $payload = $response->json() ?? ['body' => $response->body()];
        $status = (bool) data_get($payload, 'status', data_get($payload, 'Status', false));

        if ($response->successful() && $status) {
            $notification->update([
                'status' => WhatsAppNotification::STATUS_SENT,
                'sent_at' => now(),
                'provider_request_id' => data_get($payload, 'requestid'),
                'provider_message_ids' => data_get($payload, 'id'),
                'provider_response' => $payload,
                'failure_reason' => null,
            ]);

            return $notification->fresh();
        }

        return $this->markFailed(
            $notification,
            (string) data_get($payload, 'reason', data_get($payload, 'detail', 'Fonnte request gagal.')),
            $payload
        );
    }

    private function markFailed(WhatsAppNotification $notification, string $reason, array $payload = []): WhatsAppNotification
    {
        $notification->update([
            'status' => WhatsAppNotification::STATUS_FAILED,
            'provider_response' => $payload ?: null,
            'failure_reason' => $reason,
        ]);

        return $notification->fresh();
    }
}
