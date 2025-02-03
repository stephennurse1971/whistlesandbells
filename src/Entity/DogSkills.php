<?php

namespace App\Entity;

use App\Repository\DogSkillsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DogSkillsRepository::class)]
#[ORM\Table(name: "dog_skills")]


class DogSkills
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $skillOrBehaviour = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $notes = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $ranking = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSkillOrBehaviour(): ?string
    {
        return $this->skillOrBehaviour;
    }

    public function setSkillOrBehaviour(?string $skillOrBehaviour): self
    {
        $this->skillOrBehaviour = $skillOrBehaviour;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
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

    public function getRanking(): ?int
    {
        return $this->ranking;
    }

    public function setRanking(?int $ranking): self
    {
        $this->ranking = $ranking;
        return $this;
    }
}
