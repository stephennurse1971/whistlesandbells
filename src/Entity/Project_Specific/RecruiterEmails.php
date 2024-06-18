<?php

namespace App\Entity\Project_Specific;

use App\Repository\Project_Specific\RecruiterEmailsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RecruiterEmailsRepository::class)
 */
class RecruiterEmails
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
    private $sendTo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sendCc;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sendBcc;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subject;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $body;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attachment;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $sendDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sendToFullName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sendCcFullName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sendBccFullName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $authorFullName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSendTo(): ?string
    {
        return $this->sendTo;
    }

    public function setSendTo(?string $sendTo): self
    {
        $this->sendTo = $sendTo;

        return $this;
    }

    public function getSendCc(): ?string
    {
        return $this->sendCc;
    }

    public function setSendCc(?string $sendCc): self
    {
        $this->sendCc = $sendCc;

        return $this;
    }

    public function getSendBcc(): ?string
    {
        return $this->sendBcc;
    }

    public function setSendBcc(?string $sendBcc): self
    {
        $this->sendBcc = $sendBcc;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): self
    {
        $this->body = $body;

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

    public function getsendDate(): ?\DateTimeInterface
    {
        return $this->sendDate;
    }

    public function setsendDate(?\DateTimeInterface $sendDate): self
    {
        $this->sendDate = $sendDate;

        return $this;
    }

    public function getauthor(): ?string
    {
        return $this->author;
    }

    public function setauthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getsendToFullName(): ?string
    {
        return $this->sendToFullName;
    }

    public function setsendToFullName(?string $sendToFullName): self
    {
        $this->sendToFullName = $sendToFullName;

        return $this;
    }

    public function getsendCcFullName(): ?string
    {
        return $this->sendCcFullName;
    }

    public function setsendCcFullName(?string $sendCcFullName): self
    {
        $this->sendCcFullName = $sendCcFullName;

        return $this;
    }

    public function getsendBccFullName(): ?string
    {
        return $this->sendBccFullName;
    }

    public function setsendBccFullName(?string $sendBccFullName): self
    {
        $this->sendBccFullName = $sendBccFullName;

        return $this;
    }

    public function getauthorFullName(): ?string
    {
        return $this->authorFullName;
    }

    public function setauthorFullName(?string $authorFullName): self
    {
        $this->authorFullName = $authorFullName;

        return $this;
    }
}
