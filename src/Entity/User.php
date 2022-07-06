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
     * @ORM\OneToMany(targetEntity=Log::class, mappedBy="user")
     */
    private $logs;

    /**
     * @ORM\OneToMany(targetEntity=HouseGuests::class, mappedBy="guestName", orphanRemoval=true)
     */
    private $houseGuests;

    /**
     * @ORM\ManyToMany(targetEntity=Photos::class, mappedBy="person")
     */
    private $photos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $company;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $businessAddress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $homeAddress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $businessPhone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $homePhone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $homePhone2;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $webPage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $notes;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $inviteDate;







    public function __construct()
    {
        $this->logs = new ArrayCollection();
        $this->houseGuests = new ArrayCollection();
        $this->photos = new ArrayCollection();
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
     * @return Collection|Log[]
     */
    public function getLogs(): Collection
    {
        return $this->logs;
    }

    public function addLog(Log $log): self
    {
        if (!$this->logs->contains($log)) {
            $this->logs[] = $log;
            $log->setUser($this);
        }

        return $this;
    }

    public function removeLog(Log $log): self
    {
        if ($this->logs->removeElement($log)) {
            // set the owning side to null (unless already changed)
            if ($log->getUser() === $this) {
                $log->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|HouseGuests[]
     */
    public function getHouseGuests(): Collection
    {
        return $this->houseGuests;
    }

    public function addHouseGuest(HouseGuests $houseGuest): self
    {
        if (!$this->houseGuests->contains($houseGuest)) {
            $this->houseGuests[] = $houseGuest;
            $houseGuest->setGuestName($this);
        }

        return $this;
    }

    public function removeHouseGuest(HouseGuests $houseGuest): self
    {
        if ($this->houseGuests->removeElement($houseGuest)) {
            // set the owning side to null (unless already changed)
            if ($houseGuest->getGuestName() === $this) {
                $houseGuest->setGuestName(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Photos[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photos $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->addPerson($this);
        }

        return $this;
    }

    public function removePhoto(Photos $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            $photo->removePerson($this);
        }

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getBusinessAddress(): ?string
    {
        return $this->businessAddress;
    }

    public function setBusinessAddress(?string $businessAddress): self
    {
        $this->businessAddress = $businessAddress;

        return $this;
    }

    public function getHomeAddress(): ?string
    {
        return $this->homeAddress;
    }

    public function setHomeAddress(?string $homeAddress): self
    {
        $this->homeAddress = $homeAddress;

        return $this;
    }

    public function getBusinessPhone(): ?string
    {
        return $this->businessPhone;
    }

    public function setBusinessPhone(?string $businessPhone): self
    {
        $this->businessPhone = $businessPhone;

        return $this;
    }

    public function getHomePhone(): ?string
    {
        return $this->homePhone;
    }

    public function setHomePhone(?string $homePhone): self
    {
        $this->homePhone = $homePhone;

        return $this;
    }

    public function getHomePhone2(): ?string
    {
        return $this->homePhone2;
    }

    public function setHomePhone2(?string $homePhone2): self
    {
        $this->homePhone2 = $homePhone2;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getEmail3(): ?string
    {
        return $this->email3;
    }

    public function setEmail3(?string $email3): self
    {
        $this->email3 = $email3;

        return $this;
    }

    public function getWebPage(): ?string
    {
        return $this->webPage;
    }

    public function setWebPage(?string $webPage): self
    {
        $this->webPage = $webPage;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function getInviteDate(): ?\DateTimeInterface
    {
        return $this->inviteDate;
    }

    public function setInviteDate(?\DateTimeInterface $inviteDate): self
    {
        $this->inviteDate = $inviteDate;

        return $this;
    }


}
