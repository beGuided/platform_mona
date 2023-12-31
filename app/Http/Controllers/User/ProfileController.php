<?php

namespace App\Http\Controllers\User;

use App\Models\Student;
use App\Models\User;
use App\Models\Profile;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    // Show all profile
    public function index() {
        $allProfile = Profile::all();
        return response()->json( ['Profiles' => $allProfile, 'status'=>true], 200);
    }


    /*****************
     * WILL RECONSIDER IF ONLY STUDENT SHOULD HAVE PROFILE
     *********************************/

    //Show single Student profile
    public function studentProfile(Request $request ) {
       $student = Student::with('profile')->find($request->id);
        if ($student->profile->isEmpty()){
            return response()->json(
                ['message' => "You don't have a profile, please create one",
                'status'=>true   ]);
        }
        $profile = $student->profile;
        return response()->json(['Profile' => $profile,'status'=>true], 200);
    }

      //Show single Staff profile
      public function staffProfile(Request $request ) {
        $user = User::with('profile')->find($request->id);
       
          if(empty( $user->profile->isEmpty())){
              return response()->json(
                  ['message' => "You don't have a profile, please create one",
                  'status'=>true   ]);
          }
          $profile = $user->profile;
          return response()->json(['Profile' => $profile,'status'=>true], 200);
      }






    /*****************
     *   // Store studet profile Data
     *********************************/
  
    public function store(Request $request) {
        $dept = Department::all();
        if ($dept->isEmpty() ) {
            return response()->json(
                ['message' => "Department cannot be empty",
                'status'=>false ],401);
        }
        
      $validatedField =  $request->validate([
            'gender' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
            'date_of_birth' => 'nullable',
            'level' => 'nullable',
            'email' => 'nullable|unique:profiles',
            'state_of_origin' => 'required',
            'department_id' =>'required'
          
        ]);

        $profile = new Profile($validatedField);
        $student = Student::find(auth()->id());
        $student->profile()->save($profile);
        
    // $userProfile = Profile::create($validatedField);     
    if($request->hasFile('image')) {
        $profile->image = $request->file('image')->store('image', 'public');
        $profile->save();
    }
        return response()->json([
            'message'=> 'profile created successfully!',
            'profile'=> $profile,'status'=>true], 200);
    }







    // Update profile Data
    public function update(Request $request) {
      
        $profile = DB::table('profiles')->where('user_id', $request->id)->first();
        if(empty($profile)){
            return response()->json(['message' => "You don't have a profile, please create one",'status'=>true]);
        }
          // Make sure logged in user is owner
          if($profile->user_id != auth()->id()) {
              abort(403, 'Unauthorized Action',);
          }

         $request->validate([
            'gender' => '',
            'address' => '',
            'phone_number' => '',
            'date_of_birth' =>'',
            'level' => '',
            'email' => 'string|unique:profiles',
            'state_of_origin' => '',  
        ]);
           
            $userProfile =  Profile::find($profile->id);

           $userProfile->gender = $request->gender;
            $userProfile->address = $request->address;
            $userProfile->phone_number = $request->phone_number;
            $userProfile->date_of_birth = $request->date_of_birth;
            $userProfile->level= $request->level;
            $userProfile->email = $request->email;
            $userProfile->state_of_origin = $request->state_of_origin;
          
            //check if image
          if($request->hasFile('image')){
            //upload it
            $image = $request->file('image')->store('image', 'public');
            //delete former image
            Storage::disk('public')->delete($userProfile->image);
            
            $userProfile->image = $image;
             }

           $userProfile->save();
            
         return response()->json([
            'message'=> 'profile updated successfully!',
            'profile'=>$userProfile,'status'=>true], 200);
   
    }


    // Delete profile
//     public function delete(Request $request) {

         
//         $user =User::with('profile')->find($request->id);
        
//         if($user->profile->image && Storage::disk('public')->exists($user->profile->image)) {
//             Storage::disk('public')->delete($user->profile->image);
            
//             $user->delete();
//             $user->profile->delete();
//         return response()->json([ 'message'=>'User deleted successfully!'],200);
//     }

// }

}
