<?php


namespace App\Services\Project_Specific;


use App\Repository\Project_Specific\FxRatesHistoryRepository;

class FXRatesOnAsOfDate
{
    public function findFXRates(\DateTimeInterface $date, string $currency)
    {
        $historyOfFXRates = $this->fxRatesHistoryRepository->findOneBy([
            'date' => $date
        ]);
        if ($historyOfFXRates) {
            if($currency=="GBP"){
               $rate = $historyOfFXRates->getGBPFXRate();
            }
            if($currency=="EUR"){
                $rate = $historyOfFXRates->getEURFXRate();
            }
            if($currency=="CHF"){
                $rate = $historyOfFXRates->getCHFFXRate();
            }
            return $rate;
        }

        else{
            $previousRates = $this->fxRatesHistoryRepository->findPreviousRate($date);
            if($previousRates){
                if($currency=="GBP"){
                    $rate = $previousRates[0]->getGBPFXRate();
                }
                if($currency=="EUR"){
                    $rate = $previousRates[0]->getEURFXRate();
                }
                if($currency=="CHF"){
                    $rate = $previousRates[0]->getCHFFXRate();
                }
                return $rate;
            }
        }
        return null;
    }


    public function __construct(FxRatesHistoryRepository $fxRatesHistoryRepository)
    {
        $this->fxRatesHistoryRepository = $fxRatesHistoryRepository;
    }
}