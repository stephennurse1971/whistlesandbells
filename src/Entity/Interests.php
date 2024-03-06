<?php

namespace App\Entity;

use App\Repository\InterestsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InterestsRepository::class)
 */
class Interests
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
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ranking;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cmsText1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cmsText2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cmsText3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cmsPhoto1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cmsPhoto2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cmsPhoto3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $menu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $accessRoles;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublic;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(?bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getCmsText1(): ?string
    {
        return $this->cmsText1;
    }

    public function setCmsText1(?string $cmsText1): self
    {
        $this->cmsText1 = $cmsText1;

        return $this;
    }

    public function getCmsText2(): ?string
    {
        return $this->cmsText2;
    }

    public function setCmsText2(?string $cmsText2): self
    {
        $this->cmsText2 = $cmsText2;

        return $this;
    }

    public function getCmsText3(): ?string
    {
        return $this->cmsText3;
    }

    public function setCmsText3(?string $cmsText3): self
    {
        $this->cmsText3 = $cmsText3;

        return $this;
    }

    public function getCmsPhoto1(): ?string
    {
        return $this->cmsPhoto1;
    }

    public function setCmsPhoto1(?string $cmsPhoto1): self
    {
        $this->cmsPhoto1 = $cmsPhoto1;

        return $this;
    }

    public function getCmsPhoto2(): ?string
    {
        return $this->cmsPhoto2;
    }

    public function setCmsPhoto2(?string $cmsPhoto2): self
    {
        $this->cmsPhoto2 = $cmsPhoto2;

        return $this;
    }

    public function getCmsPhoto3(): ?string
    {
        return $this->cmsPhoto3;
    }

    public function setCmsPhoto3(?string $cmsPhoto3): self
    {
        $this->cmsPhoto3 = $cmsPhoto3;

        return $this;
    }

    public function getMenu(): ?string
    {
        return $this->menu;
    }

    public function setMenu(?string $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public function getAccessRoles(): ?string
    {
        return $this->accessRoles;
    }

    public function setAccessRoles(?string $accessRoles): self
    {
        $this->accessRoles = $accessRoles;

        return $this;
    }

    public function getIsPublic(): ?bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(bool $isPublic): self
    {
        $this->isPublic = $isPublic;

        return $this;
    }
}
