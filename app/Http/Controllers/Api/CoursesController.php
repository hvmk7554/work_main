<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Artisan;

class CoursesController extends Controller
{
    public function index()
    {
        $courses = Course::query()
            ->limit(25)
            ->orderBy('id', 'desc')
            ->with(['grades', 'subjects', 'teachers', 'schedules'])
            ->get();

        return CourseResource::collection($courses);
    }

    public function detail(int $id)
    {
        $course = Course::query()
            ->where('id', $id)
            ->with(['grades', 'subjects', 'teachers', 'schedules'])
            ->first();

        return new CourseResource($course);
    }

    public function batch(Request $req): AnonymousResourceCollection
    {
        $classin_ids = $req->post('classin_ids');

        $coursesList = Course::query()
            ->whereIn('classin_id', $classin_ids)
            ->get();
        return CourseResource::collection($coursesList);
    }

    public function criteriaCourseNoty(Request|null $request = null){
        Artisan::call('course:criteria-course-noty');
        Artisan::call('course:delay-date-command');
    }
}
