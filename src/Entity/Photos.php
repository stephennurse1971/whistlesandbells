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

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $uploadedBy;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $priority;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\ManyToMany(targetEntity=User::class)
     */
    private $favourites;



        public function __construct()
    {
      //  $this->person = new ArrayCollection();
      $this->favourites = new ArrayCollection();
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

    public function getUploadedBy(): ?User
    {
        return $this->uploadedBy;
    }

    public function setUploadedBy(?User $uploadedBy): self
    {
        $this->uploadedBy = $uploadedBy;

        return $this;
    }




    public function getEmail(): ?bool
    {
        return $this->email;
    }

    public function setEmail(?bool $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPriority(): ?bool
    {
        return $this->priority;
    }

    public function setPriority(?bool $priority): self
    {
        $this->priority = $priority;

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

    /**
     * @return Collection<int, User>
     */
    public function getFavourites(): Collection
    {
        return $this->favourites;
    }

    public function addFavourite(User $favourite): self
    {
        if (!$this->favourites->contains($favourite)) {
            $this->favourites[] = $favourite;
        }

        return $this;
    }

    public function removeFavourite(User $favourite): self
    {
        $this->favourites->removeElement($favourite);

        return $this;
    }





}
