<?php

namespace App\Entity;

use App\Repository\TaxYearRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaxYearRepository::class)
 */
class TaxYear
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $start_date;

    /**
     * @ORM\Column(type="date")
     */
    private $end_date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $taxYearRange;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $taxBand1PersonalAllowance;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $taxBand2BasicRate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $taxBand3HigherRate;


    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $taxBand1Rate;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $taxBand2Rate;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $taxBand3Rate;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $taxBand4Rate;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getTaxYearRange(): ?string
    {
        return $this->taxYearRange;
    }

    public function setTaxYearRange(?string $taxYearRange): self
    {
        $this->taxYearRange = $taxYearRange;

        return $this;
    }

    public function getTaxBand1PersonalAllowance(): ?int
    {
        return $this->taxBand1PersonalAllowance;
    }

    public function setTaxBand1PersonalAllowance(?int $taxBand1PersonalAllowance): self
    {
        $this->taxBand1PersonalAllowance = $taxBand1PersonalAllowance;

        return $this;
    }

    public function getTaxBand2BasicRate(): ?int
    {
        return $this->taxBand2BasicRate;
    }

    public function setTaxBand2BasicRate(?int $taxBand2BasicRate): self
    {
        $this->taxBand2BasicRate = $taxBand2BasicRate;

        return $this;
    }

    public function getTaxBand3HigherRate(): ?int
    {
        return $this->taxBand3HigherRate;
    }

    public function setTaxBand3HigherRate(?int $taxBand3HigherRate): self
    {
        $this->taxBand3HigherRate = $taxBand3HigherRate;

        return $this;
    }


    public function getTaxBand1Rate(): ?float
    {
        return $this->taxBand1Rate;
    }

    public function setTaxBand1Rate(?float $taxBand1Rate): self
    {
        $this->taxBand1Rate = $taxBand1Rate;

        return $this;
    }

    public function getTaxBand2Rate(): ?float
    {
        return $this->taxBand2Rate;
    }

    public function setTaxBand2Rate(?float $taxBand2Rate): self
    {
        $this->taxBand2Rate = $taxBand2Rate;

        return $this;
    }

    public function getTaxBand3Rate(): ?float
    {
        return $this->taxBand3Rate;
    }

    public function setTaxBand3Rate(?float $taxBand3Rate): self
    {
        $this->taxBand3Rate = $taxBand3Rate;

        return $this;
    }

    public function getTaxBand4Rate(): ?float
    {
        return $this->taxBand4Rate;
    }

    public function setTaxBand4Rate(?float $taxBand4Rate): self
    {
        $this->taxBand4Rate = $taxBand4Rate;

        return $this;
    }
}
