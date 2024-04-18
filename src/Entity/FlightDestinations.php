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
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $adminOnly;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateStart;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateEnd;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastScraped;

    /**
     * @ORM\ManyToOne(targetEntity=Airports::class)
     */
    private $departureCity;

    /**
     * @ORM\ManyToOne(targetEntity=Airports::class)
     */
    private $arrivalCity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $returnLeg;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $grouping;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(?\DateTimeInterface $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(?\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getLastScraped(): ?\DateTimeInterface
    {
        return $this->lastScraped;
    }

    public function setLastScraped(?\DateTimeInterface $lastScraped): self
    {
        $this->lastScraped = $lastScraped;

        return $this;
    }

    public function getDepartureCity(): ?Airports
    {
        return $this->departureCity;
    }

    public function setDepartureCity(?Airports $departureCity): self
    {
        $this->departureCity = $departureCity;

        return $this;
    }

    public function getArrivalCity(): ?Airports
    {
        return $this->arrivalCity;
    }

    public function setArrivalCity(?Airports $arrivalCity): self
    {
        $this->arrivalCity = $arrivalCity;

        return $this;
    }

    public function getReturnLeg(): ?string
    {
        return $this->returnLeg;
    }

    public function setReturnLeg(?string $returnLeg): self
    {
        $this->returnLeg = $returnLeg;

        return $this;
    }

    public function getGrouping(): ?int
    {
        return $this->grouping;
    }

    public function setGrouping(?int $grouping): self
    {
        $this->grouping = $grouping;

        return $this;
    }
}
