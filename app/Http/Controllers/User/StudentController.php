<?php

namespace App\Http\Controllers\User;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{

    public function __construct()
    {
     $this->middleware('admin')->only(['update', 'store', 'delete']);
   
    }

    public function index() {

        $allStudent = Student::with('profile')->get();
      // $allStudents = student::all();
       return response()->json( ['student' => $allStudent,'status'=>true], 200);
            }

    //Show single student
    public function show(Request $request ) {
       $student = Student::with('profile')->find($request->id);
        return response()->json(['student'=>$student,'status'=>true],200);
          }


    public function store(Request $request)
    { 
        $formFields = $request->validate([
            'first_name' => ['required', 'min:3'],
            'last_name' => ['required', 'min:3'],
            'matric_number' => 'required|unique:students',
            'password' => 'required|min:6'
        ]);

        //  Hash Password
         $formFields['password'] = bcrypt($formFields['password']);

         $student = Student::create($formFields);
         $token = $student->createToken('myapptoken')->plainTextToken;
        return response()->json(['data'=>$student, 'token' => $token,  'message'=>'student Created '],201);
         }



    public function update(Request $request, Student $student)
    { 
        $formFields = $request->validate([
            'first_name' => [ 'min:3'],
            'last_name' => ['min:3'],
            'matric_number' => 'unique:students',
        ]);
        //  Hash Password
        $formFields['password'] = bcrypt($request->password);

        $student = Student::find($request->id);
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->matric_number = $request->matric_number;
        $student->password =  $formFields['password'] ;
        
         $student->save();
        return response()->json(['data'=>$student, 'message'=>'student Updated '],201);
        }


     //Delete Student
     public function delete(Request $request) {  
        
        $student = Student::with('profile')->find($request->id);
      
        if( $student->isEmpty()){
            return response()->json(
                [ 'message' => "student do not exist",
                  'status'=>false ]);
        }
         if(!empty($student->profile->image)) {
          if($student->profile->image && Storage::disk('public')->exists($student->profile->image)) {
            Storage::disk('public')->delete($student->profile->image);            
           
            $student->profile->delete();     
                
                }
             }
         $student->delete();
         return response()->json([ 'message'=>'student deleted successfully!','status'=>true],200);

}

}
