<?php

namespace App\Controller;

use App\Entity\FileAttachments;
use App\Form\FileAttachmentsType;
use App\Repository\FileAttachmentsRepository;
use App\Repository\StaticTextRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/fileattachments")
 */
class FileAttachmentsController extends AbstractController
{
    /**
     * @Route("/", name="/admin/fileattachments/index", methods={"GET"})
     */
    public function index(FileAttachmentsRepository $fileAttachmentsRepository, StaticTextRepository $staticTextRepository): Response
    {
        return $this->render('file_attachments/index.html.twig', [
            'file_attachments' => $fileAttachmentsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/show/attachment/{id}/{filename}", name="show_attachment")
     */
    public function showAttachment(string $filename, int $id, FileAttachmentsRepository $fileAttachmentsRepository, StaticTextRepository $staticTextRepository)
    {
        $filepath = $this->getParameter('garmin_attachments_directory') . "/" . $filename;
        if(file_exists($filepath)){
            return $this->file($filepath, 'sample.pdf', ResponseHeaderBag::DISPOSITION_INLINE);
        }
       else{
           return new Response("file does not exist");
       }
    }

    /**
     * @Route("/new", name="file_attachments_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileAttachmentsRepository $fileAttachmentsRepository, StaticTextRepository $staticTextRepository): Response
    {
        $fileAttachment = new FileAttachments();
        $form = $this->createForm(FileAttachmentsType::class,$fileAttachment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attachments = $form['attachments']->getData();
            if ($attachments) {
                $files_name = [];
                $attachment_directory = $this->getParameter('file_attachments_directory');
                foreach ($attachments as $attachment) {
                    $fileName = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
                    $file_extension = $attachment->guessExtension();
                    $newFileName = $fileName . "." . $file_extension;
                    $attachment->move($attachment_directory, $newFileName);
                    $files_name[] = $newFileName;
                }
            }
//            $fileAttachment->setAttachments($files_name);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fileAttachment);
            $entityManager->flush();
            return $this->redirectToRoute('/admin/fileattachments/index');
        }

        return $this->render('file_attachments/new.html.twig', [
            'file_attachments' => $fileAttachment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="file_attachments_show", methods={"GET"})
     */
    public function show(FileAttachmentsRepository $fileAttachmentsRepository, StaticTextRepository $staticTextRepository): Response
    {
        return $this->render('file_attachments/show.html.twig', [
            'file_attachments' => $chaveyDown,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="file_attachments_edit", methods={"GET","POST"})
     */
    public function edit(int $id, Request $request, FileAttachments $chaveyDown): Response
    {
        $form = $this->createForm(FileAttachmentsType::class, $chaveyDown, ['id' => $id]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clearAttachment = $form['clearAttachment']->getData();
            if ($clearAttachment) {
                $chaveyDown->setAttachments(null);
            }
            $attachments = $form['attachments']->getData();
            if ($attachments) {
                $files_name = [];
                $count = 1;
                $attachment_directory = $this->getParameter('file_attachments_directory');
                foreach ($attachments as $attachment) {
                    $fileName = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
                    $file_extension = $attachment->guessExtension();
                    $newFileName = $fileName . "." . $file_extension;
                    $attachment->move($attachment_directory, $newFileName);
                    $files_name[] = $newFileName;

                }
                $chaveyDown->setAttachments($files_name);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('/admin/fileattachments/index');
        }

        return $this->render('file_attachments/edit.html.twig', [
            'file_attachments' => $chaveyDown,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/{id}", name="file_attachments_delete", methods={"POST"})
     */
    public function delete(Request $request, FileAttachments $fileAttachments): Response
    {
        if ($this->isCsrfTokenValid('delete' . $fileAttachments->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fileAttachments);
            $entityManager->flush();
        }
        return $this->redirectToRoute('/admin/fileattachments/index');
    }
}
