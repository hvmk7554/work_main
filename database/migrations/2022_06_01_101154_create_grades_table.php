<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->timestamps();
        });

        foreach ($this->records as $record) {
            $record['created_at'] = Carbon::now();
            $record['updated_at'] = Carbon::now();

            DB::table('grades')->insert($record);
        }
    }

    public function down()
    {
        Schema::dropIfExists('grades');
    }

    private array $records = [
        [
            'id' => 1,
            'name' => 'Lớp 1',
        ],
        [
            'id' => 2,
            'name' => 'Lớp 2',
        ],
        [
            'id' => 3,
            'name' => 'Lớp 3',
        ],
        [
            'id' => 4,
            'name' => 'Lớp 4',
        ],
        [
            'id' => 5,
            'name' => 'Lớp 5',
        ],
        [
            'id' => 6,
            'name' => 'Lớp 6',
        ],
        [
            'id' => 7,
            'name' => 'Lớp 7',
        ],
        [
            'id' => 8,
            'name' => 'Lớp 8',
        ],
        [
            'id' => 9,
            'name' => 'Lớp 9',
        ],
        [
            'id' => 10,
            'name' => 'Lớp 10',
        ],
        [
            'id' => 11,
            'name' => 'Lớp 11',
        ],
        [
            'id' => 12,
            'name' => 'Lớp 12',
        ],
        [
            'id' => 13,
            'name' => 'Ielts 0.5-1.5',
        ],
        [
            'id' => 14,
            'name' => 'Ielts 1.5-4.5',
        ],
        [
            'id' => 15,
            'name' => 'Ielts 4.5-6.5',
        ],
        [
            'id' => 16,
            'name' => 'Ielts 6.5-7.5',
        ],
    ];
};
