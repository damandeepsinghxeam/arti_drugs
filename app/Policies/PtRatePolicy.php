<?php

namespace App\Policies;

use App\User;
use App\PtRate;
use Illuminate\Auth\Access\HandlesAuthorization;

class PtRatePolicy
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
     * Determine whether the user can view any pt rates.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        $user = Auth::user()->with(['roles:id'])->first();
        foreach($user->roles as $role){
            $permissions = DB::table('permissions as p')
                ->join('role_has_permissions as rp', 'p.id', '=', 'rp.permission_id')
                ->where('role_id',$role->id)
                ->select('p.name')
                ->get();

            foreach ($permissions as $permission){
                if($permission->name == 'index-pt-rate'){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }

    /**
     * Determine whether the user can view the pt rate.
     *
     * @param  \App\User  $user
     * @param  \App\PtRate  $ptRate
     * @return mixed
     */
    public function view(User $user, PtRate $ptRate)
    {
        //
    }

    /**
     * Determine whether the user can create pt rates.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $user = Auth::user()->with(['roles:id'])->first();
        foreach($user->roles as $role){
            $permissions = DB::table('permissions as p')
                ->join('role_has_permissions as rp', 'p.id', '=', 'rp.permission_id')
                ->where('role_id',$role->id)
                ->select('p.name')
                ->get();

            foreach ($permissions as $permission){
                if($permission->name == 'create-pt-rate'){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }

    /**
     * Determine whether the user can update the pt rate.
     *
     * @param  \App\User  $user
     * @param  \App\PtRate  $ptRate
     * @return mixed
     */
    public function update(User $user, PtRate $ptRate)
    {
        $user = Auth::user()->with(['roles:id'])->first();
        foreach($user->roles as $role){
            $permissions = DB::table('permissions as p')
                ->join('role_has_permissions as rp', 'p.id', '=', 'rp.permission_id')
                ->where('role_id',$role->id)
                ->select('p.name')
                ->get();

            foreach ($permissions as $permission){
                if($permission->name == 'update-pt-rate'){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }

    /**
     * Determine whether the user can delete the pt rate.
     *
     * @param  \App\User  $user
     * @param  \App\PtRate  $ptRate
     * @return mixed
     */
    public function delete(User $user, PtRate $ptRate)
    {
        $user = Auth::user()->with(['roles:id'])->first();
        foreach($user->roles as $role){
            $permissions = DB::table('permissions as p')
                ->join('role_has_permissions as rp', 'p.id', '=', 'rp.permission_id')
                ->where('role_id',$role->id)
                ->select('p.name')
                ->get();

            foreach ($permissions as $permission){
                if($permission->name == 'delete-pt-rate'){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }

    /**
     * Determine whether the user can restore the pt rate.
     *
     * @param  \App\User  $user
     * @param  \App\PtRate  $ptRate
     * @return mixed
     */
    public function restore(User $user, PtRate $ptRate)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the pt rate.
     *
     * @param  \App\User  $user
     * @param  \App\PtRate  $ptRate
     * @return mixed
     */
    public function forceDelete(User $user, PtRate $ptRate)
    {
        //
    }
}
