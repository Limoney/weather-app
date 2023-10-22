<?php

namespace App\Controller;

use App\Entity\Location;
use App\Service\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class WeatherController extends AbstractController
{

    public function __construct(private WeatherService $weatherService)
    {

    }

    #[Route('/weather/{country}/{city}', name: 'app_weather')]
    public function city(
                            #[MapEntity(mapping: ['country' => 'country', 'city' => 'city'])]
                            Location $location
                        ): Response
    {
        $futureMeasurements = $this->weatherService->getFutureMeasurementsByLocation($location);

        return $this->render('weather/index.html.twig', [
            'location' => $location,
            'futureMeasurements' => $futureMeasurements
        ]);
    }

//    #[Route('/weather/{cityId}', name: 'app_weather', requirements: ['cityId' => '\d+'])]
//    public function cityById(int $cityId): Response
//    {
//        $location = $this->weatherService->getLocationById($cityId);
//        $futureMeasurements = $this->weatherService->getFutureMeasurementsByLocation($location);
//
//        return $this->render('weather/index.html.twig', [
//            'location' => $location,
//            'futureMeasurements' => $futureMeasurements
//        ]);
//    }
}
