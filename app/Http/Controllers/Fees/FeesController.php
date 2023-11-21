<?php

namespace App\Http\Controllers\Fees;

use App\Models\Student;
use App\Models\Semester;
use App\Models\Fees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Date;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Exception;

use Illuminate\Support\Facades\Log;

class FeesController extends Controller
{
   // public $amount= 50000;
     
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
            'payment_id'=>$request->payment_id,
        ]);
        $fees = DB::table('feess')
        ->where('matric_number', $request->matric_number)
        ->where('payment_id', $request->payment_id)
        ->get();
        return response()->json(['fees'=>$fees],200);
    }


    
     // for admins access only
    public function remita(Request $request)
    {
       
        if( $request->amount >= 2000){

            $student_id =$request->student_id;
            $current_session = $request->current_session;
            $payment_id = $request->payment_id;
            $amount = $request->amount;
            $payment_type = $request->payment_type;
            $payment_status = $request->payment_status;
            $semester =$request->semester;

            
            return response()->json(['message'=>'payment succeful '],200);

           
        }else{
            return response()->json(['message'=>'invalid amount '],400);
     
    }
    }


    
     // for admins access only
     public function payStack(Request $request)
        {   
        if( $request->amount >= 2000){
         try {
            $student_id =auth()->id();
          //  $email =;
            $amount = $request->amount*100;

               // app/Http/Controllers/PaymentController.php

            $url = "https://api.paystack.co/transaction/initialize";

              // Additional data to pass along with the payment
            $metadata = [
                'custom_fields'=>[
                // 'student_id' => $student_id,
                'student_id' => 1,
                'semester' => $request->semester,
                'payment_status' =>  $request->payment_status,
                'current_session' => $request->current_session,
                'payment_type' => $request->payment_type,]
            ];

            $fields = [
                'email' => 'customer@email.com',
                'amount' => $amount,
                'metadata' => $metadata,
            ];

        $response = Http::withHeaders([
            "Authorization" => "Bearer ".config("services.paystack.secret_key"),
            "Cache-Control" => "no-cache",
        ])->timeout(30)->post($url, $fields);

        // Handle the response as needed (e.g., redirect to payment page)
        // For demonstration purposes, just print the response body
        $response = $response->json();
        return response()->json( [ 'response'=>$response, 'message'=>'payment succeful '],200);

         }catch(Exception $e){
        return response()->json(['error' => $e->getMessage(),'message'=>'payment failled.'], 422);
         }
    }
        else{
            return response()->json(['message'=>'invalid amount, pls comfirm '],400);
    }
     }
 

    public function delete($id)
    {
        $fees =  Fees::find($id);
        $fees->delete();
        return response()->json('fees deleted successful');
    }



    public function payStackWebhook(Request $request)
    {
        // //Get Payload
        // $payload = $request->getContent();
        // // $payload = $request->all();

        // // Verify the Paystack webhook signature
        // $paystackSecret = config('services.paystack.secret_key');
        // $paystackHeader = $request->header('x-paystack-signature');

        // //
        // if ($this->isValidPaystackWebhook($payload, $paystackHeader, $paystackSecret)) {
        //     // Handle the webhook event based on the event type
        //     $eventData = $request->json('data');
        //     $eventType = $request->json('event');

        //     if ($eventType === 'charge.success') {
        //         // Handle successful payment event
        //         // Example: Update order status or send confirmation email
        //         $fees = new Fees();
        //         $fees->student_id =$request->student_id;
        //         $fees->current_session = $request->current_session;
        //         $fees->payment_id = $request->payment_id;
        //         $fees->amount = $request->amount;
        //         $fees->payment_type = $request->payment_type;
        //         $fees->payment_status = $eventType;
        //         $fees->semester =$request->semester;
        //         $fees->save();
    
        //         $studentStatus = Student::find($request->student_id);
        //         $studentStatus->status =1;
    
             
        //     } elseif ($eventType === 'charge.failure') {
        //         // Handle failed payment event
        //         // Example: Notify user about payment failure
        //          // return response()->json(['status' => 'payment failed ']);
        //          Log::info('message', ['status' => 'payment failed ']);
        //     }
        //     Log::info('message', ['success' => 'Webhook received']);

        //     // return response()->json(['message' => 'Webhook received']);
        // } else {
        //     Log::info('message', ['error' => 'Invalid webhook signature']);
        // }

     
    }

    private function isValidPaystackWebhook($payload, $signature, $secret)
    {
        $computedSignature = hash_hmac('sha512', $payload, $secret);
        return $computedSignature === $signature;
        // return hash_equals($hash, $signature);
    }

}
