<?php

namespace App\Policies;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class SubjectPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $this->allow();
    }

    public function view(User $user, Subject $subject): Response
    {
        return $this->allow();
    }

    public function create(User $user): Response
    {
        if ($user->isAdmin()) {
            return $this->allow();
        }
        return $this->deny();
    }

    public function update(User $user, Subject $subject): Response
    {
        if ($user->isAdmin()) {
            return $this->allow();
        }
        return $this->deny();
    }

    public function delete(User $user, Subject $subject): Response
    {
        if ($user->isSuperAdmin()) {
            return $this->allow();
        }

        return $this->deny();
    }

    public function restore(User $user, Subject $subject): Response
    {
        if ($user->isSuperAdmin()) {
            return $this->allow();
        }

        return $this->deny();
    }

    public function forceDelete(User $user, Subject $subject): Response
    {
        return $this->deny();
    }
}
