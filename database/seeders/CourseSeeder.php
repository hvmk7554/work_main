<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    public function run()
    {
        foreach ($this->records as $record) {
            $grades = $record['grades'];
            $subjects = $record['subjects'];
            $teachers = $record['teachers'];
            $schedules = $record['schedules'];

            unset($record['grades']);
            unset($record['subjects']);
            unset($record['teachers']);
            unset($record['schedules']);

            $record['created_at'] = Carbon::now();
            $record['updated_at'] = Carbon::now();

            DB::table('courses')->upsert($record, 'id');

            foreach ($grades as $grade) {
                DB::table('course_grades')->upsert([
                    'course_id' => $record['id'],
                    'grade_id' => $grade,
                ], ['course_id', 'grade_id']);
            }

            foreach ($subjects as $subject) {
                DB::table('course_subjects')->upsert([
                    'course_id' => $record['id'],
                    'subject_id' => $subject,
                ], ['course_id', 'subject_id']);
            }

            foreach ($teachers as $id => $role) {
                DB::table('course_teachers')->upsert([
                    'course_id' => $record['id'],
                    'teacher_id' => $id,
                    'role' => $role,
                ], ['course_id', 'teacher_id']);
            }

            foreach ($schedules as $schedule) {
                $schedule['course_id'] = $record['id'];
                $schedule['created_at'] = Carbon::now();
                $schedule['updated_at'] = Carbon::now();

                DB::table('course_schedules')->upsert($schedule, 'id');
            }
        }
    }

    private array $records = [
        [
            'id' => 1,
            'classin_id' => null,
            'code' => '97e5',
            'name' => 'Toán 12 (22-23) (Thầy A)',
            'start_date' => '2022-06-01',
            'end_date' => '2023-05-31',
            'school_year' => '2022 - 2023',
            'grades' => [12],
            'subjects' => [1],
            'teachers' => [
                1 => 'Main',
            ],
            'schedules' => [
                [
                    'id' => 1,
                    'day_of_week' => 1,
                    'start_time' => 1200,
                    'end_time' => 1290,
                ],
                [
                    'id' => 2,
                    'day_of_week' => 3,
                    'start_time' => 1200,
                    'end_time' => 1290,
                ],
                [
                    'id' => 3,
                    'day_of_week' => 5,
                    'start_time' => 1200,
                    'end_time' => 1290,
                ]
            ],
        ],
        [
            'id' => 2,
            'classin_id' => null,
            'code' => '473a',
            'name' => 'Văn 12 (22-23) (Cô B)',
            'start_date' => '2022-06-01',
            'end_date' => '2023-05-31',
            'school_year' => '2022 - 2023',
            'grades' => [12],
            'subjects' => [5],
            'teachers' => [
                2 => 'Main',
            ],
            'schedules' => [
                [
                    'id' => 4,
                    'day_of_week' => 2,
                    'start_time' => 1050,
                    'end_time' => 1140,
                ],
                [
                    'id' => 5,
                    'day_of_week' => 4,
                    'start_time' => 1050,
                    'end_time' => 1140,
                ],
                [
                    'id' => 6,
                    'day_of_week' => 6,
                    'start_time' => 480,
                    'end_time' => 570,
                ]
            ],
        ],
    ];
}
