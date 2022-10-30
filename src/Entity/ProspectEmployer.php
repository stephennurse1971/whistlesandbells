<?php

namespace App\Entity;

use App\Repository\ProspectEmployerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProspectEmployerRepository::class)
 */
class ProspectEmployer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $employer;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="prospectEmployers")
     */
    private $recruiter;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $interviewDate1;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $interviewDate2;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $interviewDate3;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="prospectEmployer")
     */
    private $interviewer1;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="prospectEmployer")
     */
    private $interviewer2;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="prospectEmployer")
     */
    private $interviewer3;

    public function __construct()
    {
        $this->interviewer1 = new ArrayCollection();
        $this->interviewer2 = new ArrayCollection();
        $this->interviewer3 = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployer(): ?string
    {
        return $this->employer;
    }

    public function setEmployer(string $employer): self
    {
        $this->employer = $employer;

        return $this;
    }

    public function getRecruiter(): ?User
    {
        return $this->recruiter;
    }

    public function setRecruiter(?User $recruiter): self
    {
        $this->recruiter = $recruiter;

        return $this;
    }

    public function getInterviewDate1(): ?\DateTimeInterface
    {
        return $this->interviewDate1;
    }

    public function setInterviewDate1(?\DateTimeInterface $interviewDate1): self
    {
        $this->interviewDate1 = $interviewDate1;

        return $this;
    }

    public function getInterviewDate2(): ?\DateTimeInterface
    {
        return $this->interviewDate2;
    }

    public function setInterviewDate2(?\DateTimeInterface $interviewDate2): self
    {
        $this->interviewDate2 = $interviewDate2;

        return $this;
    }

    public function getInterviewDate3(): ?\DateTimeInterface
    {
        return $this->interviewDate3;
    }

    public function setInterviewDate3(?\DateTimeInterface $interviewDate3): self
    {
        $this->interviewDate3 = $interviewDate3;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getInterviewer1(): Collection
    {
        return $this->interviewer1;
    }

    public function addInterviewer1(User $interviewer1): self
    {
        if (!$this->interviewer1->contains($interviewer1)) {
            $this->interviewer1[] = $interviewer1;
            $interviewer1->setProspectEmployer($this);
        }

        return $this;
    }

    public function removeInterviewer1(User $interviewer1): self
    {
        if ($this->interviewer1->removeElement($interviewer1)) {
            // set the owning side to null (unless already changed)
            if ($interviewer1->getProspectEmployer() === $this) {
                $interviewer1->setProspectEmployer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getInterviewer2(): Collection
    {
        return $this->interviewer2;
    }

    public function addInterviewer2(User $interviewer2): self
    {
        if (!$this->interviewer2->contains($interviewer2)) {
            $this->interviewer2[] = $interviewer2;
            $interviewer2->setProspectEmployer($this);
        }

        return $this;
    }

    public function removeInterviewer2(User $interviewer2): self
    {
        if ($this->interviewer2->removeElement($interviewer2)) {
            // set the owning side to null (unless already changed)
            if ($interviewer2->getProspectEmployer() === $this) {
                $interviewer2->setProspectEmployer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getInterviewer3(): Collection
    {
        return $this->interviewer3;
    }

    public function addInterviewer3(User $interviewer3): self
    {
        if (!$this->interviewer3->contains($interviewer3)) {
            $this->interviewer3[] = $interviewer3;
            $interviewer3->setProspectEmployer($this);
        }

        return $this;
    }

    public function removeInterviewer3(User $interviewer3): self
    {
        if ($this->interviewer3->removeElement($interviewer3)) {
            // set the owning side to null (unless already changed)
            if ($interviewer3->getProspectEmployer() === $this) {
                $interviewer3->setProspectEmployer(null);
            }
        }

        return $this;
    }
}
