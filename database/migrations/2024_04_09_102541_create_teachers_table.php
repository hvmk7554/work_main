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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 32);
            $table->string('email');
            $table->date('DOB');
            $table->string('phone', 11);
            $table->string('gender');
            $table->string('contact_type');
            $table->string('degree');
            $table->string('address');
            $table->string('workplace');
            $table->string('program');
       //     $table->string('subject');
        //    $table->string('grade');
            $table->string('photo_link');
            $table->string('area');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};