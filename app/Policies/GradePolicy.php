<?php

namespace App\Policies;

use App\Models\Grade;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GradePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $this->allow();
    }

    public function view(User $user, Grade $grade)
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

    public function update(User $user, Grade $grade)
    {
        if ($user->isAdmin()) {
            return $this->allow();
        }

        return $this->deny();
    }

    public function delete(User $user, Grade $grade)
    {
        if ($user->isSuperAdmin()) {
            return $this->allow();
        }

        return $this->deny();
    }

    public function restore(User $user, Grade $grade)
    {
        if ($user->isSuperAdmin()) {
            return $this->allow();
        }

        return $this->deny();
    }

    public function forceDelete(User $user, Grade $grade)
    {
        //
    }
}
