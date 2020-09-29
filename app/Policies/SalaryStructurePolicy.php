<?php

namespace App\Policies;

use App\SalaryStructure;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalaryStructurePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
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
     * Determine whether the user can view any salary sheets.
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
                if($permission->name == 'index-salary-structure'){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }

    /**
     * Determine whether the user can view the salary structure.
     *
     * @param  \App\User  $user
     * @param  \App\SalaryStructure  $salaryStructure
     * @return mixed
     */
    public function view(User $user, SalaryStructure $salaryStructure)
    {
        //
    }

    /**
     * Determine whether the user can create salary structures.
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
                if($permission->name == 'create-salary-structure'){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }






    /**
     * Determine whether the user can update the salary structure.
     *
     * @param  \App\User  $user
     * @param  \App\SalaryStructure  $salaryStructure
     * @return mixed
     */
    public function update(User $user, SalaryStructure $salaryStructure)
    {
        $user = Auth::user()->with(['roles:id'])->first();
        foreach($user->roles as $role){
            $permissions = DB::table('permissions as p')
                ->join('role_has_permissions as rp', 'p.id', '=', 'rp.permission_id')
                ->where('role_id',$role->id)
                ->select('p.name')
                ->get();

            foreach ($permissions as $permission){
                if($permission->name == 'update-salary-structure'){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }

    /**
     * Determine whether the user can delete the salary structure.
     *
     * @param  \App\User  $user
     * @param  \App\SalaryStructure  $salaryStructure
     * @return mixed
     */
    public function delete(User $user, SalaryStructure $salaryStructure)
    {
        $user = Auth::user()->with(['roles:id'])->first();
        foreach($user->roles as $role){
            $permissions = DB::table('permissions as p')
                ->join('role_has_permissions as rp', 'p.id', '=', 'rp.permission_id')
                ->where('role_id',$role->id)
                ->select('p.name')
                ->get();

            foreach ($permissions as $permission){
                if($permission->name == 'delete-salary-structure'){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }

    /**
     * Determine whether the user can restore the salary structure.
     *
     * @param  \App\User  $user
     * @param  \App\SalaryStructure  $salaryStructure
     * @return mixed
     */
    public function restore(User $user, SalaryStructure $salaryStructure)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the salary structure.
     *
     * @param  \App\User  $user
     * @param  \App\SalaryStructure  $salaryStructure
     * @return mixed
     */
    public function forceDelete(User $user, SalaryStructure $salaryStructure)
    {
        //
    }
}
