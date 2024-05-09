<?php

namespace App\Helpers;
use Carbon\Carbon;
use Exception;

class Utils
{
    /**
     * @throws Exception
     */


    public static function dateDiffInDays($date1, $date2)
    {
        $diff = strtotime($date2) - strtotime($date1);
        return abs(round($diff / 86400));
    }
    public static function phoneInternationalToLocal(string|int|null $phone = null,array $countryCodes = ['84']): int|string|null
    {
        if(!$phone || $phone == "") return null;

        if (mb_substr($phone, 0, 1) == 0 || mb_substr($phone, 0, 1) == "0"){
            return $phone;
        }

        $first_two_character = mb_substr($phone, 0, 2);
        $two_three_character = mb_substr($phone, 1, 2);

        if(in_array($first_two_character,$countryCodes)) return  substr_replace($phone, "0", 0, 2);

        if(in_array($two_three_character,$countryCodes)) return  substr_replace($phone, "0", 0, 3);

        return $phone;
    }

    /**
     * @param string $phone
     * @return bool
     */
    public static function validatePhone(string $phone){
        $phone_number_validation_regex = "/^\\+?\\d{1,4}?[-.\\s]?\\(?\\d{1,3}?\\)?[-.\\s]?\\d{1,4}[-.\\s]?\\d{1,4}[-.\\s]?\\d{1,9}$/";
        return (preg_match($phone_number_validation_regex,$phone));
    }

    public static function formatPhoneNumber($phone) {
        $firstLetter = $phone[0];
        $twoLetter = substr($phone, 0, 2);
        $thirdLetter = substr($phone, 0, 3);
        if ($firstLetter == "0") {

            return $phone;
        }

        if ($twoLetter == "84") {
            return "0".substr($phone, 2, strlen($phone) - 2);
        }
        if ($thirdLetter == "+84") {
            return "0".substr($phone, 3, strlen($phone) - 3);
        }
        return "0".$phone;
    }

    public static function ValidatePhoneVietnam(string|int $phone): bool{
        if ($phone == "") return false;

        $firstLetter = $phone[0];
        $twoLetter = substr($phone, 0, 2);
        $thirdLetter = substr($phone, 0, 3);
        if ($firstLetter == "0") {
            return true;
        }

        if ($twoLetter == "84") {
            return true;
        }
        if ($thirdLetter == "+84") {
            return true;

        }
        return false;
    }



    public  static function generateNumberSuffix($maxNumberOfChar, $currentValue): string
    {
        $maxSuffixNumber = pow(10, $maxNumberOfChar);
        if ($currentValue >= $maxSuffixNumber) {
            return strval($currentValue);
        }

        return substr(strval($maxSuffixNumber + $currentValue), 1);
    }

    public static function formatDateTime($dateTime) {
        if (empty($dateTime)) {
            return "-";
        }
        return Carbon::parse($dateTime)->format('d/m/Y H:i:s');
    }

    public static function formatDate($date) {
        if (empty($date)) {
            return "-";
        }
        return Carbon::parse($date)->format('d/m/Y');
    }

    public static function fullTextWildcards($term)
    {
        // removing symbols used by MySQL
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
        $term = str_replace($reservedSymbols, '', $term);

        $words = explode(' ', $term);

        foreach ($words as $key => $word) {
            /*
             * applying + operator (required word) only big words
             * because smaller ones are not indexed by mysql
             */
            if (strlen($word) >= 2) {
                $words[$key] = '+' . $word . '*';
            }
        }

        $searchTerm = implode(' ', $words);

        return $searchTerm;
    }

    public static function removeSpecialChar($str) {

        // Using str_replace() function
        // to replace the word
        // Returning the result
        return str_replace( array( '\'', '"',
            ',' , ';', '<', '>', '-', '?', ":" ), ' ', $str);
    }

    public static function removeEndLine($str, $replace): string
    {
        $str = str_replace(["-"], "", $str);
        return str_replace([" ", "\n", "\r", "\t", "\v", "\0"], $replace, $str);
    }
}
