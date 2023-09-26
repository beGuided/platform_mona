<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable  = ['first_name', 'middle_name','last_name','state_of_origin','matric_number'];
     
     // Relationship To User
     public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
      
     // Relationship To User
     public function student() {
        return $this->belongsTo(User::class, 'student_id');
    }
}
