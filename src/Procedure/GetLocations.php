<?php

namespace MalvikLab\WeatherMan\Procedure;

trait GetLocations {
    public function getLocations(): array
    {
        return $this->getLocationsService();
    }
}