<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class User extends Resource
{
    public static $model = \App\Models\User::class;

    public static $title = 'name';

    public static $search = [
        'id', 'name', 'email',
    ];

    public static $with = [
        'userGroupMemberships'
    ];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Gravatar::make()->maxWidth(50),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', Rules\Password::defaults())
                ->updateRules('nullable', Rules\Password::defaults()),

            Select::make('Authority Level')
                ->options([
                    -1000 => 'Unauthorized',
                    1 => 'Viewer',
                    -1 => 'Customer Service',
                    2 => 'Editor',
                    3 => 'Owner',
                    4 => 'Administrator',
                    5 => 'Super Administrator',
                ])
                ->displayUsingLabels()
                ->sortable()
                ->filterable()
                ->hideWhenCreating()
                ->hideWhenUpdating(function () {
                    return Auth::user()->isAdmin() == false;
                }),

            Text::make('User Groups', function (\App\Models\User $model) {
                $userGroups = [];
                foreach ($model->userGroupMemberships as $membership) {
                    $userGroups[] = '<li>' . $membership->userGroup->name . '</li>';
                }

                return '<ul>' . implode($userGroups) . '</ul>';
            })
                ->onlyOnIndex()
                ->asHtml(),

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
