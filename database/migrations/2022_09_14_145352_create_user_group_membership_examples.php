<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_group_membership_examples', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('price');
            $table->boolean('is_active')->default(false);
            $table->longText('description');
            $table->string('featured_image')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_group_membership_examples');
    }
};
