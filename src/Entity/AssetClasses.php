<?php

namespace App\Entity;

use App\Repository\AssetClassesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AssetClassesRepository::class)
 */
class AssetClasses
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
    private $assetClass;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAssetClass(): ?string
    {
        return $this->assetClass;
    }

    public function setAssetClass(?string $assetClass): self
    {
        $this->assetClass = $assetClass;

        return $this;
    }
}
