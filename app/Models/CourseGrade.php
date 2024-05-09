<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseGrade extends Pivot
{
    protected $table = 'course_grades';

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}
