<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable  = ['gender', 'address','phone_number','date_of_birth','level_id','email','state_of_origin','department_id'];
     
     // Relationship To User
     public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
      
     // Relationship To Student
     public function student() {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
