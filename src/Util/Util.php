<?php

namespace MalvikLab\WeatherMan\Util;

class Util {
    public static function isJson($string = null): bool
    {
        if ( is_object(json_decode($string)) ) 
        { 
            return true;
        }

        return false;
    }

    public static function exception(string $title, string $message): string
    {
        return sprintf('[ %s LIB EXCEPTION ] [ %s ] %s', \WeatherMan\Util\Constant::TITLE, strtoupper(preg_replace('/(?<!\ )[A-Z]/', ' $0', $title)), $message);
    }
}