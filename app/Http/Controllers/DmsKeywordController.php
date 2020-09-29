<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DmsKeyword;

class DmsKeywordController extends Controller
{
    public function index(){
        $dmsKeywords = DmsKeyword::where('isActive','1')->orderBy('id','DESC')->get();
        return view('dms_keyword.index', compact('dmsKeywords'));
    }

    public function create(){
        return view('dms_keyword.create');
    }

    public function store(Request $request){
        $request->validate([
            'document_keyword' => 'required|max:50|unique:dms_keywords,name,NULL,id,deleted_at,NULL',
        ]);
        DmsKeyword::create([
            'name' => $request->document_keyword
        ]);
        return redirect()->route('dms.keyword.index')->with('success','Dms Keyword created successfully!');
    }

    public function show(){
        return view('dms_keyword.show');
    }

    public function edit(DmsKeyword $dmsKeyword){
        return view('dms_keyword.edit', compact('dmsKeyword'));
    }

    public function update(Request $request, DmsKeyword $dmsKeyword){
        $request->validate([
            'document_keyword' => 'required|max:50|unique:dms_keywords,name,'.$dmsKeyword->id.',id,deleted_at,NULL',
        ]);
        DmsKeyword::where('id',$dmsKeyword->id)->update([
            'name' => $request->document_keyword
        ]);

        return redirect()->route('dms.keyword.index')->with('success','Dms Keyword updated successfully!');
    }

    public function destroy(DmsKeyword $dmsKeyword){
        $dmsKeyword->delete();
        return redirect()->route('dms.keyword.index')->with('success','Dms Keyword deleted successfully!');
    }
}
