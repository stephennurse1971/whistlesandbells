<?php

namespace App\Entity;

use App\Repository\TennisAvailabilityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TennisAvailabilityRepository::class)
 */
class TennisAvailability
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
}
