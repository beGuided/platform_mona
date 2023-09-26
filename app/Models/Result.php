<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable  = [ 'title','course_id','matric_number','student_email','semester','score','year'];

     // Relationship To User
     public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

     // Relationship To User
     public function course() {
        return $this->belongsTo(User::class, 'course_id');
    }
}
