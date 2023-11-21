<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Semester;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Date;

class ResultController extends Controller
{
     
    //  public function __construct()
    // {
    //  $this->middleware(['admin','staff'])->only([ 'filter','delete','show']);
   
    // }
 
    public function index()
    {
        $allResult =  Result::all();
        return response()->json(['results'=>$allResult],200);
    }


    public function show(Request $request,)
    {
         // Make sure logged in user is owner
         if($request->id != auth()->id()) {
            abort(403, 'Unauthorized Action',);
        }

        $currentYear = Date::now()->year;
        // find result by matric and email
        $result = Result::with('course')
                ->where('user_id',$request->id )
                ->where('year', $currentYear)
                ->get();
        return response()->json(['result'=>$result],200);
    }


    public function showStudentResult(Request $request,)
    {
         // Make sure logged in user is owner
         if($request->id != auth()->id()) {
            abort(403, 'Unauthorized Action',);
        }

        $semester =  Semester::find(1);
        $student = Student::find($request->id); 
        $currentYear = Date::now()->year;
        // find result by matric and email
        $result = Result::with('course')
                ->where('matric_number', $student->matric_number)
                ->where('semester', $semester->title)
                ->where('year', $currentYear)
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
        $currentYear = Date::now()->year;
        $results = DB::table('results')
        ->where('matric_number', $request->matric_number)
        ->where('year', $currentYear)
        ->get();
        return response()->json(['result'=>$results],200);
    }


     // for admins access only
    public function store(Request $request)
    {
        $formFields = $request->validate([ 
            'name' => 'required|string',
            'matric_number' =>'required|string',
            'semester' =>'required|string',  
            // 'CA' =>'integer',  
            // 'exam' =>'integer',         
            // 'score' =>'integer',   
            'year' => 'required|string',  
            'course_id'=>'required'
            
        ]); 
        $formFields['user_id'] =1;
        // return response()->json(['data'=>$formFields,'message'=>'result Created '],200);

        $result = Result::create($formFields);
        return response()->json(['data'=>$result,'message'=>'result Created '],200);
    }

    // for admins access only
    public function update(Request $request, $id)
    {
        $this->validate($request, [ 
            'name' => 'string',
            'matric_number' =>'',
            'semester' =>'string',         
            'course_id' =>'', 
            'CA' =>'integer',  
            'exam' =>'',         
            'score' =>'',  
            'year' => 'string',  
        ]); 
        $result =  Result::find($id);
       $result->name = $request->name;
        $result->matric_number = $request->matric_number;
        $result->semester = $request->semester;
        $result->course_id = $request->course_id;
        $result->score = $request->score;
        $result->year = $request->year;
        $result->save();
        return response()->json(['data'=>$result,'message'=>'result updated '],201);
    }

    public function delete($id)
    {
        $result =  Result::find($id);
        $result->delete();
        return response()->json('result deleted successful');
    }
}
