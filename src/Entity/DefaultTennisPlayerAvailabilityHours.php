<?php

namespace App\Entity;

use App\Repository\DefaultTennisPlayerAvailabilityHoursRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DefaultTennisPlayerAvailabilityHoursRepository::class)
 */
class DefaultTennisPlayerAvailabilityHours
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="defaultTennisPlayerAvailabilityHours")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $WeekdayOrWeekend;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $hour;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $defaultAvailable;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getWeekdayOrWeekend(): ?string
    {
        return $this->WeekdayOrWeekend;
    }

    public function setWeekdayOrWeekend(string $WeekdayOrWeekend): self
    {
        $this->WeekdayOrWeekend = $WeekdayOrWeekend;

        return $this;
    }

    public function getHour(): ?int
    {
        return $this->hour;
    }

    public function setHour(?int $hour): self
    {
        $this->hour = $hour;

        return $this;
    }

    public function getDefaultAvailable(): ?bool
    {
        return $this->defaultAvailable;
    }

    public function setDefaultAvailable(?bool $defaultAvailable): self
    {
        $this->defaultAvailable = $defaultAvailable;

        return $this;
    }
}
