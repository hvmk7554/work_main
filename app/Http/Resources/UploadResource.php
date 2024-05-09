<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UploadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $model = $this;
        $cdn = config('app.media_cdn');
        $url = "$cdn/$model->path";
        return [
            'id' => $model->id,
            'name' => $model->name,
            'createdAt' => $model->created_at,
            'updatedAt' => $model->updated_at,
            'createdUserInfo' => $model->created_user_info,
            'size' => $model->size,
            'path' => $url,
            'createdBy' => $model->created_by,
            'user' => $model->user,
        ];
    }
}
