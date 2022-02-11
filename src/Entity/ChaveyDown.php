<?php

namespace App\Entity;

use App\Repository\ChaveyDownRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChaveyDownRepository::class)
 */
class ChaveyDown
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vendor;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $amount;

    /**
     * @ORM\Column(type="json")
     */
    private $attachments = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $serpentimeComments;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $hmrcComments;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $receipt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cashOrDebit;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $barclays;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $caxton;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getVendor(): ?string
    {
        return $this->vendor;
    }

    public function setVendor(?string $vendor): self
    {
        $this->vendor = $vendor;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getAttachments(): ?array
    {
        $attachments = $this->attachments;
        return $attachments;
    }

    public function setAttachments(?array $attachments): self
    {
        $this->attachments = $attachments;

        return $this;
    }

    public function getSerpentimeComments(): ?string
    {
        return $this->serpentimeComments;
    }

    public function setSerpentimeComments(?string $serpentimeComments): self
    {
        $this->serpentimeComments = $serpentimeComments;

        return $this;
    }

    public function getHmrcComments(): ?string
    {
        return $this->hmrcComments;
    }

    public function setHmrcComments(?string $hmrcComments): self
    {
        $this->hmrcComments = $hmrcComments;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getReceipt(): ?string
    {
        return $this->receipt;
    }

    public function setReceipt(?string $receipt): self
    {
        $this->receipt = $receipt;

        return $this;
    }

    public function getCashOrDebit(): ?string
    {
        return $this->cashOrDebit;
    }

    public function setCashOrDebit(?string $cashOrDebit): self
    {
        $this->cashOrDebit = $cashOrDebit;

        return $this;
    }

    public function getBarclays(): ?float
    {
        return $this->barclays;
    }

    public function setBarclays(?float $barclays): self
    {
        $this->barclays = $barclays;

        return $this;
    }

    public function getCaxton(): ?float
    {
        return $this->caxton;
    }

    public function setCaxton(?float $caxton): self
    {
        $this->caxton = $caxton;

        return $this;
    }
}
