<?php

namespace App\Policies;

use App\Models\GroupProgramType;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupProgramTypePolicy
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

    public function view(User $user, GroupProgramType $groupProgramType)
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

    public function update(User $user, GroupProgramType $groupProgramType)
    {
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return $this->allow();
        }
        if ($user->in(UserGroup::PROMOTION_WRITE)) {
            return $this->allow();
        }

        return $this->deny();
    }

    public function delete(User $user, GroupProgramType $groupProgramType)
    {
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return $this->allow();
        }
        if ($user->in(UserGroup::PROMOTION_DELETE)) {
            return $this->allow();
        }

        return $this->deny();
    }

    public function restore(User $user, GroupProgramType $groupProgramType)
    {
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return $this->allow();
        }

        return $this->deny();
    }

    public function forceDelete(User $user, GroupProgramType $groupProgramType)
    {
        if ($user->isSuperAdmin()) {
            return $this->allow();
        }

        return $this->deny();
    }
}
