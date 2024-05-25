<?php

namespace App\Entity;

use App\Repository\ToDoListItemsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ToDoListItemsRepository::class)
 */
class ToDoListItems
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ToDoList::class)
     */
    private $project;



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $priority;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $task;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $hoursAllocated;



    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $immediatePriority;



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attachment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $needsResearch;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProject(): ?ToDoList
    {
        return $this->project;
    }

    public function setProject(?ToDoList $project): self
    {
        $this->project = $project;

        return $this;
    }


    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPriority(): ?float
    {
        return $this->priority;
    }

    public function setPriority(?float $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getTask(): ?string
    {
        return $this->task;
    }

    public function setTask(?string $task): self
    {
        $this->task = $task;

        return $this;
    }

    public function getHoursAllocated(): ?int
    {
        return $this->hoursAllocated;
    }

    public function setHoursAllocated(?int $hoursAllocated): self
    {
        $this->hoursAllocated = $hoursAllocated;

        return $this;
    }




    public function getImmediatePriority(): ?bool
    {
        return $this->immediatePriority;
    }

    public function setImmediatePriority(?bool $immediatePriority): self
    {
        $this->immediatePriority = $immediatePriority;

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

    public function getNeedsResearch(): ?string
    {
        return $this->needsResearch;
    }

    public function setNeedsResearch(?string $needsResearch): self
    {
        $this->needsResearch = $needsResearch;

        return $this;
    }
}
