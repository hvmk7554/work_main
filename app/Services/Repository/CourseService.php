<?php

namespace App\Services\Repository;

use App\Helpers\Utils;
use App\Models\Course;
use App\Models\ReserveCourse;
use App\Models\Subscription;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class CourseService
{
    public function inlineGrades(Course $course): string
    {
        $grades = [];

        foreach ($course->grades as $grade) {
            $grades[] = $grade->name;
        }

        return join(', ', $grades);
    }

    public function inlineSubjects(Course $course): string
    {
        $subjects = [];

        foreach ($course->subjects as $subject) {
            $subjects[] = $subject->name;
        }

        return join(', ', $subjects);
    }

    public function inlineTeachers(Course $course): string
    {
        $teachers = [];

        foreach ($course->teachers as $teacher) {
            $teachers[] = $teacher->pivot->role == "Main" ? $teacher->name : null;
        }

        return join(', ',array_filter($teachers));
    }

    public static function createCourseContent(Course $course): void
    {
        if ($course->curriculum == null) {
            return;
        }
        $new = $course->curriculum->replicate()->fill([
            'type' => 2,
            'private' => true
        ]);

        $new->save();
        $course->fill(['content_id' => $new->id]);

        // Clone lesson
        $parent = [];
        $newLessons = [];
        foreach ($course->curriculum->lessons as $lesson) {
            $newLesson = $lesson->replicate()->fill([
                'curriculum_id' => $new->id,
                'old_id' => $lesson->id,
            ]);
            $newLesson->save();
            $parent[$lesson->id] = $newLesson->id;
            $newLessons[] = $newLesson;

            foreach ($lesson->documents as $doc) {
                $doc->replicate()->fill([
                    'lesson_id' => $newLesson->id
                ])->save();
            }
        }

        foreach ($newLessons as $lesson) {
            if ($lesson->parent_id) {
                $newParent = $parent[$lesson->parent_id];

                $lesson->update([
                    'parent_id' => $newParent
                ]);
            }
        }
    }

    public static function showLifeCycle($startDate, $endDate): array
    {
        $currentDate = Carbon::now()->startOfDay();
        if ($startDate == null || $endDate == null) {
            return [
                'opened' => 'Active',
                'cancelled' => 'Cancelled'
            ];
        }
        if ($currentDate->isBefore($startDate)) {
            return [
                'opened' => 'Not started',
                'cancelled' => 'Cancelled'
            ];
        }
        if (!$currentDate->isAfter($endDate)) {
            return [
                'opened' => 'Active (started)',
                'cancelled' => 'Cancelled'
            ];
        }
        return [
            'opened' => 'Expired',
            'cancelled' => 'Cancelled'
        ];
    }

    public static function displayLifeCycle($v, $startDate, $endDate): string {
        if ($v == 'cancelled') {
            return 'Cancelled';
        }
        if ($startDate == null || $endDate == null) {
            return 'Active';
        }

        $currentDate = Carbon::now()->startOfDay();
        if ($currentDate->isBefore($startDate)) {
            return 'Not started';
        }
        if (!$currentDate->isAfter($endDate)) {
            return 'Active (started)';
        }
        return 'Expired';
    }

    public static function cancelCourse(Course $course)
    {
        if ($course->type == 5 || $course->type == 6 || $course->type == 9) {
            return;
        }
        $subscriptions = $course->subscriptions()->get();

        $now = Carbon::now()->utc()->toDateString();
        $program = $course->getPrograms()->first();
        $program_id = 0;
        if (isset($program)) {
            $program_id = $program->id;
        }
        $subjects = $course->subjects()->first();
        $subject_id = 0;
        if (isset($subjects)) {
            $subject_id = $subjects->id;
        }
        $grades = $course->grades()->first();
        $grade_id = 0;
        if (isset($grades)) {
            $grade_id = $grades->id;
        }
        $listClassinUid = [];
        foreach ($subscriptions as $subscription) {
            $listClassinUid [] = $subscription->classin_uid;
            $lifeCycle = Subscription::getLifeCycle($subscription->lifecycle,
                $subscription->subscription_start_date,
                $subscription->subscription_end_date);

//            Log::info("Canceling subscription: " . $subscription->id. "-". $lifeCycle);
            if ($lifeCycle == "cancelled" || $lifeCycle == "expired") {
                continue;
            }


            $numberOfUnit = $subscription->subscription_end_date->diffInDays($now) + 1;

            Log::info("Canceling subscription: " . $subscription->id. "-". $numberOfUnit);

            $subscription->old_subscription_end_date = $subscription->subscription_end_date;
            $subscription->subscription_end_date = $now;
            $subscription->lifecycle = "cancelled";
            $subscription->cancellation_reason = "course cancelled";
            $subscription->system_remove_date = $now;

            $subscription->save();

            $reserveCourse = new ReserveCourse();

            $reserveCourse->fill([
               'student_id' => $subscription->student_id,
               'course_id' => $course->id,
               'unit_type' => 'day',
               'unit_value' => $numberOfUnit,
               'original_id' => $subscription->id,
               'original_type' => 'subscription',
               'status' => 'new',
               'expired_at' => Carbon::now()->addDays(180),
               'program_id' => $program_id,
               'subject_id' => $subject_id,
               'grade_id' => $grade_id,
               'cross_sell_id' =>  $course->cross_sell_id,
               'course_type' => $course->type,
               'reason_id' => 5,
            ]);
            $reserveCourse->save();
        }


        Utils::removeStudentInCourse($listClassinUid, $course->classin_id, 1);
    }
}
