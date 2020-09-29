<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\DmsCategory;

class DmsCategoryController extends Controller
{
    public function index(){
        $dmsCategories = DmsCategory::where('isActive','1')->orderBy('id','DESC')->get();
        return view('dms_category.index', compact('dmsCategories'));
    }

    public function create(){
        return view('dms_category.create');
    }

    public function store(Request $request){
        $request->validate([
            'document_category' => 'required|max:50|unique:dms_categories,name,NULL,id,deleted_at,NULL',
        ]);
        DmsCategory::create([
            'name' => $request->document_category
        ]);
        return redirect()->route('dms.category.index')->with('success','Dms Category created successfully!');
    }

    public function show(){
        return view('dms_category.show');
    }

    public function edit(DmsCategory $dmsCategory){
        return view('dms_category.edit', compact('dmsCategory'));
    }
    public function update(Request $request, DmsCategory $dmsCategory){
        $request->validate([
            'document_category' => 'required|max:50|unique:dms_categories,name,'.$dmsCategory->id.',id,deleted_at,NULL',
        ]);
        DmsCategory::where('id',$dmsCategory->id)->update([
            'name' => $request->document_category
        ]);

        return redirect()->route('dms.category.index')->with('success','Dms Category updated successfully!');
    }

    public function destroy(DmsCategory $dmsCategory){
        $dmsCategory->delete();
        return redirect()->route('dms.category.index')->with('success','Dms Category deleted successfully!');
    }
}
