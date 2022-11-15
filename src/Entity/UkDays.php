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

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="ukDays")
     */
    private $country;

    /**
     * @ORM\Column(type="json",  nullable=true)
     */
    private $travelDocs2;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $travel1Description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $travel2Description;



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

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getTravelDocs2(): ?array
    {
        return $this->travelDocs2;
    }

    public function setTravelDocs2(?array $travelDocs2): self
    {
        $this->travelDocs2 = $travelDocs2;

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

    public function getTravel1Description(): ?string
    {
        return $this->travel1Description;
    }

    public function setTravel1Description(?string $travel1Description): self
    {
        $this->travel1Description = $travel1Description;

        return $this;
    }

    public function getTravel2Description(): ?string
    {
        return $this->travel2Description;
    }

    public function setTravel2Description(?string $travel2Description): self
    {
        $this->travel2Description = $travel2Description;

        return $this;
    }


}
