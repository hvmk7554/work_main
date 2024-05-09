<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Actions\Actionable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
  protected $table='students';

  public function subscriptions(): HasMany
  {
      return $this->hasMany(Subscription::class);
  }


    use HasFactory;

     
    
}
