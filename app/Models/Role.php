<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable  = [ 'title','organization_id','permission_id'];

       
     // Relationship To User
     public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

     // Relationship To User
     public function organization() {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
    
       // Relationship To User
       public function permissions() {
        return $this->hasMany(Permission::class, 'permission_id');
    }

}
