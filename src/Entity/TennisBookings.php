<?php

namespace App\Entity;

use App\Repository\TennisBookingsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TennisBookingsRepository::class)
 */
class TennisBookings
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=TennisVenues::class, inversedBy="tennisBookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $venue;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $cost;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tennisBookings")
     */
    private $player1;



    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tennisBookings3")
     * @ORM\JoinColumn(nullable=true)
     */
    private $player3;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tennisBookings4")
     * @ORM\JoinColumn(nullable=true)
     */
    private $player4;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tennisBookings2")
     */
    private $player2;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numberOfPlayers;




    public function __construct()
    {

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getVenue(): ?TennisVenues
    {
        return $this->venue;
    }

    public function setVenue(?TennisVenues $venue): self
    {
        $this->venue = $venue;

        return $this;
    }

    public function getCost(): ?float
    {
        return $this->cost;
    }

    public function setCost(?float $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getPlayer1(): ?User
    {
        return $this->player1;
    }

    public function setPlayer1(?User $player1): self
    {
        $this->player1 = $player1;

        return $this;
    }




    public function getPlayer3(): ?User
    {
        return $this->player3;
    }

    public function setPlayer3(?User $player3): self
    {
        $this->player3 = $player3;

        return $this;
    }

    public function getPlayer4(): ?User
    {
        return $this->player4;
    }

    public function setPlayer4(?User $player4): self
    {
        $this->player4 = $player4;

        return $this;
    }

    public function getPlayer2(): ?User
    {
        return $this->player2;
    }

    public function setPlayer2(?User $player2): self
    {
        $this->player2 = $player2;

        return $this;
    }

    public function getNumberOfPlayers(): ?int
    {
        return $this->numberOfPlayers;
    }

    public function setNumberOfPlayers(?int $numberOfPlayers): self
    {
        $this->numberOfPlayers = $numberOfPlayers;

        return $this;
    }




}
