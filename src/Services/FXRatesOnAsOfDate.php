<?php


namespace App\Services;


use App\Repository\FxRatesHistoryRepository;

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
            $previousPrice = $this->fxRatesHistoryRepository->findPricePrevious($date);
            if($previousPrice){
                return $previousPrice[0];
            }
        }
        return null;
    }


    public function __construct(FxRatesHistoryRepository $fxRatesHistoryRepository)
    {
        $this->fxRatesHistoryRepository = $fxRatesHistoryRepository;
    }
}