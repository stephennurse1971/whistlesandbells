<?php

namespace App\Entity;

use App\Repository\TaxSchemesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaxSchemesRepository::class)
 */
class TaxSchemes
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
    private $name;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $purchaseIncomeOffset;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $purchaseTaxOffset;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $saleIncomeOffset;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $saleTaxOffset;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $includeTaxSummary;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $cgtRate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPurchaseIncomeOffset(): ?float
    {
        return $this->purchaseIncomeOffset;
    }

    public function setPurchaseIncomeOffset(?float $purchaseIncomeOffset): self
    {
        $this->purchaseIncomeOffset = $purchaseIncomeOffset;

        return $this;
    }

    public function getPurchaseTaxOffset(): ?float
    {
        return $this->purchaseTaxOffset;
    }

    public function setPurchaseTaxOffset(?float $purchaseTaxOffset): self
    {
        $this->purchaseTaxOffset = $purchaseTaxOffset;

        return $this;
    }

    public function getSaleIncomeOffset(): ?float
    {
        return $this->saleIncomeOffset;
    }

    public function setSaleIncomeOffset(?float $saleIncomeOffset): self
    {
        $this->saleIncomeOffset = $saleIncomeOffset;

        return $this;
    }

    public function getSaleTaxOffset(): ?float
    {
        return $this->saleTaxOffset;
    }

    public function setSaleTaxOffset(?float $saleTaxOffset): self
    {
        $this->saleTaxOffset = $saleTaxOffset;

        return $this;
    }

    public function getIncludeTaxSummary(): ?bool
    {
        return $this->includeTaxSummary;
    }

    public function setIncludeTaxSummary(?bool $includeTaxSummary): self
    {
        $this->includeTaxSummary = $includeTaxSummary;

        return $this;
    }

    public function getCgtRate(): ?float
    {
        return $this->cgtRate;
    }

    public function setCgtRate(?float $cgtRate): self
    {
        $this->cgtRate = $cgtRate;

        return $this;
    }
}
