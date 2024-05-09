<?php

namespace App\Observers;

use App\Helpers\ArrayUtils;
use App\Http\Resources\CourseResource;
use App\Http\Resources\SkuResource;
use App\Models\Course;
use App\Models\Sku;
use App\Models\SubjectConfig;
use App\Services\External\AcademicService;
use App\Services\RedisPublishingService;
use App\Services\Repository\CourseService;
use App\Services\Repository\SkuService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CourseObserver
{
    public function saving(Course $course) {
        if (!$course->active) {
            $course->fill([
                'ready_for_web' => false,
            ]);
        }

        if(is_null($course->max_of_classes_by_subject_config))
        {
            if (ArrayUtils::arrayHasOneValue($course->subjects) && ArrayUtils::arrayHasOneValue($course->grades)) {
                $subjectConfig = SubjectConfig::query()->where("subject_id", $course->subjects[0]->id)->where("grade_id", $course->grades[0]->id)->first();
                $course->fill([
                    'max_of_classes_by_subject_config' => $subjectConfig->number_of_class ?? null,
                    'class_types_by_subject_config' => $subjectConfig->class_types ?? null
                ]);
            }
        }
    }

    public function creating(Course $course) {
        $course->fill([
            'slug' => self::slugify($course->name)
        ]);
    }

    public function created(Course $course)
    {
        $course->load(['grades', 'subjects', 'teachers', 'schedules']);

        RedisPublishingService::publishMessage('course', 'created', new CourseResource($course));
    }

    public function updated(Course $course)
    {

        if ($course->isDirty('active') && !$course->active) {
            self::deactiveCourseSku($course);
        }

        if ($course->isDirty(['stage']) && $course->stage == 'cancelled') {
            SkuService::cancelSkus($course->skus);
            DB::table('courses')->where('id',$course->id)->update([
                'end_date'=>Carbon::now(),
            ]);
            CourseService::cancelCourse($course);
        }

        if ($course->isDirty('cross_sell_id')){
            // update cross-sell product hubspot
            foreach ($course->skus()->get() as $sku){
                /** @var Sku $sku */
                RedisPublishingService::publishMessage('sku', 'updated', new SkuResource($sku));
            }
        }

        $course->load(['grades', 'subjects', 'teachers', 'schedules']);

        RedisPublishingService::publishMessage('course', 'updated', new CourseResource($course));
    }

    public function deleted(Course $course)
    {
        RedisPublishingService::publishMessage('course', 'deleted', new CourseResource($course));
    }

    public function restored(Course $course)
    {
        //
    }

    public function forceDeleted(Course $course)
    {
        //
    }

    public static function slugify($text, string $divider = '-')
    {

        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//IGNORE', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    private static function deactiveCourseSku(Course $course) {
        SkuService::deActiveSkus($course->skus);
    }
}
