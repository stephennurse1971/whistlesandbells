<?php

namespace App\Entity;

use App\Repository\PhotosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PhotosRepository::class)
 */
class Photos
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
    private $photoFile;

    /**
     * @ORM\ManyToOne(targetEntity=PhotoLocations::class, inversedBy="photos")
     */
    private $location;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $rotate;

        public function __construct()
    {
      //  $this->person = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhotoFile(): ?string
    {
        return $this->photoFile;
    }

    public function setPhotoFile(?string $photoFile): self
    {
        $this->photoFile = $photoFile;

        return $this;
    }

    public function getLocation(): ?PhotoLocations
    {
        return $this->location;
    }

    public function setLocation(?PhotoLocations $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getRotate(): ?bool
    {
        return $this->rotate;
    }

    public function setRotate(?bool $rotate): self
    {
        $this->rotate = $rotate;

        return $this;
    }

}
