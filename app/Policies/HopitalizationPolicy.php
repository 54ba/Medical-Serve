<?php

namespace App\Policies;

use App\Models\Hospitalization\Hospitalization;
use App\Models\Auth\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HopitalizationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any hospitalizations.
     *
     * @param  \App\Models\Auth\User\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the hospitalization.
     *
     * @param  \App\Models\Auth\User\User  $user
     * @param  \App\App\Hospitalization\Hospitalization  $hospitalization
     * @return mixed
     */
    public function view(User $user, Hospitalization $hospitalization)
    {
        //
    }

    /**
     * Determine whether the user can create hospitalizations.
     *
     * @param  \App\Models\Auth\User\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the hospitalization.
     *
     * @param  \App\Models\Auth\User\User  $user
     * @param  \App\App\Hospitalization\Hospitalization  $hospitalization
     * @return mixed
     */
    public function update(User $user, $slug)
    {
        return $user->slug == $slug ;
    }

    /**
     * Determine whether the user can delete the hospitalization.
     *
     * @param  \App\Models\Auth\User\User  $user
     * @param  \App\App\Hospitalization\Hospitalization  $hospitalization
     * @return mixed
     */
    public function delete(User $user, Hospitalization $hospitalization)
    {
        //
    }

    /**
     * Determine whether the user can restore the hospitalization.
     *
     * @param  \App\Models\Auth\User\User  $user
     * @param  \App\App\Hospitalization\Hospitalization  $hospitalization
     * @return mixed
     */
    public function restore(User $user, Hospitalization $hospitalization)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the hospitalization.
     *
     * @param  \App\Models\Auth\User\User  $user
     * @param  \App\App\Hospitalization\Hospitalization  $hospitalization
     * @return mixed
     */
    public function forceDelete(User $user, Hospitalization $hospitalization)
    {
        //
    }
}
