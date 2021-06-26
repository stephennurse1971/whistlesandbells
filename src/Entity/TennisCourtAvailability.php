<?php

namespace App\Entity;

use App\Repository\TennisCourtAvailabilityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TennisCourtAvailabilityRepository::class)
 */
class TennisCourtAvailability
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="integer")
     */
    private $hour;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $available;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=TennisVenues::class, inversedBy="tennisAvailabilities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $venue;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $courtBooked;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $courtCost;

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getHour(): ?int
    {
        return $this->hour;
    }

    public function setHour(int $hour): self
    {
        $this->hour = $hour;

        return $this;
    }

    public function getAvailable(): ?string
    {
        return $this->available;
    }

    public function setAvailable(?string $available): self
    {
        $this->available = $available;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getVenue(): ?TennisVenues
    {
        return $this->venue;
    }

    public function setVenue(?TennisVenues $venue): self
    {
        $this->venue = $venue;

        return $this;
    }

    public function getCourtBooked(): ?bool
    {
        return $this->courtBooked;
    }

    public function setCourtBooked(?bool $courtBooked): self
    {
        $this->courtBooked = $courtBooked;

        return $this;
    }

    public function getCourtCost(): ?float
    {
        return $this->courtCost;
    }

    public function setCourtCost(?float $courtCost): self
    {
        $this->courtCost = $courtCost;

        return $this;
    }
}
