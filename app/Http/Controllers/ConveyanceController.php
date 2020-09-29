<?php

namespace App\Http\Controllers;

use App\Band;
use App\Conveyance;
use Illuminate\Http\Request;

class ConveyanceController extends Controller
{
    public function index(){
        $conveyances = Conveyance::get();
        return view('conveyance.index', compact('conveyances'));
    }

    public function create(){
        $bands = Band::where('isactive', 1)->get();
        return view('conveyance.create', compact('bands'));
    }

    public function store(Request $request){
        if($request->is_local == ''){
            $isLocal = 0;
        }else{
            $isLocal = $request->is_local;
        }

        if($request->is_attachment == ''){
            $isAttachment = 0;
        }else{
            $isAttachment = $request->is_attachment;
        }
        $conveyance = Conveyance::create([
            'name' => $request->conveyance_name,
            'price_per_km' => $request->price_per_km,
            'islocal' => $isLocal,
            'is_attachment' => $isAttachment
        ]);
        $conveyance->bands()->sync($request->bands);

        return redirect()->route('conveyance.index')->with('success', 'New Conveyance successfully added');;
    }

    public function show(){
        return view('conveyance.show');
    }

    public function edit(Conveyance $conveyance){
        $bands = Band::where('isactive', 1)->get();
        $conveyanceBands =  $conveyance->bands->pluck('id')->toArray();
        return view('conveyance.edit', compact('conveyance', 'bands', 'conveyanceBands'));
    }

    public function update(Request $request, Conveyance  $conveyance){
        if($request->is_local == ''){
            $isLocal = 0;
        }else{
            $isLocal = $request->is_local;
        }

        if($request->is_attachment == ''){
            $isAttachment = 0;
        }else{
            $isAttachment = $request->is_attachment;
        }
        Conveyance::where('id', $conveyance->id)->update([
            'name' => $request->conveyance_name,
            'price_per_km' => $request->price_per_km,
            'islocal' => $isLocal,
            'is_attachment' => $isAttachment
        ]);
        $conveyance->bands()->sync($request->bands);

        return redirect()->route('conveyance.index')->with('success', 'Conveyance is successfully updated');
    }

    public function destroy(Conveyance $conveyance){
        $conveyance->bands()->detach();
        $conveyance->delete();
        return redirect()->route('payroll.conveyance.index')->with('success', 'Conveyance is successfully deleted');
    }

    public function makeActive(Request $request){
        Conveyance::where('id', $request->conveyance_id)->update([
            'is_active' => $request->is_active
        ]);
        return redirect()->route('payroll.conveyance.index')->with('success', 'Conveyance Status is successfully Updated');;
    }

}
