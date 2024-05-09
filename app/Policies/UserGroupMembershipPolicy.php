<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserGroupMembership;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserGroupMembershipPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $this->allow();
    }

    public function view(User $user, UserGroupMembership $userGroupMembership)
    {
        return $this->allow();
    }

    public function create(User $user)
    {
        if ($user->isAdmin()) {
            return $this->allow();
        }

        return $this->deny();
    }

    public function update(User $user, UserGroupMembership $userGroupMembership)
    {
        //
    }

    public function delete(User $user, UserGroupMembership $userGroupMembership)
    {
        if ($user->isAdmin()) {
            return $this->allow();
        }

        return $this->deny();
    }

    public function restore(User $user, UserGroupMembership $userGroupMembership)
    {
        //
    }

    public function forceDelete(User $user, UserGroupMembership $userGroupMembership)
    {
        //
    }
}
