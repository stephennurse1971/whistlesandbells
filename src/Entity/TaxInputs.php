<?php

namespace App\Entity;

use App\Repository\TaxInputsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaxInputsRepository::class)
 */
class TaxInputs
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
    private $employmentEarnings;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $interestEarnings;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $otherEarnings;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $incomeOffsetBPRAorEISLosses;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $taxDeductedAtSource;

    /**
     * @ORM\OneToOne(targetEntity=TaxYear::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $year;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmploymentEarnings(): ?float
    {
        return $this->employmentEarnings;
    }

    public function setEmploymentEarnings(?float $employmentEarnings): self
    {
        $this->employmentEarnings = $employmentEarnings;

        return $this;
    }

    public function getInterestEarnings(): ?int
    {
        return $this->interestEarnings;
    }

    public function setInterestEarnings(?int $interestEarnings): self
    {
        $this->interestEarnings = $interestEarnings;

        return $this;
    }

    public function getOtherEarnings(): ?int
    {
        return $this->otherEarnings;
    }

    public function setOtherEarnings(?int $otherEarnings): self
    {
        $this->otherEarnings = $otherEarnings;

        return $this;
    }

    public function getIncomeOffsetBPRAorEISLosses(): ?float
    {
        return $this->incomeOffsetBPRAorEISLosses;
    }

    public function setIncomeOffsetBPRAorEISLosses(?float $incomeOffsetBPRAorEISLosses): self
    {
        $this->incomeOffsetBPRAorEISLosses = $incomeOffsetBPRAorEISLosses;

        return $this;
    }

    public function getTaxDeductedAtSource(): ?float
    {
        return $this->taxDeductedAtSource;
    }

    public function setTaxDeductedAtSource(?float $taxDeductedAtSource): self
    {
        $this->taxDeductedAtSource = $taxDeductedAtSource;

        return $this;
    }

    public function getYear(): ?TaxYear
    {
        return $this->year;
    }

    public function setYear(TaxYear $year): self
    {
        $this->year = $year;

        return $this;
    }
}
