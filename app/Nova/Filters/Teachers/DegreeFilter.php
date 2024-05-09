<?php

namespace App\Nova\Filters\Teachers;

use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class DegreeFilter extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';
    public $name = "Degree";
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
        return $query->where("Degree", $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function options(NovaRequest $request)
    {
        return [
            1 => 'Thac si',
            2 => 'Cu nhan',
            3 => 'Tien si',
            4 => 'Pho giao su',
            5 => 'Giao su',
            6 => 'Khac',
        ];
    }
}
