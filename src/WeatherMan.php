<?php

namespace MalvikLab\WeatherMan;

use GuzzleHttp\Client;
use Cocur\Slugify\Slugify;

class WeatherMan
 {
    const VERSION = '1.0.1';
    const DEFAULT_LOCATIONS_VERSION = '2021-01-17';

    private $client;
    private $path;
    private $iconsVersion;
    private $locationsVersion;
    private $locations;
    private $slugify;

    use Service\GetLocationsService;
    use Service\GetUrlsService;
    use Service\ExtractDataService;
    use Service\ExtractDayPartsService;
    use Service\MergeDataService;
    use Service\ClearDataService;
    use Service\ExtractExtraDataService;

    use Procedure\GetLocations;
    use Procedure\GetLocationById;
    use Procedure\GetUrl;
    use Procedure\Get;
    use Procedure\SearchLocation;

    function __construct(Client $client, array $options = [])
    {
        $this->client = $client;
        $this->path = sprintf('%s/../', realpath(__DIR__));

        if ( array_key_exists('locationsVersion', $options) AND is_string($options['locationsVersion']) )
        {
            $this->locationsVersion = $options['locationsVersion'];
        } else {
            $this->locationsVersion = self::DEFAULT_LOCATIONS_VERSION;
        }

        $this->locations = $this->getLocationsService();
        $this->slugify = new Slugify();
    }
}