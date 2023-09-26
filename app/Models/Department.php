<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable  = [ 'title'];
       
     // Relationship To User
     public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

      // Relationship To student
      public function student() {
        return $this->belongsTo(User::class, 'student_id');
    }

      // Relationship To User
         public function student() {
            return $this->belongsTo(Student::class, 'sudent_id');
        }

         // Relationship To Course
       public function courses() {
        return $this->hasMany(Result::class, 'department_id');
    }
    
}
