<?php

namespace App\Nova\Filters\Classes;

use Illuminate\Support\Carbon;
use Laravel\Nova\Filters\DateFilter;
use Laravel\Nova\Http\Requests\NovaRequest;

class StartTimeFilter extends DateFilter
{
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
        $value = Carbon::parse($value);

        return $query->where('start_time', '=', $value);
    }
}
