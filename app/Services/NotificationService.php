<?php

namespace App\Services;

use App\Services\External\MarathonIntegrationService;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public function sendSMS(string $phoneNumber, string $type, string $content)
    {
        if ($this->shouldSendSMS()) {
            Log::info(sprintf('Sending SMS to phone number: %s', $phoneNumber), [
                'phone_number' => $phoneNumber,
                'type' => $type,
                'content' => $content,
            ]);

            resolve(MarathonIntegrationService::class)->sendSmsPlaintext($phoneNumber, $type, $content);
        } else {
            Log::info(sprintf('Mocking SMS to phone number: %s', $phoneNumber), [
                'phone_number' => $phoneNumber,
                'type' => $type,
                'content' => $content,
            ]);
        }
    }

    private function shouldSendSMS(): bool
    {
        return config('insight.enable_sms', false);
    }
}
