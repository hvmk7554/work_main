<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('classin_id')->nullable()->unique();
            $table->string('code')->unique();
            $table->string('name')->index();
            $table->date('start_date')->nullable()->index();
            $table->date('end_date')->nullable()->index();
            $table->string('school_year')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('course_grades', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('grade_id');

            $table->primary(['course_id', 'grade_id']);
        });

        Schema::create('course_subjects', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('subject_id');

            $table->primary(['course_id', 'subject_id']);
        });

        Schema::create('course_teachers', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('teacher_id');
            $table->enum('role', ['Main', 'Supporter']);

            $table->primary(['course_id', 'teacher_id']);
        });

        Schema::create('course_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->integer('day_of_week')->index();
            $table->integer('start_time')->index();
            $table->integer('end_time')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_schedules');
        Schema::dropIfExists('course_teachers');
        Schema::dropIfExists('course_subjects');
        Schema::dropIfExists('course_grades');
        Schema::dropIfExists('courses');
    }
};
