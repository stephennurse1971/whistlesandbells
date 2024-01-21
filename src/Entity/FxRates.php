<?php

namespace App\Entity;

use App\Repository\FxRatesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FxRatesRepository::class)
 */
class FxRates
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fx;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $currentFxRate;

    /**
     * @ORM\OneToMany(targetEntity=Investments::class, mappedBy="currency")
     */
    private $investments;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $liveRateLink;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $reciprocal;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $updatedDate;



    public function __construct()
    {
        $this->investments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFx(): ?string
    {
        return $this->fx;
    }

    public function setFx(?string $fx): self
    {
        $this->fx = $fx;

        return $this;
    }

    public function getCurrentFxRate(): ?float
    {
        return $this->currentFxRate;
    }

    public function setCurrentFxRate(?float $currentFxRate): self
    {
        $this->currentFxRate = $currentFxRate;

        return $this;
    }

    /**
     * @return Collection|Investments[]
     */
    public function getInvestments(): Collection
    {
        return $this->investments;
    }

    public function addInvestment(Investments $investment): self
    {
        if (!$this->investments->contains($investment)) {
            $this->investments[] = $investment;
            $investment->setCurrency($this);
        }

        return $this;
    }

    public function removeInvestment(Investments $investment): self
    {
        if ($this->investments->removeElement($investment)) {
            // set the owning side to null (unless already changed)
            if ($investment->getCurrency() === $this) {
                $investment->setCurrency(null);
            }
        }

        return $this;
    }

    public function getLiveRateLink(): ?string
    {
        return $this->liveRateLink;
    }

    public function setLiveRateLink(?string $liveRateLink): self
    {
        $this->liveRateLink = $liveRateLink;

        return $this;
    }

    public function getReciprocal(): ?bool
    {
        return $this->reciprocal;
    }

    public function setReciprocal(?bool $reciprocal): self
    {
        $this->reciprocal = $reciprocal;

        return $this;
    }

    public function getUpdatedDate(): ?\DateTimeInterface
    {
        return $this->updatedDate;
    }

    public function setUpdatedDate(?\DateTimeInterface $updatedDate): self
    {
        $this->updatedDate = $updatedDate;

        return $this;
    }


}
