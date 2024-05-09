<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Actions\Actionable;
use Laravel\Nova\Nova;

class Program extends Model
{
    use SoftDeletes, Actionable;

    protected $table = 'programs';

    protected $connection = "mysql";

    protected $fillable = [
        'name',
    ];

    public function subjects(): HasMany{
        return $this->setConnection('mysql')->hasMany(Subject::class);
    }

    public function grades(): BelongsToMany{
        return $this->setConnection('mysql')->belongsToMany(Grade::class,'program_grades');
    }
    public static function programAvailable(): array
    {
        return self::all()->pluck('display_name','name')->toArray();
    }

    public static array $programAvailable = [
        1 => 'MOET',
        2 => 'IELTS',
        3 => 'Gia sư',
        4 => 'Toán tư duy',
        5 => 'Coding',
        6 => 'Cambridge',
        8 => 'Elizi',
        7 => 'Khác',
        9 => 'FOLA',
    ];

    public static array $program = [
      1 =>  'MOET',
       9 => 'FOLA',

    ];

}
