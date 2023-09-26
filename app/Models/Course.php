<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['title','code','unit','level'];
   
         // Relationship To User
         public function student() {
            return $this->belongsTo(Student::class, 'sudent_id');
        }

         // Relationship To Course
      public function results() {
        return $this->hasMany(Result::class, 'course_id');
    }

       // Relationship To Course
       public function departments() {
        return $this->hasMany(Department::class, 'department_id');
    }

}
