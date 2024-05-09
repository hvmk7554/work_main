<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\Teacher;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $this->allow();
    }

    public function view(User $user, Course $course)
    {
        return $this->allow();
    }

    public function create(User $user)
    {
        if ($user->in(UserGroup::COURSE_WRITE)) {
            return $this->allow();
        }

        if ($user->isOwner()) {
            return $this->allow();
        }

        return $this->deny();
    }

    public function update(User $user, Course $course)
    {
        if ($user->in(UserGroup::COURSE_WRITE)) {
            return $this->allow();
        }

        if ($user->isOwner()) {
            return $this->allow();
        }

        return $this->deny();
    }

    public function delete(User $user, Course $course)
    {
        if ($user->in(UserGroup::COURSE_DESTROY)) {
            return $this->allow();
        }

        if ($user->isSuperAdmin()) {
            return $this->allow();
        }

        return $this->deny();
    }

    public function restore(User $user, Course $course)
    {
        if ($user->in(UserGroup::COURSE_DESTROY)) {
            return $this->allow();
        }

        if ($user->isSuperAdmin()) {
            return $this->allow();
        }

        return $this->deny();
    }

    public function forceDelete(User $user, Course $course)
    {
        //
    }

    public function attachAnyTeacher(User $user, Course $record)
    {
        if ($user->in(UserGroup::COURSE_WRITE)) {
            return $this->allow();
        }

        if ($user->isOwner()) {
            return $this->allow();
        }

        return $this->deny();
    }

    public function detachTeacher(User $user, Course $record, Teacher $target)
    {
        if ($user->in(UserGroup::COURSE_WRITE)) {
            return $this->allow();
        }

        if ($user->isOwner()) {
            return $this->allow();
        }

        return $this->deny();
    }

    public function attachAnyStudent(User $user, Course $course)
    {
        if ($user->isSuperAdmin()) {
            return $this->allow();
        }

        return $this->deny();
    }

    public function detachStudent(User $user)
    {
        return $this->deny();
    }
}
