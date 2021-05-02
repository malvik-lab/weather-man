<?php

namespace MalvikLab\WeatherMan\Service;

use MalvikLab\WeatherMan\Util\Util;
use MalvikLab\WeatherMan\Service\Exception\ExtractExtraDataServiceException;

trait ExtractExtraDataService {
    private function extractExtraDataService(\DiDom\Document $document): array
    {
        $return = [];

        $lis = $document->find('ul.mb-24 li');

        if ( count($lis) < 1 )
        {
            throw new ExtractExtraDataServiceException(Util::exception(__FUNCTION__, 'Impossible to find "ul.mb-24 li" tags in response'));
        }

        foreach ( $lis as $li )
        {
            $hourSpan = $li->find('span.hour');

            if ( count($hourSpan) !== 1 )
            {
                throw new ExtractExtraDataServiceException(Util::exception(__FUNCTION__, 'Impossible to find "span.hour" tags in response'));
            }

            $hourSpan = $hourSpan[0];
            $time = $hourSpan->find('time');

            if ( count($time) !== 1 )
            {
                throw new ExtractExtraDataServiceException(Util::exception(__FUNCTION__, 'Impossible to find "time" tags in response'));
            }

            $hour = $time[0]->text();

            $tmp = $li->find('figure img');

            if ( count($tmp) !== 1 )
            {
                throw new ExtractExtraDataServiceException(Util::exception(__FUNCTION__, 'Impossible to find "figure img" tags in response'));
            }

            $weatherIconUrl = $tmp[0]->getAttribute('src');
            $weatherIconText = ucfirst($tmp[0]->getAttribute('alt'));

            $tmp = $li->find('p.windInfoContainer span span');

            if ( count($tmp) < 1 )
            {
                throw new ExtractExtraDataServiceException(Util::exception(__FUNCTION__, 'Impossible to find "div.containerLastInfo div.lastInfo p.windInfoContainer span span" tags in response'));
            }

            $windMinimumIntensity = (int)$tmp[0]->text();
            $windMaximunIntensity = (int)$tmp[1]->text();
            
            $tmp = $li->find('p.windDirectionName img');

            if ( count($tmp) !== 1 )
            {
                throw new ExtractExtraDataServiceException(Util::exception(__FUNCTION__, 'Impossible to find "div.containerLastInfo div.lastInfo p.windDirectionName img" tags in response'));
            }

            $windDirectionIconUrl = $tmp[0]->getAttribute('src');
            $windDirectionIconText = $tmp[0]->getAttribute('alt');

            $tmp = $li->find('div.containerLastInfo p.blue span');
            if ( array_key_exists(0, $tmp) )
            {
                $rainIntencityText = ucfirst($tmp[0]->text());
            } else {
                $rainIntencityText = null;
            }

            $dayParts = [];
            $tmp = $document->find('div.partOfDay');
            if ( count($tmp) === 4 )
            {
                foreach ( $tmp as $k => $i )
                {
                    $img = $i->find('img');

                    if ( count($img) !== 1 )
                    {
                        throw new ExtractExtraDataServiceException(Util::exception(__FUNCTION__, 'Impossible to find "div.partOfDay img" tags in response'));
                    }

                    $img = $img[0];
    
                    $iconUrl = $img->getAttribute('src');
                    $iconText = $img->getAttribute('alt');
    
                    $dayParts[] = [
                        'type' => $i->text(),
                        'iconUrl' => $iconUrl,
                        'iconText' => ucfirst($iconText),
                    ];
                }
            }

            $return[] = [
                '_hour' => $hour,
                '_weatherIconUrl' => $weatherIconUrl,
                '_weatherIconText' => $weatherIconText,
                '_windMinimumIntensity' => $windMinimumIntensity,
                '_windMaximunIntensity' => $windMaximunIntensity,
                '_windDirectionIconUrl' => $windDirectionIconUrl,
                '_windDirectionIconText' => $windDirectionIconText,
                '_rainIntencityText' => $rainIntencityText,
            ];
        }

        return $return;
    }
}