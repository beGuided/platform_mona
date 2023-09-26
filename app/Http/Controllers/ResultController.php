<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

 
    public function index()
    {
        $allResult =  Result::all();
        return response()->json(['result'=>$allResult],200);
    }


    public function show(Request $request, $mat,$semester,$level)
    {
         // Make sure logged in user is owner
         if($request->id != auth()->id()) {
            abort(403, 'Unauthorized Action',);
        }

        // find result by matric and email
        $result = DB::table('results')
                ->where('matric_number', '=', $mat)
                ->where('level', '=', $level)
                ->where('semester', '=', $semester)
                ->get();
        return response()->json(['result'=>$result],200);
    }


    /* for admins access only
    filter for admin to find student result*/

    public function filter(Request $request)
    {
        $request->validate([
            'matric_number'=>$request->matric_number
        ]);

        $results = DB::table('results')->where('matric_number', '=', $$request->matric_number);
        return response()->json(['result'=>$results],200);
    }


     // for admins access only
    public function store(Request $request)
    {
        $formFields = $request->validate([ 
            'name' => 'required|string',
            'matric_number' =>'required|string',
            'student_email' =>'required|unique:results|string',  
            'semester' =>'required|string',         
            'course_id' =>'required',  
            'score' =>'required|string',  
            'year' => 'required|string',  
            
        ]); 

        $result = result::create($formFields);
        return response()->json(['data'=>$result,'message'=>'result Created '],200);
    }

    // for admins access only
    public function update(Request $request, $id)
    {
        $this->validate($request, [ 
            'name' => 'string',
            'matric_number' =>'',
            'student_email' =>'unique:results',  
            'semester' =>'string',         
            'course_id' =>'',  
            'score' =>'string',  
            'year' => 'string',  
        ]); 
        $result =  result::find($id);
        $result->name = $request->name;
        $result->matric_number = $request->matric_number;
        $result->student_email = $request->student_email;
        $result->semester = $request->semester;
        $result->course_id = $request->course_id;
        $result->score = $request->score;
        $result->year = $request->year;
        $result->save();
        return response()->json(['data'=>$result,'message'=>'result updated '],201);
    }

    public function delete($id)
    {
        $result =  result::find($id);
        $result->delete();
        return response()->json('result deleted successful');
    }
}
