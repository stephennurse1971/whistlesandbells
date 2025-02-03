<?php

namespace App\Entity;

use App\Repository\DogsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DogsRepository::class)
 */
class Dogs
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $owner;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $breed;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $breedChoiceReasons;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $dogChoiceReasons;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateOfBirth;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $neutered;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $neuteredDate;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $rescueDog;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $arrivalDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dogFood;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $dailyMealCount;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mealTimes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $healthIssues;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dogWalkedCount;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dogWalkLength;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
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

    public function getBreed(): ?string
    {
        return $this->breed;
    }

    public function setBreed(?string $breed): self
    {
        $this->breed = $breed;

        return $this;
    }

    public function getBreedChoiceReasons(): ?string
    {
        return $this->breedChoiceReasons;
    }

    public function setBreedChoiceReasons(string $breedChoiceReasons): self
    {
        $this->breedChoiceReasons = $breedChoiceReasons;

        return $this;
    }

    public function getDogChoiceReasons(): ?string
    {
        return $this->dogChoiceReasons;
    }

    public function setDogChoiceReasons(?string $dogChoiceReasons): self
    {
        $this->dogChoiceReasons = $dogChoiceReasons;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function isNeutered(): ?string
    {
        return $this->neutered;
    }

    public function setNeutered(?string $neutered): self
    {
        $this->neutered = $neutered;

        return $this;
    }

    public function getNeuteredDate(): ?\DateTimeInterface
    {
        return $this->neuteredDate;
    }

    public function setNeuteredDate(?\DateTimeInterface $neuteredDate): self
    {
        $this->neuteredDate = $neuteredDate;

        return $this;
    }

    public function isRescueDog(): ?string
    {
        return $this->rescueDog;
    }

    public function setRescueDog(?string $rescueDog): self
    {
        $this->rescueDog = $rescueDog;

        return $this;
    }

    public function getArrivalDate(): ?\DateTimeInterface
    {
        return $this->arrivalDate;
    }

    public function setArrivalDate(?\DateTimeInterface $arrivalDate): self
    {
        $this->arrivalDate = $arrivalDate;

        return $this;
    }

    public function getDogFood(): ?string
    {
        return $this->dogFood;
    }

    public function setDogFood(?string $dogFood): self
    {
        $this->dogFood = $dogFood;

        return $this;
    }

    public function getDailyMealCount(): ?int
    {
        return $this->dailyMealCount;
    }

    public function setDailyMealCount(?int $dailyMealCount): self
    {
        $this->dailyMealCount = $dailyMealCount;

        return $this;
    }

    public function getMealTimes(): ?string
    {
        return $this->mealTimes;
    }

    public function setMealTimes(?string $mealTimes): self
    {
        $this->mealTimes = $mealTimes;

        return $this;
    }

    public function getHealthIssues(): ?string
    {
        return $this->healthIssues;
    }

    public function setHealthIssues(?string $healthIssues): self
    {
        $this->healthIssues = $healthIssues;

        return $this;
    }

    public function getDogWalkedCount(): ?string
    {
        return $this->dogWalkedCount;
    }

    public function setDogWalkedCount(?string $dogWalkedCount): self
    {
        $this->dogWalkedCount = $dogWalkedCount;

        return $this;
    }

    public function getDogWalkLength(): ?string
    {
        return $this->dogWalkLength;
    }

    public function setDogWalkLength(?string $dogWalkLength): self
    {
        $this->dogWalkLength = $dogWalkLength;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }
}
