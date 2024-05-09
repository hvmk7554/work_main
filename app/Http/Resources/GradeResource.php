<?php

namespace App\Http\Resources;

use App\Models\Grade;
use Illuminate\Http\Resources\Json\JsonResource;

class GradeResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Grade $model */
        $model = $this;

        return [
            'id' => $model->id,
            'name' => $model->name,
        ];
    }
}
