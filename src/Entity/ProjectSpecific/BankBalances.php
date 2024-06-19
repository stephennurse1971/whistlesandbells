<?php

namespace App\Entity\ProjectSpecific;

use App\Repository\ProjectSpecific\BankBalancesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BankBalancesRepository::class)
 */
class BankBalances
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=BankAccounts::class)
     */
    private $bank;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $BalanceGbp;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $BalanceUsd;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $BalanceEur;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $BalanceChf;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBank(): ?BankAccounts
    {
        return $this->bank;
    }

    public function setBank(?BankAccounts $bank): self
    {
        $this->bank = $bank;

        return $this;
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

    public function getBalanceGbp(): ?float
    {
        return $this->BalanceGbp;
    }

    public function setBalanceGbp(?float $BalanceGbp): self
    {
        $this->BalanceGbp = $BalanceGbp;

        return $this;
    }

    public function getBalanceUsd(): ?float
    {
        return $this->BalanceUsd;
    }

    public function setBalanceUsd(?float $BalanceUsd): self
    {
        $this->BalanceUsd = $BalanceUsd;

        return $this;
    }

    public function getBalanceEur(): ?float
    {
        return $this->BalanceEur;
    }

    public function setBalanceEur(?float $BalanceEur): self
    {
        $this->BalanceEur = $BalanceEur;

        return $this;
    }

    public function getBalanceChf(): ?float
    {
        return $this->BalanceChf;
    }

    public function setBalanceChf(?float $BalanceChf): self
    {
        $this->BalanceChf = $BalanceChf;

        return $this;
    }
}
