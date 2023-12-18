<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function before(User $user, string $ability): bool|null
    {

        if ($user->roles[0]->role_name === 'root_admin') {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {

        if ($user->roles[0]->role_name === 'cinema_admin') return true;

        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {

        $isAdmin = $user->roles[0]->role_name === 'cinema_admin';
        $hasValidCinema =  $model->cinemas->contains($user->roles[0]->pivot->cinema_id);

        if ($isAdmin &&  $hasValidCinema) return true;

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        $isAdmin = $user->roles[0]->role_name === 'cinema_admin';
        $hasValidCinema =  $model->cinemas->contains($user->roles[0]->pivot->cinema_id);

        if ($isAdmin &&  $hasValidCinema) return true;

        return false;
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        $isAdmin = $user->roles[0]->role_name === 'cinema_admin';
        $hasValidCinema =  $model->cinemas->contains($user->roles[0]->pivot->cinema_id);

        if ($isAdmin &&  $hasValidCinema) return true;

        return false;
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
        //
    }
}
