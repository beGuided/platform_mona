<?php

namespace App\Http\Controllers\Fees;

use App\Models\Student;
use App\Models\Semester;
use App\Models\Fees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Date;
use App\Http\Controllers\Controller;

class FeesController extends Controller
{
     
    //  public function __construct()
    // {
    //  $this->middleware(['admin','staff'])->only([ 'filter','delete','show']);
   
    // }
 
    // show all paid fees
    public function index()
    {
        $allFees =  Fees::all();
        return response()->json(['feess'=>$allFees],200);
    }


        /*********
         * TODO inplement the view/show payment status, 
         verifying the RRR through the remiter API (for student)
        i*******/


    /*********
    for admins access only
    filter for admin to find student fees
    ****************/

    public function filter(Request $request)
    {
        $request->validate([
            'matric_number'=>$request->matric_number,
            'RRR_id'=>$request->RRR_id,
        ]);
        $fees = DB::table('feess')
        ->where('matric_number', $request->matric_number)
        ->where('RRR_id', $request->RRR_id)
        ->get();
        return response()->json(['fees'=>$fees],200);
    }


     // for admins access only
    public function store(Request $request)
    {
        $request->validate([ 
            'RRR_id' => 'required|integer',
            'amount' =>'required|integer',
            'payment_type' =>'required|string',         
            'payment_status' =>'required|integer',
            'current_session' =>'required|string', 
            'semester' =>'required',   
        ]); 
        
        $fees = new Fees();
        $fees->student_id =$request->student_id;
        $fees->current_session = $request->current_session;
        $fees->RRR_id = $request->RRR_id;
        $fees->amount = $request->amount;
        $fees->payment_type = $request->payment_type;
        $fees->payment_status = $request->payment_status;
        $fees->semester =$request->semester;
   
        $fees->save();

        return response()->json(['data'=>$fees,'message'=>'fees Created '],200);
    }


    // for admins access only
    // public function update(Request $request, $id)
    // {
    //     $this->validate($request, [ 
    //         //'email' => 'string',
    //         'matric_number' =>'',
    //         'email' =>'unique:feess',  
    //         'semester' =>'string',         
    //         'course_id' =>'',  
    //         'score' =>'string',  
    //         'year' => 'string',  
    //     ]); 
    //     $fees =  fees::find($id);
    //    // $fees->name = $request->name;
    //     $fees->matric_number = $request->matric_number;
    //     $fees->student_email = $request->student_email;
    //     $fees->semester = $request->semester;
    //     $fees->course_id = $request->course_id;
    //     $fees->score = $request->score;
    //     $fees->year = $request->year;
    //     $fees->save();
    //     return response()->json(['data'=>$fees,'message'=>'fees updated '],201);
    // }

    public function delete($id)
    {
        $fees =  Fees::find($id);
        $fees->delete();
        return response()->json('fees deleted successful');
    }
}
