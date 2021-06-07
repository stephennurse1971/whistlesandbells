<?php

namespace App\Entity;

use App\Repository\TennisPlayerAvailabilityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TennisPlayerAvailabilityRepository::class)
 */
class TennisPlayerAvailability
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=TennisPlayers::class, inversedBy="tennisPlayerAvailability")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tennisPlayer;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $hour;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $available;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTennisPlayer(): ?TennisPlayers
    {
        return $this->tennisPlayer;
    }

    public function setTennisPlayer(?TennisPlayers $tennisPlayer): self
    {
        $this->tennisPlayer = $tennisPlayer;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function getAvailable(): ?bool
    {
        return $this->available;
    }

    public function setAvailable(?bool $available): self
    {
        $this->available = $available;

        return $this;
    }


}
