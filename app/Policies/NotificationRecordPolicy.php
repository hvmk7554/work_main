<?php

namespace App\Policies;

use App\Models\NotificationRecord;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotificationRecordPolicy
{
    use HandlesAuthorization;

    public function view(User $user, NotificationRecord $record)
    {
        return $this->allow();
    }

    public function create(User $user)
    {
        return $this->deny();
    }

    public function update(User $user, NotificationRecord $record)
    {
        return $this->deny();
    }

    public function delete(User $user, NotificationRecord $record)
    {
        return $this->deny();
    }
}
