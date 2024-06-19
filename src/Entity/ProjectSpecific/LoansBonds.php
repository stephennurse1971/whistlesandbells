<?php

namespace App\Entity\ProjectSpecific;

use App\Repository\ProjectSpecific\LoansBondsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LoansBondsRepository::class)
 */
class LoansBonds
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $currency;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $notional;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $interestRate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $drawdownDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $repaymentDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $category;



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

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getNotional(): ?float
    {
        return $this->notional;
    }

    public function setNotional(?float $notional): self
    {
        $this->notional = $notional;

        return $this;
    }

    public function getInterestRate(): ?float
    {
        return $this->interestRate;
    }

    public function setInterestRate(?float $interestRate): self
    {
        $this->interestRate = $interestRate;

        return $this;
    }

    public function getDrawdownDate(): ?\DateTimeInterface
    {
        return $this->drawdownDate;
    }

    public function setDrawdownDate(?\DateTimeInterface $drawdownDate): self
    {
        $this->drawdownDate = $drawdownDate;

        return $this;
    }

    public function getRepaymentDate(): ?\DateTimeInterface
    {
        return $this->repaymentDate;
    }

    public function setRepaymentDate(?\DateTimeInterface $repaymentDate): self
    {
        $this->repaymentDate = $repaymentDate;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }


}
