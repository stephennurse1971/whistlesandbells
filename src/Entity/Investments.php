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
     * @ORM\Column(type="date", nullable=true)
     */
    private $investmentDate;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $investmentAmount;




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
     * @ORM\Column(type="float", nullable=true)
     */
    private $EISSaleYear1Percentage;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $EISSaleYear2Percentage;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $numberOfShares;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $purchaseSharePrice;

    /**
     * @ORM\ManyToOne(targetEntity=FxRates::class, inversedBy="investments")
     */
    private $currency;

    /**
     * @ORM\ManyToOne(targetEntity=MarketData::class)
     */
    private $investmentCompany;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $initialInvestmentAmountGBP;

    /**
     * @ORM\ManyToOne(targetEntity=TaxYear::class)
     */
    private $eisPurchaseYear1;

    /**
     * @ORM\ManyToOne(targetEntity=TaxYear::class)
     */
    private $eisPurchaseYear2;

    /**
     * @ORM\ManyToOne(targetEntity=TaxYear::class)
     */
    private $eisSaleYear1;

    /**
     * @ORM\ManyToOne(targetEntity=TaxYear::class)
     */
    private $eisSaleYear2;

    /**
     * @ORM\ManyToOne(targetEntity=TaxSchemes::class)
     */
    private $taxScheme;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $sale_share_price;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $crystallisedGainLossInGBP;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $lossDeductibleAgainstIncome;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $eisPurchaseYear1SelfAssessmentCheck;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $eisPurchaseYear2SelfAssessmentCheck;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $eisSaleYear1SelfAssessmentCheck;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $eisSaleYear2SelfAssessmentCheck;







    public function __construct()
    {
        $this->investmentFutureComms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNumberOfShares(): ?float
    {
        return $this->numberOfShares;
    }

    public function setNumberOfShares(?float $numberOfShares): self
    {
        $this->numberOfShares = $numberOfShares;

        return $this;
    }

    public function getPurchaseSharePrice(): ?float
    {
        return $this->purchaseSharePrice;
    }

    public function setPurchaseSharePrice(?float $purchaseSharePrice): self
    {
        $this->purchaseSharePrice = $purchaseSharePrice;

        return $this;
    }

    public function getCurrency(): ?FxRates
    {
        return $this->currency;
    }

    public function setCurrency(?FxRates $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getInvestmentCompany(): ?MarketData
    {
        return $this->investmentCompany;
    }

    public function setInvestmentCompany(?MarketData $investmentCompany): self
    {
        $this->investmentCompany = $investmentCompany;

        return $this;
    }

    public function getInitialInvestmentAmountGBP(): ?float
    {
        return $this->initialInvestmentAmountGBP;
    }

    public function setInitialInvestmentAmountGBP(?float $initialInvestmentAmountGBP): self
    {
        $this->initialInvestmentAmountGBP = $initialInvestmentAmountGBP;

        return $this;
    }

    public function getEisPurchaseYear1(): ?TaxYear
    {
        return $this->eisPurchaseYear1;
    }

    public function setEisPurchaseYear1(?TaxYear $eisPurchaseYear1): self
    {
        $this->eisPurchaseYear1 = $eisPurchaseYear1;

        return $this;
    }

    public function getEisPurchaseYear2(): ?TaxYear
    {
        return $this->eisPurchaseYear2;
    }

    public function setEisPurchaseYear2(?TaxYear $eisPurchaseYear2): self
    {
        $this->eisPurchaseYear2 = $eisPurchaseYear2;

        return $this;
    }

    public function getEisSaleYear1(): ?TaxYear
    {
        return $this->eisSaleYear1;
    }

    public function setEisSaleYear1(?TaxYear $eisSaleYear1): self
    {
        $this->eisSaleYear1 = $eisSaleYear1;

        return $this;
    }

    public function getEisSaleYear2(): ?TaxYear
    {
        return $this->eisSaleYear2;
    }

    public function setEisSaleYear2(?TaxYear $eisSaleYear2): self
    {
        $this->eisSaleYear2 = $eisSaleYear2;

        return $this;
    }

    public function getTaxScheme(): ?TaxSchemes
    {
        return $this->taxScheme;
    }

    public function setTaxScheme(?TaxSchemes $taxScheme): self
    {
        $this->taxScheme = $taxScheme;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getSaleSharePrice(): ?float
    {
        return $this->sale_share_price;
    }

    public function setSaleSharePrice(?float $sale_share_price): self
    {
        $this->sale_share_price = $sale_share_price;

        return $this;
    }

    public function getCrystallisedGainLossInGBP(): ?float
    {
        return $this->crystallisedGainLossInGBP;
    }

    public function setCrystallisedGainLossInGBP(?float $crystallisedGainLossInGBP): self
    {
        $this->crystallisedGainLossInGBP = $crystallisedGainLossInGBP;

        return $this;
    }

    public function getLossDeductibleAgainstIncome(): ?float
    {
        return $this->lossDeductibleAgainstIncome;
    }

    public function setLossDeductibleAgainstIncome(float $lossDeductibleAgainstIncome): self
    {
        $this->lossDeductibleAgainstIncome = $lossDeductibleAgainstIncome;

        return $this;
    }

    public function getEisPurchaseYear1SelfAssessmentCheck(): ?string
    {
        return $this->eisPurchaseYear1SelfAssessmentCheck;
    }

    public function setEisPurchaseYear1SelfAssessmentCheck(?string $eisPurchaseYear1SelfAssessmentCheck): self
    {
        $this->eisPurchaseYear1SelfAssessmentCheck = $eisPurchaseYear1SelfAssessmentCheck;

        return $this;
    }

    public function getEisPurchaseYear2SelfAssessmentCheck(): ?string
    {
        return $this->eisPurchaseYear2SelfAssessmentCheck;
    }

    public function setEisPurchaseYear2SelfAssessmentCheck(?string $eisPurchaseYear2SelfAssessmentCheck): self
    {
        $this->eisPurchaseYear2SelfAssessmentCheck = $eisPurchaseYear2SelfAssessmentCheck;

        return $this;
    }

    public function getEisSaleYear1SelfAssessmentCheck(): ?string
    {
        return $this->eisSaleYear1SelfAssessmentCheck;
    }

    public function setEisSaleYear1SelfAssessmentCheck(?string $eisSaleYear1SelfAssessmentCheck): self
    {
        $this->eisSaleYear1SelfAssessmentCheck = $eisSaleYear1SelfAssessmentCheck;

        return $this;
    }

    public function getEisSaleYear2SelfAssessmentCheck(): ?string
    {
        return $this->eisSaleYear2SelfAssessmentCheck;
    }

    public function setEisSaleYear2SelfAssessmentCheck(?string $eisSaleYear2SelfAssessmentCheck): self
    {
        $this->eisSaleYear2SelfAssessmentCheck = $eisSaleYear2SelfAssessmentCheck;

        return $this;
    }








}
