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

    public function getFutureMeasurementsByLocation(Location $location)
    {
        return $this->measurementRepository->findByLocation($location);
    }

    public function getLocationByCity(string $city, string $countryCode = null): Location
    {
        $propsArray = ["city" => $city];
        if($countryCode)
        {
            $propsArray["country"] = $countryCode;
        }

        $location = $this->locationRepository->findOneBy($propsArray);
        if ($location === null) {
            throw new NotFoundHttpException('City not found');
        }
        return $location;
    }
}