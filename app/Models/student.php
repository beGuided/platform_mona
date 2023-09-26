<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    use HasFactory;

    protected $fillable =['name','matric_number','password'];


     // Relationship To Profile
     public function profile()
     {
         return $this->hasOne(Profile::class);
     }
    
     // Relationship To Organization
     public function organization()
     {
         return $this->hasOne(Organization::class);
     }
     // Relationship To Department
     public function department()
     {
         return $this->hasOne(Department::class);
     }
      // Relationship To Course
      public function courses() {
         return $this->hasMany(Course::class, 'student_id');
     }
     
    
}
