<?php

namespace App\Http\Resources;

use App\Models\Student;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class StudentResource extends JsonResource
{
    public function toArray(Request $request)
    {
        /** @var Student $model */
        $model = $this;

        return [
            'id' => $model->id,
            'name' => $model->name,
            'bday' => $model->bday,
            'email' => $model->email,
            'phone_number' => $model->phone_number,
            'gender' => $model->gender,
            'subscription' => $model->subscription,
        ];
    }
}