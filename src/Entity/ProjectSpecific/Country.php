<?php

namespace App\Entity\ProjectSpecific;

use App\Repository\ProjectSpecific\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CountryRepository::class)
 */
class Country
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
    private $country;

    /**
     * @ORM\OneToMany(targetEntity=UkDays::class, mappedBy="country")
     */
    private $travelDocs2;

    public function __construct()
    {
        $this->travelDocs2 = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection|UkDays[]
     */
    public function getTravelDocs2(): Collection
    {
        return $this->travelDocs2;
    }

    public function addTravelDocs2(UkDays $travelDocs2): self
    {
        if (!$this->travelDocs2->contains($travelDocs2)) {
            $this->travelDocs2[] = $travelDocs2;
            $travelDocs2->setCountry($this);
        }

        return $this;
    }

    public function removeTravelDocs2(UkDays $travelDocs2): self
    {
        if ($this->travelDocs2->removeElement($travelDocs2)) {
            // set the owning side to null (unless already changed)
            if ($travelDocs2->getCountry() === $this) {
                $travelDocs2->setCountry(null);
            }
        }

        return $this;
    }
}
