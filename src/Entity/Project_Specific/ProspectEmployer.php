<?php

namespace App\Entity\Project_Specific;

use App\Repository\Project_Specific\ProspectEmployerRepository;
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
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $interviewer1;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $interviewer2;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $interviewer3;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="prospectiveEmployer")
     * @ORM\JoinColumn(nullable=false)
     */
    private $applicant;





    public function __construct()
    {

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

    public function getInterviewer1(): ?User
    {
        return $this->interviewer1;
    }

    public function setInterviewer1(?User $interviewer1): self
    {
        $this->interviewer1 = $interviewer1;

        return $this;
    }

    public function getInterviewer2(): ?User
    {
        return $this->interviewer2;
    }

    public function setInterviewer2(?User $interviewer2): self
    {
        $this->interviewer2 = $interviewer2;

        return $this;
    }

    public function getInterviewer3(): ?User
    {
        return $this->interviewer3;
    }

    public function setInterviewer3(?User $interviewer3): self
    {
        $this->interviewer3 = $interviewer3;

        return $this;
    }

    public function getApplicant(): ?User
    {
        return $this->applicant;
    }

    public function setApplicant(?User $applicant): self
    {
        $this->applicant = $applicant;

        return $this;
    }
}
