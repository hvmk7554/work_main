<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Carbon;

return new class extends Migration
{

    public function up()
    {
        foreach ($this->records as $record) {
            DB::table('user_groups')->insert([
                'id' => $record[0],
                'slug' => $record[1],
                'name' => $record[2],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    public function down()
    {
        foreach ($this->records as $record) {
            DB::table('user_groups')->delete($record[0]);
        }
    }

    private array $records = [
        [20, 'ZALOSENDZNS_READ', 'ZALOSENDZNS (Read)'],
        [21, 'ZALOSENDZNS_WRITE', 'ZALOSENDZNS (Create & Update)'],
        [22, 'ZALOSENDZNS_DESTROY', 'ZALOSENDZNS (Delete)'],
    ];
};
