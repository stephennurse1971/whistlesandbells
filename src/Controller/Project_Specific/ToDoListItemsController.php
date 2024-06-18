<?php

namespace App\Controller\Project_Specific;

use App\Entity\Project_Specific\ToDoListItems;
use App\Form\Project_Specific\ToDoListItemsType;
use App\Repository\Project_Specific\ToDoListItemsRepository;
use App\Repository\Project_Specific\ToDoListRepository;
use App\Repository\StaticTextRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/todolist_items")
 */
class ToDoListItemsController extends AbstractController
{
    /**
     * @Route("/index", name="to_do_list_items_index", methods={"GET"})
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
    public function new(Request $request, Security $security, $project, ToDoListItemsRepository $toDoListItemsRepository, ToDoListRepository $doListRepository, EntityManagerInterface $entityManager): Response
    {
        $all_projects = $doListRepository->findAll();
        $access_projects = [];
        foreach ($all_projects as $project) {
            if (
                in_array('ROLE_ADMIN', $security->getUser()->getRoles())
                ||
                in_array($security->getUser(), $project->getAccessTo()->toArray())) {
                $access_projects[] = $project;
            }
        }
        usort($access_projects, function ($first, $second) {
            return strcmp($first->getProject(), $second->getProject());
        });
        $toDoList = $doListRepository->findOneBy(['project' => $project]);
        $toDoListItem = new ToDoListItems();
        $form = $this->createForm(ToDoListItemsType::class, $toDoListItem, ['project' => $toDoList, 'access_projects' => $access_projects]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $toDoListItemsRepository->add($toDoListItem);
            $attachment = $form['attachment']->getData();
            if ($attachment) {
                $originalFilename = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename;
                $attachment->move(
                    $this->getParameter('todolist_items_attachments_directory'),
                    $newFilename
                );
                $toDoListItem->setAttachment($newFilename);
                $entityManager->persist($toDoListItem);
                $entityManager->flush();
            }
            return $this->redirectToRoute('to_do_list_index', ['status' => 'Pending', 'project' => 'All'], Response::HTTP_SEE_OTHER);
        }

        return $this->render('to_do_list_items/new.html.twig', [
            'to_do_list_item' => $toDoListItem,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="to_do_list_items_show", methods={"GET"})
     */
    public function show(ToDoListItems $toDoListItem): Response
    {
        return $this->render('to_do_list_items/show.html.twig', [
            'to_do_list_item' => $toDoListItem,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="to_do_list_items_edit", methods={"GET", "POST"})
     */
    public function edit(Security $security, Request $request, ToDoListItems $toDoListItem, ToDoListItemsRepository $toDoListItemsRepository, ToDoListRepository $toDoListRepository, EntityManagerInterface $entityManager): Response
    {
        $all_projects = $toDoListRepository->findAll();
        $access_projects = [];
        foreach ($all_projects as $project) {
            if (in_array($security->getUser(), $project->getAccessTo()->toArray())) {
                $access_projects[] = $project;
            }
        }
        usort($access_projects, function ($first, $second) {
            return strcmp($first->getProject(), $second->getProject());
        });

        $form = $this->createForm(ToDoListItemsType::class, $toDoListItem, ['project' => $toDoListItem->getProject(), 'access_projects' => $access_projects]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $toDoListItemsRepository->add($toDoListItem);

            $attachment = $form['attachment']->getData();
            if ($attachment) {
                $originalFilename = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename;
                $attachment->move(
                    $this->getParameter('todolist_items_attachments_directory'),
                    $newFilename
                );
                $toDoListItem->setAttachment($newFilename);
                $entityManager->persist($toDoListItem);
                $entityManager->flush();
            }

            return $this->redirectToRoute('to_do_list_index', ['project' => 'All', 'status' => 'All'], Response::HTTP_SEE_OTHER);
        }
        return $this->render('to_do_list_items/edit.html.twig', ['to_do_list_item' => $toDoListItem,
            'form' => $form->createView(),]);
    }

    /**
     * @Route("/update_priority_with_rank", name="update_priority_with_rank", methods={"GET", "POST"})
     */
    public function updatePriorityWithRank(ToDoListRepository $toDoListRepository, ToDoListItemsRepository $toDoListItemsRepository, Request $request, EntityManagerInterface $manager): Response
    {
        foreach ($toDoListRepository->findAll() as $toDoList) {
            $toDoListByProject = $toDoListItemsRepository->findBy(['project' => $toDoList, 'status' => 'Complete']);
            if ($toDoListByProject) {
                $rankingContainer = [];
                foreach ($toDoListByProject as $item) {
                    $rankingContainer[] = ['id' => $item->getId(), 'priority' => $item->getPriority()];
                }
                array_multisort(array_column($rankingContainer, 'priority'), SORT_ASC, $rankingContainer);
                $minRank = 1;

                foreach ($rankingContainer as $sortedItem) {
                    $getToDoList = $toDoListItemsRepository->find($sortedItem['id']);
                    $getToDoList->setPriority($minRank);
                    $manager->flush();
                    $minRank = $minRank + 1;
                }
            }

            $toDoListByProject = $toDoListItemsRepository->findBy(['project' => $toDoList, 'status' => 'Pending']);
            if ($toDoListByProject) {
                $rankingContainer = [];
                foreach ($toDoListByProject as $item) {
                    $rankingContainer[] = ['id' => $item->getId(), 'priority' => $item->getPriority()];
                }
                array_multisort(array_column($rankingContainer, 'priority'), SORT_ASC, $rankingContainer);
                $minRank = 1;

                foreach ($rankingContainer as $sortedItem) {
                    $getToDoList = $toDoListItemsRepository->find($sortedItem['id']);
                    $getToDoList->setPriority($minRank);
                    $manager->flush();
                    $minRank = $minRank + 1;
                }
            }

            $toDoListByProject = $toDoListItemsRepository->findBy(['project' => $toDoList, 'status' => 'Blocked']);
            if ($toDoListByProject) {
                $rankingContainer = [];
                foreach ($toDoListByProject as $item) {
                    $rankingContainer[] = ['id' => $item->getId(), 'priority' => $item->getPriority()];
                }
                array_multisort(array_column($rankingContainer, 'priority'), SORT_ASC, $rankingContainer);
                $minRank = 1;

                foreach ($rankingContainer as $sortedItem) {
                    $getToDoList = $toDoListItemsRepository->find($sortedItem['id']);
                    $getToDoList->setPriority($minRank);
                    $manager->flush();
                    $minRank = $minRank + 1;
                }
            }
        }
        $referer = $request->headers->get('Referer');
        return $this->redirect($referer);
    }


    /**
     * @Route("/change_status/{status}/{id}", name="to_do_list_items_change_status", methods={"GET", "POST"})
     */
    public
    function changeStatus(Request $request, $status, ToDoListItems $toDoListItem, EntityManagerInterface $manager): Response
    {
        $referer = $request->headers->get('Referer');
        $toDoListItem->setStatus($status);
        if ($status == "Complete") {
            $toDoListItem->setPriority('99');
        }
        $manager->flush();
        return $this->redirect($referer);
    }


    /**
     * @Route("/copy/{id}/", name="to_do_list_items_copy", methods={"GET", "POST"})
     */
    public
    function copy(Request $request, $id, ToDoListItemsRepository $toDoListItemsRepository, EntityManagerInterface $manager): Response
    {
        $referer = $request->headers->get('Referer');
        $itemToCopy = $toDoListItemsRepository->find($id);
        $project = $itemToCopy->getProject();
        $priority = $itemToCopy->getPriority();
        $task = $itemToCopy->getTask();
        $status = $itemToCopy->getStatus();

        $newCopy = new ToDoListItems();
        $newCopy->setProject($project);
        $newCopy->setPriority($priority);
        $newCopy->setTask($task);
        $newCopy->setStatus($status);
        $manager->persist($newCopy);
        $manager->flush();
        return $this->redirect($referer);
    }


    /**
     * @Route("/change_priority/{change}/{id}", name="to_do_list_items_change_priority", methods={"GET", "POST"})
     */
    public
    function changePriority(Request $request, $change, ToDoListItems $toDoListItem, EntityManagerInterface $manager): Response
    {
        $referer = $request->headers->get('Referer');
        $currentPriority = $toDoListItem->getPriority();
        if ($change == "Up") {
            $newPriority = $currentPriority - 0.99999;
        }
        if ($change == "Down") {
            $newPriority = $currentPriority + 1.00001;
        }
        $toDoListItem->setPriority($newPriority);
        $manager->flush();
        return $this->redirect($referer);
    }

    /**
     * @Route("/delete/{id}", name="to_do_list_items_delete", methods={"POST"})
     */
    public
    function delete(Request $request, ToDoListItems $toDoListItem, ToDoListItemsRepository $toDoListItemsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $toDoListItem->getId(), $request->request->get('_token'))) {
            $toDoListItemsRepository->remove($toDoListItem);
        }
        return $this->redirectToRoute('to_do_list_index', ['status' => 'Pending', 'project' => 'All'], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/show_attachment/{id}", name="show_attachment_to_do_list")
     */
    public function showAttachment(Request $request, $id, ToDoListItemsRepository $toDoListItemsRepository)
    {
        $filename =$toDoListItemsRepository->find($id)->getAttachment();
        $filepath = $this->getParameter('todolist_items_attachments_directory') . "/" . $filename;
        if (file_exists($filepath)) {
            $response = new BinaryFileResponse($filepath);
            //  $response->headers->set('Content-Type');
            $response->setContentDisposition(
                ResponseHeaderBag::DISPOSITION_INLINE, //use ResponseHeaderBag::DISPOSITION_ATTACHMENT to save as an attachment
                $filename
            );
            return $response;
        } else {
            return new Response("file does not exist");
        }
    }

    /**
     * @Route("/to_do_list_item/delete_attachment/{id}", name="to_do_list_item_delete_attachment")
     */
    public function deleteToDoListItemAttachment(Request $request, $id, ToDoListItemsRepository $toDoListItemsRepository, EntityManagerInterface $entityManager)
    {
        $referer = $request->headers->get('referer');
        $to_do_list_item = $toDoListItemsRepository->find($id);
        $to_do_list_item->setAttachment(null);
        $entityManager->flush();
        return $this->redirect($referer);
    }
}
