<?php

namespace App\Policies;

use App\User;
use App\DmsKeyword;
use Illuminate\Auth\Access\HandlesAuthorization;

class DmsKeywordPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if($user->hasRole('MD') || $user->hasRole('AGM') || $user->id == 1){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Determine whether the user can view any dms keywords.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        $permissions =  Auth::user()->permissions()->pluck('name')->toArray();
        if (in_array('index-dms-keyword', $permissions)) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can view the dms keyword.
     *
     * @param  \App\User  $user
     * @param  \App\DmsKeyword  $dmsKeyword
     * @return mixed
     */
    public function view(User $user, DmsKeyword $dmsKeyword)
    {
        //
    }

    /**
     * Determine whether the user can create dms keywords.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $permissions =  Auth::user()->permissions()->pluck('name')->toArray();
        if (in_array('create-dms-document', $permissions)) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can update the dms keyword.
     *
     * @param  \App\User  $user
     * @param  \App\DmsKeyword  $dmsKeyword
     * @return mixed
     */
    public function update(User $user, DmsKeyword $dmsKeyword)
    {
        $permissions =  Auth::user()->permissions()->pluck('name')->toArray();
        if (in_array('update-dms-document', $permissions)) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can delete the dms keyword.
     *
     * @param  \App\User  $user
     * @param  \App\DmsKeyword  $dmsKeyword
     * @return mixed
     */
    public function delete(User $user, DmsKeyword $dmsKeyword)
    {
        $permissions =  Auth::user()->permissions()->pluck('name')->toArray();
        if (in_array('delete-dms-document', $permissions)) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can restore the dms keyword.
     *
     * @param  \App\User  $user
     * @param  \App\DmsKeyword  $dmsKeyword
     * @return mixed
     */
    public function restore(User $user, DmsKeyword $dmsKeyword)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the dms keyword.
     *
     * @param  \App\User  $user
     * @param  \App\DmsKeyword  $dmsKeyword
     * @return mixed
     */
    public function forceDelete(User $user, DmsKeyword $dmsKeyword)
    {
        //
    }
}
