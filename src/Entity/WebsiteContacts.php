<?php

namespace App\Entity;

use App\Repository\WebsiteContactsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WebsiteContactsRepository::class)]
#[ORM\Table(name: 'website_contacts')]

class WebsiteContacts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $mobile = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $notes = null;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $dateTime = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    private ?Product $product = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile): self
    {
        $this->mobile = $mobile;
        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;
        return $this;
    }

    public function getDateTime(): ?\DateTimeInterface
    {
        return $this->dateTime;
    }

    public function setDateTime(?\DateTimeInterface $dateTime): self
    {
        $this->dateTime = $dateTime;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;
        return $this;
    }
}
