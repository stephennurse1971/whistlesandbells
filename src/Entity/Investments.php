<?php

namespace App\Entity;

use App\Repository\InvestmentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InvestmentsRepository::class)
 */
class Investments
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
    private $investmentName;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $investmentDate;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $investmentAmount;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $investmentEIS;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $investmentSoldPrice;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $investmentSaleDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $shareCert;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $eisCert;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $otherDocs;

    /**
     * @ORM\OneToMany(targetEntity=InvestmentFutureComms::class, mappedBy="investment", orphanRemoval=true)
     */
    private $investmentFutureComms;



    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $EISPurchaseYear1Percentage;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $EISPurchaseYear2Percentage;

    /**
     * @ORM\ManyToOne(targetEntity=TaxDocuments::class)
     */
    private $EISPurchaseYear1;

    /**
     * @ORM\ManyToOne(targetEntity=TaxDocuments::class)
     */
    private $EISPurchaseYear2;

    /**
     * @ORM\ManyToOne(targetEntity=TaxDocuments::class)
     */
    private $EISSaleYear1;

    /**
     * @ORM\ManyToOne(targetEntity=TaxDocuments::class)
     */
    private $EISSaleYear2;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $EISSaleYear1Percentage;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $EISSaleYear2Percentage;





    public function __construct()
    {
        $this->investmentFutureComms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInvestmentName(): ?string
    {
        return $this->investmentName;
    }

    public function setInvestmentName(string $investmentName): self
    {
        $this->investmentName = $investmentName;

        return $this;
    }

    public function getInvestmentDate(): ?\DateTimeInterface
    {
        return $this->investmentDate;
    }

    public function setInvestmentDate(?\DateTimeInterface $investmentDate): self
    {
        $this->investmentDate = $investmentDate;

        return $this;
    }

    public function getInvestmentAmount(): ?float
    {
        return $this->investmentAmount;
    }

    public function setInvestmentAmount(?float $investmentAmount): self
    {
        $this->investmentAmount = $investmentAmount;

        return $this;
    }

    public function getInvestmentEIS(): ?bool
    {
        return $this->investmentEIS;
    }

    public function setInvestmentEIS(bool $investmentEIS): self
    {
        $this->investmentEIS = $investmentEIS;

        return $this;
    }

    public function getInvestmentSoldPrice(): ?float
    {
        return $this->investmentSoldPrice;
    }

    public function setInvestmentSoldPrice(?float $investmentSoldPrice): self
    {
        $this->investmentSoldPrice = $investmentSoldPrice;

        return $this;
    }

    public function getInvestmentSaleDate(): ?\DateTimeInterface
    {
        return $this->investmentSaleDate;
    }

    public function setInvestmentSaleDate(?\DateTimeInterface $investmentSaleDate): self
    {
        $this->investmentSaleDate = $investmentSaleDate;

        return $this;
    }

    public function getShareCert(): ?string
    {
        return $this->shareCert;
    }

    public function setShareCert(?string $shareCert): self
    {
        $this->shareCert = $shareCert;

        return $this;
    }

    public function getEisCert(): ?string
    {
        return $this->eisCert;
    }

    public function setEisCert(?string $eisCert): self
    {
        $this->eisCert = $eisCert;

        return $this;
    }

    public function getOtherDocs(): ?string
    {
        return $this->otherDocs;
    }

    public function setOtherDocs(?string $otherDocs): self
    {
        $this->otherDocs = $otherDocs;

        return $this;
    }

    /**
     * @return Collection|InvestmentFutureComms[]
     */
    public function getInvestmentFutureComms(): Collection
    {
        return $this->investmentFutureComms;
    }

    public function addInvestmentFutureComm(InvestmentFutureComms $investmentFutureComm): self
    {
        if (!$this->investmentFutureComms->contains($investmentFutureComm)) {
            $this->investmentFutureComms[] = $investmentFutureComm;
            $investmentFutureComm->setInvestment($this);
        }

        return $this;
    }

    public function removeInvestmentFutureComm(InvestmentFutureComms $investmentFutureComm): self
    {
        if ($this->investmentFutureComms->removeElement($investmentFutureComm)) {
            // set the owning side to null (unless already changed)
            if ($investmentFutureComm->getInvestment() === $this) {
                $investmentFutureComm->setInvestment(null);
            }
        }

        return $this;
    }



    public function getEISPurchaseYear1Percentage(): ?float
    {
        return $this->EISPurchaseYear1Percentage;
    }

    public function setEISPurchaseYear1Percentage(?float $EISPurchaseYear1Percentage): self
    {
        $this->EISPurchaseYear1Percentage = $EISPurchaseYear1Percentage;

        return $this;
    }

    public function getEISPurchaseYear2Percentage(): ?float
    {
        return $this->EISPurchaseYear2Percentage;
    }

    public function setEISPurchaseYear2Percentage(?float $EISPurchaseYear2Percentage): self
    {
        $this->EISPurchaseYear2Percentage = $EISPurchaseYear2Percentage;

        return $this;
    }

    public function getEISPurchaseYear1(): ?TaxDocuments
    {
        return $this->EISPurchaseYear1;
    }

    public function setEISPurchaseYear1(?TaxDocuments $EISPurchaseYear1): self
    {
        $this->EISPurchaseYear1 = $EISPurchaseYear1;

        return $this;
    }

    public function getEISPurchaseYear2(): ?TaxDocuments
    {
        return $this->EISPurchaseYear2;
    }

    public function setEISPurchaseYear2(?TaxDocuments $EISPurchaseYear2): self
    {
        $this->EISPurchaseYear2 = $EISPurchaseYear2;

        return $this;
    }

    public function getEISSaleYear1(): ?TaxDocuments
    {
        return $this->EISSaleYear1;
    }

    public function setEISSaleYear1(?TaxDocuments $EISSaleYear1): self
    {
        $this->EISSaleYear1 = $EISSaleYear1;

        return $this;
    }

    public function getEISSaleYear2(): ?TaxDocuments
    {
        return $this->EISSaleYear2;
    }

    public function setEISSaleYear2(?TaxDocuments $EISSaleYear2): self
    {
        $this->EISSaleYear2 = $EISSaleYear2;

        return $this;
    }

    public function getEISSaleYear1Percentage(): ?float
    {
        return $this->EISSaleYear1Percentage;
    }

    public function setEISSaleYear1Percentage(?float $EISSaleYear1Percentage): self
    {
        $this->EISSaleYear1Percentage = $EISSaleYear1Percentage;

        return $this;
    }

    public function getEISSaleYear2Percentage(): ?float
    {
        return $this->EISSaleYear2Percentage;
    }

    public function setEISSaleYear2Percentage(?float $EISSaleYear2Percentage): self
    {
        $this->EISSaleYear2Percentage = $EISSaleYear2Percentage;

        return $this;
    }






}
