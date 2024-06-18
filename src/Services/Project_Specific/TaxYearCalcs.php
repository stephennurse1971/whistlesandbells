<?php

namespace App\Services\Project_Specific;

use App\Repository\Project_Specific\InvestmentsRepository;
use App\Repository\Project_Specific\TaxInputsRepository;

class TaxYearCalcs
{
   public function taxDueOnIncomeByYear(\App\Entity\Project_Specific\TaxYear $taxYear, float $income){
      $tax_input_by_year = $this->taxInputsRepository->findOneBy(['year'=>$taxYear]);
      $basic_rate = max(0,min($income,$taxYear->getTaxBand2BasicRate()));
      $higher_rate = max(0,(min($income,$taxYear->getTaxBand3HigherRate())-$basic_rate));
      $additional_rate = max(0,($income- $taxYear->getTaxBand3HigherRate()));
      $tax_due_on_income = ($basic_rate*$taxYear->getTaxBand2Rate()) + ($higher_rate * $taxYear->getTaxBand3Rate()) + ($additional_rate * $taxYear->getTaxBand4Rate());
      return $tax_due_on_income;
   }


    public function taxReliefsByYear(\App\Entity\Project_Specific\TaxYear $taxYear ){
        $tax_input_by_year = $this->taxInputsRepository->findOneBy(['year'=>$taxYear]);
        $tax_relief_offset = 0;
         foreach ($this->investmentRepository->findAll() as $investment ){
             if($investment->getEisPurchaseYear1()){
                 if($investment->getEisPurchaseYear1() == $taxYear){
                     $tax_relief_offset = $tax_relief_offset + ($investment->getInvestmentAmount() * $investment->getEISPurchaseYear1Percentage() * ($investment->getAssetClass()->getTaxScheme()->getPurchaseTaxOffset()/100));
                 }
             }
             if($investment->getEisPurchaseYear2()){
                 if($investment->getEisPurchaseYear2() == $taxYear){
                     $tax_relief_offset = $tax_relief_offset + ($investment->getInvestmentAmount() * $investment->getEISPurchaseYear2Percentage() * ($investment->getAssetClass()->getTaxScheme()->getPurchaseTaxOffset()/100));
                 }
             }
             if($investment->getEisSaleYear1()){
                 if($investment->getEisSaleYear1() == $taxYear){
                     $tax_relief_offset = $tax_relief_offset + ($investment->getInvestmentAmount() * $investment->getEISSaleYear1Percentage() * $investment->getAssetClass()->getTaxScheme()->getSaleTaxOffset()/100);
                 }
             }
             if($investment->getEisSaleYear2()){
                 if($investment->getEisPurchaseYear2() == $taxYear){
                     $tax_relief_offset = $tax_relief_offset + ($investment->getInvestmentAmount() * $investment->getEISSaleYear2Percentage() * $investment->getAssetClass()->getTaxScheme()->getSaleTaxOffset()/100);
                 }
             }
         }
         return $tax_relief_offset;
    }

    public function incomeOffsetsByYear(\App\Entity\Project_Specific\TaxYear $taxYear ){
        $tax_input_by_year = $this->taxInputsRepository->findOneBy(['year'=>$taxYear]);
        $income_offset = 0;
        foreach ($this->investmentRepository->findAll() as $investment ){
            if($investment->getEisPurchaseYear1()){
                if($investment->getEisPurchaseYear1() == $taxYear){
                    $income_offset = $income_offset - ($investment->getInvestmentAmount() * $investment->getEISPurchaseYear1Percentage() * ($investment->getAssetClass()->getTaxScheme()->getPurchaseIncomeOffset()/100));
                }
            }
            if($investment->getEisPurchaseYear2()){
                if($investment->getEisPurchaseYear2() == $taxYear){
                    $income_offset = $income_offset - ($investment->getInvestmentAmount() * $investment->getEISPurchaseYear2Percentage() * ($investment->getAssetClass()->getTaxScheme()->getPurchaseIncomeOffset()/100));
                }
            }

            if($investment->getEisSaleYear1()){
                if($investment->getEisSaleYear1() == $taxYear){
                    $income_offset = $income_offset + ($investment->getLossDeductibleAgainstIncome() * $investment->getEISSaleYear1Percentage()/100);
                }
            }

            if($investment->getEisSaleYear2()){
                if($investment->getEisSaleYear2() == $taxYear){
                    $income_offset = $income_offset + ($investment->getLossDeductibleAgainstIncome() * $investment->getEISSaleYear2Percentage() /100);
                }
            }
        }
        return $income_offset;
    }



    public function __construct(TaxInputsRepository $taxInputsRepository, InvestmentsRepository $investmentsRepository){
        $this->taxInputsRepository = $taxInputsRepository;
        $this->investmentRepository = $investmentsRepository;
    }



}