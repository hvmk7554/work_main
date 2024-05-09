<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class UserGroupMembershipExample extends Resource
{
    public static $model = \App\Models\UserGroupMembershipExample::class;

    public static $title = 'name';

    public static $search = [
        'id', 'name'
    ];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Name', 'name')
                ->rules('required'),

            Text::make('Price', 'price')
                ->rules('required'),

            Boolean::make('Is Active', 'is_active')
                ->readonly(!Auth::user()->in(\App\Models\UserGroup::PRODUCT_WRITE)),

            Textarea::make('Description', 'description')
                ->rules('required'),

            Image::make('Featured Image', 'featured_image')
                ->rules('nullable'),
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
