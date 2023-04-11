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
    private $showTaxYearDetails;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $showSharePrices;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $showDocs;

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

    public function getShowTaxYearDetails(): ?bool
    {
        return $this->showTaxYearDetails;
    }

    public function setShowTaxYearDetails(?bool $showTaxYearDetails): self
    {
        $this->showTaxYearDetails = $showTaxYearDetails;

        return $this;
    }

    public function getShowSharePrices(): ?bool
    {
        return $this->showSharePrices;
    }

    public function setShowSharePrices(?bool $showSharePrices): self
    {
        $this->showSharePrices = $showSharePrices;

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
}
