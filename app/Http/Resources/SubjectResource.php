<?php

namespace App\Http\Resources;

use App\Models\Subject;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Subject $model */
        $model = $this;

        return [
            'id' => $model->id,
            'name' => $model->name,
        ];
    }
}
