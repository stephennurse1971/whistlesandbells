<?php


namespace App\Services\ProjectSpecific;


use App\Entity\ProjectSpecific\BankAccounts;
use App\Repository\ProjectSpecific\BankAccountsRepository;
use App\Repository\ProjectSpecific\BankBalancesRepository;

class BankBalanceOnAsOfDate
{
    public function findBankBalance(\DateTimeInterface $date, BankAccounts $bankAccounts)
    {
        $historyOfBalance = $this->bankBalancesRepository->findOneBy([
            'bank' => $bankAccounts,
            'date' => $date
        ]);
        if ($historyOfBalance) {
            return $historyOfBalance;
        }
        else{
            $previousPrice = $this->bankBalancesRepository->findPricePrevious($bankAccounts,$date);
            if($previousPrice){
                return $previousPrice[0];
            }
        }
        return null;
    }


    public function __construct(BankBalancesRepository $bankBalancesRepository, BankAccountsRepository $bankAccountsRepository)
    {
        $this->bankBalancesRepository = $bankBalancesRepository;
        $this->bankAccountsRepository = $bankAccountsRepository;
    }
}