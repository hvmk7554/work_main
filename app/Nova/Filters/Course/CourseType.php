<?php

namespace App\Nova\Filters\Course;

use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaMultiselectFilter\MultiselectFilter;

class CourseType extends MultiselectFilter
{
    public $name = "Course Types";


    public function apply(NovaRequest $request, $query, $value)
    {
            return $query->whereIn("type",$value);
    }



    public function options(NovaRequest $request)
    {
        return [
            0 =>'Lớp Mass',
            1 =>'Khoá học trải nghiệm EC',
            2 => 'Khai giảng',
            3 => 'Phụ đạo',
            4 => 'Chuyên đề',
            6 => 'Paid in advance',
            7 => 'Infinity',
            8 => 'Interaction',
            5 => 'Gia sư 1:n',
            9 => 'Gia sư 1:1'
        ];
    }
}
