<?php

namespace App\Entity;


use App\Repository\CompanyDetailsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompanyDetailsRepository::class)
 */
class CompanyDetails
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
    private $companyName;



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyEmail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $companyTel;



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyMobile;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyAddressStreet;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyAddressTown;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyAddressCity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyAddressPostalCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyAddressCountry;




    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $companyAddressMapLink;




    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $companyAddressInstructions;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebook;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $linkedIn;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $instagram;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twitter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $faviconLive;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $faviconDev;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $currency;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyEmailPassword;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyEmailImportDirectory;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $companyEmailImportProcessedDirectory;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $weatherLocation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyWebsite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyAddressLongitude;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyAddressLatitude;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyTimeZone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companySkype;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyQrCode;









    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }


    public function getCompanyEmail(): ?string
    {
        return $this->companyEmail;
    }

    public function setCompanyEmail(?string $companyEmail): self
    {
        $this->companyEmail = $companyEmail;

        return $this;
    }


    public function getCompanyTel(): ?string
    {
        return $this->companyTel;
    }

    public function setCompanyTel(string $companyTel): self
    {
        $this->companyTel = $companyTel;

        return $this;
    }

    public function getCompanyMobile(): ?string
    {
        return $this->companyMobile;
    }

    public function setCompanyMobile(?string $companyMobile): self
    {
        $this->companyMobile = $companyMobile;

        return $this;
    }



    public function getCompanyAddressStreet(): ?string
    {
        return $this->companyAddressStreet;
    }

    public function setCompanyAddressStreet(?string $companyAddressStreet): self
    {
        $this->companyAddressStreet = $companyAddressStreet;

        return $this;
    }

    public function getCompanyAddressTown(): ?string
    {
        return $this->companyAddressTown;
    }

    public function setCompanyAddressTown(?string $companyAddressTown): self
    {
        $this->companyAddressTown = $companyAddressTown;

        return $this;
    }



    public function getCompanyAddressCity(): ?string
    {
        return $this->companyAddressCity;
    }

    public function setCompanyAddressCity(?string $companyAddressCity): self
    {
        $this->companyAddressCity = $companyAddressCity;

        return $this;
    }

    public function getCompanyAddressPostalCode(): ?string
    {
        return $this->companyAddressPostalCode;
    }

    public function setCompanyAddressPostalCode(?string $companyAddressPostalCode): self
    {
        $this->companyAddressPostalCode = $companyAddressPostalCode;

        return $this;
    }

    public function getCompanyAddressCountry(): ?string
    {
        return $this->companyAddressCountry;
    }

    public function setCompanyAddressCountry(?string $companyAddressCountry): self
    {
        $this->companyAddressCountry = $companyAddressCountry;

        return $this;
    }

    public function getCompanyAddressMapLink(): ?string
    {
        return $this->companyAddressMapLink;
    }

    public function setCompanyAddressMapLink(?string $companyAddressMapLink): self
    {
        $this->companyAddressMapLink = $companyAddressMapLink;

        return $this;
    }



    public function getcompanyAddressInstructions(): ?string
    {
        return $this->companyAddressInstructions;
    }

    public function setCompanyAddressInstructions(?string $companyAddressInstructions): self
    {
        $this->companyAddressInstructions = $companyAddressInstructions;

        return $this;
    }







    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;

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

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): self
    {
        $this->instagram = $instagram;

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

    public function getFaviconLive(): ?string
    {
        return $this->faviconLive;
    }

    public function setFaviconLive(?string $faviconLive): self
    {
        $this->faviconLive = $faviconLive;

        return $this;
    }

    public function getFaviconDev(): ?string
    {
        return $this->faviconDev;
    }

    public function setFaviconDev(?string $faviconDev): self
    {
        $this->faviconDev = $faviconDev;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCompanyEmailPassword(): ?string
    {
        return $this->companyEmailPassword;
    }

    public function setCompanyEmailPassword(?string $companyEmailPassword): self
    {
        $this->companyEmailPassword = $companyEmailPassword;

        return $this;
    }

    public function getCompanyEmailImportDirectory(): ?string
    {
        return $this->companyEmailImportDirectory;
    }

    public function setCompanyEmailImportDirectory(?string $companyEmailImportDirectory): self
    {
        $this->companyEmailImportDirectory = $companyEmailImportDirectory;

        return $this;
    }

    public function getCompanyEmailImportProcessedDirectory(): ?string
    {
        return $this->companyEmailImportProcessedDirectory;
    }

    public function setCompanyEmailImportProcessedDirectory(string $companyEmailImportProcessedDirectory): self
    {
        $this->companyEmailImportProcessedDirectory = $companyEmailImportProcessedDirectory;

        return $this;
    }

    public function getWeatherLocation(): ?string
    {
        return $this->weatherLocation;
    }

    public function setWeatherLocation(?string $weatherLocation): self
    {
        $this->weatherLocation = $weatherLocation;

        return $this;
    }

    public function getCompanyWebsite(): ?string
    {
        return $this->companyWebsite;
    }

    public function setCompanyWebsite(?string $companyWebsite): self
    {
        $this->companyWebsite = $companyWebsite;

        return $this;
    }

    public function getCompanyAddressLongitude(): ?string
    {
        return $this->companyAddressLongitude;
    }

    public function setCompanyAddressLongitude(?string $companyAddressLongitude): self
    {
        $this->companyAddressLongitude = $companyAddressLongitude;

        return $this;
    }

    public function getCompanyAddressLatitude(): ?string
    {
        return $this->companyAddressLatitude;
    }

    public function setCompanyAddressLatitude(?string $companyAddressLatitude): self
    {
        $this->companyAddressLatitude = $companyAddressLatitude;

        return $this;
    }

    public function getCompanyTimeZone(): ?string
    {
        return $this->companyTimeZone;
    }

    public function setCompanyTimeZone(?string $companyTimeZone): self
    {
        $this->companyTimeZone = $companyTimeZone;

        return $this;
    }

    public function getCompanySkype(): ?string
    {
        return $this->companySkype;
    }

    public function setCompanySkype(?string $companySkype): self
    {
        $this->companySkype = $companySkype;

        return $this;
    }

    public function getCompanyQrCode(): ?string
    {
        return $this->companyQrCode;
    }

    public function setCompanyQrCode(?string $companyQrCode): self
    {
        $this->companyQrCode = $companyQrCode;

        return $this;
    }



}
