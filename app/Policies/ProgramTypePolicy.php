<?php

namespace App\Policies;

use App\Models\ProgramType;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProgramTypePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return $this->allow();
        }
        if ($user->in(UserGroup::PROMOTION_READ)) {
            return $this->allow();
        }
        return $this->deny();
    }

    public function view(User $user, ProgramType $programType)
    {
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return $this->allow();
        }
        if ($user->in(UserGroup::PROMOTION_READ)) {
            return $this->allow();
        }
    }

    public function create(User $user)
    {
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return $this->allow();
        }
        if ($user->in(UserGroup::PROMOTION_WRITE)) {
            return $this->allow();
        }

        return $this->deny();
    }

    public function update(User $user, ProgramType $programType)
    {
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return $this->allow();
        }
        if ($user->in(UserGroup::PROMOTION_WRITE)) {
            return $this->allow();
        }

        return $this->deny();
    }

    public function delete(User $user, ProgramType $programType)
    {
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return $this->allow();
        }
        if ($user->in(UserGroup::PROMOTION_DELETE)) {
            return $this->allow();
        }

        return $this->deny();
    }

    public function restore(User $user, ProgramType $programType)
    {
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return $this->allow();
        }

        return $this->deny();
    }

    public function forceDelete(User $user, ProgramType $programType)
    {
        if ($user->isSuperAdmin()) {
            return $this->allow();
        }

        return $this->deny();
    }
}
