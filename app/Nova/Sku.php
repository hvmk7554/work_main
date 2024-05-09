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
use App\Nova\Filters\Sku\StatusFilter;
use App\Nova\Filters\Sku\StartDayFilter;
use App\Nova\Filters\Sku\EndDayFilter;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;

class Sku extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Sku>
     */
    public static $model = \App\Models\Sku::class;

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
        'name',
        'website_name'
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

            Text::make('type'),
            Text::make('school_year'),

            Text::make('website_name')->sortable(),
            Text::make('name')->sortable(),

            Select::make('status')->options(function () {
                return \App\Models\Sku::$status;
            })->required()->displayUsingLabels(),
                
            Date::make('start_date')
            ->displayUsing(fn ($value) => $value ? $value->format('d/m/Y') : ''),

            Date::make('end_date')
            ->displayUsing(fn ($value) => $value ? $value->format('d/m/Y') : ''),

            Text::make('unit_number'),
            Text::make('original_price'),
            Text::make('listing_price'),
            Text::make('unit_type'),
            Text::make('note'),

            Select::make('grade')->options(function () {
                 return \App\Models\Grade::$studentManagementGrades;
              })->required()->displayUsingLabels(),
              
        //    HasMany::make('Grades'),
                           
            Select::make('subject')->options(function () {
                return \App\Models\Subject::$subjectx;
            })->required()->displayUsingLabels(),

            

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
            StatusFilter::make(),
            StartDayFilter::make(),
            EndDayFilter::make(),
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