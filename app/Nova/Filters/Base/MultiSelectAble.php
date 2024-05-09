<?php

namespace App\Nova\Filters\Base;

use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaMultiselectFilter\MultiselectFilter;

class MultiSelectAble extends MultiselectFilter
{

    public function __construct(string $name, string $column, array $dataOption)
    {
        $this->name = $name;
        $this->column = $column;
        $this->dataOption = $dataOption;
    }

    public array $dataOption;

    public $name;

    public string $column;

    public $callable;

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
        return $query->whereIn($this->column,$value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function options(NovaRequest $request)
    {
        return $this->dataOption;
    }
}
