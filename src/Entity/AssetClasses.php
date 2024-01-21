<?php

namespace App\Entity;

use App\Repository\AssetClassesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AssetClassesRepository::class)
 */
class AssetClasses
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
    private $assetClass;



    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $showDocs;

    /**
     * @ORM\ManyToOne(targetEntity=TaxSchemes::class)
     */
    private $taxScheme;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $showInvestmentPurchaseAndSaleDates;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $updatedPriceAvailable;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $includeInStandardInvestmentForm;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAssetClass(): ?string
    {
        return $this->assetClass;
    }

    public function setAssetClass(?string $assetClass): self
    {
        $this->assetClass = $assetClass;

        return $this;
    }



    public function getShowDocs(): ?bool
    {
        return $this->showDocs;
    }

    public function setShowDocs(?bool $showDocs): self
    {
        $this->showDocs = $showDocs;

        return $this;
    }

    public function getTaxScheme(): ?TaxSchemes
    {
        return $this->taxScheme;
    }

    public function setTaxScheme(?TaxSchemes $taxScheme): self
    {
        $this->taxScheme = $taxScheme;

        return $this;
    }

    public function getShowInvestmentPurchaseAndSaleDates(): ?bool
    {
        return $this->showInvestmentPurchaseAndSaleDates;
    }

    public function setShowInvestmentPurchaseAndSaleDates(?bool $showInvestmentPurchaseAndSaleDates): self
    {
        $this->showInvestmentPurchaseAndSaleDates = $showInvestmentPurchaseAndSaleDates;

        return $this;
    }

    public function getUpdatedPriceAvailable(): ?bool
    {
        return $this->updatedPriceAvailable;
    }

    public function setUpdatedPriceAvailable(?bool $updatedPriceAvailable): self
    {
        $this->updatedPriceAvailable = $updatedPriceAvailable;

        return $this;
    }

    public function getIncludeInStandardInvestmentForm(): ?bool
    {
        return $this->includeInStandardInvestmentForm;
    }

    public function setIncludeInStandardInvestmentForm(?bool $includeInStandardInvestmentForm): self
    {
        $this->includeInStandardInvestmentForm = $includeInStandardInvestmentForm;

        return $this;
    }
}
