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
     * @ORM\OneToMany(targetEntity=TennisAvailability::class, mappedBy="venue", orphanRemoval=true)
     */
    private $tennisAvailabilities;

    public function __construct()
    {
        $this->tennisAvailabilities = new ArrayCollection();
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
     * @return Collection|TennisAvailability[]
     */
    public function getTennisAvailabilities(): Collection
    {
        return $this->tennisAvailabilities;
    }

    public function addTennisAvailability(TennisAvailability $tennisAvailability): self
    {
        if (!$this->tennisAvailabilities->contains($tennisAvailability)) {
            $this->tennisAvailabilities[] = $tennisAvailability;
            $tennisAvailability->setVenue($this);
        }

        return $this;
    }

    public function removeTennisAvailability(TennisAvailability $tennisAvailability): self
    {
        if ($this->tennisAvailabilities->removeElement($tennisAvailability)) {
            // set the owning side to null (unless already changed)
            if ($tennisAvailability->getVenue() === $this) {
                $tennisAvailability->setVenue(null);
            }
        }

        return $this;
    }
}
