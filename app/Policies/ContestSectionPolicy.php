<?php

namespace App\Policies;

use App\Models\ContestSection;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContestSectionPolicy
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
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ContestSection  $contestSection
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ContestSection $contestSection)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ContestSection  $contestSection
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ContestSection $contestSection)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ContestSection  $contestSection
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ContestSection $contestSection)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ContestSection  $contestSection
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ContestSection $contestSection)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ContestSection  $contestSection
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ContestSection $contestSection)
    {
        //
    }
}
