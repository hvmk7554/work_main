<?php

namespace App\Rules;

use App\Models\Course;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class SkuEndDate implements Rule
{
    private ?Course $course;

    public function __construct($course)
    {
        $this->course = $course;
    }

    public function passes($attribute, $value)
    {
        Log::debug('App\Rules\SkuEndDate validating', [
            'course' => $this->course,
            'attribute' => $attribute,
            'value' => $value,
        ]);

        if (!$this->course || !$this->course->end_date) {
            return true;
        }

        $courseEndDate = Carbon::parse($this->course->end_date);
        $skuEndDate = Carbon::parse($value);

        return $skuEndDate <= $courseEndDate;
    }

    public function message()
    {
        return sprintf(
            "SKU's end date must before course's end date! (%s)",
            Carbon::parse($this->course->end_date)->toIso8601String(),
        );
    }
}
