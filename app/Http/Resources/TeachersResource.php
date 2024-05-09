<?php

namespace App\Http\Resources;

use App\Models\Teacher;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class TeacherResource extends JsonResource
{
    public function toArray(Request $request)
    {
        /** @var Teacher $model */
        $model = $this;

        return [
            'id' => $model->id,
            'name' => $model->name,
            'DOB' => $model->DOB,
            'email' => $model->email,
            'phone' => $model->phone,
            'gender' => $model->gender,
             'contact_type'  => $model->contact_type,
             'degree' => $model->degree,
             'address' => $model->address,
             'workplace' => $model->workplace,
             'program' => $model->program,
             'subject' => $model->subject,
             'grade' => $model->grade,
             'photo_link' => $model->photo_link,
             'area' => $model->area,
        ];
    }
}