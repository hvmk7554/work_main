<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseSubject extends Pivot
{
    protected $table = 'course_subjects';

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

}
