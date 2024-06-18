<?php


namespace App\Services\Project_Specific;


use App\Repository\Project_Specific\UkDayCalendarRepository;

class CountDaysByCountry
{
    public function calculateDays($country, $startDate, $endDate)
    {
        $days = $this->ukDayCalendarRepository->findBy([
            'locationAtMidnight' => $country,
        ]);
        $count = 0;
        foreach($days as $day){
            if($day->getDate()>=$startDate && $day->getDate()<=$endDate){
                $count++;
            }
        }

        return $count;

    }


    public function __construct(UkDayCalendarRepository $ukDayCalendarRepository)
    {
        $this->ukDayCalendarRepository = $ukDayCalendarRepository;
    }
}