<?php

namespace App\Entity;

use App\Repository\GarminFilesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GarminFilesRepository::class)
 */
class GarminFiles
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
    private $gpxFile;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class)
     */
    private $country;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $kilometres;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $climb;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $startingPoint;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $endPoint;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGpxFile(): ?string
    {
        return $this->gpxFile;
    }

    public function setGpxFile(?string $gpxFile): self
    {
        $this->gpxFile = $gpxFile;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getKilometres(): ?int
    {
        return $this->kilometres;
    }

    public function setKilometres(?int $kilometres): self
    {
        $this->kilometres = $kilometres;

        return $this;
    }

    public function getClimb(): ?int
    {
        return $this->climb;
    }

    public function setClimb(?int $climb): self
    {
        $this->climb = $climb;

        return $this;
    }

    public function getStartingPoint(): ?string
    {
        return $this->startingPoint;
    }

    public function setStartingPoint(?string $startingPoint): self
    {
        $this->startingPoint = $startingPoint;

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

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getEndPoint(): ?string
    {
        return $this->endPoint;
    }

    public function setEndPoint(?string $endPoint): self
    {
        $this->endPoint = $endPoint;

        return $this;
    }
}
