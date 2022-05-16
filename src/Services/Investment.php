<?php


namespace App\Services;


use App\Repository\InvestmentFutureCommsRepository;
use App\Repository\InvestmentsRepository;

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
  public function __construct(InvestmentsRepository $investmentsRepository,InvestmentFutureCommsRepository $investmentFutureCommsRepository)
  {
     $this->comms = $investmentFutureCommsRepository;
     $this->investmentRepository = $investmentsRepository;
  }
}