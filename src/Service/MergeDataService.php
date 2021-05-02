<?php

namespace MalvikLab\WeatherMan\Service;

use MalvikLab\WeatherMan\Service\Exception\MergeDataServiceException;
use MalvikLab\WeatherMan\Util\Util;
use DateTimeImmutable;

trait MergeDataService {
    private function mergeDataService(array $data, array $extraData, array $dayPartsData): array
    {
        if ( array_key_exists('data', $data) AND is_array($data['data']) )
        {
            $data = $data['data'];
        }

        if ( !array_key_exists('hours', $data) OR !is_array($data['hours']) )
        {
            throw new MergeDataServiceException(Util::exception(__FUNCTION__, 'Hours data array not found')); 
        }

        if ( !array_key_exists('dayParts', $data) OR !is_array($data['dayParts']) )
        {
            throw new MergeDataServiceException(Util::exception(__FUNCTION__, 'Day parts data array not found')); 
        }

        foreach ( $data['hours'] as &$hour )
        {
            $hour['_dateTime'] = new DateTimeImmutable($hour['time']);
            $hour['_hour'] = $hour['_dateTime']->format('H');

            foreach ( $extraData as $i )
            {
                if ( array_key_exists('_hour', $i) AND $i['_hour'] === $hour['_hour'] )
                {
                    $hour = array_merge($hour, $i);
                }
            }
        }

        foreach ( $data['dayParts'] as &$dayPart )
        {
            switch ($dayPart['part'])
            {
                case 'NIGHT':
                    $type = 'NOTTE';
                    break;

                case 'MORNING':
                    $type = 'MATTINO';
                    break;

                case 'AFTERNOON':
                    $type = 'POMERIGGIO';
                    break;

                case 'EVENING':
                    $type = 'SERA';
                    break;

                default:
                    $type = null;
                    break;
            }

            if ( !is_null($type) )
            {
                foreach ( $dayPartsData as $dp )
                {
                    if ( array_key_exists('type', $dp) AND strtolower($dp['type']) === strtolower($type) )
                    {
                        $dayPart['_title'] =  ucfirst(strtolower($type));
                        $dayPart['_iconUrl'] = array_key_exists('iconUrl', $dp) ? $dp['iconUrl'] : null;
                        $dayPart['_iconText'] = array_key_exists('iconText', $dp) ? $dp['iconText'] : null;

                        continue;
                    }
                }
            }
        }

        return $data;
    }
}