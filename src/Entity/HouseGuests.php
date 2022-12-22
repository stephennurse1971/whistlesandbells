<?php

namespace App\Entity;

use App\Repository\HouseGuestsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HouseGuestsRepository::class)
 */
class HouseGuests
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
    private $dateArrival;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="houseGuests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $guestName;



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $notes;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateDeparture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $departureNotes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $arrivalNotes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateArrival(): ?\DateTimeInterface
    {
        return $this->dateArrival;
    }

    public function setDateArrival(?\DateTimeInterface $date): self
    {
        $this->dateArrival = $date;

        return $this;
    }

    public function getGuestName(): ?User
    {
        return $this->guestName;
    }

    public function setGuestName(?User $guestName): self
    {
        $this->guestName = $guestName;

        return $this;
    }

      public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function getDateDeparture(): ?\DateTimeInterface
    {
        return $this->dateDeparture;
    }

    public function setDateDeparture(?\DateTimeInterface $dateDeparture): self
    {
        $this->dateDeparture = $dateDeparture;

        return $this;
    }

    public function getDepartureNotes(): ?string
    {
        return $this->departureNotes;
    }

    public function setDepartureNotes(?string $departureNotes): self
    {
        $this->departureNotes = $departureNotes;

        return $this;
    }

    public function getArrivalNotes(): ?string
    {
        return $this->arrivalNotes;
    }

    public function setArrivalNotes(?string $arrivalNotes): self
    {
        $this->arrivalNotes = $arrivalNotes;

        return $this;
    }
}
