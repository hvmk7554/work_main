<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserGroup;
use App\Models\UserGroupMembershipExample;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserGroupMembershipExamplePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->in(UserGroup::ADMINISTRATOR);
    }

    public function view(User $user, UserGroupMembershipExample $userGroupMembershipExample)
    {
        return $user->in(UserGroup::ADMINISTRATOR);
    }

    public function create(User $user)
    {
        return $user->in(UserGroup::ADMINISTRATOR);
    }

    public function update(User $user, UserGroupMembershipExample $userGroupMembershipExample)
    {
        return $user->in(UserGroup::ADMINISTRATOR);
    }

    public function delete(User $user, UserGroupMembershipExample $userGroupMembershipExample)
    {
        return $user->in(UserGroup::ADMINISTRATOR);
    }

    public function restore(User $user, UserGroupMembershipExample $userGroupMembershipExample)
    {
        //
    }

    public function forceDelete(User $user, UserGroupMembershipExample $userGroupMembershipExample)
    {
        //
    }
}
