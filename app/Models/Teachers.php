<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Teachers extends Model
{
    protected $table = 'teachers';

    protected $casts = [
        'DOB' => 'date',
    ];

    protected $fillable = [
        'name',
        'email',
        'DOB',
        'phone',
        'gender',
        'contact_type',
        'degree',
        'address',
        'workplace',
        'created_at',
        'photo_link',
    ];

    public static array $gender = [
        'Male' => 'Male',
        'Female' => 'Female',
        'Others' => 'Others',
    ];

    public static array $contact = [
        'Fulltime' => 'Fulltime',
        'Part-time' => 'Part-time',
    ];

    public static array $degree = [
        'Thac si' => 'Thac si',
        'Cu nhan' => 'Cu nhan',
        'Tien si' => 'Tien si',
        'Pho giao su' => 'Pho giao su',
        'Giao su' => 'Giao su',
        'Khac' => 'Khac',
    ];

    public static array $program = [
        'moet' => 'moet',
        'fola' => 'fola',
    ];

    

    public static array $area = [
        'Vietnam' => 'Vietnam',
        'Philippine' => 'Philippine',
        'Singapore' => 'Singapore',
    ];

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

    public function grades(): HasManyThrough
    {
        
        return $this->hasManyThrough(Grade::class, Program::class);
    }



    use HasFactory;
}
