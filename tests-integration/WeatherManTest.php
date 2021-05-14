<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use MalvikLab\WeatherMan\WeatherMan;
use MalvikLab\WeatherMan\Util\Constant;
use GuzzleHttp\Client;

/**
 * vendor/bin/phpunit tests-integration --do-not-cache-result
 */

final class WeatherManTest extends TestCase {
    protected $obj;

    protected function setUp(): void
    {
        $this->obj = new WeatherMan(new Client());
    }

    public function testRandomGet(): void
    {
        $locations = $this->obj->getLocations();
        $location = $locations[array_rand($locations)];

        $search = $this->obj->searchLocation($location['name']);
        $this->assertIsArray($search);
        $this->assertTrue(count($search) > 0);

        $types = [
            Constant::TODAY,
            Constant::TOMORROW,
            Constant::TWO_DAYS,
            Constant::THREE_DAYS,
            Constant::FOUR_DAYS,
            Constant::FIVE_DAYS,
            Constant::SIX_DAYS,
            Constant::SEVEN_DAYS,
        ];

        foreach ( $types as $type )
        {
            $response = $this->obj->get($location['idLocation'], $type);

            $this->assertEquals($location['name'], $response['locationInfo']['name']);

            if ( array_key_exists('region', $locations) AND array_key_exists('region', $response['locationInfo']) )
            {
                $this->assertEquals($location['region'], $response['locationInfo']['region']);
            }
    
            $this->assertEquals($location['nation'], $response['locationInfo']['nation']);
        }
    }
}
