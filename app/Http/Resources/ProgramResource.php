<?php

namespace App\Http\Resources;

use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramResource extends JsonResource
{
    public function toArray(Request $request)
    {
        /** @var Program $model */
        $model = $this;
        return [
            "id" => $model->id,
            "displayName" => $model->display_name,
            "businessLine" => $model->businessLine()->value("name")
        ];
    }
}
