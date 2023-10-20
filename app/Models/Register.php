<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    use HasFactory;

    protected $fillable =['semester','level','year',];

           // Relationship To student
     public function student() {
        return $this->belongsTo(Student::class, 'student_id');
}

      // Relationship To Course
      public function courses() {
        return $this->belongsToMany(Course::class);
    }
    
}