<?php

namespace App\Entity;

use App\Repository\TennisPlayersRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TennisPlayersRepository::class)
 */
class TennisPlayers
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
     * @ORM\Column(type="string", length=255)
     */
    private $email1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mobile;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rank;

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

    public function getEmail1(): ?string
    {
        return $this->email1;
    }

    public function setEmail1(string $email1): self
    {
        $this->email1 = $email1;

        return $this;
    }

    public function getEmail2(): ?string
    {
        return $this->email2;
    }

    public function setEmail2(?string $email2): self
    {
        $this->email2 = $email2;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getRank(): ?int
    {
        return $this->rank;
    }

    public function setRank(?int $rank): self
    {
        $this->rank = $rank;

        return $this;
    }
}
