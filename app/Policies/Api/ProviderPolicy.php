<?php

namespace App\Policies\Api;

use App\Models\Provider;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProviderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Provider $provider)
    {
        return $this->checkMorph($provider);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Provider $provider)
    {
        return $this->checkMorph($provider);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Provider $provider)
    {
        return $this->checkMorph($provider);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Provider $provider)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Provider $provider)
    {
        return true;
    }

    private function checkMorph($provider)
    {
        return application()->providers()->where('id', $provider->id)->exists();
    }
}
