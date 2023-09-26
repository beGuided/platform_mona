<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('gender');
            $table->string('address');
            $table->string('phone_number');
            $table->string('date_of_birth')->nullable();
            $table->string('email')->unique()->nullable();
            $table->integer('department_id')->unsigned();
            $table->integer('level_id')->unsigned();
            $table->string('state_of_origin');
            $table->string('image');
            $table->timestamps();

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
};
