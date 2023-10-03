<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       
        $user = User::where('email', 'admin@email.com')->first();
        if(!$user){
            User::create([
            'name'=> 'Admin',
            'staff_id'=>'123',
            'email'=> 'admin@email.com',
            'role_id'=>1,
            'email_verified_at' => now(),
            'password' => Hash::make('secret')
            ]);
        };

        // $user= new User([                                    
        //     'name' => 'Admin Team',
        //    'email' =>'adminteam@email.com',
        //    'role' =>'admin',
        //    'email_verified_at' => now(),
        //    'password' => Hash::make('AdminTeam@DCI')     
        //       ]);  $user->save() ;
    }
}
