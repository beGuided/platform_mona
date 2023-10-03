<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    
    // public function __construct()
    // {
    //  $this->middleware('createRole');
   
    // }


    public function index()
    {
        $roles =  Role::all();
        return response()->json($roles);

    }
    
    public function store(Request $request)
    {
        $formFields = $request->validate([ 
            'title' => 'required|unique:roles',
            'organization_id' => 'required|string',
            'permission_id'=>'nullable'
           
        ]);
        
        // $role = new Role();
    
        // $role->title = $request->title;
        // $role->organization_id = $request->organization_id;  
        // $role->permission_id = $request->permission_id;    
        // $role->save();
      
        $role = Role::create($formFields);
        return response()->json([
        'message' => 'Role created successfully',
        'data' => $role
   ]);
    
     }

    public function show($id)
    {
        $role = Role::findOrFail($id);
       return response()->json($role);
        
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [ 
            'title' => 'required',
            // 'user_id' => ' required',
            'organization_id' => ' required',
            'permissions'=>'nullable|array'
        ]);
        
        $role = Role::findOrFail($id);
        $role->title = $request->title;
        $role->organization_id = $request->organization_id;    
        $role->save();
    
        return response()->json([
            'message' => 'Role updated successfully',
            'data' => $role
        ]);
    }

   
    public function delete($id)
    {
        $role = Role::find($id);
      $role->permissions()->detach();
      $role->delete();
        return response()->json('Role deleted successful');
    }
}
