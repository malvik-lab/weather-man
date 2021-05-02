<?php

namespace MalvikLab\WeatherMan\Service;

trait ExtractDayPartsService {
    private function extractDayPartsService(\DiDom\Document $document): array
    {
        $return = [];

        $tmp = $document->find('div.partOfDay');
        if ( count($tmp) === 4 )
        {
            foreach ( $tmp as $k => $i )
            {
                $img = $i->find('img');
                $img = $img[0];

                $iconUrl = $img->getAttribute('src');
                $iconText = $img->getAttribute('alt');

                $return[] = [
                    'type' => $i->text(),
                    'iconUrl' => $iconUrl,
                    'iconText' => ucfirst($iconText),
                ];
            }
        }

        return $return;
    }
}