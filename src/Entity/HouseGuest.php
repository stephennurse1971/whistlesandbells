<?php

namespace App\Entity;

use App\Repository\HouseGuestRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HouseGuestRepository::class)
 */
class HouseGuest
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $flightFromLondonPrice;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $flightToLondonPrice;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFlightFromLondonPrice(): ?float
    {
        return $this->flightFromLondonPrice;
    }

    public function setFlightFromLondonPrice(?float $flightFromLondonPrice): self
    {
        $this->flightFromLondonPrice = $flightFromLondonPrice;

        return $this;
    }

    public function getFlightToLondonPrice(): ?float
    {
        return $this->flightToLondonPrice;
    }

    public function setFlightToLondonPrice(?float $flightToLondonPrice): self
    {
        $this->flightToLondonPrice = $flightToLondonPrice;

        return $this;
    }
}
