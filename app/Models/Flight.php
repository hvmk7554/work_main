<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
   /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'my_flights';
    protected $primaryKey = 'flight_id';

    protected $attributes = [
        'options' => '[]',
        'delayed' => false,
    ];

   


    use HasFactory;
}
