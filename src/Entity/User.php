<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fullName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mobile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $plainPassword;

    /**
     * @ORM\OneToMany(targetEntity=TennisCourtPreferences::class, mappedBy="user")
     */
    private $tennisCourtPreferences;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Email2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mobile2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $calendarInviteEmail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $LastName;

    /**
     * @ORM\OneToMany(targetEntity=DefaultTennisPlayerAvailabilityHours::class, mappedBy="user")
     */
    private $defaultTennisPlayerAvailabilityHours;

    /**
     * @ORM\OneToMany(targetEntity=TennisBookings::class, mappedBy="player1")
     */
    private $tennisBookings;


    /**
     * @ORM\OneToMany(targetEntity=TennisBookings::class, mappedBy="player3")
     */
    private $tennisBookings3;

    /**
     * @ORM\OneToMany(targetEntity=TennisBookings::class, mappedBy="player4")
     */
    private $tennisBookings4;

    /**
     * @ORM\OneToMany(targetEntity=TennisBookings::class, mappedBy="player2")
     */
    private $tennisBookings2;







    public function __construct()
    {

        $this->tennisCourtPreferences = new ArrayCollection();
        $this->defaultTennisPlayerAvailabilityHours = new ArrayCollection();
        $this->tennisBookings = new ArrayCollection();
        $this->tennisBookings3 = new ArrayCollection();
        $this->tennisBookings4 = new ArrayCollection();
        $this->tennisBookings2 = new ArrayCollection();



    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return Collection|TennisCourtPreferences[]
     */
    public function getTennisCourtPreferences(): Collection
    {
        return $this->tennisCourtPreferences;
    }

    public function addTennisCourtPreference(TennisCourtPreferences $tennisCourtPreference): self
    {
        if (!$this->tennisCourtPreferences->contains($tennisCourtPreference)) {
            $this->tennisCourtPreferences[] = $tennisCourtPreference;
            $tennisCourtPreference->setUser($this);
        }

        return $this;
    }

    public function removeTennisCourtPreference(TennisCourtPreferences $tennisCourtPreference): self
    {
        if ($this->tennisCourtPreferences->removeElement($tennisCourtPreference)) {
            // set the owning side to null (unless already changed)
            if ($tennisCourtPreference->getUser() === $this) {
                $tennisCourtPreference->setUser(null);
            }
        }

        return $this;
    }

    public function getEmail2(): ?string
    {
        return $this->Email2;
    }

    public function setEmail2(?string $Email2): self
    {
        $this->Email2 = $Email2;

        return $this;
    }

    public function getMobile2(): ?string
    {
        return $this->mobile2;
    }

    public function setMobile2(?string $mobile2): self
    {
        $this->mobile2 = $mobile2;

        return $this;
    }

    public function getCalendarInviteEmail(): ?string
    {
        return $this->calendarInviteEmail;
    }

    public function setCalendarInviteEmail(?string $calendarInviteEmail): self
    {
        $this->calendarInviteEmail = $calendarInviteEmail;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    public function setLastName(?string $LastName): self
    {
        $this->LastName = $LastName;

        return $this;
    }

    /**
     * @return Collection|DefaultTennisPlayerAvailabilityHours[]
     */
    public function getDefaultTennisPlayerAvailabilityHours(): Collection
    {
        return $this->defaultTennisPlayerAvailabilityHours;
    }

    public function addDefaultTennisPlayerAvailabilityHour(DefaultTennisPlayerAvailabilityHours $defaultTennisPlayerAvailabilityHour): self
    {
        if (!$this->defaultTennisPlayerAvailabilityHours->contains($defaultTennisPlayerAvailabilityHour)) {
            $this->defaultTennisPlayerAvailabilityHours[] = $defaultTennisPlayerAvailabilityHour;
            $defaultTennisPlayerAvailabilityHour->setUser($this);
        }

        return $this;
    }

    public function removeDefaultTennisPlayerAvailabilityHour(DefaultTennisPlayerAvailabilityHours $defaultTennisPlayerAvailabilityHour): self
    {
        if ($this->defaultTennisPlayerAvailabilityHours->removeElement($defaultTennisPlayerAvailabilityHour)) {
            // set the owning side to null (unless already changed)
            if ($defaultTennisPlayerAvailabilityHour->getUser() === $this) {
                $defaultTennisPlayerAvailabilityHour->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TennisBookings[]
     */
    public function getTennisBookings(): Collection
    {
        return $this->tennisBookings;
    }

    public function addTennisBooking(TennisBookings $tennisBooking): self
    {
        if (!$this->tennisBookings->contains($tennisBooking)) {
            $this->tennisBookings[] = $tennisBooking;
            $tennisBooking->setPlayer1($this);
        }

        return $this;
    }

    public function removeTennisBooking(TennisBookings $tennisBooking): self
    {
        if ($this->tennisBookings->removeElement($tennisBooking)) {
            // set the owning side to null (unless already changed)
            if ($tennisBooking->getPlayer1() === $this) {
                $tennisBooking->setPlayer1(null);
            }
        }

        return $this;
    }



    /**
     * @return Collection|TennisBookings[]
     */
    public function getTennisBookings3(): Collection
    {
        return $this->tennisBookings3;
    }

    public function addTennisBookings3(TennisBookings $tennisBookings3): self
    {
        if (!$this->tennisBookings3->contains($tennisBookings3)) {
            $this->tennisBookings3[] = $tennisBookings3;
            $tennisBookings3->setPlayer3($this);
        }

        return $this;
    }

    public function removeTennisBookings3(TennisBookings $tennisBookings3): self
    {
        if ($this->tennisBookings3->removeElement($tennisBookings3)) {
            // set the owning side to null (unless already changed)
            if ($tennisBookings3->getPlayer3() === $this) {
                $tennisBookings3->setPlayer3(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TennisBookings[]
     */
    public function getTennisBookings4(): Collection
    {
        return $this->tennisBookings4;
    }

    public function addTennisBookings4(TennisBookings $tennisBookings4): self
    {
        if (!$this->tennisBookings4->contains($tennisBookings4)) {
            $this->tennisBookings4[] = $tennisBookings4;
            $tennisBookings4->setPlayer4($this);
        }

        return $this;
    }

    public function removeTennisBookings4(TennisBookings $tennisBookings4): self
    {
        if ($this->tennisBookings4->removeElement($tennisBookings4)) {
            // set the owning side to null (unless already changed)
            if ($tennisBookings4->getPlayer4() === $this) {
                $tennisBookings4->setPlayer4(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TennisBookings[]
     */
    public function getTennisBookings2(): Collection
    {
        return $this->tennisBookings2;
    }

    public function addTennisBookings2(TennisBookings $tennisBookings2): self
    {
        if (!$this->tennisBookings2->contains($tennisBookings2)) {
            $this->tennisBookings2[] = $tennisBookings2;
            $tennisBookings2->setPlayer2($this);
        }

        return $this;
    }

    public function removeTennisBookings2(TennisBookings $tennisBookings2): self
    {
        if ($this->tennisBookings2->removeElement($tennisBookings2)) {
            // set the owning side to null (unless already changed)
            if ($tennisBookings2->getPlayer2() === $this) {
                $tennisBookings2->setPlayer2(null);
            }
        }

        return $this;
    }





    
}
