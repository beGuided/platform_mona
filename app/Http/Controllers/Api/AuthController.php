<?php
namespace App\Http\Controllers\Api;

use  App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

use Illuminate\Foundation\Auth\EmailVerificationRequest;


class AuthController extends Controller
{   

   
    public function registerStaff(Request $request)
    {
  
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'staff_id' =>'required|unique:users',
            'role_id' =>'required',
            // 'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|min:6|confirmed'
        ]);

        // Hash Password
        $formFields['password'] = bcrypt($formFields['password']);
        $user = User::create($formFields);

        // event(new Registered($user));
        $token = $user->createToken('myapptoken')->plainTextToken;
       
        $response = [
            'message' => 'Registration successful.',
            'user'=> $user, 'token' => $token   ];
        return response($response, 201); 

    }

    // public function verifyEmail($id, $hash)
    // {
    //     $user = User::find($id);
    //     abort_if(!$user, 405);
    //     abort_if(!hash_equals($hash, sha1($user->getEmailForVerification())), 405);

    //     if (!$user->hasVerifiedEmail()) {
    //         $user->markEmailAsVerified();
    //         event(new Verified($user));        
    //         }
    //         return [   'message' => 'Email verified', 'status'=>true     ];
        
    // }


      // Show Login Form
      public function loginStaff(Request $request) {
        $formFields = $request->validate([
            'staff_id' => 'required',
            'password' => 'required|min:6'
        ]);

        // Hash Password
        $user = User::where('staff_id', $formFields['staff_id'])->first();

        if(!$user || !Hash::check($formFields['password'], $user->password)) {
            return response([
                'message' => 'Invalid login creds'
            ], 401);
        }
        // if($user->email_verified_at == null) {
        //     $user->sendEmailVerificationNotification();
        //     return response([
        //         'message' => 'Please check your email for verification link',
        //         'status'=>false
        //     ], 401);
        // }
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
