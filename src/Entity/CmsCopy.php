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
}
