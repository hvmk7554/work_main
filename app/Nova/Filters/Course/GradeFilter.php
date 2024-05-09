<?php

namespace App\Nova\Filters\Course;

use App\Models\CourseGrade;
use App\Models\Grade;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaMultiselectFilter\MultiselectFilter;

class GradeFilter extends MultiselectFilter
{
    /**
     * The filter's component.
     *
     * @var string
     */
//    public $component = 'select-filter';

    public $name = 'Grades';

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
        $courseIds = CourseGrade::query()->whereIn('grade_id',$value)->get()->pluck('course_id')->toArray();

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
        return Grade::all()->pluck('name','id')->toArray();
    }
}
