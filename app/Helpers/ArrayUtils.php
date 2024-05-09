<?php
namespace App\Helpers;

class ArrayUtils{
    public static function renderArray(array $data,$format = 'text'): string{
        $text = '';

        foreach ($data as $key => $value){
            if(empty($key)){
                continue;
            }
            if(is_array($value)){
                $text .= self::renderArray($value,$format);
                continue;
            };

            $text .= ($format == 'text') ? " $key : $value \n" : " $key : $value <br>";
        }

        return $text;
    }

    public static function renderArrayToCSV(array $data): string
    {
        return self::renderArray($data);
    }

    public static function renderArrayToHtml(array $data): string{
        return self::renderArray($data,'html');
    }

    /**
     * @param array|object|null $data
     * @param callable $callable param key and value of array
     * @return string|null
     */
    public static function renderArrayAble(array|object|null $data, callable $callable): string|null{
        if(!$data) return null;

        $text = '';

        foreach ($data as $key => $value){
//            if(is_array($value)){
//                $text .= self::renderArray($value,$callable);
//                continue;
//            };

            $text .= $callable($key,$value);
        }

        return $text;
    }

    public static function renderArrayToObject(array $data): array{
        $new_array = [];
        foreach ($data as $key => $value){
            if(empty($key)){
                continue;
            }
            $new_array[] = [
                'code' => $key,
                'name' => $value
            ];
        }

        return $new_array;
    }

    public static function convertKeyToObject($key, array $data): array|null{
        if (empty($key)) return null;
        return [
            'code' => $key,
            'name' => $data[$key]
        ];
    }

    public static function arrayHasOneValue(mixed $data) : bool
    {
        if (count($data) == 1)
        {
            return true;
        }
        return false;

    }
}
