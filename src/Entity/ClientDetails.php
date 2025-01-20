<?php

namespace App\Entity;

use App\Repository\ClientDetailsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientDetailsRepository::class)
 */
class ClientDetails
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
    private $addressStreet;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $addressTown;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $addressCounty;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $addressPostCode;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $addresslongitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $addresslatitude;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mobile;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $childrenInHome;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $communicationVerbally;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $communicationEmail;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $communicationWhatsApp;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $communicationWhatsAppGroup;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     */
    private $user;

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

    public function getAddresslongitude(): ?float
    {
        return $this->addresslongitude;
    }

    public function setAddresslongitude(?float $addresslongitude): self
    {
        $this->addresslongitude = $addresslongitude;

        return $this;
    }

    public function getAddresslatitude(): ?float
    {
        return $this->addresslatitude;
    }

    public function setAddresslatitude(?float $addresslatitude): self
    {
        $this->addresslatitude = $addresslatitude;

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
