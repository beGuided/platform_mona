<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Student;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{

    // Show all Department
    public function index() {
        $allDepartment = Department::all();
        return response()->json( ['Departments' => $allDepartment, 'status'=>true], 200);
    }

    // //Show single  staff Department
    // public function show(Request $request ) {
    //    $user = User::find($request->id);
    //     if(empty( $user->Department )){
    //         return response()->json(
    //             ['message' => "You don't have a Department, please create one",
    //             'status'=>true   ]);
    //     }
    //     $Department = $user->Department;
    //     return response()->json(['Department' => $Department,'status'=>true], 200);
    // }

      //Show single  student Department
    public function show(Request $request ) {
        $student = Student::find($request->id);
         if(empty( $student->Department )){
             return response()->json(
                 ['message' => "You don't have a Department, please create one",
                 'status'=>true   ]);
         }
         $department = $student->Department;
         return response()->json(['Department' => $department,'status'=>true], 200);
     }

 
    // Store Department Data
    public function store(Request $request) {
      $validatedField =  $request->validate([
            'name' => 'required|unique:departments',
        ]);
    $userDepartment = Department::create($validatedField);
        return response()->json([
            'message'=> 'Department created successfully!',
            'Department'=>$userDepartment,'status'=>true], 200);
    }


    // Update Department Data
    public function update(Request $request) {
      
        $Department = DB::table('Departments')->where('user_id', $request->id)->first();

        if(empty($Department)){
            return response()->json(['message' => "You don't have a Department, please create one",'status'=>true]);
        }
          // Make sure logged in user is owner
          if($Department->user_id != auth()->id()) {
              abort(403, 'Unauthorized Action',);
          }

         $request->validate([
            'name' => '',
          
        ]);
           
            $userDepartment =  Department::find($Department->id);

           $userDepartment->gender = $request->gender;
            $userDepartment->address = $request->address;
            $userDepartment->phone_number = $request->phone_number;
            $userDepartment->date_of_birth = $request->date_of_birth;
            $userDepartment->level_id = $request->level_id;
            $userDepartment->email = $request->email;
            $userDepartment->state_of_origin = $request->state_of_origin;
          
            //check if image
          if($request->hasFile('image')){
            //upload it
            $image = $request->file('image')->store('image', 'public');
            //delete former image
            Storage::disk('public')->delete($userDepartment->image);
            
            $userDepartment->image = $image;
             }

           $userDepartment->save();
            
         return response()->json([
            'message'=> 'Department updated successfully!',
            'Department'=>$userDepartment,'status'=>true], 200);
   
    }


    // Delete Department
//     public function delete(Request $request) {

         
//         $user =User::with('Department')->find($request->id);
        
//         if($user->Department->image && Storage::disk('public')->exists($user->Department->image)) {
//             Storage::disk('public')->delete($user->Department->image);
            
//             $user->delete();
//             $user->Department->delete();
//         return response()->json([ 'message'=>'User deleted successfully!'],200);
//     }

// }

}
