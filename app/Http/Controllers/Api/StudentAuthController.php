<?php
namespace App\Http\Controllers\Api;

use  App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

use Illuminate\Foundation\Auth\EmailVerificationRequest;


class StudentAuthController extends Controller
{   

   
    public function registerStudent(Request $request)
    {
  
        $formFields = $request->validate([
            'first_name' => ['required', 'min:3'],
            'last_name' => ['required', 'min:3'],
            'matric_number' => 'required|unique:students',
            'password' => 'required|min:6'
        ]);

        // Hash Password
        $formFields['password'] = bcrypt($formFields['password']);
        $student = Student::create($formFields);

        // event(new Registered($student));
        $token = $student->createToken('myapptoken')->plainTextToken;
       
        $response = [
             'message' => 'Registration successful.',
             'student'=> $student, 'token' => $token   ];
        return response($response, 201); 

    }

      // Show Login Form
      public function loginStudent(Request $request) {
        $formFields = $request->validate([
            'matric_number' => 'required',
            'password' => 'required|min:6'
        ]);

        // Hash Password
        $student = Student::where('matric_number', $formFields['matric_number'])->first();

        if(!$student || !Hash::check($formFields['password'], $student->password)) {
            return response([
                'message' => 'Invalid login creds'
            ], 401);
        }
       $token = $student->createToken('myapptoken')->plainTextToken;
        $response = [ 
            'student'=> $student, 'token' => $token   ];
        return response($response, 201); 
    }



    // Logout student
    public function logout(Request $request) {
        $request->student()->currentAccessToken()->delete();
       
        return [
            'message' => 'Logged out'
        ];
    }
  
    // Authenticate student
   
}
