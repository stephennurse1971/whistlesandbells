<?php

namespace App\Entity;

use App\Repository\CurriculumVitaeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CurriculumVitaeRepository::class)
 */
class CurriculumVitae
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="curriculumVitaes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $candidate;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $jobDescription;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateFinish;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $section;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCandidate(): ?User
    {
        return $this->candidate;
    }

    public function setCandidate(?User $candidate): self
    {
        $this->candidate = $candidate;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getJobDescription(): ?string
    {
        return $this->jobDescription;
    }

    public function setJobDescription(?string $jobDescription): self
    {
        $this->jobDescription = $jobDescription;

        return $this;
    }

    public function getDateFinish(): ?\DateTimeInterface
    {
        return $this->dateFinish;
    }

    public function setDateFinish(?\DateTimeInterface $dateFinish): self
    {
        $this->dateFinish = $dateFinish;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSection(): ?string
    {
        return $this->section;
    }

    public function setSection(?string $section): self
    {
        $this->section = $section;

        return $this;
    }
}
