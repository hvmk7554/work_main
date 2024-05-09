<?php

namespace App\Nova\Filters\Classes;

use App\Models\Classes;
use App\Models\Course;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaMultiselectFilter\MultiselectFilter;

class CourseFilter extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $name = 'Course Filter';

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
        // $courseId = Classes::query()->where('course_id',$value)->value('course_id');

        $courseId = Course::query()->where('name',$value)->value('id');
        // var_dump($value);
        return $query->where('course_id', $courseId);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function options(NovaRequest $request)
    {
        return Course::all()->pluck('name')->toArray();
    }
}
