<?php


namespace App\Services\Project_Specific;


use App\Entity\Project_Specific\BankAccounts;
use App\Repository\Project_Specific\BankAccountsRepository;
use App\Repository\Project_Specific\BankBalancesRepository;

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