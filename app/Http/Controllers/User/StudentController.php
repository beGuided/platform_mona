<?php

namespace App\Http\Controllers\User;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{

    public function __construct()
    {
    //  $this->middleware('admin')->only([ 'index','makeAdmin', 'makeUser', 'delete', 'store',  ]);
   
    }

    public function index() {

        $allStudent = Student::with('')->get();
      // $allStudents = student::all();
       return response()->json( ['student' => $allStudent,'status'=>true], 200);
    }

    //Show single student
    public function show(Request $request ) {
       $student = Student::with('')->find($request->id);
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

}
