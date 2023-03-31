<?php

namespace App\Entity;

use App\Repository\TaxDocumentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaxDocumentsRepository::class)
 */
class TaxDocuments
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $p11D;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $p60;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $selfAssessment;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=TaxSupportingDocs::class, mappedBy="taxYear", orphanRemoval=true)
     */
    private $taxSupportingDocs;



    public function __construct()
    {
        $this->taxSupportingDocs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(?string $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getP11D(): ?string
    {
        return $this->p11D;
    }

    public function setP11D(?string $p11D): self
    {
        $this->p11D = $p11D;

        return $this;
    }

    public function getP60(): ?string
    {
        return $this->p60;
    }

    public function setP60(?string $p60): self
    {
        $this->p60 = $p60;

        return $this;
    }

    public function getSelfAssessment(): ?string
    {
        return $this->selfAssessment;
    }

    public function setSelfAssessment(?string $selfAssessment): self
    {
        $this->selfAssessment = $selfAssessment;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * @return Collection|TaxSupportingDocs[]
     */
    public function getTaxSupportingDocs(): Collection
    {
        return $this->taxSupportingDocs;
    }

    public function addTaxSupportingDoc(TaxSupportingDocs $taxSupportingDoc): self
    {
        if (!$this->taxSupportingDocs->contains($taxSupportingDoc)) {
            $this->taxSupportingDocs[] = $taxSupportingDoc;
            $taxSupportingDoc->setTaxYear($this);
        }

        return $this;
    }

    public function removeTaxSupportingDoc(TaxSupportingDocs $taxSupportingDoc): self
    {
        if ($this->taxSupportingDocs->removeElement($taxSupportingDoc)) {
            // set the owning side to null (unless already changed)
            if ($taxSupportingDoc->getTaxYear() === $this) {
                $taxSupportingDoc->setTaxYear(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Investments[]
     */
   }
