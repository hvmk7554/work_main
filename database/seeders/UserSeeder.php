<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        $currentIndex = 1;

        foreach ($this->administrators as $email) {
            DB::table('users')->upsert([
                'id' => $currentIndex,
                'name' => $email,
                'email' => $email,
                'authority_level' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], 'id');

            $currentIndex = $currentIndex + 1;
        }
    }

    private array $administrators = [
        'khanhnp@marathon.edu.vn',
        'vietnt@marathon.edu.vn',
        'nguyendt@marathon.edu.vn',
        'nampt@marathon.edu.vn',
        'anhvd@marathon.edu.vn',
        'tira@marathon.edu.vn',
        'duc@marathon.edu.vn',
        'nghi@marathon.edu.vn',
        'truchnt@marathon.edu.vn',
        'quang.nguyen@marathon.edu.vn'
    ];
}
