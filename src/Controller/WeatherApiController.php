<?php

namespace App\Controller;

use App\Entity\Measurement;
use App\Service\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1')]
class WeatherApiController extends AbstractController
{
    public function __construct(private WeatherService $weatherService)
    {

    }

    #[Route('/weather', name: 'app_weather_api')]
    public function index(#[MapQueryParameter] string $city,
                          #[MapQueryParameter] string $country,
                          #[MapQueryParameter] string $accept = 'json',
                          #[MapQueryParameter] bool $twig = false): Response
    {
        
        $location = $this->weatherService->getLocationByCountryAndCity($city,$country);
        $measurements = $this->weatherService->getWeatherForLocation($location);

        if($accept === 'json'){
            

            if($twig){
                return $this->render('weather_api/index.json.twig', [
                    'city' => $city,
                    'country' => $country,
                    'measurements' => $measurements,
                ]);
            }
            else {
                $measurements = array_map(fn(Measurement $m) => [
                    'date' => $m->getDate()->format('Y-m-d'),
                    'celsius' => $m->getTemperatureCelsius(),
                    'fahrenheit' => $m->getTemperatureFahrenheit(),
                ], $measurements);

                return $this->json([
                    'city' => $city,
                    'country' => $country,
                    'measurements' => $measurements
                ]);
            }
        }
        else if($accept === 'csv'){
            $columns = "city,country,date,celsius,fahrenheit";
            if($twig){
                return $this->render('weather_api/index.csv.twig', [
                    'city' => $city,
                    'country' => $country,
                    'measurements' => $measurements,
                    'columns' => $columns
                ]);
            }
            else {
                $csv = $columns."\n";
                $csv .= implode("\n",array_map( fn(Measurement $m) => sprintf(
                        '%s,%s,%s,%s,%s',
                        $city,
                        $country,
                        $m->getDate()->format('Y-m-d'),
                        $m->getTemperatureCelsius(),
                        $m->getTemperatureFahrenheit(),
                    ), $measurements)
                );
                return new Response($csv, Response::HTTP_OK, ['Content-Type' => 'text/csv']);
            }
        }
        else {
            return new Response("invalid format",Response::HTTP_NOT_ACCEPTABLE);
        }
    }
    
}
