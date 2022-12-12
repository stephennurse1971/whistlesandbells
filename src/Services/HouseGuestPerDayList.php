<?php


namespace App\Services;


use App\Repository\HouseGuestsRepository;

class HouseGuestPerDayList
{
    public function guestList()
    {
        $guests = $this->guestsRepository->findAll();
        $per_day_guests_list = [];

        foreach ($guests as $list)
        {
            $date = $list->getDateArrival();
            //$date_modifier = $list->getDateArrival();
            while($date <= $list->getDateDeparture())
            {
                $per_day_guests_list[]=[
                    'date'=>$date->format('d-m-y'),
                    'guest'=> $list->getGuestName(),
                    'notes'=>$list->getNotes()
                ];
                $date = $date->modify("+1 day");
            }
        }
        return $per_day_guests_list;
    }
    public function __construct(HouseGuestsRepository $houseGuestsRepository)
    {
        $this->guestsRepository = $houseGuestsRepository;
    }
}
