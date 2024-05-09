<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::table('job_types', function (Blueprint $table) {
            $table->create();
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('display_name')->nullable(false);
        });

        Schema::table('jobs', function (Blueprint $table) {
           $table->create();
           $table->id();
           $table->string('type_name')->nullable(false);
           $table->string('status')->nullable(false);
           $table->integer('course_id')->nullable();
           $table->integer('sku_id')->nullable();
           $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
           $table->dateTime('updated_at');
           $table->dateTime('started_at')->nullable();
           $table->dateTime('completed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_types', function (Blueprint $table) {
            $table->dropIfExists();
        });
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropIfExists();
        });
    }
};
