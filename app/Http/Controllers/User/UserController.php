<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;



class UserController extends Controller
{


    public function __construct()
    {
    //  $this->middleware('admin')->only([ 'index','makeAdmin', 'makeUser', 'delete', 'store',  ]);
   
    }

    
    public function index() {

        $allUsers = User::with('')->get();
      // $alluser = User::all();
       return response()->json( ['User' => $allUsers,'status'=>true], 200);
        
    }

    //Show single user
    public function show(Request $request ) {
       $user =User::with('')->find($request->id);
        return response()->json(['user'=>$user,'status'=>true],200);
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::create($formFields);

        return response()->json(['data'=>$user,'message'=>'user Created '],200);
    }

    public function makeAdmin(Request $request)
    {
       $user = User::find($request->id);
       $user->role = 'admin';
       $user->save();
        return response(['message' => $user->name.' is now an admin.','status'=>true], 200); 

    }

    public function makeUser(Request $request)
    {
       $user = User::find($request->id);
       $user->role = 'user';
       $user->save();
        return response(['message' => $user->name.' is now a user.','status'=>true], 200); 
    }



    // Delete profile
    public function delete(Request $request) {  
        
        $user = User::with('profile','arts')->find($request->id);
      
        if(empty( $user)){
            return response()->json(
                [ 'message' => "user do not exist",
                  'status'=>false ]);
        }


         if(!empty($user->profile->image)) {
          if($user->profile->image && Storage::disk('public')->exists($user->profile->image)) {
            Storage::disk('public')->delete($user->profile->image);            
           
            $user->profile->delete();     
                
                }
             }
      
            if(!empty($user->arts)) {
                foreach($user->arts as $art){

                    if($art->art_image && Storage::disk('public')->exists($art->art_image)) {
                        Storage::disk('public')->delete($art->art_image);
                        $art->delete();
                        }
                }
                
             }

        // if($user->profile->image && Storage::disk('public')->exists($user->profile->image)) {
        //     Storage::disk('public')->delete($user->profile->image);     
        //  }

        //  if($user->arts->art_image && Storage::disk('public')->exists($user->arts->art_image)) {
        //       Storage::disk('public')->delete($user->arts->art_image);
        //  }

         $user->delete();
         return response()->json([ 'message'=>'User deleted successfully!','status'=>true],200);

}

}
