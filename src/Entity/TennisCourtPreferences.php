<?php

namespace App\Entity;

use App\Repository\TennisCourtPreferencesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TennisCourtPreferencesRepository::class)
 */
class TennisCourtPreferences
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tennisCourtPreferences")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=TennisVenues::class, inversedBy="tennisCourtPreferences")
     */
    private $tennisVenue;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $weekdayElection;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $weekendElection;



    public function __construct()
    {
        //$this->tennisVenue = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTennisVenue(): ?TennisVenues
    {
        return $this->tennisVenue;
    }

    public function setTennisVenue(?TennisVenues $tennisVenue): self
    {
        $this->tennisVenue = $tennisVenue;

        return $this;
    }

    public function getWeekdayElection(): ?bool
    {
        return $this->weekdayElection;
    }

    public function setWeekdayElection(?bool $weekdayElection): self
    {
        $this->weekdayElection = $weekdayElection;

        return $this;
    }

    public function getWeekendElection(): ?bool
    {
        return $this->weekendElection;
    }

    public function setWeekendElection(?bool $weekendElection): self
    {
        $this->weekendElection = $weekendElection;

        return $this;
    }



}
