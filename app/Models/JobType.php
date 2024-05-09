<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobType extends Model
{
    use HasFactory;

    public const GenerateClass = 'generate_classes';
    public const AssignClasses = 'assign_classes';
    public const RegisterClassInClassin = 'register_class_in_classin';
}
