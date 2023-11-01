<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Student extends Authenticatable
{
    use  HasApiTokens, HasFactory;

    protected $fillable =['first_name','last_name','matric_number','password',];

    protected $hidden = [
        'password',
        'remember_token',
    ];

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
      // Relationship To register
      public function registers() {
         return $this->hasMany(Register::class,'student_id');
     }
     
    
}
