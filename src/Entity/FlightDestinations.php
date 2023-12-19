<?php

namespace App\Entity;

use App\Repository\FlightDestinationsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FlightDestinationsRepository::class)
 */
class FlightDestinations
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $departureCity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $departureCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $arrivalCity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $arrivalCode;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $adminOnly;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isActive;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartureCity(): ?string
    {
        return $this->departureCity;
    }

    public function setDepartureCity(?string $departureCity): self
    {
        $this->departureCity = $departureCity;

        return $this;
    }

    public function getDepartureCode(): ?string
    {
        return $this->departureCode;
    }

    public function setDepartureCode(?string $departureCode): self
    {
        $this->departureCode = $departureCode;

        return $this;
    }

    public function getArrivalCity(): ?string
    {
        return $this->arrivalCity;
    }

    public function setArrivalCity(string $arrivalCity): self
    {
        $this->arrivalCity = $arrivalCity;

        return $this;
    }

    public function getArrivalCode(): ?string
    {
        return $this->arrivalCode;
    }

    public function setArrivalCode(string $arrivalCode): self
    {
        $this->arrivalCode = $arrivalCode;

        return $this;
    }

    public function getAdminOnly(): ?bool
    {
        return $this->adminOnly;
    }

    public function setAdminOnly(?bool $adminOnly): self
    {
        $this->adminOnly = $adminOnly;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(?bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
}
