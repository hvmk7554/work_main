<?php

namespace App\Http\Resources;

use App\Models\Job;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Job $model */
        $model = $this;

        return [
            'id' => $model->id,
        ];
    }
}
