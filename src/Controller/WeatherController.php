<?php

namespace App\Controller;

use App\Entity\Location;
use App\Service\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

class WeatherController extends AbstractController
{

    public function __construct(private WeatherService $weatherService)
    {

    }

    #[Route('/weather/{id}', name: 'app_weather_by_city_id', requirements: ['id' => '\d+'])]
    public function cityById(Location $location): Response
    {
        $currentMeasurements = $this->weatherService->getCurrentMeasurementsByLocation($location);

        return $this->render('weather/index.html.twig', [
            'location' => $location,
            'currentMeasurements' => $currentMeasurements
        ]);
    }

    #[Route('/weather/{city}', name: 'app_weather_by_city_name', requirements: ['city' => '[a-zA-Z]+'])]
    public function cityByName(Location $location): Response
    {
        $currentMeasurements = $this->weatherService->getCurrentMeasurementsByLocation($location);

        return $this->render('weather/index.html.twig', [
            'location' => $location,
            'currentMeasurements' => $currentMeasurements
        ]);
    }
}
