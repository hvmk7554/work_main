<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->timestamps();
        });

        foreach ($this->records as $record) {
            $record['created_at'] = Carbon::now();
            $record['updated_at'] = Carbon::now();

            DB::table('subjects')->insert($record);
        }
    }

    public function down()
    {
        Schema::dropIfExists('subjects');
    }

    private array $records = [
        [
            'id' => 1,
            'name' => 'Toán',
        ],
        [
            'id' => 2,
            'name' => 'Lý',
        ],
        [
            'id' => 3,
            'name' => 'Hóa',
        ],
        [
            'id' => 4,
            'name' => 'Sinh',
        ],
        [
            'id' => 5,
            'name' => 'Văn',
        ],
        [
            'id' => 6,
            'name' => 'Sử',
        ],
        [
            'id' => 7,
            'name' => 'Địa',
        ],
        [
            'id' => 8,
            'name' => 'Tiếng Anh',
        ],
    ];
};
