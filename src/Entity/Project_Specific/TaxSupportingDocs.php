<?php

namespace App\Entity\Project_Specific;

use App\Repository\Project_Specific\TaxSupportingDocsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaxSupportingDocsRepository::class)
 */
class TaxSupportingDocs
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comments;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attachment;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $detailedComments;

    /**
     * @ORM\ManyToOne(targetEntity=TaxYear::class)
     */
    private $taxYear;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function getAttachment(): ?string
    {
        return $this->attachment;
    }

    public function setAttachment(?string $attachment): self
    {
        $this->attachment = $attachment;

        return $this;
    }

    public function getDetailedComments(): ?string
    {
        return $this->detailedComments;
    }

    public function setDetailedComments(?string $detailedComments): self
    {
        $this->detailedComments = $detailedComments;

        return $this;
    }

    public function getTaxYear(): ?TaxYear
    {
        return $this->taxYear;
    }

    public function setTaxYear(?TaxYear $taxYear): self
    {
        $this->taxYear = $taxYear;

        return $this;
    }
}
