<?php

namespace App\Policies;

use App\User;
use App\Pf;
use Illuminate\Auth\Access\HandlesAuthorization;

class PfPolicy
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
     * Determine whether the user can view any pfs.
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
                if($permission->name == 'index-pf'){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }

    /**
     * Determine whether the user can view the pf.
     *
     * @param  \App\User  $user
     * @param  \App\Pf  $pf
     * @return mixed
     */
    public function view(User $user, Pf $pf)
    {
        //
    }

    /**
     * Determine whether the user can create pfs.
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
                if($permission->name == 'create-pf'){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }

    /**
     * Determine whether the user can update the pf.
     *
     * @param  \App\User  $user
     * @param  \App\Pf  $pf
     * @return mixed
     */
    public function update(User $user, Pf $pf)
    {
        $user = Auth::user()->with(['roles:id'])->first();
        foreach($user->roles as $role){
            $permissions = DB::table('permissions as p')
                ->join('role_has_permissions as rp', 'p.id', '=', 'rp.permission_id')
                ->where('role_id',$role->id)
                ->select('p.name')
                ->get();

            foreach ($permissions as $permission){
                if($permission->name == 'update-pf'){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }

    /**
     * Determine whether the user can delete the pf.
     *
     * @param  \App\User  $user
     * @param  \App\Pf  $pf
     * @return mixed
     */
    public function delete(User $user, Pf $pf)
    {
        $user = Auth::user()->with(['roles:id'])->first();
        foreach($user->roles as $role){
            $permissions = DB::table('permissions as p')
                ->join('role_has_permissions as rp', 'p.id', '=', 'rp.permission_id')
                ->where('role_id',$role->id)
                ->select('p.name')
                ->get();

            foreach ($permissions as $permission){
                if($permission->name == 'delete-pf'){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }

    /**
     * Determine whether the user can restore the pf.
     *
     * @param  \App\User  $user
     * @param  \App\Pf  $pf
     * @return mixed
     */
    public function restore(User $user, Pf $pf)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the pf.
     *
     * @param  \App\User  $user
     * @param  \App\Pf  $pf
     * @return mixed
     */
    public function forceDelete(User $user, Pf $pf)
    {
        //
    }
}
