<?php

namespace App\Controller;

use App\Entity\ChaveyDown;
use App\Form\ChaveyDownType;
use App\Repository\ChaveyDownRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/chavey/down")
 */
class ChaveyDownController extends AbstractController
{
    /**
     * @Route("/", name="chavey_down_index", methods={"GET"})
     */
    public function index(ChaveyDownRepository $chaveyDownRepository): Response
    {
        return $this->render('chavey_down/index.html.twig', [
            'chavey_downs' => $chaveyDownRepository->findAll(),
        ]);
    }

    /**
     * @Route("show/attachment/{id}/{filename}", name="show_attachment")
     */
    public function showAttachment(string $filename,int $id,ChaveyDownRepository $chaveyDownRepository)
    {


        $filepath = $this->getParameter('attachments_directory')."/".$filename;
//
//
//        header('Content-Disposition: inline; filename="' . $filename . '"');
//       return  new BinaryFileResponse($filepath);
//        header('Content-type: application/pdf');
//
//        header('Content-Disposition: inline; filename="' . $filepath . '"');
//
//        header('Content-Transfer-Encoding: binary');
//
//        header('Accept-Ranges: bytes');
//
//// Read the file
//        @readfile($filepath);
       // return new Response(null);
        return $this->file($filepath, 'sample.pdf', ResponseHeaderBag::DISPOSITION_INLINE);

//        return new Response($filepath, 200, [
//            'Content-Type' => 'application/pdf',
//            'Content-Disposition' => 'inline; filename="file.pdf"'
//        ]);

    }

    /**
     * @Route("/new", name="chavey_down_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $chaveyDown = new ChaveyDown();
        $form = $this->createForm(ChaveyDownType::class, $chaveyDown);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attachments = $form['attachments']->getData();


            if($attachments)
            {
                $files_name=[];

                $attachment_directory = $this->getParameter('attachments_directory');
                foreach($attachments as $attachment) {
                    $fileName = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
                    $file_extension = $attachment->guessExtension();
                    $newFileName = $fileName . "." . $file_extension;
                    $attachment->move($attachment_directory, $newFileName);

                    $files_name[] = $newFileName;
                }
           }
                $chaveyDown->setAttachments($files_name);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($chaveyDown);
            $entityManager->flush();

            return $this->redirectToRoute('chavey_down_index');
        }

        return $this->render('chavey_down/new.html.twig', [
            'chavey_down' => $chaveyDown,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="chavey_down_show", methods={"GET"})
     */
    public function show(ChaveyDown $chaveyDown): Response
    {
        return $this->render('chavey_down/show.html.twig', [
            'chavey_down' => $chaveyDown,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="chavey_down_edit", methods={"GET","POST"})
     */
    public function edit(int $id,Request $request, ChaveyDown $chaveyDown): Response
    {
        $form = $this->createForm(ChaveyDownType::class, $chaveyDown,['id'=>$id]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attachments = $form['attachments']->getData();
            if($attachments)
            {
                $files_name=[];
                $count = 1;
                $attachment_directory = $this->getParameter('attachments_directory');
                foreach($attachments as $attachment) {
                    $fileName = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
                    $file_extension = $attachment->guessExtension();
                    $newFileName = $fileName . "." . $file_extension;
                    $attachment->move($attachment_directory, $newFileName);
                    $files_name[] = $newFileName;

                }
                $chaveyDown->setAttachments($files_name);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('chavey_down_index');
        }

        return $this->render('chavey_down/edit.html.twig', [
            'chavey_down' => $chaveyDown,
            'form' => $form->createView(),

        ]);
    }


    /**
     * @Route("/{id}/{comment}/editComment", name="chavey_down_edit_comment", methods={"GET","POST"})
     */
    public function editComment(string $comment,Request $request, ChaveyDown $chaveyDown,EntityManagerInterface $entityManager): Response
    {
      $chaveyDown->setHmrcComments($comment);
      $entityManager->flush();
     return $this->redirectToRoute('chavey_down_index');
    }
    


    /**
     * @Route("/{id}", name="chavey_down_delete", methods={"POST"})
     */
    public function delete(Request $request, ChaveyDown $chaveyDown): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chaveyDown->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($chaveyDown);
            $entityManager->flush();
        }

        return $this->redirectToRoute('chavey_down_index');
    }
}
