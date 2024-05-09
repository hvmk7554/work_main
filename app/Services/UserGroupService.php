<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserGroup;

class UserGroupService
{
    private array $userGroupsMapping = [];

    public function isUserInGroup(User $user, array $needles): bool
    {
        $haystack = $this->retrieveUserGroups($user);
        foreach ($needles as $needle) {
            if (in_array($needle, $haystack)) {
                return true;
            }
        }

        return in_array(UserGroup::ADMINISTRATOR, $haystack);
    }

    private function retrieveUserGroups(User $user): array
    {
        if (isset($this->userGroupsMapping[$user->id])) {
            return $this->userGroupsMapping[$user->id];
        }

        $haystack = [];
        foreach ($user->userGroupMemberships as $membership) {
            $haystack[] = $membership->user_group_id;
        }

        $this->userGroupsMapping[$user->id] = $haystack;

        return $haystack;
    }
}
