<?php

namespace App\Entity;

use App\Repository\DogsRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: DogsRepository::class)]
#[ORM\Table(name: "dogs")]
class Dogs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $owner = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $breed = null;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $breedChoiceReasons = null;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $dogChoiceReasons = null;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $dateOfBirth = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $gender = null;

    #[ORM\Column(type: "string", nullable: true)]
    private ?string $neutered = null;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $neuteredDate = null;

    #[ORM\Column(type: "string", nullable: true)]
    private ?string $rescueDog = null;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $arrivalDate = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $dogFood = null;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $dailyMealCount = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $mealTimes = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $healthIssues = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $dogWalkedCount = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $dogWalkLength = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $photo = null;

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
