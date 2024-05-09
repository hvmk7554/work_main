<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserGroupPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $this->allow();
    }

    public function view(User $user, UserGroup $userGroup)
    {
        return $this->allow();
    }
}
