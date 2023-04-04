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
    private $taxDeductedAtSource;

    /**
     * @ORM\OneToOne(targetEntity=TaxYear::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $p11D;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $p60;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $p45;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $selfAssessment;

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

    public function getP11D(): ?string
    {
        return $this->p11D;
    }

    public function setP11D(?string $p11D): self
    {
        $this->p11D = $p11D;

        return $this;
    }

    public function getP60(): ?string
    {
        return $this->p60;
    }

    public function setP60(?string $p60): self
    {
        $this->p60 = $p60;

        return $this;
    }

    public function getP45(): ?string
    {
        return $this->p45;
    }

    public function setP45(?string $p45): self
    {
        $this->p45 = $p45;

        return $this;
    }

    public function getSelfAssessment(): ?string
    {
        return $this->selfAssessment;
    }

    public function setSelfAssessment(?string $selfAssessment): self
    {
        $this->selfAssessment = $selfAssessment;

        return $this;
    }
}
