<?php

namespace App\Services;

use App\Repository\InterestsRepository;

class WebPages
{
    public function getWebPages()
    {
        return $this->interestsRepository->findBy([
            'isActive'=>1,
        ]);
    }

    public function getWebPagesInterests()
    {
        $interests = $this->interestsRepository->findBy([
            'isActive'=>1,
            'menu'=>'Interests'
        ]);
        usort($interests,function($first,$second){
            return $first->getRanking() > $second->getRanking();
        });

        return $interests;

    }
    public function __construct(InterestsRepository $interestsRepository)
    {
        $this->interestsRepository = $interestsRepository;
    }
}