<?php

namespace App\Nova\Metrics\Course;

use App\Models\Course;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class AllCourses extends Value
{
    public $name = 'Number of Courses';

    public function calculate(NovaRequest $request)
    {
        return $this->count($request, Course::class);
    }

    public function ranges()
    {
        return [
            'ALL' => __('All'),
            30 => __('30 Days'),
            60 => __('60 Days'),
            365 => __('365 Days'),
            'TODAY' => __('Today'),
            'MTD' => __('Month To Date'),
            'QTD' => __('Quarter To Date'),
            'YTD' => __('Year To Date'),
        ];
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'course-all-courses';
    }
}
