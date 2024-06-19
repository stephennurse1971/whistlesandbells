<?php

namespace App\Entity\ProjectSpecific;

use App\Repository\ProjectSpecific\IntroductionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IntroductionRepository::class)
 */
class Introduction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="introductions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $region;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $areaOfInterest;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $introductoryEmail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subjectLine;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attachment;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $introductoryEmail2;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getAreaOfInterest(): ?string
    {
        return $this->areaOfInterest;
    }

    public function setAreaOfInterest(?string $areaOfInterest): self
    {
        $this->areaOfInterest = $areaOfInterest;

        return $this;
    }

    public function getIntroductoryEmail(): ?string
    {
        return $this->introductoryEmail;
    }

    public function setIntroductoryEmail(?string $introductoryEmail): self
    {
        $this->introductoryEmail = $introductoryEmail;

        return $this;
    }

    public function getSubjectLine(): ?string
    {
        return $this->subjectLine;
    }

    public function setSubjectLine(?string $subjectLine): self
    {
        $this->subjectLine = $subjectLine;

        return $this;
    }

    public function getAttachment(): ?string
    {
        return $this->attachment;
    }

    public function setAttachment(?string $attachment): self
    {
        $this->attachment = $attachment;

        return $this;
    }

    public function getIntroductoryEmail2(): ?string
    {
        return $this->introductoryEmail2;
    }

    public function setIntroductoryEmail2(?string $introductoryEmail2): self
    {
        $this->introductoryEmail2 = $introductoryEmail2;

        return $this;
    }
}
