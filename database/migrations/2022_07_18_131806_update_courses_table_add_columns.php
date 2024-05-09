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
        Schema::table('courses', function (Blueprint $table) {
            $table->enum('type', ['Mass class', 'Tutoring', 'Q&A'])->default('Mass class')->index();
            $table->string('name_on_website')->nullable();
            $table->string('name_on_insight')->nullable();
            $table->string('name_on_classin')->nullable();
            $table->string('slug')->nullable()->index();
            $table->string('image')->nullable();
            $table->string('introduction')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['type', 'name_on_website', 'name_on_insight', 'name_on_classin', 'slug', 'image', 'introduction']);
        });
    }
};
