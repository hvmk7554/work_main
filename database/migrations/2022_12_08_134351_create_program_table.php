<?php

use App\Models\BusinessLine;
use App\Models\Program;
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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->string('display_name', 255);
            $table->timestamps();
            $table->softDeletes();
        });
        $data = [
            ['id' => 1,
                'name' => 'moet', 'display_name' => 'MOET'
            ],
            ['id' => 2,
                'name' => 'ielts', 'display_name' => 'IELTS'
            ],
            ['id' => 3,
                'name' => 'tutoring', 'display_name' => 'Gia sư'
            ],
            ['id' => 4,
                'name' => 'toan_tu_duy', 'display_name' => 'Toán tư duy'
            ],
            ['id' => 5,
                'name' => 'programming', 'display_name' => 'Coding'
            ],
            ['id' => 6,
                'name' => 'cambridge', 'display_name' => 'Cambridge'
            ],
            ['id' => 7,
                'name' => 'other', 'display_name' => 'Khác'
            ],
            ['id' => 8,
                'name' => 'elizi', 'display_name' => 'Elizi'
            ],
            ['id' => 9,
                'name' => 'fola', 'display_name' => 'FOLA'
            ]
        ];

        foreach ($data as $item){
            \Illuminate\Support\Facades\DB::table('programs')->updateOrInsert($item,$item);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programs');
        Schema::dropIfExists('program_business_line');
    }
};
