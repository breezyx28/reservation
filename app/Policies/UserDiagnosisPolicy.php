<?php

namespace App\Policies;

use App\Helper\ResponseMessage;
use App\User;
use App\UserDiagnosis;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserDiagnosisPolicy
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
     * @param  \App\UserDiagnosis  $userDiagnosis
     * @return mixed
     */
    public function view(User $user, UserDiagnosis $userDiagnosis)
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
     * @param  \App\UserDiagnosis  $userDiagnosis
     * @return mixed
     */
    public function update(User $user, UserDiagnosis $userDiagnosis)
    {
        $lab = auth()->user();
        if ($lab->accountType == 'lab' && $userDiagnosis->labID == $lab->userID) {
            return true;
        } else {
            return ResponseMessage::Error('غير مصرح');
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\UserDiagnosis  $userDiagnosis
     * @return mixed
     */
    public function delete(User $user, UserDiagnosis $userDiagnosis)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\UserDiagnosis  $userDiagnosis
     * @return mixed
     */
    public function restore(User $user, UserDiagnosis $userDiagnosis)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\UserDiagnosis  $userDiagnosis
     * @return mixed
     */
    public function forceDelete(User $user, UserDiagnosis $userDiagnosis)
    {
        //
    }
}
