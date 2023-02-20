<?php

namespace App\Entity;

use App\Repository\FlyingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FlyingRepository::class)
 */
class Flying
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
    private $instructor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $aircraft;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $hots;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $paymentMade;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $lessonsLearnt;

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

    public function getInstructor(): ?string
    {
        return $this->instructor;
    }

    public function setInstructor(?string $instructor): self
    {
        $this->instructor = $instructor;

        return $this;
    }

    public function getAircraft(): ?string
    {
        return $this->aircraft;
    }

    public function setAircraft(?string $aircraft): self
    {
        $this->aircraft = $aircraft;

        return $this;
    }

    public function getHots(): ?float
    {
        return $this->hots;
    }

    public function setHots(?float $hots): self
    {
        $this->hots = $hots;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPaymentMade(): ?bool
    {
        return $this->paymentMade;
    }

    public function setPaymentMade(?bool $paymentMade): self
    {
        $this->paymentMade = $paymentMade;

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

    public function getLessonsLearnt(): ?string
    {
        return $this->lessonsLearnt;
    }

    public function setLessonsLearnt(?string $lessonsLearnt): self
    {
        $this->lessonsLearnt = $lessonsLearnt;

        return $this;
    }
}
