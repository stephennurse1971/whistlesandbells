<?php


namespace App\Services\ProjectSpecific;

use App\Repository\ProjectSpecific\UkDayCalendarRepository;

class LocationByDate
{
    public function priorDayLocation($date)
    {
        $location=[];
        $calendar_entry = $this->ukDayCalendarRepository->findOneBy([
            'date' => $date->modify("-1 day"),
        ]);
        if($calendar_entry){
            if($calendar_entry->getLocationAtMidnight()){
                $location=$calendar_entry->getLocationAtMidnight()->getCountry();
                return $location;
            }

        }

            return null;
    }

    public function __construct(UkDayCalendarRepository $ukDayCalendarRepository)
    {
        $this->ukDayCalendarRepository = $ukDayCalendarRepository;
    }
}