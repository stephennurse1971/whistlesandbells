<?php


namespace App\Services\ProjectSpecific;


use App\Entity\ProjectSpecific\MarketData;
use App\Repository\ProjectSpecific\InvestmentsRepository;
use App\Repository\ProjectSpecific\MarketDataHistoryRepository;
use App\Repository\ProjectSpecific\MarketDataRepository;

class MarketDataPrice
{
    public function findMarketPrice(\DateTimeInterface $date, MarketData $marketData)
    {
        $history = $this->marketDataHistoryRepository->findOneBy([
            'security' => $marketData,
            'date' => $date
        ]);
        if ($history) {
            return $history;
        }
        else{
            $previousPrice = $this->marketDataHistoryRepository->findPricePrevious($marketData,$date);
            if($previousPrice){
                return $previousPrice[0]->getMarketPrice();
            }

        }

        return null;
    }
    public function findReal(\DateTimeInterface $date, MarketData $marketData)
    {
        $history = $this->marketDataHistoryRepository->findOneBy([
            'security' => $marketData,
            'date' => $date
        ]);
        if ($history) {
            return true;
        }
        else{
            return false;
        }
    }

    public function __construct(InvestmentsRepository $investmentsRepository, MarketDataHistoryRepository $marketDataHistoryRepository, MarketDataRepository $marketDataRepository)
    {
        $this->investmentRepository = $investmentsRepository;
        $this->marketDataHistoryRepository = $marketDataHistoryRepository;
    }
}