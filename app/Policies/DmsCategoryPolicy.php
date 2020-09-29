<?php

namespace App\Policies;

use App\User;
use App\DmsCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class DmsCategoryPolicy
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
     * Determine whether the user can view any dms categories.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        $permissions =  Auth::user()->permissions()->pluck('name')->toArray();
        if (in_array('index-dms-category', $permissions)) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can view the dms category.
     *
     * @param  \App\User  $user
     * @param  \App\DmsCategory  $dmsCategory
     * @return mixed
     */
    public function view(User $user, DmsCategory $dmsCategory)
    {
        //
    }

    /**
     * Determine whether the user can create dms categories.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $permissions =  Auth::user()->permissions()->pluck('name')->toArray();
        if (in_array('create-dms-category', $permissions)) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can update the dms category.
     *
     * @param  \App\User  $user
     * @param  \App\DmsCategory  $dmsCategory
     * @return mixed
     */
    public function update(User $user, DmsCategory $dmsCategory)
    {
        $permissions =  Auth::user()->permissions()->pluck('name')->toArray();
        if (in_array('update-dms-category', $permissions)) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can delete the dms category.
     *
     * @param  \App\User  $user
     * @param  \App\DmsCategory  $dmsCategory
     * @return mixed
     */
    public function delete(User $user, DmsCategory $dmsCategory)
    {
        $permissions =  Auth::user()->permissions()->pluck('name')->toArray();
        if (in_array('delete-dms-category', $permissions)) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can restore the dms category.
     *
     * @param  \App\User  $user
     * @param  \App\DmsCategory  $dmsCategory
     * @return mixed
     */
    public function restore(User $user, DmsCategory $dmsCategory)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the dms category.
     *
     * @param  \App\User  $user
     * @param  \App\DmsCategory  $dmsCategory
     * @return mixed
     */
    public function forceDelete(User $user, DmsCategory $dmsCategory)
    {
        //
    }
}
