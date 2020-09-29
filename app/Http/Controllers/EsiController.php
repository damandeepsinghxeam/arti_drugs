<?php

namespace App\Http\Controllers;

use App\Helpers\CalculatorHelper;
use Illuminate\Http\Request;
use App\Esi;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class EsiController extends Controller
{
    public function index(){
        $esis = Esi::get();
        return view('esi.index', compact('esis'));
    }

    public function create(){
        return view('esi.create');
    }

    public function store(Request $request){

        Esi::create([
            'employee_percent' => $request->employee_percent,
            'employer_percent' => $request->employer_percent,
            'cutoff' => $request->cutoff,
            'effective_esi_dt' => $request->effective_esi_dt,
        ]);

        return redirect()->route('payroll.esi.index')->with('success', 'New scheme of ESI successfully added');;
    }

    public function show(){
        return view('esi.show');
    }

    public function edit(Esi $esi){
        return view('esi.edit', compact('esi'));
    }

    public function update(Request $request, Esi $esi){

        Esi::where('id', $esi->id)->update([
            'employee_percent' => $request->employee_percent,
            'employer_percent' => $request->employer_percent,
            'cutoff' => $request->cutoff,
            'effective_esi_dt' => $request->effective_esi_dt,
        ]);

        return redirect()->route('payroll.esi.index')->with('success', 'ESI scheme is successfully updated');
    }

    public function destroy(Esi $esi){
        $esi->delete();
        return redirect()->route('payroll.esi.index')->with('success', 'ESI scheme is successfully deleted');
    }

    public function makeActive(Request $request){
        if($request->is_active == 1) {
            $esi = Esi::where('is_active', '1')->first();
            if ($esi != '') {
                return Redirect::back()->with('error', 'Another ESI Scheme is already active kindly In-Active it first Added');
            }

        }
        Esi::where('id', $request->esi_id)->update([
            'is_active' => $request->is_active
        ]);
        return redirect()->route('payroll.esi.index')->with('success', 'ESI scheme is successfully activated');;
    }

    public function calculateEsiForm(){
        return view('esi.calculate_esi');
    }

    public function calculateEsi(Request $request){
        $salary = $request->salary;
        $employeePercent = $request->employee_percent;
        $employerPercent = $request->employer_percent;

        $esi = CalculatorHelper::calculateEsi($salary, $employeePercent, $employerPercent);
        return Response::json(['success'=>true, 'result' => $esi]);
    }
}
