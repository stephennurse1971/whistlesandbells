<?php

namespace App\Services;

use App\Repository\UserRepository;

class FindUser
{
  public function getUser(int $id){
      $user = $this->userRepository->find($id);
      if($user){
          return $user;
      }
     return null;
  }
  public function __construct(UserRepository $userRepository){
      $this->userRepository = $userRepository;
  }
}