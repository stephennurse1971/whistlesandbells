<?php

namespace App\Entity\Project_Specific;

use App\Repository\Project_Specific\ToDoListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ToDoListRepository::class)
 */
class ToDoList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $priority;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $project;

    /**
     * @ORM\ManyToMany(targetEntity=User::class)
     */
    private $accessTo;

    public function __construct()
    {
        $this->accessTo = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(?int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }



    public function getProject(): ?string
    {
        return $this->project;
    }

    public function setProject(?string $project): self
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getAccessTo(): Collection
    {
        return $this->accessTo;
    }

    public function addAccessTo(User $accessTo): self
    {
        if (!$this->accessTo->contains($accessTo)) {
            $this->accessTo[] = $accessTo;
        }

        return $this;
    }

    public function removeAccessTo(User $accessTo): self
    {
        $this->accessTo->removeElement($accessTo);

        return $this;
    }
}
