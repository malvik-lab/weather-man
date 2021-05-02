<?php

namespace MalvikLab\WeatherMan\Service;

use MalvikLab\WeatherMan\Util\Constant;

trait GetUrlsService {
    private function getUrlsService(string $serviceId): array
    {
        $return = [];

        $location = $this->getLocationById($serviceId);

        $items = [
            Constant::TODAY,
            Constant::TOMORROW,
            Constant::TWO_DAYS,
            Constant::THREE_DAYS,
            Constant::FOUR_DAYS,
            Constant::FIVE_DAYS,
            Constant::SIX_DAYS,
            Constant::SEVEN_DAYS,
        ];

        foreach ( $items as $item )
        {
            $url = sprintf('https://www.meteo.it/meteo/%s-%s-%s', $this->slugify->slugify($location['name']), $item, (int)$location['idLocation']);
            $return[$item] = $url;
        }

        return $return;
    }
}