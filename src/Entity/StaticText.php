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
     * @ORM\Column(type="text", nullable=true)
     */
    private $homepage1;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $homepage2;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $emailFamily;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $emailAccountant;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $emailContact;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $emailGuest;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $webDesign;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $aboutSN;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHomepage1(): ?string
    {
        return $this->homepage1;
    }

    public function setHomepage1(?string $homepage1): self
    {
        $this->homepage1 = $homepage1;

        return $this;
    }

    public function getHomepage2(): ?string
    {
        return $this->homepage2;
    }

    public function setHomepage2(?string $homepage2): self
    {
        $this->homepage2 = $homepage2;

        return $this;
    }

    public function getEmailFamily(): ?string
    {
        return $this->emailFamily;
    }

    public function setEmailFamily(string $emailFamily): self
    {
        $this->emailFamily = $emailFamily;

        return $this;
    }

    public function getEmailAccountant(): ?string
    {
        return $this->emailAccountant;
    }

    public function setEmailAccountant(?string $emailAccountant): self
    {
        $this->emailAccountant = $emailAccountant;

        return $this;
    }

    public function getEmailContact(): ?string
    {
        return $this->emailContact;
    }

    public function setEmailContact(?string $emailContact): self
    {
        $this->emailContact = $emailContact;

        return $this;
    }

    public function getEmailGuest(): ?string
    {
        return $this->emailGuest;
    }

    public function setEmailGuest(?string $emailGuest): self
    {
        $this->emailGuest = $emailGuest;

        return $this;
    }

    public function getWebDesign(): ?string
    {
        return $this->webDesign;
    }

    public function setWebDesign(?string $webDesign): self
    {
        $this->webDesign = $webDesign;

        return $this;
    }

    public function getAboutSN(): ?string
    {
        return $this->aboutSN;
    }

    public function setAboutSN(?string $aboutSN): self
    {
        $this->aboutSN = $aboutSN;

        return $this;
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
}
