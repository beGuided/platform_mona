<?php

namespace App\Http\Controllers\User;

use App\Models\Role;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;



class UserController extends Controller
{


    public function __construct()
    {
     $this->middleware('admin')->only([ 'index','show', 'makeAdmin','makeUser','store', 'delete',  ]);
   
    }

    
    public function index() {

        $allUsers = User::with('profile')->get();
      // $alluser = User::all();
       return response()->json( ['User' => $allUsers,'status'=>true], 200);
        
    }

    //Show single user
    public function show(Request $request ) {
        
       $user = User::with('profile')->find($request->id);
        return response()->json(['user'=>$user,'status'=>true],200);
    }

    public function store(Request $request)
    {
        // $role = Role::all();
        // if($role->isEmpty()){
        //     return response()->json(
        //         ['message' => "Role is empty, please create Role",
        //         'status'=>true ]);
        // }
        
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'staff_id'=>'required|unique:users',
            'role_id'=>'required',
            // 'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|min:6'
        ]);
           // Hash Password
           $formFields['password'] = bcrypt($formFields['password']);
           $user = User::create($formFields);
   
           $token = $user->createToken('myapptoken')->plainTextToken;
        $user = User::create($formFields);


        return response()->json(['data'=>$user,'token'=>$token,'message'=>'user Created '],201);
    }

    public function update(Request $request)
    {
        $this->$request->validate([
            'name' => ['string', 'min:3'],
            'staff_id'=>'string',
            'role_id'=>'',
            // 'email' => ['required', 'email', Rule::unique('users', 'email')],
        ]);

        $user = User::find($request->id);
        $user->name =$request->name;
        $user->staff_id =$request->staff_id;
        $user->role_id =$request->role_id;
        $user->save();

        return response()->json(['data'=>$user,'message'=>'user updated '],200);
    }

    public function makeAdmin(Request $request)
    {
       $user = User::find($request->id);
       $user->role_id = 'admin';
       $user->save();
        return response(['message' => $user->name.' is now an admin.','status'=>true], 200); 

    }

    public function makeUser(Request $request)
    {
       $user = User::find($request->id);
       $user->role_id = 'student';
       $user->save();
        return response(['message' => $user->name.' is now a user.','status'=>true], 200); 
    }

    // Delete user with profile
    public function delete(Request $request) {       
        $user = User::with('profile')->find($request->id);
      
        if($user->isEmpty()){
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
         $user->delete();
         return response()->json([ 'message'=>'User deleted successfully!','status'=>true],200);

}

}
