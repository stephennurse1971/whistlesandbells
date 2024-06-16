<?php

namespace App\Entity;

use App\Repository\UkDaysRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UkDaysRepository::class)
 */
class UkDays
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $flightDate;


    /**
     * @ORM\ManyToOne(targetEntity=Country::class)
     */
    private $departCountry;


    /**
     * @ORM\ManyToOne(targetEntity=Country::class)
     */
    private $arrivalCountry;


    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $travelDocs;

    /**
     * @ORM\ManyToOne(targetEntity=Airports::class)
     */
    private $departureAirport;

    /**
     * @ORM\ManyToOne(targetEntity=Airports::class)
     */
    private $arrivalAirport;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $airline;



    public function getId(): ?int
    {
        return $this->id;
    }



    public function getFlightDate(): ?\DateTimeInterface
    {
        return $this->flightDate;
    }

    public function setFlightDate(?\DateTimeInterface $flightDate): self
    {
        $this->flightDate = $flightDate;

        return $this;
    }

    public function getDepartCountry(): ?Country
    {
        return $this->departCountry;
    }

    public function setDepartCountry(?Country $departCountry): self
    {
        $this->departCountry = $departCountry;

        return $this;
    }

    public function getArrivalCountry(): ?Country
    {
        return $this->arrivalCountry;
    }

    public function setArrivalCountry(?Country $arrivalCountry): self
    {
        $this->arrivalCountry = $arrivalCountry;

        return $this;
    }
    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getTravelDocs(): ?string
    {
        return $this->travelDocs;
    }

    public function setTravelDocs(?string $travelDocs): self
    {
        $this->travelDocs = $travelDocs;

        return $this;
    }

    public function getDepartureAirport(): ?Airports
    {
        return $this->departureAirport;
    }

    public function setDepartureAirport(?Airports $departureAirport): self
    {
        $this->departureAirport = $departureAirport;

        return $this;
    }

    public function getArrivalAirport(): ?Airports
    {
        return $this->arrivalAirport;
    }

    public function setArrivalAirport(?Airports $arrivalAirport): self
    {
        $this->arrivalAirport = $arrivalAirport;

        return $this;
    }

    public function getAirline(): ?string
    {
        return $this->airline;
    }

    public function setAirline(?string $airline): self
    {
        $this->airline = $airline;

        return $this;
    }

}
