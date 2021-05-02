<?php

namespace MalvikLab\WeatherMan\Service;

use MalvikLab\WeatherMan\Util\Constant;

trait ClearDataService {
    private function clearDataService(array $data, string $type): array
    {
        switch ($type)
        {
            case Constant::TODAY:
                $data['_weatherReport'] = array_key_exists('weatherReportToday', $data) ? $data['weatherReportToday'] : null;
                unset($data['weatherReportToday']);
                unset($data['weatherReportTomorrow']);
                break;

            case Constant::TOMORROW:
                $data['_weatherReport'] = array_key_exists('weatherReportTomorrow', $data) ? $data['weatherReportTomorrow'] : null;
                unset($data['weatherReportToday']);
                unset($data['weatherReportTomorrow']);
                break;
        }

        return $data;
    }
}