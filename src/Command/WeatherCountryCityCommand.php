<?php

namespace App\Command;

use App\Service\WeatherService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:country-city',
    description: 'Add a short description for your command',
)]
class WeatherCountryCityCommand extends Command
{
    public function __construct(private WeatherService $weatherService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('country', InputArgument::REQUIRED, 'country name')
            ->addArgument('city', InputArgument::REQUIRED, 'city name')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $city = $input->getArgument('city');
        $country = $input->getArgument('country');
        if ($city && $country) {
            $location = $this->weatherService->getLocationByCountryAndCity($city,$country);
            $measurements = $this->weatherService->getWeatherForLocation($location);
            $io->writeln(sprintf('Location: %s', $location->getCity()));
            foreach($measurements as $measurement)
            {
                $io->writeln(sprintf("\t%s: %s",
                    $measurement->getDate()->format('Y-m-d'),
                    $measurement->getTemperatureCelsius()
                ));
            }
        }

        $io->success('DONE');

        return Command::SUCCESS;
    }
}
