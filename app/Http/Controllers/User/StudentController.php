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
    //  $this->middleware('admin')->only([ 'index','makeAdmin', 'makeUser', 'delete', 'store',  ]);
   
    }

    public function index() {

        $allStudent = Student::with('profile')->get();
      // $allStudents = student::all();
       return response()->json( ['student' => $allStudent,'status'=>true], 200);
            }

    //Show single student
    public function show(Request $request ) {
       $student = Student::with('profiles')->find($request->id);
        return response()->json(['student'=>$student,'status'=>true],200);
             }


    public function store(Request $request)
    { 
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'matric_number' => 'required|unique:students',
            'password' => 'required|min:6'
        ]);

        $student = Student::create($formFields);

        return response()->json(['data'=>$student,'message'=>'student Created '],200);
         }


         
     // Delete profile
     public function delete(Request $request) {  
        
        $student = Student::with('profile')->find($request->id);
      
        if(empty( $student)){
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
