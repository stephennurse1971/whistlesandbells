<?php

namespace App\Entity\Project_Specific;

use App\Repository\Project_Specific\HealthRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HealthRepository::class)
 */
class Health
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
    private $weight;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $diastolic;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $systolic;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $heartRate;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $user;

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

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getDiastolic(): ?int
    {
        return $this->diastolic;
    }

    public function setDiastolic(?int $diastolic): self
    {
        $this->diastolic = $diastolic;

        return $this;
    }

    public function getSystolic(): ?int
    {
        return $this->systolic;
    }

    public function setSystolic(?int $systolic): self
    {
        $this->systolic = $systolic;

        return $this;
    }

    public function getHeartRate(): ?int
    {
        return $this->heartRate;
    }

    public function setHeartRate(?int $heartRate): self
    {
        $this->heartRate = $heartRate;

        return $this;
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
}
