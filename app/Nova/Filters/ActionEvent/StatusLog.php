<?php

namespace App\Nova\Filters\ActionEvent;

use App\Models\ActionEvent;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaMultiselectFilter\MultiselectFilter;

class StatusLog extends MultiselectFilter
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
        return $query->whereIn('status',$value);
    }

    public function options(NovaRequest $request)
    {
        return ActionEvent::getActionStatus();
    }
}
