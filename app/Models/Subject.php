<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Nova\Actions\Actionable;

class Subject extends Model
{
    use HasFactory, Actionable;

    protected $connection = "mysql";

    public function program(): BelongsTo
    {
        return $this->setConnection("mysql")->belongsTo(Program::class);
    }

    public function questionLevels(): BelongsToMany
    {
        return $this->setConnection('mysql_exam')->belongsToMany(QuestionLevel::class, config('database.connections.mysql_exam.database') . "." . 'question_level_subjects');
    }

    public function questionVariants(): BelongsToMany
    {
        return $this->setConnection('mysql_exam')->belongsToMany(QuestionVariant::class, config('database.connections.mysql_exam.database') . "." . 'question_variant_subjects');
    }

    public function subjectConfigs(): HasMany
    {
        return $this->hasMany(SubjectConfig::class);
    }

    public function examSkills(): BelongsToMany
    {
        return $this->setConnection('mysql_exam')->belongsToMany(ExamSkill::class, config('database.connections.mysql_exam.database') . "." . 'exam_skill_subjects');
    }

    public static array $subjectx = [
        1 => ' Toán',
        2 => 'Lí',
        3 => 'Hóa',
        4 => 'Sinh',
        5 => 'Văn',
        6 => 'Sử',
        7 => 'Địa',
        8 => 'Tiếng Anh',
       
    ];

}
