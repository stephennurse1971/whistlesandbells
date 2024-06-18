<?php

namespace App\Services\Project_Specific;

use App\Entity\Project_Specific\User;
use App\Repository\Project_Specific\HouseGuestsRepository;
use App\Repository\Project_Specific\UserRepository;

class UserIsHouseGuest
{
  public function userExist(User $user){

      $guest_list_by_user = $this->houseGuestsRepository->findBy(['guestName'=>$user]);
      if($guest_list_by_user){
          return true;
      }
      return false;
  }
  public function __construct(HouseGuestsRepository $houseGuestsRepository,UserRepository $userRepository){
      $this->houseGuestsRepository = $houseGuestsRepository;

  }
}