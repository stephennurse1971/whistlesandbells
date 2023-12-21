<?php

namespace App\Controller;

use App\Entity\ToDoListItems;
use App\Form\ToDoListItemsType;
use App\Repository\ToDoListItemsRepository;
use App\Repository\ToDoListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/todolist_items")
 */
class ToDoListItemsController extends AbstractController
{
    /**
     * @Route("/", name="to_do_list_items_index", methods={"GET"})
     */
    public function index(ToDoListItemsRepository $toDoListItemsRepository): Response
    {
        return $this->render('to_do_list_items/index.html.twig', [
            'to_do_list_items' => $toDoListItemsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{project}", name="to_do_list_items_new", methods={"GET", "POST"})
     */
    public function new(Request $request, $project, ToDoListItemsRepository $toDoListItemsRepository, ToDoListRepository $doListRepository): Response
    {
        $todolist = $doListRepository->findBy(['project' => $project]);
        $toDoListItem = new ToDoListItems();
        $form = $this->createForm(ToDoListItemsType::class, $toDoListItem, ['project' => $todolist]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $toDoListItemsRepository->add($toDoListItem);
            return $this->redirectToRoute('to_do_list_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('to_do_list_items/new.html.twig', [
            'to_do_list_item' => $toDoListItem,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="to_do_list_items_show", methods={"GET"})
     */
    public function show(ToDoListItems $toDoListItem): Response
    {
        return $this->render('to_do_list_items/show.html.twig', [
            'to_do_list_item' => $toDoListItem,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="to_do_list_items_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ToDoListItems $toDoListItem, ToDoListItemsRepository $toDoListItemsRepository): Response
    {
        $form = $this->createForm(ToDoListItemsType::class, $toDoListItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $toDoListItemsRepository->add($toDoListItem);
            return $this->redirectToRoute('to_do_list_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('to_do_list_items/edit.html.twig', [
            'to_do_list_item' => $toDoListItem,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/change_status/{id}/{status}", name="to_do_list_items_change_status", methods={"GET", "POST"})
     */
    public function changeStatus(Request $request, $status, ToDoListItems $toDoListItem, EntityManagerInterface $manager): Response
    {
        $referer = $request->headers->get('Referer');
        $toDoListItem->setStatus($status);
        $manager->flush();
        return $this->redirect($referer);
    }

    /**
     * @Route("/change_priority/{id}/{change}", name="to_do_list_items_change_priority", methods={"GET", "POST"})
     */
    public function changePriority(Request $request, $change, ToDoListItems $toDoListItem, EntityManagerInterface $manager): Response
    {
        $referer = $request->headers->get('Referer');
        $currentPriority = $toDoListItem->getPriority();
        if ($change == "Up") {
            $newPriority = $currentPriority - 1;
        }
        if ($change == "Down") {
            $newPriority = $currentPriority + 1;
        }
        $toDoListItem->setPriority($newPriority);
        $manager->flush();
        return $this->redirect($referer);
    }

    /**
     * @Route("/{id}", name="to_do_list_items_delete", methods={"POST"})
     */
    public function delete(Request $request, ToDoListItems $toDoListItem, ToDoListItemsRepository $toDoListItemsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $toDoListItem->getId(), $request->request->get('_token'))) {
            $toDoListItemsRepository->remove($toDoListItem);
        }

        return $this->redirectToRoute('to_do_list_index', [], Response::HTTP_SEE_OTHER);
    }
}
