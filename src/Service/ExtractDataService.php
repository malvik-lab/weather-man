<?php

namespace MalvikLab\WeatherMan\Service;

use MalvikLab\WeatherMan\Util\Util;
use MalvikLab\WeatherMan\Service\Exception\ExtractDataServiceException;

/**
 * devi sistemare questo file
 */

trait ExtractDataService {
    private function extractDataService(\DiDom\Document $document): array
    {
        $raw = $document->find('#day-overview[data-dayoverview]');

        if ( count($raw) !== 1 )
        {
            throw new ExtractDataServiceException(Util::exception(__FUNCTION__, 'Impossible to find "day-overview" tag in response'));
        }

        $string = $raw[0]->getAttribute('data-dayoverview');

        if ( is_null($string) )
        {
            throw new ExtractDataServiceException(Util::exception(__FUNCTION__, 'Impossible to find "day-overview" data in response')); 
        }

        if ( !Util::isJson($string) )
        {
            throw new ExtractDataServiceException(Util::exception(__FUNCTION__, 'Invalid json response'));
        }

        return json_decode($string, true);
    }
}