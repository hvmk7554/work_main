<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('user_group_memberships', function (Blueprint $table) {
            $table->id();
            $table->string('user_group_id');
            $table->string('user_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_group_memberships');
    }
};
