<?php

namespace App\Entity;

use App\Repository\InvestmentFutureCommsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InvestmentFutureCommsRepository::class)
 */
class InvestmentFutureComms
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Investments::class, inversedBy="investmentFutureComms")
     * @ORM\JoinColumn(nullable=true)
     */
    private $investment;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $attachment = [];

    /**
     * @ORM\ManyToOne(targetEntity=MarketData::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $marketData;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInvestment(): ?Investments
    {
        return $this->investment;
    }

    public function setInvestment(?Investments $investment): self
    {
        $this->investment = $investment;

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



    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getAttachment(): ?array
    {
        return $this->attachment;
    }

    public function setAttachment(?array $attachment): self
    {
        $this->attachment = $attachment;

        return $this;
    }

    public function getMarketData(): ?MarketData
    {
        return $this->marketData;
    }

    public function setMarketData(?MarketData $marketData): self
    {
        $this->marketData = $marketData;

        return $this;
    }
}
