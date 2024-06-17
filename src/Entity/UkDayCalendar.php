<?php

namespace App\Entity;

use App\Repository\UkDayCalendarRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UkDayCalendarRepository::class)
 */
class UkDayCalendar
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
     * @ORM\ManyToOne(targetEntity=Country::class)
     */
    private $locationAtMidnight;

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

    public function getLocationAtMidnight(): ?Country
    {
        return $this->locationAtMidnight;
    }

    public function setLocationAtMidnight(?Country $locationAtMidnight): self
    {
        $this->locationAtMidnight = $locationAtMidnight;

        return $this;
    }
}
