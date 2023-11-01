<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'staff_id',
        'email',
        'role_id',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     // Relationship To Profile
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    // Relationship To Role
    public function role()
    {
        return $this->hasOne(Role::class);
    }
    // Relationship To Organization
    public function organization()
    {
        return $this->hasOne(Organization::class);
    }
      // Relationship To Result
      public function results() {
        return $this->hasMany(Result::class);
    }
  
}
