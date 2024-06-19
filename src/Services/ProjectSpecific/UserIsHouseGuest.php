<?php

namespace App\Services\ProjectSpecific;

use App\Entity\ProjectSpecific\User;
use App\Repository\ProjectSpecific\HouseGuestsRepository;
use App\Repository\ProjectSpecific\UserRepository;

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