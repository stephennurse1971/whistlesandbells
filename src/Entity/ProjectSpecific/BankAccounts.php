<?php

namespace App\Entity\ProjectSpecific;

use App\Repository\ProjectSpecific\BankAccountsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BankAccountsRepository::class)
 */
class BankAccounts
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
    private $bank;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isPension;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBank(): ?string
    {
        return $this->bank;
    }

    public function setBank(?string $bank): self
    {
        $this->bank = $bank;

        return $this;
    }

    public function getIsPension(): ?bool
    {
        return $this->isPension;
    }

    public function setIsPension(?bool $isPension): self
    {
        $this->isPension = $isPension;

        return $this;
    }
}
