<?php

namespace App\Policies;

use App\User;
use App\Esi;
use Illuminate\Auth\Access\HandlesAuthorization;

class EsiPolicy
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
     * Determine whether the user can view any esis.
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
                if($permission->name == 'index-esi'){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }

    /**
     * Determine whether the user can view the esi.
     *
     * @param  \App\User  $user
     * @param  \App\Esi  $esi
     * @return mixed
     */
    public function view(User $user, Esi $esi)
    {
        //
    }

    /**
     * Determine whether the user can create esis.
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
                if($permission->name == 'create-esi'){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }

    /**
     * Determine whether the user can update the esi.
     *
     * @param  \App\User  $user
     * @param  \App\Esi  $esi
     * @return mixed
     */
    public function update(User $user, Esi $esi)
    {
        $user = Auth::user()->with(['roles:id'])->first();
        foreach($user->roles as $role){
            $permissions = DB::table('permissions as p')
                ->join('role_has_permissions as rp', 'p.id', '=', 'rp.permission_id')
                ->where('role_id',$role->id)
                ->select('p.name')
                ->get();

            foreach ($permissions as $permission){
                if($permission->name == 'update-esi'){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }

    /**
     * Determine whether the user can delete the esi.
     *
     * @param  \App\User  $user
     * @param  \App\Esi  $esi
     * @return mixed
     */
    public function delete(User $user, Esi $esi)
    {
        $user = Auth::user()->with(['roles:id'])->first();
        foreach($user->roles as $role){
            $permissions = DB::table('permissions as p')
                ->join('role_has_permissions as rp', 'p.id', '=', 'rp.permission_id')
                ->where('role_id',$role->id)
                ->select('p.name')
                ->get();

            foreach ($permissions as $permission){
                if($permission->name == 'delete-esi'){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }

    /**
     * Determine whether the user can restore the esi.
     *
     * @param  \App\User  $user
     * @param  \App\Esi  $esi
     * @return mixed
     */
    public function restore(User $user, Esi $esi)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the esi.
     *
     * @param  \App\User  $user
     * @param  \App\Esi  $esi
     * @return mixed
     */
    public function forceDelete(User $user, Esi $esi)
    {
        //
    }
}
