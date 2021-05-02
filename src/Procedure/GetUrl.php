<?php

namespace MalvikLab\WeatherMan\Procedure;

use MalvikLab\WeatherMan\Service\Exception\GetLocationByIdException;
use MalvikLab\WeatherMan\Util\Util;

trait GetUrl {
    public function getUrl(string $locationId, string $type): string
    {
        $urls = $this->getUrlsService($locationId);

        if ( !array_key_exists($type, $urls) )
        {
            throw new GetLocationByIdException(Util::exception(__FUNCTION__, sprintf('Url type "%s" not found', $type)));
        }

        return $urls[$type];
    }
}