<?php

namespace App\Http\Controllers;

use App\State;
use Illuminate\Http\Request;
use App\PtRate;
use DB;

class PtRateController extends Controller
{
    public function index(){
        $ptRates = PtRate::all();
        return view('pt_rate.index', compact('ptRates'));
    }

    public function create(){
        $states = State::all();
        return view('pt_rate.create', compact('states'));
    }

    public function store(Request $request){
        $request->validate([
            'certificate_number' => 'required|max:50|unique:pt_rates,certificate_number,NULL,id,deleted_at,NULL',
            'si_number' => 'required|max:50|unique:pt_rates,si_number,NULL,id,deleted_at,NULL',
        ]);
        $ptRate = PtRate::create([
            'state_id' => $request->state_id,
            'effective_month' => $request->effective_month,
            'si_number' => $request->si_number,
            'circle_no' => $request->circle_no,
            'certificate_number' => $request->certificate_number,
        ]);

        for($i = 0; $i < count($request->min_salary); $i++){
            DB::table('pt_rate_salary_ranges')->insert([
                'pt_rate_id' => $ptRate->id,
                'min_salary' => $request->min_salary[$i],
                'max_salary' => $request->max_salary[$i],
                'pt_rate' => $request->pt_rate[$i],
            ]);
        }
        return redirect()->route('payroll.pt.rate.index')->with('success','PT Rate created successfully!');;
    }

    public function show(){
        return view('payroll.pt.rate.show');
    }

    public function edit(PtRate $ptRate){
        $states = State::all();
        $ptRateSaleRanges = DB::table('pt_rate_salary_ranges')->where('pt_rate_id', $ptRate->id)->get();
        return view('pt_rate.edit', compact('ptRate', 'states', 'ptRateSaleRanges'));
    }

    public function update(Request $request, PtRate $ptRate){
        $request->validate([
            'certificate_number' => 'required|max:50|unique:pt_rates,certificate_number,'.$ptRate->id.',id,deleted_at,NULL',
            'si_number' => 'required|max:50|unique:pt_rates,si_number,'.$ptRate->id.',id,deleted_at,NULL',
        ]);

        PtRate::where('id',$ptRate->id)->update([
            'state_id' => $request->state_id,
            'effective_month' => $request->effective_month,
            'si_number' => $request->si_number,
            'circle_no' => $request->circle_no,
            'certificate_number' => $request->certificate_number,
        ]);

        for($i = 0; $i < count($request->pt_rate_salary_range_id); $i++) {
            DB::table('pt_rate_salary_ranges')->where('pt_rate_id', $ptRate->id)->where('id', $request->pt_rate_salary_range_id[$i])->update([
                'min_salary' => $request->min_salary[$i],
                'max_salary' => $request->max_salary[$i],
                'pt_rate' => $request->pt_rate[$i],
            ]);
        }

        if(count($request->pt_rate_salary_range_id) < count($request->min_salary)) {
            for ($j = $i; $j < count($request->min_salary); $j++) {
                DB::table('pt_rate_salary_ranges')->where('pt_rate_id', $ptRate->id)->insert([
                    'min_salary' => $request->min_salary[$i],
                    'max_salary' => $request->max_salary[$i],
                    'pt_rate' => $request->pt_rate[$i],
                    'pt_rate_id' => $ptRate->id,
                ]);
            }
        }

        return redirect()->route('payroll.pt.rate.index');
    }

    public function destroy(PtRate $ptRate){
        $ptRate->delete();
        return redirect()->route('payroll.pt.rate.index');
    }
}
