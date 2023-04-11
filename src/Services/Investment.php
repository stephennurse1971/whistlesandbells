<?php


namespace App\Services;


use App\Repository\InvestmentFutureCommsRepository;
use App\Repository\InvestmentsRepository;
use App\Repository\MarketDataRepository;

class Investment
{
  public function findFutureComms(int $investmentID)
  {
     $findComms = $this->comms->findOneBy([
         'investment'=> $this->investmentRepository->find($investmentID)
     ]);
     if($findComms)
     {
         return 1;
     }
     else{
         return 0;
     }
  }
  public function getAssetClass(int $id){
      $company = $this->marketDataRepository->find($id);
      $data =[];
      $data['tax'] =  $company->getAssetClass()->getShowTaxYearDetails();
      $data['docs'] = $company->getAssetClass()->getShowDocs();
      return $data;
  }
  public function __construct(InvestmentsRepository $investmentsRepository,InvestmentFutureCommsRepository $investmentFutureCommsRepository,MarketDataRepository $marketDataRepository)
  {
     $this->comms = $investmentFutureCommsRepository;
     $this->investmentRepository = $investmentsRepository;
     $this->marketDataRepository = $marketDataRepository;
  }
}