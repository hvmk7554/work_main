<?php

namespace App\Rules;

use App\Models\Course;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class SkuStartDate implements Rule
{
    private ?Course $course;

    public function __construct($course)
    {
        $this->course = $course;
    }

    public function passes($attribute, $value)
    {
        Log::debug('App\Rules\SkuStartDate validating', [
            'course' => $this->course,
            'attribute' => $attribute,
            'value' => $value,
        ]);

        if (!$this->course || !$this->course->start_date) {
            return true;
        }

        $courseStartDate = Carbon::parse($this->course->start_date);
        $skuStartDate = Carbon::parse($value);

        return $skuStartDate >= $courseStartDate;
    }

    public function message()
    {
        return sprintf(
            "SKU's start date must after course's start date! (%s)",
            Carbon::parse($this->course->start_date)->toIso8601String(),
        );
    }
}
