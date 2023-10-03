<?php

namespace App\Http\Controllers\Student;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


     public function __construct()
    {
     $this->middleware('admin')->only([ 'index','filter','delete', 'store',  ]);
   
    }
 
    public function index()
    {
        $allCourse =  Course::all();
        return response()->json(['Course'=>$allCourse],200);
    }


    public function show(Request $request, $mat,$semester,$level)
    {
         // Make sure logged in user is owner
         if($request->id != auth()->id()) {
            abort(403, 'Unauthorized Action',);
        }

        // find Course by matric and email
        $Course = DB::table('Courses')
                ->where('matric_number', '=', $mat)
                ->where('level', '=', $level)
                ->where('semester', '=', $semester)
                ->get();
        return response()->json(['Course'=>$Course],200);
    }


    /* for admins access only
    filter for admin to find student Course*/

    public function filter(Request $request)
    {
        $request->validate([
            'matric_number'=>$request->matric_number
        ]);

        $Courses = DB::table('Courses')->where('matric_number', '=', $$request->matric_number);
        return response()->json(['Course'=>$Courses],200);
    }


     // for admins access only
    public function store(Request $request)
    {
        $formFields = $request->validate([ 
            'name' => 'required|string',
            'matric_number' =>'required|string',
            'student_email' =>'required|unique:Courses|string',  
            'semester' =>'required|string',         
            'course_id' =>'required',  
            'score' =>'required|string',  
            'year' => 'required|string',  
            
        ]); 

        $Course = Course::create($formFields);
        return response()->json(['data'=>$Course,'message'=>'Course Created '],200);
    }

    // for admins access only
    public function update(Request $request, $id)
    {
        $this->validate($request, [ 
            'name' => 'string',
            'matric_number' =>'',
            'student_email' =>'unique:Courses',  
            'semester' =>'string',         
            'course_id' =>'',  
            'score' =>'string',  
            'year' => 'string',  
        ]); 
        $Course =  Course::find($id);
        $Course->name = $request->name;
        $Course->matric_number = $request->matric_number;
        $Course->student_email = $request->student_email;
        $Course->semester = $request->semester;
        $Course->course_id = $request->course_id;
        $Course->score = $request->score;
        $Course->year = $request->year;
        $Course->save();
        return response()->json(['data'=>$Course,'message'=>'Course updated '],201);
    }

    public function delete($id)
    {
        $Course =  Course::find($id);
        $Course->delete();
        return response()->json('Course deleted successful');
    }
}
