<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{  
    protected $table = 'classes';
    protected $casts = [
        'start_time' => 'date',
        'end_time' => 'date',
    ];
    protected $fillable =[
        'id',
        'status',
        'start_time',
        'end_timme',
    ];
    
    use HasFactory;
}
