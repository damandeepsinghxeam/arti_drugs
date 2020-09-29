<?php

namespace App\Policies;

use App\User;
use App\DmsDocument;
use Illuminate\Auth\Access\HandlesAuthorization;

class DmsDocumentPolicy
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
     * Determine whether the user can view any dms documents.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        $permissions =  Auth::user()->permissions()->pluck('name')->toArray();
        if (in_array('index-dms-document', $permissions)) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can view the dms document.
     *
     * @param  \App\User  $user
     * @param  \App\DmsDocument  $dmsDocument
     * @return mixed
     */
    public function view(User $user, DmsDocument $dmsDocument)
    {
        //
    }

    /**
     * Determine whether the user can create dms documents.
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
     * Determine whether the user can update the dms document.
     *
     * @param  \App\User  $user
     * @param  \App\DmsDocument  $dmsDocument
     * @return mixed
     */
    public function update(User $user, DmsDocument $dmsDocument)
    {
        $permissions =  Auth::user()->permissions()->pluck('name')->toArray();
        if (in_array('update-dms-document', $permissions)) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can delete the dms document.
     *
     * @param  \App\User  $user
     * @param  \App\DmsDocument  $dmsDocument
     * @return mixed
     */
    public function delete(User $user, DmsDocument $dmsDocument)
    {
        $permissions =  Auth::user()->permissions()->pluck('name')->toArray();
        if (in_array('delete-dms-document', $permissions)) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can restore the dms document.
     *
     * @param  \App\User  $user
     * @param  \App\DmsDocument  $dmsDocument
     * @return mixed
     */
    public function restore(User $user, DmsDocument $dmsDocument)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the dms document.
     *
     * @param  \App\User  $user
     * @param  \App\DmsDocument  $dmsDocument
     * @return mixed
     */
    public function forceDelete(User $user, DmsDocument $dmsDocument)
    {
        //
    }
}
