<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SalaryHead;

class SalaryHeadController extends Controller
{
    public function index(){
        $salaryHeads = SalaryHead::orderBy('sort_by')->get();
        return view('salary_head.index', compact('salaryHeads'));
    }

    public function create(){
        return view('salary_head.create');
    }

    public function store(Request $request){
        $request->validate([
            'salary_head' => 'required|max:50|unique:salary_heads,name,NULL,id,deleted_at,NULL',
        ]);
        SalaryHead::create([
            'name' => $request->salary_head,
            'type' => $request->type
        ]);
        return redirect()->route('payroll.salary.head.index')->with('success','Salary Head created successfully!');
    }

    public function show(){
        return view('salary_head.show');
    }

    public function edit(SalaryHead $salaryHead){
        return view('salary_head.edit', compact('salaryHead'));
    }

    public function update(Request $request, SalaryHead $salaryHead){
        $request->validate([
            'salary_head' => 'required|max:50|unique:salary_heads,name,'.$salaryHead->id.',id,deleted_at,NULL',
        ]);
        SalaryHead::where('id',$salaryHead->id)->update([
            'name' => $request->salary_head,
            'type' => $request->type
        ]);

        return redirect()->route('payroll.salary.head.index')->with('success','Salary Head updated successfully!');
    }

    public function destroy(SalaryHead $salaryHead){
        $salaryHead->delete();
        return redirect()->route('payroll.salary.head.index')->with('success','Salary Head deleted successfully!');
    }
}
