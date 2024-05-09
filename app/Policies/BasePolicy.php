<?php
namespace App\Policies;

use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;

abstract class BasePolicy{
    use HandlesAuthorization;

    public array $permission = [];

    /**
     * array | create, update, destroy, restore
     * @return array
     */
    abstract function getPermission(): array;

    public function __construct()
    {
        $this->permission = $this->getPermission();
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return Response
     */
    public function viewAny($user)
    {
        return $this->allow();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Model $model
     * @return Response
     */
    public function view($user,$model)
    {
        return $this->allow();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return Response
     */
    public function create($user)
    {
        if (isset($this->permission['write']) && $user->in($this->permission['write'])) {
            return $this->allow();
        }

        if ($user->isOwner()) {
            return $this->allow();
        }

        return $this->deny();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Model $model
     * @return Response
     */
    public function update($user,$model)
    {
        if (isset($this->permission['update']) && $user->in($this->permission['update'])) {
            return $this->allow();
        }

        if ($user->isAdmin() || $user->isCustomerService()) {
            return $this->allow();
        }

        return $this->deny();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Model $model
     * @return Response
     */
    public function delete($user,$model)
    {
        if (isset($this->permission['destroy']) && $user->in($this->permission['destroy'])) {
            return $this->allow();
        }

        if ($user->isOwner()){
            return $this->allow();
        }

        return $this->deny();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  Model $model
     * @return Response
     */
    public function restore($user,$model)
    {
        if (isset($this->permission['restore']) && $user->in($this->permission['restore'])) {
            return $this->allow();
        }

        return $this->deny();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  Model  $model
     * @return void
     */
    public function forceDelete($user,$model)
    {
        //
    }

    public function allowEdit(User $user, int|null $permission = null): Response
    {
        $permission = ($permission) ?: $this->permission['write'];
        if ($user->in($permission) || $user->isOwner()) {
            return $this->allow();
        }

        return $this->deny();
    }


}
