<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Student;

class LevelController extends Controller
{

    public function __construct()
    {
     $this->middleware('admin')->only(['nextLevel','prevLevel']);
   
    }
    // $this->validate($request, [ 
    //     'level' => 'required|integer',
    // ]); 

    // update student level route
    public function nextLevel()
    {
        $allStudentProfile =  Profile::all();
        $allstudentStatus =  Student::all();

        foreach($allStudentProfile as $studentProfile){
            $studentProfile->level += 100;
            $studentProfile->save();
        }
        foreach($allstudentStatus as $studentStatus){
            $studentStatus->status = 0;
            $studentStatus->save();
        }
        return response()->json(['message' =>'All student level updated'],201);

    }


      // update student level route
      public function prevLevel(Request $request)
      {
          
          $allStudentProfile =  Profile::all();
          foreach($allStudentProfile as $studentProfile){
              $studentProfile->level -= 100;
              $studentProfile->save();
          }
  
          return response()->json(['message' =>'All student level updated'],201);
  
      }

}
