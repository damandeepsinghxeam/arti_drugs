<?php

namespace App\Http\Controllers;

use App\State;
use Illuminate\Http\Request;
use App\Lwf;

class LwfController extends Controller
{
    public function index(){
        $lwfs = Lwf::get();
        return view('lwf.index', compact('lwfs'));
    }

    public function create(){
        $states = State::all();
        return view('lwf.create', compact('states'));
    }

    public function store(Request $request){
        $request->validate([
//            'state_id' => 'required|max:50|unique:lwfs,state_id,NULL,id,deleted_at,NULL',
        ]);
        Lwf::create([
            'state_id' => $request->state_id,
            'tenure' => $request->tenure,
            'min_salary' => $request->min_salary,
            'max_salary' => $request->max_salary,
            'employee_share' => $request->employee_share,
            'employer_share' => $request->employer_share,
        ]);
        return redirect()->route('payroll.lwf.index')->with('success','Lwf created successfully!');
    }

    public function show(){
        return view('lwf.show');
    }

    public function edit(Lwf $lwf){
        $states = State::all();
        return view('lwf.edit', compact('lwf', 'states'));
    }

    public function update(Request $request, Lwf $lwf){
        $request->validate([
//            'state_name' => 'required|max:50|unique:lwfs,name,'.$lwf->id.',id,deleted_at,NULL',
        ]);
        Lwf::where('id',$lwf->id)->update([
            'state_id' => $request->state_id,
            'tenure' => $request->tenure,
            'min_salary' => $request->min_salary,
            'max_salary' => $request->max_salary,
            'employee_share' => $request->employee_share,
            'employer_share' => $request->employer_share,
        ]);

        return redirect()->route('payroll.lwf.index')->with('success','Lwf updated successfully!');
    }

    public function destroy(Lwf $lwf){
        $lwf->delete();
        return redirect()->route('payroll.lwf.index')->with('success','Lwf deleted successfully!');
    }
}
