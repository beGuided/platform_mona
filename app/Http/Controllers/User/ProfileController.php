<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{

    // Show all profile
    public function index() {
        $allProfile = Profile::all();
        return response()->json( ['Profiles' => $allProfile, 'status'=>true], 200);
    }


    //Show single profile
    public function show(Request $request ) {

       $user = User::with('profile')->find($request->id);
        if(empty( $user->profile )){
            return response()->json(
                ['message' => "You don't have a profile, please create one",
                'status'=>true   ]);
        }
        $profile = $user->profile;
        return response()->json(['Profile' => $profile,'status'=>true], 200);
    }

    // Store profile Data
    public function store(Request $request) {
      $profile =  $request->validate([
            'gender' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
            'date_of_birth' => 'nullable',
            'level_id' => 'required',
            'email' => 'required|unique:profiles',
            'state_of_origin' => 'requires',
          
        ]);

       
    $userProfile = Profile::create($profile);
           
    if($request->hasFile('image')) {
        $userProfile->image = $request->file('image')->store('image', 'public');
    }

     $userProfile->user_id = auth()->id();
     $userProfile->save();

        return response()->json([
            'message'=> 'profile created successfully!',
            'profile'=>$userProfile,'status'=>true], 200);
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
            'level_id' => '',
            'email' => 'string|unique:profiles',
            'state_of_origin' => '',  
        ]);
           
            $userProfile =  Profile::find($profile->id);

           $userProfile->gender = $request->gender;
            $userProfile->address = $request->address;
            $userProfile->phone_number = $request->phone_number;
            $userProfile->date_of_birth = $request->date_of_birth;
            $userProfile->level_id = $request->level_id;
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
