<?php


namespace App\Services;


use App\Entity\BankBalances;
use App\Repository\BankBalancesRepository;

class LatestBankBalance
{
    public function findBankBalance(\DateTimeInterface $date, BankBalances $bankBalances)
    {
        $history = $this->bankBalancesRepository->findOneBy([
            'bank' => $bankBalances,
            'date' => $date
        ]);
        if ($history) {
            return $history;
        }
        else{
            $previousPrice = $this->bankBalancesRepository->findPricePrevious($bankBalances,$date);
            if($previousPrice){
                return $previousPrice[0]->getMarketPrice();
            }
        }
        return null;
    }


    public function __construct(BankBalancesRepository $bankBalancesRepository)
    {
        $this->bankBalancesRepository = $bankBalancesRepository;
    }
}