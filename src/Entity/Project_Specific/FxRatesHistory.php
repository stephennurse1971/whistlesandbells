<?php

namespace App\Entity\Project_Specific;

use App\Repository\Project_Specific\FxRatesHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FxRatesHistoryRepository::class)
 */
class FxRatesHistory
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
     * @ORM\Column(type="float", nullable=true)
     */
    private $EUR_FX_Rate;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $GBP_FX_Rate;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $CHF_FX_Rate;




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

    public function getEURFXRate(): ?float
    {
        return $this->EUR_FX_Rate;
    }

    public function setEURFXRate(?float $EUR_FX_Rate): self
    {
        $this->EUR_FX_Rate = $EUR_FX_Rate;

        return $this;
    }

    public function getGBPFXRate(): ?float
    {
        return $this->GBP_FX_Rate;
    }

    public function setGBPFXRate(?float $GBP_FX_Rate): self
    {
        $this->GBP_FX_Rate = $GBP_FX_Rate;

        return $this;
    }

    public function getCHFFXRate(): ?float
    {
        return $this->CHF_FX_Rate;
    }

    public function setCHFFXRate(?float $CHF_FX_Rate): self
    {
        $this->CHF_FX_Rate = $CHF_FX_Rate;

        return $this;
    }



}
