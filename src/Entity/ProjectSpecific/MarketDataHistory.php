<?php

namespace App\Entity\ProjectSpecific;

use App\Repository\ProjectSpecific\MarketDataHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MarketDataHistoryRepository::class)
 */
class MarketDataHistory
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
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=MarketData::class)
     */
    private $security;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $marketPrice;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getSecurity(): ?MarketData
    {
        return $this->security;
    }

    public function setSecurity(?MarketData $security): self
    {
        $this->security = $security;

        return $this;
    }

    public function getMarketPrice(): ?float
    {
        return $this->marketPrice;
    }

    public function setMarketPrice(?float $marketPrice): self
    {
        $this->marketPrice = $marketPrice;

        return $this;
    }
}
