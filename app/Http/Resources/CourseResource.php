<?php

namespace App\Http\Resources;

use App\Models\Course;
use Illuminate\Http\Resources\Json\JsonResource;
use phpDocumentor\Reflection\Types\Boolean;

class CourseResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Course $model */
        $model = $this;
        return [
            'id' => $model->id,
            'classinId' => $model->classin_id,
            'code' => $model->code,
            'slug' => $model->slug,
            'name' => $model->name,
            'nameOnWebsite' => $model->name_on_website,
            'nameOnClassin' => $model->name_on_classin,
            'introduction' => $model->introduction,
            'startDate' => $model->start_date,
            'endDate' => $model->end_date,
            'numberEndDate' => strtotime($model->end_date),
            'schoolYear' => $model->school_year,
            'createdAt' => $model->created_at,
            'updatedAt' => $model->updated_at,
            'image' => $model->image,
            'active' => !!$model->active,
            'readyForWeb' => $model->ready_for_web,
            'program' => $model->program,
            'classinAllowAddFriend' => $model->classin_allow_add_friend,
            'type' => (int)$model->type,
            'grades' => $this->whenLoaded('grades', function () use ($model) {
                return GradeResource::collection($model->grades);
            }),

            'subjects' => $this->whenLoaded('subjects', function () use ($model) {
                return SubjectResource::collection($model->subjects);
            }),

            'teachers' => $this->whenLoaded('teachers', function () use ($model) {
                return TeacherResource::collection($model->teachers);
            }),

            'schedules' => $this->whenLoaded('schedules', function () use ($model) {
                return CourseScheduleResource::collection($model->schedules);
            }),
            'programs' => $this->when("getPrograms",function () use ($model){
                return new ProgramResource($model->getPrograms);
            }),

            'crossSellId' => $model->crossSell?->getKey() ?? 0,

            'crossSell' => $model->crossSell,


        ];
    }
}
