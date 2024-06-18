<?php


namespace App\Services\Project_Specific;
use App\Repository\Project_Specific\HouseGuestsRepository;

class HouseGuestPerDayList
{
    public function guestList()
    {
        $guests = $this->guestsRepository->findAll();
        $per_day_guests_list = [];

        foreach ($guests as $list)
        {
            $date = new \DateTime($list->getDateArrival()->format('y-m-d'));
           // $start_date = new \DateTime($list->getDateArrival()->format('y-m-d'));
            $start_date = $list->getDateArrival();
            $end_date = $list->getDateDeparture();

            while($date <= $list->getDateDeparture())
            {
                if($date == $start_date){
                    $arrival_date = $start_date->format('d-m-y');
                    $departure_date = null;
                }

                elseif($date == $end_date){
                    $arrival_date = null;
                    $departure_date = $end_date->format('d-m-y');
                }
                else{
                    $arrival_date = null;
                    $departure_date = null;
                }

                $per_day_guests_list[]=[
                    'date'=>$date->format('d-m-y'),
                    'arrivalDate'=> $arrival_date,
                    'departureDate'=>$departure_date,
                    'guest'=> $list->getGuestName(),
                    'notes'=>$list->getNotes(),
                    'arrivalNotes'=>$list->getArrivalNotes(),
                    'departureNotes'=>$list->getDepartureNotes(),
                    'id'=>$list->getId(),
                    'referenceInformation'=>$list->getReferenceInformation()
                ];
               $date =  $date->modify("+1 day");
            }

        }
        return $per_day_guests_list;

    }
    public function __construct(HouseGuestsRepository $houseGuestsRepository)
    {
        $this->guestsRepository = $houseGuestsRepository;
    }
}
