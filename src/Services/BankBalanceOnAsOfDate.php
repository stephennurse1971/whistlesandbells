<?php


namespace App\Services;


use App\Entity\BankAccounts;
use App\Entity\BankBalances;
use App\Repository\BankAccountsRepository;
use App\Repository\BankBalancesRepository;

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