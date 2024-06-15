<?php

namespace App\Entity;

use App\Repository\SettingsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SettingsRepository::class)
 */
class Settings
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $flightStatsDays;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $flightStatsStartDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $investmentDate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $flightStatsReturnLegOffset;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $lastOutlookDownload;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFlightStatsDays(): ?int
    {
        return $this->flightStatsDays;
    }

    public function setFlightStatsDays(?int $flightStatsDays): self
    {
        $this->flightStatsDays = $flightStatsDays;

        return $this;
    }

    public function getFlightStatsStartDate(): ?\DateTimeInterface
    {
        return $this->flightStatsStartDate;
    }

    public function setFlightStatsStartDate(?\DateTimeInterface $flightStatsStartDate): self
    {
        $this->flightStatsStartDate = $flightStatsStartDate;

        return $this;
    }

    public function getInvestmentDate(): ?\DateTimeInterface
    {
        return $this->investmentDate;
    }

    public function setInvestmentDate(?\DateTimeInterface $investmentDate): self
    {
        $this->investmentDate = $investmentDate;

        return $this;
    }

    public function getFlightStatsReturnLegOffset(): ?int
    {
        return $this->flightStatsReturnLegOffset;
    }

    public function setFlightStatsReturnLegOffset(?int $flightStatsReturnLegOffset): self
    {
        $this->flightStatsReturnLegOffset = $flightStatsReturnLegOffset;

        return $this;
    }

    public function getLastOutlookDownload(): ?\DateTimeInterface
    {
        return $this->lastOutlookDownload;
    }

    public function setLastOutlookDownload(?\DateTimeInterface $lastOutlookDownload): self
    {
        $this->lastOutlookDownload = $lastOutlookDownload;

        return $this;
    }
}
