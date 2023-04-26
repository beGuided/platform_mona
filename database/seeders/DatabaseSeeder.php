<?php

namespace Database\Seeders;

use App\Models\Listing;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::factory(5)->create();
         Listing::factory(6)->create();
        
        
        //  Listing::create([
        //     'title' =>'Laravel senior Developer',
        //     'tags' =>'laravel, javascript',
        //     'company'=> 'Acene Crop',
        //     'location'=>'Boston',
        //     'email'=>'email@email.com',
        //     'website'=>'https://acne.com',
        //     'description'=>'Lorem ipsum dolor sit ipsum dolor sit 
        //     ipsum dolor sit ipsum dolor sit ipsum dolor sit 
        //     ipsum dolor sit ipsum dolor sit  ipsum dolor sit ipsum dolor sit  ipsum dolor sit ipsum dolor sit '

        // ]);
        // Listing::create([
        //     'title' =>'Laravel senior Developer',
        //     'tags' =>'laravel, javascript',
        //     'company'=> 'Acene Crop',
        //     'location'=>'Boston',
        //     'email'=>'email@email.com',
        //     'website'=>'https://acne.com',
        //     'description'=>'Lorem ipsum dolor sit ipsum dolor sit 
        //     ipsum dolor sit ipsum dolor sit ipsum dolor sit 
        //     ipsum dolor sit ipsum dolor sit  ipsum dolor sit ipsum dolor sit  ipsum dolor sit ipsum dolor sit '

        // ]);
    }
}
