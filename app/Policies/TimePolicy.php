<?php

namespace App\Policies;

use App\User;
use App\Time;
use Illuminate\Auth\Access\HandlesAuthorization;

class TimePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any times.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the time.
     *
     * @param  \App\User  $user
     * @param  \App\Time  $time
     * @return mixed
     */
    public function view(User $user, Time $time)
    {
        return $time->user_id == $user->id;
    }

    /**
     * Determine whether the user can create times.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the time.
     *
     * @param  \App\User  $user
     * @param  \App\Time  $time
     * @return mixed
     */
    public function update(User $user, Time $time)
    {
        //
    }

    /**
     * Determine whether the user can delete the time.
     *
     * @param  \App\User  $user
     * @param  \App\Time  $time
     * @return mixed
     */
    public function delete(User $user, Time $time)
    {
        //
    }

    /**
     * Determine whether the user can restore the time.
     *
     * @param  \App\User  $user
     * @param  \App\Time  $time
     * @return mixed
     */
    public function restore(User $user, Time $time)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the time.
     *
     * @param  \App\User  $user
     * @param  \App\Time  $time
     * @return mixed
     */
    public function forceDelete(User $user, Time $time)
    {
        //
    }
}
