<?php

namespace App\Entity;

use App\Repository\RecruiterEmailsRepository;
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
    private $SendTo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $SendCC;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $SendBcc;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subject;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $body;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attachment;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $SendDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sendAuthor;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSendTo(): ?string
    {
        return $this->SendTo;
    }

    public function setSendTo(?string $SendTo): self
    {
        $this->SendTo = $SendTo;

        return $this;
    }

    public function getSendCC(): ?string
    {
        return $this->SendCC;
    }

    public function setSendCC(?string $SendCC): self
    {
        $this->SendCC = $SendCC;

        return $this;
    }

    public function getSendBcc(): ?string
    {
        return $this->SendBcc;
    }

    public function setSendBcc(?string $SendBcc): self
    {
        $this->SendBcc = $SendBcc;

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

    public function getSendDate(): ?\DateTimeInterface
    {
        return $this->SendDate;
    }

    public function setSendDate(?\DateTimeInterface $SendDate): self
    {
        $this->SendDate = $SendDate;

        return $this;
    }

    public function getSendAuthor(): ?string
    {
        return $this->sendAuthor;
    }

    public function setSendAuthor(?string $sendAuthor): self
    {
        $this->sendAuthor = $sendAuthor;

        return $this;
    }
}
