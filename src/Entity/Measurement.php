<?php

namespace App\Entity;

use App\Repository\MeasurementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MeasurementRepository::class)]
class Measurement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'measurements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $location = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: '0')]
    #[Assert\Range(min: -50, max: 50)]
    private ?string $temperatureCelsius = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?WeatherCondition $weatherCondition = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getTemperatureCelsius(): ?string
    {
        return $this->temperatureCelsius;
    }

    public function setTemperatureCelsius(string $temperatureCelsius): static
    {
        $this->temperatureCelsius = $temperatureCelsius;

        return $this;
    }

    public function getWeatherCondition(): ?WeatherCondition
    {
        return $this->weatherCondition;
    }

    public function setWeatherCondition(?WeatherCondition $weatherCondition): static
    {
        $this->weatherCondition = $weatherCondition;

        return $this;
    }

    public function getTemperatureFahrenheit()
    {
        return $this->getTemperatureCelsius() * 9/5 + 32;
    }
}
