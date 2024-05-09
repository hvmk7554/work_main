<?php

namespace App\Nova\Filters\Course;

use App\Models\CourseSubject;
use App\Models\Subject;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaMultiselectFilter\MultiselectFilter;

class SubjectFilter extends MultiselectFilter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $name = "Subjects";

    /**
     * Apply the filter to the given query.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(NovaRequest $request, $query, $value)
    {
        $courseIds = CourseSubject::query()->whereIn('subject_id',$value)->get()->pluck('course_id')->toArray();

        return $query->whereIn('id',array_unique($courseIds));
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function options(NovaRequest $request)
    {
        return Subject::all()->pluck('name','id')->toArray();
    }
}
