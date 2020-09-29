<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Department;

class MasterController extends Controller
{
    /*
        Get all departments from database
    */
    function departments(Request $request)
    {
        checkDeviceId($request->user());
        $departments = Department::where('isactive',1)->get();

        $success['departments'] = $departments;
        return response()->json(['success' => $success], 200);
    }

}
