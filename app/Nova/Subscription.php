<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\MultiSelect;
use Bissolli\NovaPhoneField\PhoneNumber;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;

class Subscription extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Subscription>
     */
    public static $model = \App\Models\Subscription::class;

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

            Select::make('student')->options(
                \App\Models\Student::get()->pluck('name')
            )
            ->displayUsingLabels(),
            

            // Select::make('student')->options(function () {
            //     return \App\Models\Student::get('name');
            // })->required()->displayUsingLabels(),

            Select::make('course')->options(
                \App\Models\Course::get()->pluck('name')
            )
            ->displayUsingLabels(),
            

            Select::make('class')->options(
                \App\Models\Classes::get()->pluck('id')
            )
            ->displayUsingLabels(),
            

            Select::make('status')->options(function () {
                return \App\Models\Sku::$status;
            })->required()->displayUsingLabels(),
                
            Date::make('start_date')
            ->displayUsing(fn ($value) => $value ? $value->format('d/m/Y') : ''),

            Date::make('end_date')
            ->displayUsing(fn ($value) => $value ? $value->format('d/m/Y') : ''),
                           
           
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
    protected function myFilters()
    {
        return [
           
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