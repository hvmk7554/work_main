<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Subject extends Resource
{
    public static $model = \App\Models\Subject::class;

    public static $title = 'name';

    public static $search = [
        'id', 'name', 'slug'
    ];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Name', 'name')->sortable(),
            BelongsTo::make('Program', 'program')->display('display_name'),
            Text::make('Slug', 'slug')->nullable()->hideWhenUpdating(),
            Text::make("Colors", "colors"),
            Number::make("Order", "order")->required()
                ->rules('required', 'integer', 'min:0')->sortable(),

            Image::make('Icon', 'icon')->hideFromIndex()->nullable()->disableDownload(),
            Image::make('Image', 'image')->hideFromIndex()->nullable()->disableDownload(),

            HasMany::make("Max number of classes","subjectConfigs", SubjectConfig::class)
        ];
    }

    public function cards(NovaRequest $request)
    {
        return [];
    }

    public function filters(NovaRequest $request)
    {
        return [];
    }

    public function lenses(NovaRequest $request)
    {
        return [];
    }

    public function actions(NovaRequest $request)
    {
        return [];
    }
}
