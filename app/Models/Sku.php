<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
 

class Sku extends Model
{
    protected $table = 'skus';

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];


    public static array $status = [
        'active' => 'active',
        'inactive' => 'inactive',
        
    ];

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    // public function subjects(): HasMany
    // {
    //     return $this->hasMany(Subject::class);
    // }

    use HasFactory;
}