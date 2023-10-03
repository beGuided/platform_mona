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
     $this->middleware('admin')->only([ 'show','update','delete', 'store',  ]);
   
    }
 
    public function index()
    {
        $allCourse =  Course::all();
        return response()->json(['Course'=>$allCourse],200);
    }


    public function show(Request $request, $student_id,$semester,$level)
    {
         // Make sure logged in user is owner
         if($request->id != auth()->id()) {
            abort(403, 'Unauthorized Action',);
        }

        // find Course by matric and email
        $student = DB::table('course_students')
                ->where($student->student_id, '=', $student_id)
                ->where('level', '=', $level)
                ->where('semester', '=', $semester)
                ->get();
        return response()->json(['Course'=>$student],200);
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
            'title' => 'required|unique:Courses|string',
            'code' =>'required|string',
            'unit' =>'required|integer',  
            'level' =>'required', 
            'semester' =>'required|string',          
         
        ]); 

        $Course = Course::create($formFields);
        return response()->json(['data'=>$Course,'message'=>'Course Created '],200);
    }

    // for admins access only
    public function update(Request $request, $id)
    {
        $this->validate($request, [ 
            'title' => 'unique:Courses|string',
            'code' =>'string',
            'unit' =>'',  
            'level' =>'string',  
            'semester' =>'string',    
        ]); 
        $Course =  Course::find($id);
        $Course->title = $request->title;
        $Course->code = $request->code;
        $Course->unit = $request->unit;
        $Course->level = $request->level;
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
