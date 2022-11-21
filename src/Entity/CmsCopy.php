<?php

namespace App\Entity;

use App\Repository\CmsCopyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CmsCopyRepository::class)
 */
class CmsCopy
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $contentText;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $hyperlinks;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contentTitle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $contentTextFR;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $contentTextDE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contentTitleFR;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contentTitleDE;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getContentText(): ?string
    {
        return $this->contentText;
    }

    public function setContentText(string $contentText): self
    {
        $this->contentText = $contentText;

        return $this;
    }

    public function getHyperlinks(): ?string
    {
        return $this->hyperlinks;
    }

    public function setHyperlinks(?string $hyperlinks): self
    {
        $this->hyperlinks = $hyperlinks;

        return $this;
    }

    public function getContentTitle(): ?string
    {
        return $this->contentTitle;
    }

    public function setContentTitle(?string $contentTitle): self
    {
        $this->contentTitle = $contentTitle;

        return $this;
    }

    public function getContentTextFR(): ?string
    {
        return $this->contentTextFR;
    }

    public function setContentTextFR(?string $contentTextFR): self
    {
        $this->contentTextFR = $contentTextFR;

        return $this;
    }

    public function getContentTextDE(): ?string
    {
        return $this->contentTextDE;
    }

    public function setContentTextDE(?string $contentTextDE): self
    {
        $this->contentTextDE = $contentTextDE;

        return $this;
    }

    public function getContentTitleFR(): ?string
    {
        return $this->contentTitleFR;
    }

    public function setContentTitleFR(?string $contentTitleFR): self
    {
        $this->contentTitleFR = $contentTitleFR;

        return $this;
    }

    public function getContentTitleDE(): ?string
    {
        return $this->contentTitleDE;
    }

    public function setContentTitleDE(?string $contentTitleDE): self
    {
        $this->contentTitleDE = $contentTitleDE;

        return $this;
    }
}
