<?php

namespace App\Services;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class RedisPublishingService
{
    /**
     * @throws \RedisException
     */
    public static function publishMessage(string $model, string $event, JsonResource $resource, $source = 'model'): void
    {
        // Process one
        Redis::rPush('models_q', json_encode([
            'model' => $model,
            'event' => $event,
            'data' => json_encode($resource),
            'source' => $source,
        ]));

        // Just a signal
        Redis::publish('models', 'message');
    }
}
