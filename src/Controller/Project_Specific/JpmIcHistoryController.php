<?php

namespace App\Controller\Project_Specific;

use App\Controller\FileException;
use App\Entity\Project_Specific\JpmIcHistory;
use App\Form\Project_Specific\JpmIcHistoryType;
use App\Repository\Project_Specific\JpmIcHistoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/admin/jpmichistory")
 * @IsGranted("ROLE_ACCOUNTANT")
 */
class JpmIcHistoryController extends AbstractController
{
    /**
     * @Route("/index", name="jpm_ic_history_index", methods={"GET"})
     */
    public function index(JpmIcHistoryRepository $jpmIcHistoryRepository): Response
    {
        return $this->render('jpm_ic_history/index.html.twig', [
            'jpm_ic_histories' => $jpmIcHistoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="jpm_ic_history_new", methods={"GET","POST"})
     */
    public function new(Request $request,SluggerInterface $slugger): Response
    {
        $jpmIcHistory = new JpmIcHistory();
        $form = $this->createForm(JpmIcHistoryType::class, $jpmIcHistory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attachment = $form->get('attachmentICFile')->getData();
            if ($attachment) {
                $originalFilename = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.pdf';
                try {
                    $attachment->move(
                        $this->getParameter('jpm_ic_history_directory'),
                        $newFilename
                    );
                    $jpmIcHistory->setAttachmentICFile($newFilename);
                } catch (FileException $e) {
                    die('Import failed');
                }
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($jpmIcHistory);
            $entityManager->flush();

            return $this->redirectToRoute('jpm_ic_history_index');
        }

        return $this->render('jpm_ic_history/new.html.twig', [
            'jpm_ic_history' => $jpmIcHistory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="jpm_ic_history_show", methods={"GET"})
     */
    public function show(JpmIcHistory $jpmIcHistory): Response
    {
        return $this->render('jpm_ic_history/show.html.twig', [
            'jpm_ic_history' => $jpmIcHistory,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="jpm_ic_history_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, JpmIcHistory $jpmIcHistory,SluggerInterface $slugger): Response
    {
        $form = $this->createForm(JpmIcHistoryType::class, $jpmIcHistory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attachment = $form->get('attachmentICFile')->getData();
            if ($attachment) {
                $originalFilename = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.pdf';
                try {
                    $attachment->move(
                        $this->getParameter('jpm_ic_history_directory'),
                        $newFilename
                    );
                    $jpmIcHistory->setAttachmentICFile($newFilename);
                } catch (FileException $e) {
                    die('Import failed');
                }
            }


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('jpm_ic_history_index');
        }

        return $this->render('jpm_ic_history/edit.html.twig', [
            'jpm_ic_history' => $jpmIcHistory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="jpm_ic_history_delete", methods={"POST"})
     */
    public function delete(Request $request, JpmIcHistory $jpmIcHistory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$jpmIcHistory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($jpmIcHistory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('jpm_ic_history_index');
    }

    /**
     * @Route("/delete/attachment/{id}", name="delete_ic_history_attachment")
     */
    public function deleteAttachment(Request $request,JpmIcHistory $jpmIcHistory , EntityManagerInterface $entityManager)
    {
        $referer = $request->headers->get('referer');
        $jpmIcHistory->setAttachmentICFile('');
        $entityManager->flush();
        return $this->redirect($referer);
    }


    /**
     * @Route("/show/attachment/{id}/{filename}", name="show_jpm_ic_attachment")
     */
    public function showAttachment(string $filename, int $id, JpmIcHistoryRepository $jpmIcHistoryRepository)
    {
        $filepath = $this->getParameter('jpm_ic_history_directory') . "/" . $filename;
        if (file_exists($filepath)) {
            return $this->file($filepath, 'sample.pdf', ResponseHeaderBag::DISPOSITION_INLINE);
        } else {
            return new Response("file does not exist");
        }
    }

}
