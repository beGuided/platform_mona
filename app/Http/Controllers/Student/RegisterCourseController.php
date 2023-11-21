<?php

namespace App\Http\Controllers\Student;

use App\Models\Student;
use App\Models\Semester;
use App\Models\Register;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Date;

class RegisterCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


     public function __construct()
    {
     $this->middleware('admin')->only([ 'filter','delete']);
   
    }
 
    public function index()
    {
        $allRegister =  Register::with('courses')->get();
        return response()->json(['Course'=>$allRegister],200);
    }


        /* ********************
        for admins access only
    filter for admin to find courese registered by student
    *******************/

    public function filter(Request $request)
    {

        $student = Student::find($request->id); 
        if (!$student || $student->registers->isEmpty()){
              return response()->json(
                  ['message' => "You don't have any course, please register",
                  'status'=>false   ],404);
          }
        
        $register = Register::with('courses')->where('student_id', '=', $request->id)->get();
        return response()->json(['data'=>$register],200);


    }


    public function currentRegisteredCourse(Request $request,)
    {
       $semester =  Semester::find(1);
         // Make sure logged in user is owner
         if($request->id != auth()->id()) {
            abort(403, 'Unauthorized Action',);
        }
        
        $student = Student::find($request->id); 
        if ($student->registers->isEmpty()){
              return response()->json(
                  ['message' => "You don't have any course, please register",
                  'status'=>false   ]);
          }
             // Get the current year
        $currentYear = Date::now()->year;

        $register = Register::with('courses')
                ->where('student_id', $request->id)
                ->where('level', $student->profile->level)
                ->where('semester', $semester->title)
                ->where('year', $currentYear)
                ->get();

        return response()->json(['data'=>$register,'message' => "registered course for this semester"],200);

    }


     // for admins access only
    public function store(Request $request)
    {
        $student = Student::find(auth()->id());
        $semester = Semester::find(1);

        if ($student->profile == null){
            return response()->json(
                ['message' => "You have not created any profile",
                'status'=>false   ]);
        }
        if ($student->status == 0){
            return response()->json(
                ['message' => "You have not paid school fees for this session",
                'status'=>false   ]);
        }
         $request->validate([ 
            // 'year' =>'required|string',              
        ]); 
        
        // Get the current year
        $currentYear = Date::now()->year;

        $register = new Register();
        $register->level = $student->profile->level;
        $register->semester = $semester->title;
        $register->year = $currentYear;
        $register->student_id = auth()->id();
        $register->save();

        if ($request->courses) {
            $register->courses()->attach($request->courses);
        }
        return response()->json(['data'=>$register,'message'=>'Course rgistered '],201);
    }


    // for admins access only
    public function update(Request $request, )
    {
        $request->validate([ 
            'level' =>'string', 
            'semester' =>'string', 
            'year' =>'string',               
    ]); 
        $register =  Register::find($request->id);
        $register->level = $request->level;
        $register->semester = $request->semester;
        $register->year = $request->year;

        $register->save();
        if ($request->has('courses')) {
            $register->courses()->sync($request->courses);
        }
            return response()->json(['data'=>$register,'message'=>'Registered courses updated '],201);
        
    }


    public function delete($id)
    {
        $Course =  Register::find($id);
        $Course->delete();
        return response()->json('Registered deleted successful');
    }
}
