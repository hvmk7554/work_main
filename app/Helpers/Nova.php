<?php

namespace App\Helpers;

class Nova
{
    public static function displayUsingNumber(): \Closure
    {
        return function ($value) {
            return number_format($value, 0, ',', '.');
        };
    }

    public static function numberFormat(int $value): string
    {
        return number_format($value, 0, ',', '.');
    }
}
