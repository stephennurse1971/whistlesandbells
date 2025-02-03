<?php

namespace App\Entity;

use App\Repository\ClientDetailsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientDetailsRepository::class)]
class ClientDetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $addressStreet = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $addressTown = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $addressCounty = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $addressPostCode = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $addressLongitude = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $addressLatitude = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $mobile = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $childrenInHome = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $communicationVerbally = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $communicationEmail = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $communicationWhatsApp = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $communicationWhatsAppGroup = null;

    #[ORM\OneToOne(targetEntity: User::class, cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddressStreet(): ?string
    {
        return $this->addressStreet;
    }

    public function setAddressStreet(?string $addressStreet): self
    {
        $this->addressStreet = $addressStreet;
        return $this;
    }

    public function getAddressTown(): ?string
    {
        return $this->addressTown;
    }

    public function setAddressTown(?string $addressTown): self
    {
        $this->addressTown = $addressTown;
        return $this;
    }

    public function getAddressCounty(): ?string
    {
        return $this->addressCounty;
    }

    public function setAddressCounty(?string $addressCounty): self
    {
        $this->addressCounty = $addressCounty;
        return $this;
    }

    public function getAddressPostCode(): ?string
    {
        return $this->addressPostCode;
    }

    public function setAddressPostCode(?string $addressPostCode): self
    {
        $this->addressPostCode = $addressPostCode;
        return $this;
    }

    public function getAddressLongitude(): ?float
    {
        return $this->addressLongitude;
    }

    public function setAddressLongitude(?float $addressLongitude): self
    {
        $this->addressLongitude = $addressLongitude;
        return $this;
    }

    public function getAddressLatitude(): ?float
    {
        return $this->addressLatitude;
    }

    public function setAddressLatitude(?float $addressLatitude): self
    {
        $this->addressLatitude = $addressLatitude;
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

    public function getChildrenInHome(): ?int
    {
        return $this->childrenInHome;
    }

    public function setChildrenInHome(?int $childrenInHome): self
    {
        $this->childrenInHome = $childrenInHome;
        return $this;
    }

    public function isCommunicationVerbally(): ?bool
    {
        return $this->communicationVerbally;
    }

    public function setCommunicationVerbally(?bool $communicationVerbally): self
    {
        $this->communicationVerbally = $communicationVerbally;
        return $this;
    }

    public function isCommunicationEmail(): ?bool
    {
        return $this->communicationEmail;
    }

    public function setCommunicationEmail(?bool $communicationEmail): self
    {
        $this->communicationEmail = $communicationEmail;
        return $this;
    }

    public function isCommunicationWhatsApp(): ?bool
    {
        return $this->communicationWhatsApp;
    }

    public function setCommunicationWhatsApp(?bool $communicationWhatsApp): self
    {
        $this->communicationWhatsApp = $communicationWhatsApp;
        return $this;
    }

    public function isCommunicationWhatsAppGroup(): ?bool
    {
        return $this->communicationWhatsAppGroup;
    }

    public function setCommunicationWhatsAppGroup(?bool $communicationWhatsAppGroup): self
    {
        $this->communicationWhatsAppGroup = $communicationWhatsAppGroup;
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