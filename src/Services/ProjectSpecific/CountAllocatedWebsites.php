<?php


namespace App\Services\ProjectSpecific;


use App\Repository\ProjectSpecific\UsefulLinksRepository;

class CountAllocatedWebsites
{
    public function countAllocatedWebsites($category)
    {
        $items = $this->usefulLinksRepository->findBy([
            'category' => $category,
        ]);
        if ($items) {
            return count($items);
        }
        return 0;
    }



    public function __construct(UsefulLinksRepository $usefulLinksRepository)
    {
        $this->usefulLinksRepository = $usefulLinksRepository;
    }
}