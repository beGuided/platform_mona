<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permission =  Permission::all();
        return response()->json($permission);
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([ 
            'title' => 'required|unique:permissions',
            'module_name' => 'nullable|unique:permissions',
           
        ]); 
        $permission = Permission::create($formFields);
        $permission->save();
        return response()->json(['permission'=>$permission,'message' =>'Permission Created'],201);
    }

 
    public function show($id)
    {
        $permission =  Permission::find($id);
        return response()->json($permission);
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [ 
            'title' => 'required',
            'mdule_name' => 'nullable',
        ]); 
        $permission =  Permission::find($id);
        $permission->title = $request->title;
        $permission->module_name = $request->module_name;
        
        $permission->save();
        return response()->json(['permission'=>$permission,'message' =>'Permission updated'],201);

    }

    
    public function delete($id)
    {
        $permission =  Permission::find($id);
        $permission->delete();
        return response()->json('Permission deleted ');
    }
}
