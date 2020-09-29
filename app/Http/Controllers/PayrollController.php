<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use View;

use App\Company;
use App\Location;
use App\State;
use App\EsiRegistration;
use App\PtRegistration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\User;
use App\Employee;
use App\Log;
use App\Project;
use App\ProjectContact;
use App\Country;
use App\City;
use App\SalaryStructure;
use App\SalaryCycle;
use App\DocumentCategory;
use App\Department;
use App\LeaveAuthority;
use App\Conveyance;
use App\Band;

//Travel Module Models
use App\TravelImprest;
use App\TravelApproval;
use App\TravelOtherApproval;
use App\TravelStay;
use App\TravelClaim;
use App\TravelClaimDetail;
use App\TravelClaimAttachment;
use App\SalaryHead;

use stdClass;
use Validator;


class PayrollController extends Controller
{
    //Salary heads are beign managed from here
    function salary_head(Request $request){
    	$data['edit']=0;

    	if($request->submit=='Add'){
    		$validatedData = $request->validate([
                'name' => 'required|max:255',
            ]);

            $obj=new SalaryHead;
            $obj->name=$request->name;
            $obj->save();


            return redirect()->back()->with('success',"Salary head created successfully.");
    	}

        if($request->id){
            $data['edit']=1;
            $data['rec']=SalaryHead::where('id', $request->id)->first();
            if($request->submit=='Update'){
                SalaryHead::where('id', $request->id)
                    ->update([
                        'name'=>$request->name
                    ]);
                return redirect()->back()->with('success',"Salary head updated successfully.");
            }
        }

    	$data['records']=SalaryHead::orderBy('name', 'asc')->get();


    	return view('payroll.salary_head', $data);
    }


    //Salary structure are beign managed from here
    function salary_cycle(Request $request){
        $data['edit']=0;

        if($request->submit=='Add'){
            $validatedData = $request->validate([
                'name' => 'required|max:255',
                'salary_to' => 'required',
                'salary_from' => 'required',
            ]);
            $obj=new SalaryCycle;
            $obj->name=$request->name;
            $obj->salary_from=$request->salary_from;
            $obj->salary_to=$request->salary_to;
            $obj->save();

            return redirect()->back()->with('success',"Salary cycle created successfully.");
        }

        if($request->id){
            $data['edit']=1;
            $data['rec']=SalaryCycle::where('id', $request->id)->first();
            if($request->submit=='Update'){
                SalaryCycle::where('id', $request->id)
                    ->update([
                        'name'=>$request->name
                    ]);
                return redirect()->back()->with('success',"Salary cycle updated successfully.");
            }
        }

        $data['records']=SalaryCycle::orderBy('name', 'asc')->get();
        return view('payroll.salary_cycle', $data);
    }


}
