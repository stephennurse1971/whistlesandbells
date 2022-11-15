<?php

namespace App\Controller;

use App\Entity\GarminFiles;
use App\Entity\Introduction;
use App\Form\GarminFilesType;
use App\Repository\GarminFilesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/garmin/files")
 */
class GarminFilesController extends AbstractController
{
    /**
     * @Route("/", name="garmin_files_index", methods={"GET"})
     */
    public function index(GarminFilesRepository $garminFilesRepository): Response
    {
        return $this->render('garmin_files/index.html.twig', [
            'garmin_files' => $garminFilesRepository->findAll(),
        ]);
    }




    /**
     * @Route("/new", name="garmin_files_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger): Response
    {
        $garminFile = new GarminFiles();
        $form = $this->createForm(GarminFilesType::class, $garminFile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attachment = $form->get('gpxFile')->getData();
            if ($attachment) {
                $originalFilename = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $attachment->guessExtension();
                try {
                    $attachment->move(
                        $this->getParameter('garmin_attachments_directory'),
                        $newFilename
                    );
                    $garminFile->setGpxFile($newFilename);
                } catch (FileException $e) {
                    die('Import failed');
                }
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($garminFile);
            $entityManager->flush();
            return $this->redirectToRoute('garmin_files_index');
        }
        return $this->render('garmin_files/new.html.twig', [
            'garmin_file' => $garminFile,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="garmin_files_show", methods={"GET"})
     */
    public function show(GarminFiles $garminFile): Response
    {
        return $this->render('garmin_files/show.html.twig', [
            'garmin_file' => $garminFile,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="garmin_files_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, GarminFiles $garminFile, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(GarminFilesType::class, $garminFile);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $attachment = $form->get('gpxFile')->getData();
            if ($attachment) {
                $originalFilename = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $attachment->guessExtension();
                try {
                    $attachment->move(
                        $this->getParameter('garmin_attachments_directory'),
                        $newFilename
                    );
                    $garminFile->setGpxFile($newFilename);
                } catch (FileException $e) {
                    die('Import failed');
                }
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($garminFile);
            $entityManager->flush();
            return $this->redirectToRoute('garmin_files_index');
        }

        return $this->render('garmin_files/edit.html.twig', [
            'garmin_file' => $garminFile,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="garmin_files_delete", methods={"POST"})
     */
    public function delete(Request $request, GarminFiles $garminFile): Response
    {
        if ($this->isCsrfTokenValid('delete'.$garminFile->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($garminFile);
            $entityManager->flush();
        }
        return $this->redirectToRoute('garmin_files_index');
    }


    /**
     * @Route("/{id}/delete/attachment", name="garmin_files_delete_attachment")
     */
    public function deleteAttachment(Request $request, GarminFiles $garminFiles,EntityManagerInterface $entityManager)
    {
        $referer = $request->headers->get('referer');
        $garminFiles->setGpxFile('');
        $entityManager->flush();
        return $this->redirect($referer);
    }

}
