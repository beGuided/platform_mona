<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable  = ['title','module_name'];

       // Relationship To User
       public function users() {
        return $this->hasMany(User::class, 'user_id');
    }
    
       // Relationship To User
       public function roles() {
        return $this->hasMany(Role::class, 'role_id');
    }
    
}
