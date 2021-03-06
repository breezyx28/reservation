<?php

namespace App\Policies;

use App\Helper\ResponseMessage;
use App\Reservations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReservationAcceptPlicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Reservations  $reservations
     * @return mixed
     */
    public function view(User $user, Reservations $reservations)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Reservations  $reservations
     * @return mixed
     */
    public function update(User $user, Reservations $reservations)
    {
        try {
            auth()->user()->accountType == 'hospital';
            return true;
        } catch (\Exception $e) {
            return ResponseMessage::Error('غير مصرح', $e->getMessage());
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Reservations  $reservations
     * @return mixed
     */
    public function delete(User $user, Reservations $reservations)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Reservations  $reservations
     * @return mixed
     */
    public function restore(User $user, Reservations $reservations)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Reservations  $reservations
     * @return mixed
     */
    public function forceDelete(User $user, Reservations $reservations)
    {
        //
    }
}
