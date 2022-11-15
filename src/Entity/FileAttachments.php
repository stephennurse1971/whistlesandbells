<?php

namespace App\Entity;

use App\Repository\FileAttachmentsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FileAttachmentsRepository::class)
 */
class FileAttachments
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $attachments = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAttachments(): ?array
    {
        $attachments = $this->attachments;
        return $attachments;
    }

    public function setAttachments(?array $attachments): self
    {
        $this->attachments = $attachments;

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
}
