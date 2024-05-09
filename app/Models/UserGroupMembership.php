<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;

class UserGroupMembership extends Model
{
    use Actionable, HasFactory;

    public function userGroup(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(UserGroup::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
