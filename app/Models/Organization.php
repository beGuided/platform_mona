<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable  = ['name','type','size','email','address','phone_number','website_link'];
       
     // Relationship To User
     public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

     // Relationship To student
     public function student() {
        return $this->belongsTo(User::class, 'student_id');
    }
}
