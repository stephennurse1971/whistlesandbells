<?php


namespace App\Services;


use App\Entity\MarketData;
use App\Repository\InvestmentsRepository;
use App\Repository\MarketDataHistoryRepository;
use App\Repository\MarketDataRepository;

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