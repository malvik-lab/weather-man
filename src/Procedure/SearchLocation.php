<?php

namespace MalvikLab\WeatherMan\Procedure;

trait SearchLocation {
    public function searchLocation(string $s): array
    {
        $return = [];

        $s = ltrim($s);
        $len = strlen($s);

        if ( $len > 0 )
        {
            foreach ( $this->locations as $location )
            {
                if ( strtolower(trim($location['name'])) === strtolower($s) )
                {
                    $return[] = $location;
                }
            }

            foreach ( $this->locations as $location )
            {
                $substr = strtolower(substr($location['name'], 0, $len));
                if ( $substr === $s )
                {
                    $return[] = $location;
                }
            }

            foreach ( $this->locations as $location )
            {  
                if ( is_int(strpos(strtolower($location['name']), strtolower(trim($s)))) )
                {
                    $return[] = $location;
                }
            }

            $return = array_unique($return, SORT_REGULAR);
        }

        return $return;
    }
}