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

$client = new GuzzleHttp\Client();
$weatherMan = new WeatherMan\WeatherMan($client);

## First, search location id
$locations = $weatherMan->searchLocation('Roma');

## Second, get data
/*
Available types:
- WeatherMan\Util\Constant::TODAY
- WeatherMan\Util\Constant::TOMORROW
- WeatherMan\Util\Constant::TWO_DAYS
- WeatherMan\Util\Constant::THREE_DAYS
- WeatherMan\Util\Constant::FOUR_DAYS
- WeatherMan\Util\Constant::FIVE_DAYS
- WeatherMan\Util\Constant::SIX_DAYS
- WeatherMan\Util\Constant::SEVEN_DAYS
*/

$data = $weatherMan->get($locationId, $type);
```

## Demo
In the demo folder, you can find an example of an application to search and view all the weather forecasts.
