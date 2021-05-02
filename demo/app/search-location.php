<?php

require '../../vendor/autoload.php';

$weatherMan = new MalvikLab\WeatherMan\WeatherMan(new GuzzleHttp\Client());

$q = array_key_exists('q', $_GET) ? $_GET['q'] : null;

$data = [];
$locations = $weatherMan->searchLocation($q);
foreach ( $locations as $location )
{
    $data[] = [
        'value' => $location['idLocation'],
        'text' => sprintf('%s - %s', $location['name'], $location['nation']),
    ];
}

header('Content-type: application/json; charset=utf-8');
die(json_encode($data));