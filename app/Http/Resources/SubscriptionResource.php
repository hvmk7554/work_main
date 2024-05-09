<?php

namespace App\Http\Resources;

use App\Models\Subscription;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class SubscriptionResource extends JsonResource
{
    public function toArray(Request $request)
    {
        /** @var Subscription $model */
        $model = $this;

        return [
            'id' => $model->id,
            'student' => $model->student,
            'course' => $model->course,
            'class' => $model->class,
            'status' => $model->status,
            'start_date' => $model->start_date,
            'end_date' => $model->end_date,
            
        ];
    }
}