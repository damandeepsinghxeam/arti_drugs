<?php

namespace App\Policies;

use App\User;
use App\SalaryCycle;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalaryCyclePolicy
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
     * Determine whether the user can view any salary cycles.
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
                if($permission->name == 'index-salary-cycle'){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }

    /**
     * Determine whether the user can view the salary cycle.
     *
     * @param  \App\User  $user
     * @param  \App\SalaryCycle  $salaryCycle
     * @return mixed
     */
    public function view(User $user, SalaryCycle $salaryCycle)
    {
        //
    }

    /**
     * Determine whether the user can create salary cycles.
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
                if($permission->name == 'create-salary-cycle'){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }

    /**
     * Determine whether the user can update the salary cycle.
     *
     * @param  \App\User  $user
     * @param  \App\SalaryCycle  $salaryCycle
     * @return mixed
     */
    public function update(User $user, SalaryCycle $salaryCycle)
    {
        $user = Auth::user()->with(['roles:id'])->first();
        foreach($user->roles as $role){
            $permissions = DB::table('permissions as p')
                ->join('role_has_permissions as rp', 'p.id', '=', 'rp.permission_id')
                ->where('role_id',$role->id)
                ->select('p.name')
                ->get();

            foreach ($permissions as $permission){
                if($permission->name == 'update-salary-cycle'){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }

    /**
     * Determine whether the user can delete the salary cycle.
     *
     * @param  \App\User  $user
     * @param  \App\SalaryCycle  $salaryCycle
     * @return mixed
     */
    public function delete(User $user, SalaryCycle $salaryCycle)
    {
        $user = Auth::user()->with(['roles:id'])->first();
        foreach($user->roles as $role){
            $permissions = DB::table('permissions as p')
                ->join('role_has_permissions as rp', 'p.id', '=', 'rp.permission_id')
                ->where('role_id',$role->id)
                ->select('p.name')
                ->get();

            foreach ($permissions as $permission){
                if($permission->name == 'delete-salary-cycle'){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }

    /**
     * Determine whether the user can restore the salary cycle.
     *
     * @param  \App\User  $user
     * @param  \App\SalaryCycle  $salaryCycle
     * @return mixed
     */
    public function restore(User $user, SalaryCycle $salaryCycle)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the salary cycle.
     *
     * @param  \App\User  $user
     * @param  \App\SalaryCycle  $salaryCycle
     * @return mixed
     */
    public function forceDelete(User $user, SalaryCycle $salaryCycle)
    {
        //
    }
}
