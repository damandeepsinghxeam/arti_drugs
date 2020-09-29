<?php

namespace App\Http\Controllers;

use App\Project;
use App\SalaryCycle;
use Illuminate\Http\Request;

class SalaryCycleController extends Controller
{
    public function index(){
        $salaryCycles = SalaryCycle::all();
        $projects = Project::all();
        for ($i = 1; $i <= 31; ++$i) {
            $dates[] = $i;
        }
        return view('salary_cycle.index', compact('salaryCycles', 'projects', 'dates'));
    }

    public function create(){
        return view('salary_cycle.create');
    }

    public function store(Request $request){
        $request->validate([
            'salary_cycle_name' => 'required|max:50|unique:salary_cycles,name,NULL,id,deleted_at,NULL,project_id,'.$request->project_id,
        ]);

        SalaryCycle::create([
            'name' => $request->salary_cycle_name,
            'project_id' => $request->project_id,
            'salary_from' => $request->salary_from,
            'salary_to' => $request->salary_to
        ]);
        return redirect()->route('payroll.salary.cycle.index')->with('success','Salary Cycle created successfully!');
    }

    public function show(){
        return view('salary_cycle.show');
    }

    public function edit(SalaryCycle $salaryCycle){
        return view('salary_cycle.edit', compact('salaryCycle'));
    }

    public function update(Request $request, SalaryCycle $salaryCycle){
        $request->validate([
            'salary_cycle_name' => 'required|max:50|unique:salary_cycles,name,'.$salaryCycle->id.',id,deleted_at,NULL',
        ]);
        SalaryCycle::where('id',$salaryCycle->id)->update([
            'name' => $request->salary_cycle_name,
            'project_id' => $request->project_id,
            'salary_from' => $request->salary_from,
            'salary_to' => $request->salary_to
        ]);
        return redirect()->route('payroll.salary.cycle.index')->with('success','Salary Cycle updated successfully!');
    }

    public function destroy(SalaryCycle $salaryCycle){
        $salaryCycle->delete();
        return redirect()->route('payroll.salary.cycle.index')->with('success','Salary Cycle deleted successfully!');
    }
}
