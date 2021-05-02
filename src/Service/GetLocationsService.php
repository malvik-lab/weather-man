<?php

namespace MalvikLab\WeatherMan\Service;

use MalvikLab\WeatherMan\Service\Exception\GetLocationsServiceException;
use MalvikLab\WeatherMan\Util\Util;

trait GetLocationsService {
    private function getLocationsService(): array
    {
        $fl = sprintf('%sdata/locations/%s.json', $this->path, $this->locationsVersion);

        if ( !is_readable($fl) )
        {
            throw new GetLocationsServiceException(Util::exception(__FUNCTION__, sprintf('Impossible to load "%s"', $fl)));
        }

        return json_decode(file_get_contents($fl), true);
    }
}