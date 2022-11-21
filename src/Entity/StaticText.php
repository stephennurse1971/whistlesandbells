<?php

namespace App\Entity;

use App\Repository\StaticTextRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StaticTextRepository::class)
 */
class StaticText
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
    private $mobileNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $emailAddress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebookLink;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gpsCoordinates;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companiesHouseLink;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $linkedIn;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $github;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twitter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $skype;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $baseCurrency;

    public function getId(): ?int
    {
        return $this->getId();
    }

    public function getMobileNumber(): ?string
    {
        return $this->mobileNumber;
    }

    public function setMobileNumber(?string $mobileNumber): self
    {
        $this->mobileNumber = $mobileNumber;

        return $this;
    }

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(?string $emailAddress): self
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    public function getFacebookLink(): ?string
    {
        return $this->facebookLink;
    }

    public function setFacebookLink(?string $facebookLink): self
    {
        $this->facebookLink = $facebookLink;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getGpsCoordinates(): ?string
    {
        return $this->gpsCoordinates;
    }

    public function setGpsCoordinates(?string $gpsCoordinates): self
    {
        $this->gpsCoordinates = $gpsCoordinates;

        return $this;
    }

    public function getCompaniesHouseLink(): ?string
    {
        return $this->companiesHouseLink;
    }

    public function setCompaniesHouseLink(?string $companiesHouseLink): self
    {
        $this->companiesHouseLink = $companiesHouseLink;

        return $this;
    }

    public function getLinkedIn(): ?string
    {
        return $this->linkedIn;
    }

    public function setLinkedIn(?string $linkedIn): self
    {
        $this->linkedIn = $linkedIn;

        return $this;
    }

    public function getGithub(): ?string
    {
        return $this->github;
    }

    public function setGithub(?string $github): self
    {
        $this->github = $github;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getSkype(): ?string
    {
        return $this->skype;
    }

    public function setSkype(?string $skype): self
    {
        $this->skype = $skype;

        return $this;
    }

    public function getBaseCurrency(): ?string
    {
        return $this->baseCurrency;
    }

    public function setBaseCurrency(?string $baseCurrency): self
    {
        $this->baseCurrency = $baseCurrency;

        return $this;
    }

}
