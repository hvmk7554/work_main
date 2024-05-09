<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Query\Search\SearchableRelation;

class UserGroupMembership extends Resource
{
    public static $model = \App\Models\UserGroupMembership::class;

    public static $title = 'id';

    public static function searchableColumns()
    {
        return [
            'id',
            new SearchableRelation('userGroup', 'slug'),
            new SearchableRelation('userGroup', 'name'),
            new SearchableRelation('user', 'name'),
            new SearchableRelation('user', 'email'),
        ];
    }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('User Group', 'userGroup', UserGroup::class),

            BelongsTo::make('User', 'user', User::class),
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
