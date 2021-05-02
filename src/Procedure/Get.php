<?php

namespace MalvikLab\WeatherMan\Procedure;

use GuzzleHttp\Psr7\Request;
use DiDom\Document;

trait Get {
    public function get(string $locationId, string $type): array
    {
        $url = $this->getUrl($locationId, $type);

        $headers = [
            'accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9', 
            'accept-encoding' => 'gzip, deflate, br', 
            'accept-language' => 'it-IT,it;q=0.9,en-US;q=0.8,en;q=0.7', 
            'cache-control' => 'max-age=0', 
            'referer' => 'https://www.meteo.it/', 
            'sec-fetch-dest' => 'document', 
            'sec-fetch-mode' => 'navigate', 
            'sec-fetch-site' => 'same-origin', 
            'sec-fetch-user' => '?1', 
            'upgrade-insecure-requests' => '1', 
            'user-agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36', 
        ];

        $request = new Request('GET', $url, $headers);
        $response = $this->client->send($request);

        $document = new Document((string)$response->getBody());
        $data = $this->extractDataService($document);
        $extraData = $this->extractExtraDataService($document);
        $dayPartsData = $this->extractDayPartsService($document);
        $data = $this->mergeDataService($data, $extraData, $dayPartsData);
        $data = $this->clearDataService($data, $type);

        return $data;
    }
}