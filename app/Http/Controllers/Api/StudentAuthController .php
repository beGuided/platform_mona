<?php
namespace App\Http\Controllers\Api;

use  App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

use Illuminate\Foundation\Auth\EmailVerificationRequest;


class StudentAuthController extends Controller
{   

   
    public function register(Request $request)
    {
  
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'matric_number' => 'required|unique:students',
            'password' => 'required|min:6'
        ]);

        // Hash Password
        $formFields['password'] = bcrypt($formFields['password']);
        $user = User::create($formFields);

        // event(new Registered($user));
        $token = $user->createToken('myapptoken')->plainTextToken;
       
        $response = [
            'message' => 'Registration successful. Please check your email for verification link.',
             'user'=> $user, 'token' => $token   ];
        return response($response, 201); 

    }

      // Show Login Form
      public function login(Request $request) {
        $formFields = $request->validate([
            'matric_number' => 'required',
            'password' => 'required|min:6'
        ]);

        // Hash Password
        $user = User::where('matric_number', $formFields['matric_number'])->first();

        if(!$user || !Hash::check($formFields['password'], $user->password)) {
            return response([
                'message' => 'Invalid login creds'
            ], 401);
        }
         
       $token = $user->createToken('myapptoken')->plainTextToken;
       
        $response = [ 
            'user'=> $user, 
            'token' => $token   ];
        return response($response, 201); 
    }



    // Logout User
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
       
        return [
            'message' => 'Logged out'
        ];
    }
  
    // Authenticate User
   
}
