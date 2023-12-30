<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Semester;

class SemesterController extends Controller
{
    public function index()
    {
        $semester =  Semester::all();
        return response()->json($semester);
    }
  
    public function store(Request $request)
    {
        $formFields = $request->validate([ 
            'title' => 'required',
        ]); 
        $semester = Semester::create($formFields);
        $semester->save();
        return response()->json(['semester'=>$semester,'message' =>'semester Created'],201);
    }

 
    public function show($id)
    {
        $semester =  Semester::find($id);
        return response()->json($semester);
    }

    
    public function update(Request $request)
    {

        $semester =  Semester::find($request->id);
        if($semester->title == 'first'){
            $semester->title = 'second';

        }else{
            $semester->title = 'first';
        }
    
        $semester->save();
        return response()->json(['semester'=>$semester,'message' =>'semester updated'],201);

    }

    
    public function delete($id)
    {
        $semester =  Semester::find($id);
        $semester->delete();
        return response()->json('semester deleted ');
    }
}
