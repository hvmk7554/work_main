<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $this->allow();
    }

    public function view(User $user, User $model)
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

    public function update(User $user, User $model)
    {
        if ($user->id == $model->id) {
            return $this->allow();
        }

        if ($user->isAdmin()) {
            return $this->allow();
        }

        return $this->deny();
    }
}
