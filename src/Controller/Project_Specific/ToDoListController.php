<?php

namespace App\Controller\Project_Specific;

use App\Entity\Project_Specific\ToDoList;
use App\Form\Project_Specific\ToDoListType;
use App\Repository\Project_Specific\ToDoListItemsRepository;
use App\Repository\Project_Specific\ToDoListRepository;
use App\Services\Project_Specific\CountPendingItems;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/todolist")
 * @IsGranted("ROLE_IT")
 *
 */
class ToDoListController extends AbstractController
{
    /**
     * @Route("/index/{status}/{project}", name="to_do_list_index", methods={"GET"},defaults={"status"="Pending", "project"="All"})
     */
    public function index(ToDoListRepository $toDoListRepository, $status, $project, ToDoListItemsRepository $toDoListItemsRepository, CountPendingItems $countPendingItems): Response
    {
        $projects = $toDoListRepository->findAll();
        $all_projects = $toDoListRepository->findAll();
        $project_title = 'All';
        if ($project == "Top Priority") {
            $project_title = "Top Priorities";
            $projects = [];
            foreach ($all_projects as $single_project) {
                if ($countPendingItems->calculatePendingTopPriorityItems($single_project) > 0) {
                    $projects[] = $single_project;
                }
            }
            $to_do_lists_items = $toDoListItemsRepository->findBy([
                'immediatePriority' => 'Top Priority'
            ]);
        }
        if ($project != "All" and $project != "Top Priority") {
            $project_title = $project;
            $projects = $toDoListRepository->findBy([
                'project' => $project
            ]);
            $to_do_lists_items = $toDoListItemsRepository->findAll();
        }
        if ($project == "All") {
            $project_title = $project;
            $projects = $all_projects;
            $to_do_lists_items = $toDoListItemsRepository->findAll();
        }
        usort($projects, function ($first, $second) {
            return strcmp($first->getProject(), $second->getProject());
        });
        return $this->render('to_do_list/index.html.twig', [
            'status' => $status,
            'project_title' => $project_title,
            'to_do_lists' => $projects,
            'to_do_lists_items' => $to_do_lists_items,
        ]);
    }

    /**
     * @Route("/new", name="to_do_list_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $toDoList = new ToDoList();
        $form = $this->createForm(ToDoListType::class, $toDoList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($toDoList);
            $entityManager->flush();
            return $this->redirectToRoute('to_do_list_index');
        }

        return $this->render('to_do_list/new.html.twig', [
            'to_do_list' => $toDoList,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="to_do_list_show", methods={"GET"})
     */
    public function show(ToDoList $toDoList): Response
    {
        return $this->render('to_do_list/show.html.twig', [
            'to_do_list' => $toDoList,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="to_do_list_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ToDoList $toDoList): Response
    {
        $form = $this->createForm(ToDoListType::class, $toDoList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($toDoList);
            $entityManager->flush();
            return $this->redirectToRoute('to_do_list_index');
        }

        return $this->render('to_do_list/edit.html.twig', [
            'to_do_list' => $toDoList,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/view/file/{fileName}", name="to_do_list_viewfile", methods={"GET"})
     */
    public function toDoListFileLaunch(string $fileName): Response
    {
        $publicResourcesFolderPath = $this->getParameter('files_upload_default_directory');
        return new BinaryFileResponse($publicResourcesFolderPath . "/" . $fileName);
    }


    /**
     * @Route("/delete/{id}", name="to_do_list_delete", methods={"POST"})
     */
    public function delete(Request $request, ToDoList $toDoList): Response
    {
        if ($this->isCsrfTokenValid('delete' . $toDoList->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($toDoList);
            $entityManager->flush();
        }
        return $this->redirectToRoute('to_do_list_index');
    }
    
}
