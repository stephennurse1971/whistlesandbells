<?php


namespace App\Services\ProjectSpecific;


use App\Repository\ProjectSpecific\ToDoListItemsRepository;

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

    public function calculatePendingTopPriorityItems($project)
    {
        $items = $this->toDoListItemsRepository->findBy([
            'project' => $project,
            'status'=>'Pending',
            'immediatePriority'=>'Top Priority'
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