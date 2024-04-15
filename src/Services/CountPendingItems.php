<?php


namespace App\Services;


use App\Repository\ToDoListItemsRepository;

class CountPendingItems
{
    public function calculatePendingItems($project)
    {
        $items = $this->toDoListItemsRepository->findBy([
            'project' => $project,
            'status'=>'Pending'
        ]);
        if ($items) {
            return count($items);
        }
        return 0;

    }


    public function __construct(ToDoListItemsRepository $toDoListItemsRepository)
    {
        $this->toDoListItemsRepository = $toDoListItemsRepository;
    }
}