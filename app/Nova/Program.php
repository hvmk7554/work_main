<?php

namespace App\Nova;

use App\Helpers\Utils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Program extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Program>
     */
    public static $model = \App\Models\Program::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'display_name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
        'display_name'
    ];

    /**
     * @return string
     */
    public static function getTitle(): string
    {
        return \App\Models\Program::programAvailable()[self::$title];
    }

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
            Text::make('Name', 'display_name')->sortable(),

            Text::make('Subject','subjects')->displayUsing(function ($subject){
                return implode(',',$subject->pluck('name')->toArray());
            })->exceptOnForms(),
            HasMany::make('Subject', 'subjects', Subject::class)->hideFromIndex(),
            Text::make('grades','grades')->displayUsing(function ($grades){
                return implode(',',$grades->pluck('name')->toArray());
            })->exceptOnForms(),
            BelongsToMany::make('Grades','grades',Grade::class),

            Number::make('Class require percent', 'class_require_percent')->step(0.01)->required(),

            Number::make('Student require percent', 'student_require_percent')->step(0.01)->required()
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
        return [];
    }
}
