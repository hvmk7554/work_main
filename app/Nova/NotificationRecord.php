<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class NotificationRecord extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\NotificationRecord>
     */
    public static $model = \App\Models\NotificationRecord::class;

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

            Text::make('channel', 'channel'),

            Text::make('Template', 'channel_detail'),

            Text::make('Status', 'status')
                ->displayUsing(function ($v) {
                    switch ($v) {
                        case 'sending':
                            return 'Đang gửi';
                        case 'send':
                            return "Đã gửi";
                        case 'opened':
                            return "Đã mở mail";
                        case 'opened-link':
                            return "Đã mở link (bất kỳ)";
                        case 'failed':
                            return "Gửi thất bại";
                    }

                    return $v;
                }),

            Text::make('More Detail', 'status_detail'),
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
