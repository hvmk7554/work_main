<?php

namespace App\Nova;

use App\Nova\Filters\Classes\StatusType;
use App\Nova\Filters\Classes\StartTimeFilter;
use App\Nova\Filters\Classes\EndTimeFilter;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;


class Classes extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Classes>
     */
    public static $model = '\App\Models\classes';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Select::make('status')->options([
                -1 => 'Not Started',
                0 => 'Failed',
                1 => 'Success',
                2 => 'Cancelled'
            ])->default('-1')->displayUsingLabels(),
            Date::make('Start Time'),
            Date::make('End Time'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return $this->myFilters();
    }
    public function myFilters (){
        return [
            StatusType::make(),
            StartTimeFilter::make(),
            EndTimeFilter::make(),
        ];
    }
    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
