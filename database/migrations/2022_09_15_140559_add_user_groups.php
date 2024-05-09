<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        foreach ($this->records as $record) {
            $row = [
                'id' => $record[0],
                'slug' => $record[1],
                'name' => $record[2],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            DB::table('user_groups')->upsert($row, 'id');
        }
    }

    public function down()
    {
        foreach ($this->records as $record) {
            DB::table('user_groups')->delete($record[0]);
        }
    }

    private array $records = [
        [1, 'ADMINISTRATOR', 'Administrator'],

        [2, 'COURSE_READ', 'Course (Read)'],
        [3, 'COURSE_WRITE', 'Course (Create & Update)'],
        [4, 'COURSE_DESTROY', 'Course (Delete)'],

        [5, 'SKU_READ', 'SKU (Read)'],
        [6, 'SKU_WRITE', 'SKU (Create & Update)'],
        [7, 'SKU_DESTROY', 'SKU (Delete)'],

        [8, 'TEACHER_READ', 'Teacher (Read)'],
        [9, 'TEACHER_WRITE', 'Teacher (Create & Update)'],
        [10, 'TEACHER_DESTROY', 'Teacher (Delete)'],

        [11, 'CURRICULUM_READ', 'Curriculum (Read)'],
        [12, 'CURRICULUM_WRITE', 'Curriculum (Create & Update)'],
        [13, 'CURRICULUM_DESTROY', 'Curriculum (Delete)'],

        [14, 'COURSE_CLASS_READ', 'Course\' Class (Read)'],
        [15, 'COURSE_CLASS_WRITE', 'Course\' Class (Create & Update)'],
        [16, 'COURSE_CLASS_DESTROY', 'Course\' Class (Delete)'],

        [17, 'SUBSCRIPTION_READ', 'Subscription (Read)'],
        [18, 'SUBSCRIPTION_WRITE', 'Subscription (Create & Update)'],
        [19, 'SUBSCRIPTION_DESTROY', 'Subscription (Delete)'],
    ];
};
