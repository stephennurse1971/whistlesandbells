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
     * @ORM\Column(type="string", length=255, nullable=true)
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
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $LastName;


    /**
     * @ORM\OneToMany(targetEntity=Log::class, mappedBy="user", orphanRemoval=true)
     */
    private $logs;

    /**
     * @ORM\OneToMany(targetEntity=HouseGuests::class, mappedBy="guestName", orphanRemoval=true)
     */
    private $houseGuests;

//    /**
//     * @ORM\ManyToMany(targetEntity=Photos::class, mappedBy="person")
//     */
//    private $photos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $company;


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
     * @ORM\Column(type="text", nullable=true)
     */
    private $notes;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $inviteDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $salutation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $jobTitle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $recruitingArea;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $linkedIn;

    /**
     * @ORM\OneToMany(targetEntity=Introduction::class, mappedBy="author", orphanRemoval=true)
     */
    private $introductions;

    /**
     * @ORM\OneToMany(targetEntity=ProspectEmployer::class, mappedBy="recruiter")
     */
    private $prospectEmployers;

    /**
     * @ORM\ManyToOne(targetEntity=ProspectEmployer::class, inversedBy="interviewer1")
     */
    private $prospectEmployer;

    /**
     * @ORM\OneToMany(targetEntity=CurriculumVitae::class, mappedBy="candidate", orphanRemoval=true)
     */
    private $curriculumVitaes;



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $businessStreet;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $businessCity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $businessPostalCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $businessCountry;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $homeStreet;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $homeCity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $homePostalCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $homeCountry;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $recruitingAreaList = [];

    /**
     * @ORM\OneToMany(targetEntity=ProspectEmployer::class, mappedBy="applicant", orphanRemoval=true)
     */
    private $prospectiveEmployer;

    /**
     * @ORM\OneToMany(targetEntity=PhotoLocations::class, mappedBy="enabledUsers")
     */
    private $photoLocations;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $lastEdited;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $festiveMessage;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $festiveMessageDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $entryConflict;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $importTime;




    public function __construct()
    {
        $this->logs = new ArrayCollection();
        $this->houseGuests = new ArrayCollection();
      //  $this->photos = new ArrayCollection();
        $this->introductions = new ArrayCollection();
        $this->prospectEmployers = new ArrayCollection();
        $this->curriculumVitaes = new ArrayCollection();
        $this->prospectiveEmployer = new ArrayCollection();
        $this->photoLocations = new ArrayCollection();
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

    public function setMobile(?string $mobile): self
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

//    /**
//     * @return Collection|Photos[]
//     */
//    public function getPhotos(): Collection
//    {
//        return $this->photos;
//    }
//
//    public function addPhoto(Photos $photo): self
//    {
//        if (!$this->photos->contains($photo)) {
//            $this->photos[] = $photo;
//            $photo->addPerson($this);
//        }
//
//        return $this;
//    }
//
//    public function removePhoto(Photos $photo): self
//    {
//        if ($this->photos->removeElement($photo)) {
//            $photo->removePerson($this);
//        }
//
//        return $this;
//    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;

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

    public function getSalutation(): ?string
    {
        return $this->salutation;
    }

    public function setSalutation(?string $salutation): self
    {
        $this->salutation = $salutation;

        return $this;
    }

    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    public function setJobTitle(?string $jobTitle): self
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }





    public function getLinkedIn(): ?string
    {
        return $this->linkedIn;
    }

    public function setLinkedIn(?string $linkedIn): self
    {
        $this->linkedIn = $linkedIn;

        return $this;
    }

    /**
     * @return Collection|Introduction[]
     */
    public function getIntroductions(): Collection
    {
        return $this->introductions;
    }

    public function addIntroduction(Introduction $introduction): self
    {
        if (!$this->introductions->contains($introduction)) {
            $this->introductions[] = $introduction;
            $introduction->setAuthor($this);
        }

        return $this;
    }

    public function removeIntroduction(Introduction $introduction): self
    {
        if ($this->introductions->removeElement($introduction)) {
            // set the owning side to null (unless already changed)
            if ($introduction->getAuthor() === $this) {
                $introduction->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProspectEmployer[]
     */
    public function getProspectEmployers(): Collection
    {
        return $this->prospectEmployers;
    }

    public function addProspectEmployer(ProspectEmployer $prospectEmployer): self
    {
        if (!$this->prospectEmployers->contains($prospectEmployer)) {
            $this->prospectEmployers[] = $prospectEmployer;
            $prospectEmployer->setRecruiter($this);
        }

        return $this;
    }

    public function removeProspectEmployer(ProspectEmployer $prospectEmployer): self
    {
        if ($this->prospectEmployers->removeElement($prospectEmployer)) {
            // set the owning side to null (unless already changed)
            if ($prospectEmployer->getRecruiter() === $this) {
                $prospectEmployer->setRecruiter(null);
            }
        }

        return $this;
    }

    public function getProspectEmployer(): ?ProspectEmployer
    {
        return $this->prospectEmployer;
    }

    public function setProspectEmployer(?ProspectEmployer $prospectEmployer): self
    {
        $this->prospectEmployer = $prospectEmployer;

        return $this;
    }

    /**
     * @return Collection|CurriculumVitae[]
     */
    public function getCurriculumVitaes(): Collection
    {
        return $this->curriculumVitaes;
    }

    public function addCurriculumVitae(CurriculumVitae $curriculumVitae): self
    {
        if (!$this->curriculumVitaes->contains($curriculumVitae)) {
            $this->curriculumVitaes[] = $curriculumVitae;
            $curriculumVitae->setCandidate($this);
        }

        return $this;
    }

    public function removeCurriculumVitae(CurriculumVitae $curriculumVitae): self
    {
        if ($this->curriculumVitaes->removeElement($curriculumVitae)) {
            // set the owning side to null (unless already changed)
            if ($curriculumVitae->getCandidate() === $this) {
                $curriculumVitae->setCandidate(null);
            }
        }

        return $this;
    }

    public function getRecruitingArea(): ?string
    {
        return $this->recruitingArea;
    }

    public function setRecruitingArea(?string $recruitingArea): self
    {
        $this->recruitingArea = $recruitingArea;

        return $this;
    }

    public function getBusinessStreet(): ?string
    {
        return $this->businessStreet;
    }

    public function setBusinessStreet(?string $businessStreet): self
    {
        $this->businessStreet = $businessStreet;

        return $this;
    }

    public function getBusinessCity(): ?string
    {
        return $this->businessCity;
    }

    public function setBusinessCity(?string $businessCity): self
    {
        $this->businessCity = $businessCity;

        return $this;
    }

    public function getBusinessPostalCode(): ?string
    {
        return $this->businessPostalCode;
    }

    public function setBusinessPostalCode(?string $businessPostalCode): self
    {
        $this->businessPostalCode = $businessPostalCode;

        return $this;
    }

    public function getBusinessCountry(): ?string
    {
        return $this->businessCountry;
    }

    public function setBusinessCountry(?string $businessCountry): self
    {
        $this->businessCountry = $businessCountry;

        return $this;
    }

    public function getHomeStreet(): ?string
    {
        return $this->homeStreet;
    }

    public function setHomeStreet(?string $homeStreet): self
    {
        $this->homeStreet = $homeStreet;

        return $this;
    }

    public function getHomeCity(): ?string
    {
        return $this->homeCity;
    }

    public function setHomeCity(?string $homeCity): self
    {
        $this->homeCity = $homeCity;

        return $this;
    }

    public function getHomePostalCode(): ?string
    {
        return $this->homePostalCode;
    }

    public function setHomePostalCode(?string $homePostalCode): self
    {
        $this->homePostalCode = $homePostalCode;

        return $this;
    }

    public function getHomeCountry(): ?string
    {
        return $this->homeCountry;
    }

    public function setHomeCountry(?string $homeCountry): self
    {
        $this->homeCountry = $homeCountry;

        return $this;
    }

    public function getRecruitingAreaList(): ?array
    {
        return $this->recruitingAreaList;
    }

    public function setRecruitingAreaList(?array $recruitingAreaList): self
    {
        $this->recruitingAreaList = $recruitingAreaList;

        return $this;
    }

    /**
     * @return Collection|ProspectEmployer[]
     */
    public function getProspectiveEmployer(): Collection
    {
        return $this->prospectiveEmployer;
    }

    public function addProspectiveEmployer(ProspectEmployer $prospectiveEmployer): self
    {
        if (!$this->prospectiveEmployer->contains($prospectiveEmployer)) {
            $this->prospectiveEmployer[] = $prospectiveEmployer;
            $prospectiveEmployer->setApplicant($this);
        }

        return $this;
    }

    public function removeProspectiveEmployer(ProspectEmployer $prospectiveEmployer): self
    {
        if ($this->prospectiveEmployer->removeElement($prospectiveEmployer)) {
            // set the owning side to null (unless already changed)
            if ($prospectiveEmployer->getApplicant() === $this) {
                $prospectiveEmployer->setApplicant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PhotoLocations[]
     */
    public function getPhotoLocations(): Collection
    {
        return $this->photoLocations;
    }

    public function addPhotoLocation(PhotoLocations $photoLocation): self
    {
        if (!$this->photoLocations->contains($photoLocation)) {
            $this->photoLocations[] = $photoLocation;
            $photoLocation->setEnabledUsers($this);
        }

        return $this;
    }

    public function removePhotoLocation(PhotoLocations $photoLocation): self
    {
        if ($this->photoLocations->removeElement($photoLocation)) {
            // set the owning side to null (unless already changed)
            if ($photoLocation->getEnabledUsers() === $this) {
                $photoLocation->setEnabledUsers(null);
            }
        }

        return $this;
    }

    public function getLastEdited(): ?\DateTimeInterface
    {
        return $this->lastEdited;
    }

    public function setLastEdited(?\DateTimeInterface $lastEdited): self
    {
        $this->lastEdited = $lastEdited;

        return $this;
    }

    public function getFestiveMessage(): ?bool
    {
        return $this->festiveMessage;
    }

    public function setFestiveMessage(?bool $festiveMessage): self
    {
        $this->festiveMessage = $festiveMessage;

        return $this;
    }

    public function getFestiveMessageDate(): ?\DateTimeInterface
    {
        return $this->festiveMessageDate;
    }

    public function setFestiveMessageDate(?\DateTimeInterface $festiveMessageDate): self
    {
        $this->festiveMessageDate = $festiveMessageDate;

        return $this;
    }

    public function getEntryConflict(): ?string
    {
        return $this->entryConflict;
    }

    public function setEntryConflict(?string $entryConflict): self
    {
        $this->entryConflict = $entryConflict;

        return $this;
    }

    public function getImportTime(): ?\DateTimeInterface
    {
        return $this->importTime;
    }

    public function setImportTime(?\DateTimeInterface $importTime): self
    {
        $this->importTime = $importTime;

        return $this;
    }

}
