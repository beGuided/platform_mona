<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;


class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organization =  Organization::all();
        return response()->json($organization);
    }

    public function show($id)
    {
        $organization =  Organization::find($id);
        return response()->json($organization);
    }


    public function store(Request $request)
    {
        $formFields = $request->validate([ 
            'name' => 'required|string|max:255',
            'type' =>'required|string|max:255',
            'size' =>'required|string|max:255',  
            'email' =>'required|unique:organizations|string|max:255',         
            'address' =>'required|string|max:255',  
            'phone_number' => ' required|string|max:25',  
            'website_link' => ' nullable|string|max:255',  
            
        ]); 

        $organization = Organization::create($formFields);
        return response()->json(['data'=>$organization,'message'=>'organization Created '],200);
    }

   
    public function update(Request $request, $id)
    {
        $this->validate($request, [ 
            'name' => 'required|string|max:255',
            'type' =>'required|string|max:255',
            'size' =>'required|string|max:255',  
            'email' =>'required|unique:organizations|string|max:255',         
            'address' =>'required|string|max:255',  
            'phone_number' => ' required|string|max:25',  
            'website_link' => ' nullable|string|max:255',       
        ]); 
        $organization =  Organization::find($id);
        $organization->name = $request->name;
        $organization->type = $request->type;
        $organization->size = $request->size;
        $organization->email = $request->email;
        $organization->address = $request->address;
        $organization->phone_number = $request->phone_number;
        $organization->website_link = $request->website_link;
        $organization->save();
        return response()->json(['data'=>$organization,'message'=>'organization updated '],201);
    }

    public function delete($id)
    {
        $organization =  Organization::find($id);
        $organization->delete();
        return response()->json('organization deleted successful');
    }
}
