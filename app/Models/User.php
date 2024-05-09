<?php

namespace App\Models;

use App\Services\UserGroupService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Nova\Auth\Impersonatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Impersonatable, Notifiable;

    protected $connection = "mysql";

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function canImpersonate()
    {
        return $this->isAdmin();
    }

    public function canBeImpersonated()
    {
        return $this->email == 'insight-qa@marathon.edu.vn';
    }

    public function isSuperAdmin(): bool
    {
        return $this->authority_level >= 5;
    }

    public function isAdmin(): bool
    {
        return $this->authority_level >= 4;
    }

    public function isOwner(): bool
    {
        return $this->authority_level >= 3;
    }

    public function isEditor(): bool
    {
        return $this->authority_level >= 2;
    }

    public function isCustomerService(): bool
    {
        return $this->authority_level == -1;
    }

    public function in(...$needles): bool
    {
        return resolve(UserGroupService::class)->isUserInGroup($this, $needles);
    }

    public function userGroupMemberships(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserGroupMembership::class);
    }
}
