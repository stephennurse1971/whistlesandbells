<?php

namespace App\Entity;

use App\Repository\PhotoLocationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PhotoLocationsRepository::class)
 */
class PhotoLocations
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\OneToMany(targetEntity=Photos::class, mappedBy="location")
     */
    private $photos;

    /**
     * @ORM\Column(type="json")
     */
    private $enabledUsers = [];

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $publicPrivate;








    public function __construct()
    {
        $this->photos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection|Photos[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photos $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setLocation($this);
        }

        return $this;
    }

    public function removePhoto(Photos $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getLocation() === $this) {
                $photo->setLocation(null);
            }
        }

        return $this;
    }

    public function getEnabledUsers(): ?array
    {
        return $this->enabledUsers;
    }

    public function setEnabledUsers(array $enabledUsers): self
    {
        $this->enabledUsers = $enabledUsers;

        return $this;
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

    public function getPublicPrivate(): ?string
    {
        return $this->publicPrivate;
    }

    public function setPublicPrivate(?string $publicPrivate): self
    {
        $this->publicPrivate = $publicPrivate;

        return $this;
    }






}
