<?php

namespace App\Entity;

use App\Repository\CreditCardDetailsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CreditCardDetailsRepository::class)
 */
class CreditCardDetails
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=TennisPlayers::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $cardholder;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cardNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cardExpiry;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cardCVC;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCardholder(): ?TennisPlayers
    {
        return $this->cardholder;
    }

    public function setCardholder(TennisPlayers $cardholder): self
    {
        $this->cardholder = $cardholder;

        return $this;
    }

    public function getCardNumber(): ?string
    {
        return $this->cardNumber;
    }

    public function setCardNumber(?string $cardNumber): self
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    public function getCardExpiry(): ?string
    {
        return $this->cardExpiry;
    }

    public function setCardExpiry(?string $cardExpiry): self
    {
        $this->cardExpiry = $cardExpiry;

        return $this;
    }

    public function getCardCVC(): ?string
    {
        return $this->cardCVC;
    }

    public function setCardCVC(?string $cardCVC): self
    {
        $this->cardCVC = $cardCVC;

        return $this;
    }
}
