<?php


namespace App\Services;


use App\Repository\StaticTextRepository;

class StaticText
{
  public function content()
  {
    $all_static_text = $this->staticTextRepository->findAll();
    $single_static_text = $all_static_text[0];
    return $single_static_text;
  }
  public function __construct(StaticTextRepository $staticTextRepository)
  {
     $this->staticTextRepository = $staticTextRepository;
  }

}