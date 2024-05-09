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
        Schema::create('skus', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('school_year');
            $table->string('website_name');
            $table->string('name');
            $table->string('status');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('unit_number');
            $table->string('original_price');
            $table->string('listing_price');
            $table->string('unit_type');
            $table->string('note');
            
            $table->string('grade');
            $table->string('subject');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skus');
    }
};