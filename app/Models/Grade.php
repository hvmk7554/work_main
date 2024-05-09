<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Teachers;

class Grade extends Model
{
    use HasFactory;

    public static array $studentManagementGrades = [
        1 => 'Lớp 1',
        2 => 'Lớp 2',
        3 => 'Lớp 3',
        4 => 'Lớp 4',
        5 => 'Lớp 5',
        6 => 'Lớp 6',
        7 => 'Lớp 7',
        8 => 'Lớp 8',
        9 => 'Lớp 9',
        10 => 'Lớp 10',
        11 => 'Lớp 11',
        12 => 'Lớp 12',
        13 => 'Ielts 0.5-1.5',
        14 => 'Ielts 1.5-4.5',
        15 => 'Ielts 4.5-6.5',
        16 => 'Ielts 6.5-7.5',
    ];

    public function sku(): BelongsTo
    {
        return $this->belongsTo(Sku::class);
    }

    // public function programx2(): BelongsTo
    // {
    //     return $this->belongsTo(Program::class);
    // }


    // public function programx1(): BelongsTo
    // {
    //     $teacherses = Teachers::where('active', 1)->get();
 
    //     foreach ($teacherses as $teachers) {
    //         echo $teachers->name;
    //     }
    //     return $this->belongsTo(Teacher::class);
    // }

    public static array $gradeM = [
        1 => 'Lớp 1',
        2 => 'Lớp 2',
        3 => 'Lớp 3',
        4 => 'Lớp 4',
        5 => 'Lớp 5',
        6 => 'Lớp 6',
        7 => 'Lớp 7',
        8 => 'Lớp 8',
        9 => 'Lớp 9',
        10 => 'Lớp 10',
        11 => 'Lớp 11',
        12 => 'Lớp 12',
       
    ];

    public static array $gradeF = [
       
        13 => 'Ielts 0.5-1.5',
        14 => 'Ielts 1.5-4.5',
        15 => 'Ielts 4.5-6.5',
        16 => 'Ielts 6.5-7.5',
    ];



}
