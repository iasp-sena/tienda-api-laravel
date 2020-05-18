<?php


namespace App\Helpers;


class StringHelper
{

    private function __construct()
    {
    }

    public static function toUpperCamelCase($string){
        $string = str_replace('-', ' ', $string);
        $string = str_replace('_', ' ', $string);
        $string = ucwords(strtolower($string));
        $string = str_replace(' ', '', $string);
        return $string;
    }

    public static function toLowerCamelCase($string){
        return lcfirst(StringHelper::toUpperCamelCase($string));
    }
}