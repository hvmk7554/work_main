<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class UserGroup extends Resource
{
    public static $model = \App\Models\UserGroup::class;

    public static $title = 'name';

    public static $search = [
        'id', 'slug', 'name'
    ];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Slug', 'slug')
                ->sortable()
                ->exceptOnForms(),

            Text::make('Name', 'name')
                ->sortable()
                ->exceptOnForms(),

            HasMany::make('User Group Memberships', 'userGroupMemberships', UserGroupMembership::class)
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
