<?php
namespace App\Helpers;

class Loggable{
    public static function writeLoggable(array $data): void{
        \Illuminate\Support\Facades\DB::table('loggable')->insert([
            'created_at' => \Carbon\Carbon::now(),
            'content' => json_encode($data)
        ]);
    }

}
