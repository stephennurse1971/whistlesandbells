<?php

namespace App\Entity\ProjectSpecific;

use App\Repository\ProjectSpecific\JpmIcHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JpmIcHistoryRepository::class)
 */
class JpmIcHistory
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
    private $year;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $baseSalaryGBP;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $totalCompUSD;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $icTotal;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $icCash;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $icShares;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $icSharePrice;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $icShares1;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $icShares2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attachmentICFile;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $vestingDate1;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $vestingDate2;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?float
    {
        return $this->year;
    }

    public function setYear(?float $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getBaseSalaryGBP(): ?float
    {
        return $this->baseSalaryGBP;
    }

    public function setBaseSalaryGBP(?float $baseSalaryGBP): self
    {
        $this->baseSalaryGBP = $baseSalaryGBP;

        return $this;
    }

    public function getTotalCompUSD(): ?float
    {
        return $this->totalCompUSD;
    }

    public function setTotalCompUSD(?float $totalCompUSD): self
    {
        $this->totalCompUSD = $totalCompUSD;

        return $this;
    }

    public function getIcTotal(): ?float
    {
        return $this->icTotal;
    }

    public function setIcTotal(?float $icTotal): self
    {
        $this->icTotal = $icTotal;

        return $this;
    }

    public function getIcCash(): ?float
    {
        return $this->icCash;
    }

    public function setIcCash(?float $icCash): self
    {
        $this->icCash = $icCash;

        return $this;
    }

    public function getIcShares(): ?float
    {
        return $this->icShares;
    }

    public function setIcShares(?float $icShares): self
    {
        $this->icShares = $icShares;

        return $this;
    }

    public function getIcSharePrice(): ?float
    {
        return $this->icSharePrice;
    }

    public function setIcSharePrice(?float $icSharePrice): self
    {
        $this->icSharePrice = $icSharePrice;

        return $this;
    }

    public function getIcShares1(): ?float
    {
        return $this->icShares1;
    }

    public function setIcShares1(?float $icShares1): self
    {
        $this->icShares1 = $icShares1;

        return $this;
    }

    public function getIcShares2(): ?float
    {
        return $this->icShares2;
    }

    public function setIcShares2(?float $icShares2): self
    {
        $this->icShares2 = $icShares2;

        return $this;
    }

    public function getAttachmentICFile(): ?string
    {
        return $this->attachmentICFile;
    }

    public function setAttachmentICFile(?string $attachmentICFile): self
    {
        $this->attachmentICFile = $attachmentICFile;

        return $this;
    }

    public function getVestingDate1(): ?\DateTimeInterface
    {
        return $this->vestingDate1;
    }

    public function setVestingDate1(?\DateTimeInterface $vestingDate1): self
    {
        $this->vestingDate1 = $vestingDate1;

        return $this;
    }

    public function getVestingDate2(): ?\DateTimeInterface
    {
        return $this->vestingDate2;
    }

    public function setVestingDate2(?\DateTimeInterface $vestingDate2): self
    {
        $this->vestingDate2 = $vestingDate2;

        return $this;
    }
}
