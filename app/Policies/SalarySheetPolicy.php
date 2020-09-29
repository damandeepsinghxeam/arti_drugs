<?php

namespace App\Policies;

use App\User;
use App\SalarySheet;
use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;
use DB;

class SalarySheetPolicy
{
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
                ->join('model_has_permissions as rp', 'p.id', '=', 'rp.permission_id')
                ->where('model_id', Auth::user()->id)
                ->select('p.name')
                ->get();

            foreach ($permissions as $permission){
                if($permission->name == 'index-salary-sheet'){
                    return true;
                }
            }
        }
    }

    /**
     * Determine whether the user can view the salary sheet.
     *
     * @param  \App\User  $user
     * @param  \App\SalarySheet  $salarySheet
     * @return mixed
     */
    public function view(User $user, SalarySheet $salarySheet)
    {
        //
    }

    /**
     * Determine whether the user can create salary sheets.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $user = Auth::user();
        if($user->hasPermissionTo('create-salary-sheet')){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can update the salary sheet.
     *
     * @param  \App\User  $user
     * @param  \App\SalarySheet  $salarySheet
     * @return mixed
     */
    public function update(User $user, SalarySheet $salarySheet)
    {
        $user = Auth::user()->with(['roles:id'])->first();
        foreach($user->roles as $role){
            $permissions = DB::table('permissions as p')
                ->join('model_has_permissions as rp', 'p.id', '=', 'rp.permission_id')
                ->where('model_id', Auth::user()->id)
                ->select('p.name')
                ->get();

            foreach ($permissions as $permission){
                if($permission->name == 'update-salary-sheet'){
                    return true;
                }
            }
        }
    }

    /**
     * Determine whether the user can delete the salary sheet.
     *
     * @param  \App\User  $user
     * @param  \App\SalarySheet  $salarySheet
     * @return mixed
     */
    public function delete(User $user, SalarySheet $salarySheet)
    {
        $user = Auth::user()->with(['roles:id'])->first();
        foreach($user->roles as $role){
            $permissions = DB::table('permissions as p')
                ->join('model_has_permissions as rp', 'p.id', '=', 'rp.permission_id')
                ->where('model_id', Auth::user()->id)
                ->select('p.name')
                ->get();

            foreach ($permissions as $permission){
                if($permission->name == 'delete-salary-sheet'){
                    return true;
                }
            }
        }
    }

    /**
     * Determine whether the user can restore the salary sheet.
     *
     * @param  \App\User  $user
     * @param  \App\SalarySheet  $salarySheet
     * @return mixed
     */
    public function restore(User $user, SalarySheet $salarySheet)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the salary sheet.
     *
     * @param  \App\User  $user
     * @param  \App\SalarySheet  $salarySheet
     * @return mixed
     */
    public function forceDelete(User $user, SalarySheet $salarySheet)
    {
        //
    }

    public function addArrear(User $user)
    {
        $user = Auth::user()->with(['roles:id'])->first();
        foreach($user->roles as $role){
            $permissions = DB::table('permissions as p')
                ->join('model_has_permissions as rp', 'p.id', '=', 'rp.permission_id')
                ->where('model_id', Auth::user()->id)
                ->select('p.name')
                ->get();

            foreach ($permissions as $permission){
                if($permission->name == 'add-arrear'){
                    return true;
                }
            }
        }
    }

    public function addDeduction(User $user)
    {
        $user = Auth::user()->with(['roles:id'])->first();
        foreach($user->roles as $role){
            $permissions = DB::table('permissions as p')
                ->join('model_has_permissions as rp', 'p.id', '=', 'rp.permission_id')
                ->where('model_id', Auth::user()->id)
                ->select('p.name')
                ->get();

            foreach ($permissions as $permission){
                if($permission->name == 'add-deduction'){
                    return true;
                }
            }
        }
    }

    public function forApproval(User $user)
    {
        $user = Auth::user();
        if($user->hasPermissionTo('for-approve-salary-sheet')){
            return true;
        }else{
            return false;
        }
    }

    public function hold(User $user)
    {
        $user = Auth::user()->with(['roles:id'])->first();
        foreach($user->roles as $role){
            $permissions = DB::table('permissions as p')
                ->join('model_has_permissions as rp', 'p.id', '=', 'rp.permission_id')
                ->where('model_id', Auth::user()->id)
                ->select('p.name')
                ->get();

            foreach ($permissions as $permission){
                if($permission->name == 'hold-salary-sheet'){
                    return true;
                }
            }
        }
    }

    public function approve(User $user)
    {
        $user = Auth::user()->with(['roles:id'])->first();
        foreach($user->roles as $role){
            $permissions = DB::table('permissions as p')
                ->join('model_has_permissions as rp', 'p.id', '=', 'rp.permission_id')
                ->where('model_id', Auth::user()->id)
                ->select('p.name')
                ->get();



            foreach ($permissions as $permission){
                if($permission->name == 'approve-salary-sheet'){
                    return true;
                }
            }
        }
    }

    public function paid(User $user)
    {
        $user = Auth::user()->with(['roles:id'])->first();
        foreach($user->roles as $role){
            $permissions = DB::table('permissions as p')
                ->join('model_has_permissions as rp', 'p.id', '=', 'rp.permission_id')
                ->where('model_id', Auth::user()->id)
                ->select('p.name')
                ->get();

            foreach ($permissions as $permission){
                if($permission->name == 'pay-salary-sheet'){
                    return true;
                }
            }
        }
    }
}
