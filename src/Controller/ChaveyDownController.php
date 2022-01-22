<?php

namespace App\Controller;

use App\Entity\ChaveyDown;
use App\Form\ChaveyDownType;
use App\Repository\ChaveyDownRepository;
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
     * @Route("show/attachment/{id}", name="show_attachment")
     */
    public function showAttachment(int $id,ChaveyDownRepository $chaveyDownRepository)
    {
        $filename = $chaveyDownRepository->find($id)->getAttachments();

        $filepath = $this->getParameter('attachments_directory')."/".$filename;
//        $extension = pathinfo($filename, PATHINFO_EXTENSION);
//        $response = new Response();
//        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, $filename);
//        $response->headers->set('Content-Disposition', $disposition);
//
//        if($extension =='pdf')
//        {
//            $response->headers->set('Content-Type', 'application/pdf');
//        }
//        else{
//            $response->headers->set('Content-Type', 'image/png');
//        }
//        $response->setContent(file_get_contents($filepath));
//        $response = $this->render($filepath);
//        $response->headers->set('Content-Type', 'application/pdf');
//
//        return $response;


        header('Content-Disposition: inline; filename="' . $filename . '"');
       return  new BinaryFileResponse($filepath);



        //return $response;
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
            $attachment = $form['attachments']->getData();
            if($attachment)
            {
                $attachment_directory = $this->getParameter('attachments_directory');

                $fileName = pathinfo($attachment->getClientOriginalName(),PATHINFO_FILENAME);
                $file_extension = $attachment->guessExtension();
                $newFileName = $fileName.".".$file_extension;
                $attachment->move($attachment_directory,$newFileName);
                $chaveyDown->setAttachments($newFileName);
            }
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
    public function edit(Request $request, ChaveyDown $chaveyDown): Response
    {
        $form = $this->createForm(ChaveyDownType::class, $chaveyDown);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attachment = $form['attachments']->getData();
            if($attachment)
            {
                $attachment_directory = $this->getParameter('attachments_directory');

                $fileName = pathinfo($attachment->getClientOriginalName(),PATHINFO_FILENAME);
                $file_extension = $attachment->guessExtension();
                $newFileName = $fileName.".".$file_extension;
                $attachment->move($attachment_directory,$newFileName);
                $chaveyDown->setAttachments($newFileName);
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
