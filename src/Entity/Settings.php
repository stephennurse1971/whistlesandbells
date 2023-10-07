<?php

namespace App\Entity;

use App\Repository\SettingsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SettingsRepository::class)
 */
class Settings
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $flightStatsDays;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $flightStatsStartDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $flightStatsDepartureAirport;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFlightStatsDays(): ?int
    {
        return $this->flightStatsDays;
    }

    public function setFlightStatsDays(?int $flightStatsDays): self
    {
        $this->flightStatsDays = $flightStatsDays;

        return $this;
    }

    public function getFlightStatsStartDate(): ?\DateTimeInterface
    {
        return $this->flightStatsStartDate;
    }

    public function setFlightStatsStartDate(?\DateTimeInterface $flightStatsStartDate): self
    {
        $this->flightStatsStartDate = $flightStatsStartDate;

        return $this;
    }

    public function getFlightStatsDepartureAirport(): ?string
    {
        return $this->flightStatsDepartureAirport;
    }

    public function setFlightStatsDepartureAirport(?string $flightStatsDepartureAirport): self
    {
        $this->flightStatsDepartureAirport = $flightStatsDepartureAirport;

        return $this;
    }

     
}
