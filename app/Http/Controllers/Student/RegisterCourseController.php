<?php

namespace App\Http\Controllers\Student;

use App\Models\Student;
use App\Models\Semester;
use App\Models\Register;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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


        /* for admins access only
    filter for admin to find student Course*/

    public function filter(Request $request)
    {

        $student = Student::find($request->id); 
        if ($student->registers->isEmpty()){
              return response()->json(
                  ['message' => "You don't have any course, please register",
                  'status'=>false   ]);
          }

        //find courese registered by student
        $register = DB::table('registers')->where('student_id', '=', $request->id)->get();
        return response()->json(['Course'=>$register],200);


    }


    public function currentRegisteredCourse(Request $request,$level,$year)
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

        //find Course by level and email
        $register = DB::table('registers')
                ->where('student_id', '=', $request->id)
                ->where('level', '=', $level)
                ->where('semester', '=', $semester)
                ->where('year', '=', $year)
                ->get();

        return response()->json(['Course'=>$register],200);


    }






     // for admins access only
    public function store(Request $request)
    {
        $student = Student::find(auth()->id());
        if ($student->profile == null){
            return response()->json(
                ['message' => "You have not created any profile",
                'status'=>false   ]);
        }
        $formFields = $request->validate([ 
            'level' =>'required', 
            'semester' =>'required|string', 
            'year' =>'required|string',          
         
        ]); 
    $register = new Register();

    // $register->level = $request->level;
    // $register->semester = $request->semester;
    // $register->year = $request->year;
    // $register->save();
       $register =  Register::create($formFields);
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
        $register->courses()->attach($request->input('courses'));
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
