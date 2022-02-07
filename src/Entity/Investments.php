<?php

namespace App\Entity;

use App\Repository\InvestmentsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InvestmentsRepository::class)
 */
class Investments
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
    private $investmentName;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $investmentDate;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $investmentAmount;

    /**
     * @ORM\Column(type="boolean", nullable==true)
     */
    private $investmentEIS;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $investmentSoldPrice;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $investmentSaleDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $shareCert;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $eisCert;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $otherDocs;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInvestmentName(): ?string
    {
        return $this->investmentName;
    }

    public function setInvestmentName(string $investmentName): self
    {
        $this->investmentName = $investmentName;

        return $this;
    }

    public function getInvestmentDate(): ?\DateTimeInterface
    {
        return $this->investmentDate;
    }

    public function setInvestmentDate(?\DateTimeInterface $investmentDate): self
    {
        $this->investmentDate = $investmentDate;

        return $this;
    }

    public function getInvestmentAmount(): ?float
    {
        return $this->investmentAmount;
    }

    public function setInvestmentAmount(?float $investmentAmount): self
    {
        $this->investmentAmount = $investmentAmount;

        return $this;
    }

    public function getInvestmentEIS(): ?bool
    {
        return $this->investmentEIS;
    }

    public function setInvestmentEIS(bool $investmentEIS): self
    {
        $this->investmentEIS = $investmentEIS;

        return $this;
    }

    public function getInvestmentSoldPrice(): ?float
    {
        return $this->investmentSoldPrice;
    }

    public function setInvestmentSoldPrice(?float $investmentSoldPrice): self
    {
        $this->investmentSoldPrice = $investmentSoldPrice;

        return $this;
    }

    public function getInvestmentSaleDate(): ?\DateTimeInterface
    {
        return $this->investmentSaleDate;
    }

    public function setInvestmentSaleDate(?\DateTimeInterface $investmentSaleDate): self
    {
        $this->investmentSaleDate = $investmentSaleDate;

        return $this;
    }

    public function getShareCert(): ?string
    {
        return $this->shareCert;
    }

    public function setShareCert(?string $shareCert): self
    {
        $this->shareCert = $shareCert;

        return $this;
    }

    public function getEisCert(): ?string
    {
        return $this->eisCert;
    }

    public function setEisCert(?string $eisCert): self
    {
        $this->eisCert = $eisCert;

        return $this;
    }

    public function getOtherDocs(): ?string
    {
        return $this->otherDocs;
    }

    public function setOtherDocs(?string $otherDocs): self
    {
        $this->otherDocs = $otherDocs;

        return $this;
    }
}
