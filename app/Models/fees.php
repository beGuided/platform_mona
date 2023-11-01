<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fees extends Model
{
    use HasFactory;

    //details for Remeter
    // protected $fillable =[
    //     'payment_type','service_charge' 'amount','student_email','student_name','current_session','semester'
    // ];

    
    protected $fillable =[
        'RRR_id','student_id','amount','payment_type','payment_status','current_session',
        'semester'
    ];

    // Relationship to student
   public function student(){
    return $this->belongsTo(Student::class);
    }

}
