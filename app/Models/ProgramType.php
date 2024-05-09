<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Nova\Actions\Actionable;
use Laravel\Nova\Nova;

class ProgramType extends Model
{
    use HasFactory, Actionable;
    protected $connection = "mysql2";

    public function actions(): MorphMany
    {
        return $this->setConnection("mysql")->morphMany(Nova::actionEvent(), 'actionable');
    }
}
