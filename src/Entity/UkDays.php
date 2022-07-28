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
    private $startDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $travelDocs = [];

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $dayCount;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getTravelDocs(): ?array
    {
        return $this->travelDocs;
    }

    public function setTravelDocs(?array $travelDocs): self
    {
        $this->travelDocs = $travelDocs;

        return $this;
    }

    public function getDayCount(): ?int
    {
        return $this->dayCount;
    }

    public function setDayCount(?int $dayCount): self
    {
        $this->dayCount = $dayCount;

        return $this;
    }


}
