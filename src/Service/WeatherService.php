<?php

namespace App\Service;

use App\Entity\Location;
use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;
use http\Exception\RuntimeException;

class WeatherService
{
    public function __construct(private LocationRepository $locationRepository,
                                private MeasurementRepository $measurementRepository)
    {

    }

    public function getLocationById(int $locationId): Location {
        $city = $this->locationRepository->findOneBy(['id' => $locationId]);
        if ($city === null) {
            throw new RuntimeException('City not found');
        }
        return $city;
    }

    public function getCurrentMeasurementsByLocation(Location $location)
    {
        return $this->measurementRepository->findByLocation($location);
    }
}