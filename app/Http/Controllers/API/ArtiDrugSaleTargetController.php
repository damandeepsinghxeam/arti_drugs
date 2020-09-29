<?php

namespace App\Http\Controllers\API;

use App\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Validator;

class ArtiDrugSaleTargetController extends Controller
{

    public function allEmployees(){
        $project = Project::where('name', 'Aarti Drugs Ltd')->first();
        $employees = DB::table('employees')
            ->join('employee_profiles', 'employee_profiles.user_id', 'employees.user_id')
            ->join('project_user', 'project_user.user_id', 'employees.user_id')
            ->where('project_user.project_id', $project->id)
            ->where('employees.isactive', 1)
            ->select('employees.user_id', 'employees.fullname')->orderBy('employees.fullname', 'ASC')->get();
        return response()->json(['status' => 'success', 'data' => $employees]);
    }

    public function saveTargets(Request $request){
        $validation =  Validator::make($request->all(),[
            'target_of'  => 'required',
            'user_id'  => 'required',
            'employee_name'  => 'required',
            'target'  => 'required',
        ]);


        if ($validation->fails()) {
            return response()->json(['validation_error' => $validation->errors()], 400);
        }

        $time  = strtotime($request->target_of);
        $month = date('m',$time);
        $year  = date('Y',$time);

        DB::table('arti_drugs_sale_targets')->insert([
            'date' => $request->target_of,
            'year' => $year,
            'month' => $month,
            'user_id' => $request->user_id,
            'employee_name' => $request->employee_name,
            'target' => $request->target
        ]);
        return response()->json(['status' => 'success', 'message' => 'Target Added Successfully']);
    }

    public function achieveTargets(Request $request){
        $validation =  Validator::make($request->all(),[
            'target_of'  => 'required',
            'user_id'  => 'required',
            'target'  => 'required',
        ]);
        $time  = strtotime($request->target_of);
        $month = date('m',$time);
        $year  = date('Y',$time);



        DB::table('arti_drugs_achieved_sale_targets')->insert([
            'date' => $request->target_of,
            'year' => $year,
            'month' => $month,
            'user_id' => $request->user_id,
            'achieved_target' => $request->target
        ]);

        $saleTarget = DB::table('arti_drugs_sale_targets')->where('year', $year)->where('month', $month)
            ->where('user_id', $request->user_id)->first();
        $achievedTarget = $saleTarget->achieved_target + $request->target;
        DB::table('arti_drugs_sale_targets')->where('year', $year)->where('month', $month)
            ->where('user_id', $request->user_id)->update([
                'achieved_target' => $achievedTarget
            ]);


        if($saleTarget->target <= $achievedTarget){
            DB::table('arti_drugs_sale_targets')->where('id', $saleTarget->id)->update([
                'status' => 1
            ]);
        }


        return response()->json(['status' => 'success', 'message' => 'Target Added Successfully']);
    }

    public function filter(Request $request){
        $time  = strtotime($request->target_of);
        $month = date('m',$time);
        $year  = date('Y',$time);

        $allTargets = DB::table('arti_drugs_sale_targets')->where('year', $year)->where('month', $month)->get();
        return response()->json(['status' => 'success', 'data' => $allTargets]);

    }

    public function employeeTarget(Request $request){
        $time  = strtotime($request->target_of);
        $month = date('m',$time);
        $year  = date('Y',$time);
        $saleTarget = DB::table('arti_drugs_sale_targets')->where('year', $year)->where('month', $month)
            ->where('user_id', $request->user_id)->first();

        $allTargets = DB::table('arti_drugs_achieved_sale_targets')->where('year', $year)->where('month', $month)->where('user_id', $request->user_id)->get();
        return response()->json(['status' => 'success', 'status' => $saleTarget->status, 'target' => $saleTarget->target, 'achieved_target' => $saleTarget->achieved_target, 'data' => $allTargets]);

    }
}
