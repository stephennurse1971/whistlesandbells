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
}
