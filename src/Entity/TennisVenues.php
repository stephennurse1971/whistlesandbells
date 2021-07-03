<?php

namespace App\Entity;

use App\Repository\TennisVenuesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TennisVenuesRepository::class)
 */
class TennisVenues
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $venue;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mapLink;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $webLink;

    /**
     * @ORM\OneToMany(targetEntity=TennisPlayerAvailability::class, mappedBy="venue", orphanRemoval=true)
     */
    private $tennisAvailabilities;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bookingEngine;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $londonRegion;

    /**
     * @ORM\OneToMany(targetEntity=TennisCourtPreferences::class, mappedBy="tennisVenue")
     */
    private $tennisCourtPreferences;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $towerHamletsId;

    
    public function __construct()
    {
        $this->tennisAvailabilities = new ArrayCollection();
        $this->tennisCourtPreferences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVenue(): ?string
    {
        return $this->venue;
    }

    public function setVenue(string $venue): self
    {
        $this->venue = $venue;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getMapLink(): ?string
    {
        return $this->mapLink;
    }

    public function setMapLink(string $mapLink): self
    {
        $this->mapLink = $mapLink;

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

    public function getWebLink(): ?string
    {
        return $this->webLink;
    }

    public function setWebLink(?string $webLink): self
    {
        $this->webLink = $webLink;

        return $this;
    }

    /**
     * @return Collection|TennisCourtAvailability[]
     */
    public function getTennisAvailabilities(): Collection
    {
        return $this->tennisAvailabilities;
    }

    public function addTennisAvailability(TennisCourtAvailability $tennisAvailability): self
    {
        if (!$this->tennisAvailabilities->contains($tennisAvailability)) {
            $this->tennisAvailabilities[] = $tennisAvailability;
            $tennisAvailability->setVenue($this);
        }

        return $this;
    }

    public function removeTennisAvailability(TennisCourtAvailability $tennisAvailability): self
    {
        if ($this->tennisAvailabilities->removeElement($tennisAvailability)) {
            // set the owning side to null (unless already changed)
            if ($tennisAvailability->getVenue() === $this) {
                $tennisAvailability->setVenue(null);
            }
        }

        return $this;
    }

    public function getTelNumber(): ?string
    {
        return $this->telNumber;
    }

    public function setTelNumber(?string $telNumber): self
    {
        $this->telNumber = $telNumber;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getBookingEngine(): ?string
    {
        return $this->bookingEngine;
    }

    public function setBookingEngine(?string $bookingEngine): self
    {
        $this->bookingEngine = $bookingEngine;

        return $this;
    }

    public function getLondonRegion(): ?string
    {
        return $this->londonRegion;
    }

    public function setLondonRegion(?string $londonRegion): self
    {
        $this->londonRegion = $londonRegion;

        return $this;
    }

    /**
     * @return Collection|TennisCourtPreferences[]
     */
    public function getTennisCourtPreferences(): Collection
    {
        return $this->tennisCourtPreferences;
    }

    public function addTennisCourtPreference(TennisCourtPreferences $tennisCourtPreference): self
    {
        if (!$this->tennisCourtPreferences->contains($tennisCourtPreference)) {
            $this->tennisCourtPreferences[] = $tennisCourtPreference;
            $tennisCourtPreference->setTennisVenue($this);
        }

        return $this;
    }

    public function removeTennisCourtPreference(TennisCourtPreferences $tennisCourtPreference): self
    {
        if ($this->tennisCourtPreferences->removeElement($tennisCourtPreference)) {
            // set the owning side to null (unless already changed)
            if ($tennisCourtPreference->getTennisVenue() === $this) {
                $tennisCourtPreference->setTennisVenue(null);
            }
        }

        return $this;
    }

    public function getTowerHamletsId(): ?string
    {
        return $this->towerHamletsId;
    }

    public function setTowerHamletsId(?string $towerHamletsId): self
    {
        $this->towerHamletsId = $towerHamletsId;

        return $this;
    }


}
