<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Actions\ExportAsCsv;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Statistics extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Statistics::class;

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

            Number::make("Student Id", "student_id"),
            Text::make("Classin UID", "student_classin_id"),
            Text::make("Phone number", "phone_number"),
            Select::make('Action')->options(function () {
                return [
                    1 => 'Login in LDB',
                    2 => 'Get classin link',
                    3 => 'Login in ClassIn'
                ];
            })
                ->displayUsingLabels()
                ->filterable(),
            Text::make('Device', 'device')->nullable(),
            DateTime::make("At", "created_at")->filterable()
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
        return [];
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
        return [
            ExportAsCsv::make()->withFormat(function (\App\Models\Statistics $model){
                $actions = [
                    1 => 'Login in LDB',
                    2 => 'Get classin link',
                    3 => 'Login in ClassIn'
                ];
                return [
                    'id' => $model->getKey(),
                    'Student Id' => $model->student_id,
                    'Classin UID' => $model->student_classin_id,
                    'Phone number' => $model->phone_number,
                    'Action' => $actions[$model->action],
                    'Device' => $model->device,
                    'At' => $model->created_at->format('Y/m/d H:i:s')
                ];
            })
        ];
    }
}
