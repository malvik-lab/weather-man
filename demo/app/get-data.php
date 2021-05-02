<?php

require 'autoload.php';

$weatherMan = new MalvikLab\WeatherMan\WeatherMan(new GuzzleHttp\Client());

$idLocation = array_key_exists('idLocation', $_GET) ? $_GET['idLocation'] : null;

setlocale(LC_TIME, 'it_IT.UTF8');

$types = [
    [
        MalvikLab\WeatherMan\Util\Constant::TODAY,
        'Oggi'
    ],

    [
        MalvikLab\WeatherMan\Util\Constant::TOMORROW,
        'Domani'
    ],

    [
        MalvikLab\WeatherMan\Util\Constant::TWO_DAYS,
        ucfirst(strftime('%a %d %b', ((new DateTime())->add(new DateInterval('P2D')))->getTimestamp()))
    ],

    [
        MalvikLab\WeatherMan\Util\Constant::THREE_DAYS,
        ucfirst(strftime('%a %d %b', ((new DateTime())->add(new DateInterval('P3D')))->getTimestamp()))
    ],

    [
        MalvikLab\WeatherMan\Util\Constant::FOUR_DAYS,
        ucfirst(strftime('%a %d %b', ((new DateTime())->add(new DateInterval('P4D')))->getTimestamp()))
    ],

    [
        MalvikLab\WeatherMan\Util\Constant::FIVE_DAYS,
        ucfirst(strftime('%a %d %b', ((new DateTime())->add(new DateInterval('P5D')))->getTimestamp()))
    ],

    [
        MalvikLab\WeatherMan\Util\Constant::SIX_DAYS,
        ucfirst(strftime('%a %d %b', ((new DateTime())->add(new DateInterval('P6D')))->getTimestamp()))
    ],

    [
        MalvikLab\WeatherMan\Util\Constant::SEVEN_DAYS,
        ucfirst(strftime('%a %d %b', ((new DateTime())->add(new DateInterval('P7D')))->getTimestamp()))
    ],
];

try {
    $data = [
        'items' => [],
    ];

    foreach ( $types as $type )
    {
        $a = $b = $weatherMan->get($idLocation, $type[0]);
        unset($a['hours']);
        unset($a['offset']);

        $data['items'][] = [
            'type' => $type[0],
            'label' => $type[1],
            'data' => $b,
            'isToday' => $type[0] === MalvikLab\WeatherMan\Util\Constant::TODAY ? true : false,
            'isTomorrow' => $type[0] === MalvikLab\WeatherMan\Util\Constant::TOMORROW ? true : false,
        ];
    }

    $data = array_merge($data, $a);

    if ( array_key_exists('airquality', $data) )
    {
        unset($data['airquality']);
    }

    if ( array_key_exists('previsionAbstract', $data) )
    {
        unset($data['previsionAbstract']);
    }

    if ( array_key_exists('dayParts', $data) )
    {
        unset($data['dayParts']);
    }

    header('Content-type: application/json; charset=utf-8');
    die(json_encode($data));
} catch(Exception $e) {
    http_response_code(406);
    header('Content-type: text/plain; charset=utf-8');
    die($e->getMessage());
}