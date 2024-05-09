<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        DB::table('users')->insert([
            'name' => 'Insight QA',
            'email' => 'insight-qa@marathon.edu.vn',
            'authority_level' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    public function down()
    {
        DB::table('users')
            ->where('email', 'insight-qa@marathon.edu.vn')
            ->delete();
    }
};
