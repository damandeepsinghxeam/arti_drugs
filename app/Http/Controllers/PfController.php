<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pf;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use App\Helpers\CalculatorHelper;

class PfController extends Controller
{
    public function index(){
        $pfs = Pf::get();
        return view('pf.index', compact('pfs'));
    }

    public function create(){
        return view('pf.create');
    }

    public function store(Request $request){

        Pf::create([
            'epf_percent' => $request->epf_percent,
            'epf_cutoff' => $request->epf_cutoff,
            'pension_fund' => $request->pension_fund,
            'epf_ab' => $request->epf_ab,
            'acc_no2' => $request->acc_no2,
            'acc_no21' => $request->acc_no21,
            'acc_no22' => $request->acc_no22,
            'effective_pf_dt' => $request->effective_pf_dt,
            'total_pf' => $request->epf_percent + $request->pension_fund + $request->epf_ab + $request->acc_no2 + $request->acc_no21 + $request->acc_no22
        ]);

        return redirect()->route('payroll.pf.index')->with('success', 'New scheme of PF successfully added');
    }

    public function show(){
        return view('pf.show');
    }

    public function edit(Pf $pf){
        return view('pf.edit', compact('pf'));
    }

    public function update(Request $request, Pf $pf){
        Pf::where('id', $pf->id)->update([
            'epf_percent' => $request->epf_percent,
            'epf_cutoff' => $request->epf_cutoff,
            'pension_fund' => $request->pension_fund,
            'epf_ab' => $request->epf_ab,
            'acc_no2' => $request->acc_no2,
            'acc_no21' => $request->acc_no21,
            'acc_no22' => $request->acc_no22,
            'effective_pf_dt' => $request->effective_pf_dt,
            'total_pf' => $request->epf_percent + $request->pension_fund + $request->epf_ab + $request->acc_no2 + $request->acc_no21 + $request->acc_no22
        ]);

        return redirect()->route('payroll.pf.index')->with('success', 'Pf scheme is successfully updated');;
    }

    public function destroy(Pf $pf){
        $pf->delete();
        return redirect()->route('payroll.pf.index')->with('success', 'Pf scheme is successfully deleted');
    }

    public function makeActive(Request $request){
        if($request->is_active == 1) {
            $pf = Pf::where('is_active', '1')->first();
            if ($pf != '') {
                return Redirect::back()->with('error', 'Another PF Scheme is already active kindly In-Active it first Added');
            }
        }
        Pf::where('id', $request->pf_id)->update([
            'is_active' => $request->is_active
        ]);
        return redirect()->route('payroll.pf.index')->with('success', 'PF scheme is successfully activated');
    }

    public function calculatePfForm(){
        return view('pf.calculate_pf');
    }

    public function calculatePf(Request $request){
        $salary = $request->salary;
        $pfInterest = $request->epf_percent;
        $pf = CalculatorHelper::calculatePf($pfInterest, $salary);
        return Response::json(['success'=>true, 'result' => $pf]);
    }
}

