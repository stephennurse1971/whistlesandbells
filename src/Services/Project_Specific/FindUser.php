<?php

namespace App\Services\Project_Specific;

use App\Repository\Project_Specific\UserRepository;

class FindUser
{
  public function getUser(int $id){
      $user = $this->userRepository->find($id);
      if($user){
          return $user;
      }
     return null;
  }
  public function checkConflict(){

      $users = $this->userRepository->findAll();
      foreach($users as $user){
          if($user->getEntryConflict()=="Conflict"){
             return true;
          }
      }
      return false;
  }
  public function __construct(UserRepository $userRepository){
      $this->userRepository = $userRepository;
  }
}