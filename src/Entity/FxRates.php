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
}
