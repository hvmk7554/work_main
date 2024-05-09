<?php

namespace App\Nova\Filters\ActionEvent;

use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaInputFilter\InputFilter;

class ActionID extends InputFilter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $name = 'ID';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($request, $query, $value)
    {
        return $query->where('id',$value);
    }

}
