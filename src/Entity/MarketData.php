<?php

namespace App\Entity;

use App\Repository\MarketDataRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MarketDataRepository::class)
 */
class MarketData
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $sharePrice;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $shareCompany;





    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSharePrice(): ?float
    {
        return $this->sharePrice;
    }

    public function setSharePrice(?float $sharePrice): self
    {
        $this->sharePrice = $sharePrice;

        return $this;
    }

    public function getShareCompany(): ?string
    {
        return $this->shareCompany;
    }

    public function setShareCompany(?string $shareCompany): self
    {
        $this->shareCompany = $shareCompany;

        return $this;
    }








}
