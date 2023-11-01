<?php

namespace App\Service;

use App\Entity\Location;
use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WeatherService
{
    public function __construct(private LocationRepository $locationRepository,
                                private MeasurementRepository $measurementRepository)
    {

    }

    public function getLocationById(int $locationId): Location {
        $city = $this->locationRepository->findOneBy(['id' => $locationId]);
        if ($city === null) {
            throw new NotFoundHttpException('City not found');
        }
        return $city;
    }

    public function getLocationByCountryAndCity(string $city, string $countryCode): Location {
        $location = $this->locationRepository->findOneBy(["city" => $city, 
                                                          "country" => $countryCode]);
        if ($location === null) {
            throw new NotFoundHttpException('City not found');
        }
        return $location;
    }

    public function getWeatherForLocation(Location $location): array
    {
        return $this->measurementRepository->findByLocation($location);
    }

    public function getWeatherForCountryAndCity(string $city, string $countryCode): array
    {
        $location = $this->getLocationByCountryAndCity($city,$countryCode);
        return $this->measurementRepository->findByLocation($location);
    }
}