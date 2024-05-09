<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',32);
            $table->date('bday');
            $table->string('email')->unique();
            $table->string('phone_number',10)->unique();
            $table->string('gender');
           
            $table->string('subscription');

            $table->timestamps();
            $table->softDeletes();
        });
       

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
