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
}
