<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Media extends Resource
{
    public static $model = \App\Models\Media::class;

    public static $title = 'id';

    public static $search = [
        'id', 'path',
    ];

    /**
     * @throws \Exception
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Image::make('Medium', 'path')
                ->rules('file', 'required')
                ->required(),

            Text::make('Url', function () {
                $cdn = env('MEDIA_CDN');
                $url = "$cdn/$this->path";
                return view('partials.link',[
                    'link' => $url,
                    'link_title' => $url
                ])->render();
            })->asHtml()->exceptOnForms(),

            DateTime::make('Created At', 'created_at')
                ->sortable()
                ->exceptOnForms(),

            DateTime::make('Updated At', 'updated_at')
                ->sortable()
                ->exceptOnForms(),
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
