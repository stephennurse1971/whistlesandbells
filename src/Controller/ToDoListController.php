<?php

namespace App\Controller;

use App\Entity\Photos;
use App\Entity\ToDoList;
use App\Form\ToDoListType;
use App\Repository\ToDoListRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/todolist")
 * @IsGranted("ROLE_USER")
 *
 */
class ToDoListController extends AbstractController
{
    /**
     * @Route("/", name="to_do_list_index", methods={"GET"})
     */
    public function index(ToDoListRepository $toDoListRepository): Response
    {
        return $this->render('to_do_list/index.html.twig', [
            'to_do_lists' => $toDoListRepository->findAll(),
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
            if($form->get('file')->getData()) {
                $files = $form->get('file')->getData();
                $file_names = [];
                foreach($files as $file){
                    $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $newFilename = $originalFilename . "." . $file->guessExtension();
                    $file->move(
                        $this->getParameter('files_upload_default_directory'),
                        $newFilename
                    );
                    $file_names[]=$newFilename;
                }
                $toDoList->setFile($file_names);
            }
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
     * @Route("/{id}", name="to_do_list_show", methods={"GET"})
     */
    public function show(ToDoList $toDoList): Response
    {
        return $this->render('to_do_list/show.html.twig', [
            'to_do_list' => $toDoList,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="to_do_list_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ToDoList $toDoList): Response
    {
        $form = $this->createForm(ToDoListType::class, $toDoList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('file')->getData()) {
                $files = $form->get('file')->getData();
                $file_names = [];
                foreach($files as $file){
                    $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $newFilename = $originalFilename . "." . $file->guessExtension();
                    $file->move(
                        $this->getParameter('files_upload_default_directory'),
                        $newFilename
                    );
                    $file_names[]=$newFilename;
                }
                $toDoList->setFile($file_names);
            }
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
        return new BinaryFileResponse($publicResourcesFolderPath."/".$fileName);

    }



    /**
     * @Route("/{id}", name="to_do_list_delete", methods={"POST"})
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
