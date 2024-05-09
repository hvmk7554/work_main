<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public static array $status = [
        'active' => 'active',
        'inactive' => 'inactive',
        
    ];

    use HasFactory;
}
