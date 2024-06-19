<?php

namespace App\Entity\ProjectSpecific;

use App\Repository\ProjectSpecific\WineListRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WineListRepository::class)
 */
class WineList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $colour;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $grape;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $labelPicture;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $marks;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $supermarket;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getColour(): ?string
    {
        return $this->colour;
    }

    public function setColour(?string $colour): self
    {
        $this->colour = $colour;

        return $this;
    }

    public function getGrape(): ?string
    {
        return $this->grape;
    }

    public function setGrape(?string $grape): self
    {
        $this->grape = $grape;

        return $this;
    }

    public function getLabelPicture(): ?string
    {
        return $this->labelPicture;
    }

    public function setLabelPicture(?string $labelPicture): self
    {
        $this->labelPicture = $labelPicture;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getMarks(): ?int
    {
        return $this->marks;
    }

    public function setMarks(?int $marks): self
    {
        $this->marks = $marks;

        return $this;
    }

    public function getSupermarket(): ?string
    {
        return $this->supermarket;
    }

    public function setSupermarket(?string $supermarket): self
    {
        $this->supermarket = $supermarket;

        return $this;
    }
}
