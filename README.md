# Weather Man

Weather Man is just an experiment but fully functional to get the weather up to 7 days of many cities in the world using the meteo.it site without API.

 ## Installation (with Composer)
```
$ composer require malvik-lab/weather-man
```

## Use
```php
<?php

require 'vendor/autoload.php';

use MalvikLab\WeatherMan\WeatherMan;
use MalvikLab\WeatherMan\Util\Constant;
use GuzzleHttp\Client;

$client = new Client();
$weatherMan = new WeatherMan($client);

## First, search location id
$locations = $weatherMan->searchLocation('Roma');

## Second, get data
/*
Available types:
- Constant::TODAY
- Constant::TOMORROW
- Constant::TWO_DAYS
- Constant::THREE_DAYS
- Constant::FOUR_DAYS
- Constant::FIVE_DAYS
- Constant::SIX_DAYS
- Constant::SEVEN_DAYS
*/

$locationId = '0058091';
$type = Constant::TODAY;
$data = $weatherMan->get($locationId, $type);
```

## Demo
In the demo folder, you can find an example of an application to search and view all the weather forecasts.
