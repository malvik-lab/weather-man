<?php

namespace MalvikLab\WeatherMan\Procedure;

use MalvikLab\WeatherMan\Procedure\Exception\GetLocationByIdException;
use MalvikLab\WeatherMan\Util\Util;

trait GetLocationById {
    public function getLocationById(string $locationId): array
    {
        foreach ( $this->locations as $location )
        {
            if ( $location['idLocation'] === $locationId )
            {
                return $location;
            }
        }

        throw new GetLocationByIdException(Util::exception(__FUNCTION__, sprintf('Location with id "%s" not found', $locationId)));
    }
}