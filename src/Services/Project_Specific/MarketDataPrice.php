<?php


namespace App\Services\Project_Specific;


use App\Entity\Project_Specific\MarketData;
use App\Repository\Project_Specific\InvestmentsRepository;
use App\Repository\Project_Specific\MarketDataHistoryRepository;
use App\Repository\Project_Specific\MarketDataRepository;

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