<?php

namespace App\Rules;

use App\Models\CourseClass;
use Illuminate\Contracts\Validation\Rule;
use function example\int;

class MaxNumberOfClasses implements Rule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    private $maxNumberClass;
    public function __construct($maxNumberClass)
    {
        $this->maxNumberClass = $maxNumberClass;
    }

    public function passes($attribute, $value)
    {
        if (is_null($this->maxNumberClass))
        {
            return true;
        }
        if ((int)$value > $this->maxNumberClass)
        {
            return false;
        }
        return true;
        // TODO: Implement passes() method.
    }

    public function message()
    {
        return sprintf(
            "Số lượng lớp cần tạo phải bé hơn hoặc bằng (%s)",
            $this->maxNumberClass,
        );
    }
}
