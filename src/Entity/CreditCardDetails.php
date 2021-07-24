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
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
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

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $thLogin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $thPassword;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cardType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $town;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $county;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $postCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cardExpiry2;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCardholder(): ?User
    {
        return $this->cardholder;
    }

    public function setCardholder(User $cardholder): self
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

    public function getThLogin(): ?string
    {
        return $this->thLogin;
    }

    public function setThLogin(string $thLogin): self
    {
        $this->thLogin = $thLogin;

        return $this;
    }

    public function getThPassword(): ?string
    {
        return $this->thPassword;
    }

    public function setThPassword(string $thPassword): self
    {
        $this->thPassword = $thPassword;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getCardType(): ?string
    {
        return $this->cardType;
    }

    public function setCardType(string $cardType): self
    {
        $this->cardType = $cardType;

        return $this;
    }

    public function getAddress1(): ?string
    {
        return $this->address1;
    }

    public function setAddress1(string $address1): self
    {
        $this->address1 = $address1;

        return $this;
    }

    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    public function setAddress2(string $address2): self
    {
        $this->address2 = $address2;

        return $this;
    }

    public function getTown(): ?string
    {
        return $this->town;
    }

    public function setTown(string $town): self
    {
        $this->town = $town;

        return $this;
    }

    public function getCounty(): ?string
    {
        return $this->county;
    }

    public function setCounty(string $county): self
    {
        $this->county = $county;

        return $this;
    }

    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    public function setPostCode(string $postCode): self
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getCardExpiry2(): ?string
    {
        return $this->cardExpiry2;
    }

    public function setCardExpiry2(string $cardExpiry2): self
    {
        $this->cardExpiry2 = $cardExpiry2;

        return $this;
    }
}
