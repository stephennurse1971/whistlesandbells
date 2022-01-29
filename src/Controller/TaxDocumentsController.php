<?php

namespace App\Controller;

use App\Entity\TaxDocuments;
use App\Form\TaxDocumentsType;
use App\Repository\ChaveyDownRepository;
use App\Repository\TaxDocumentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tax/documents")
 */
class TaxDocumentsController extends AbstractController
{
    /**
     * @Route("/", name="tax_documents_index", methods={"GET"})
     */
    public function index(TaxDocumentsRepository $taxDocumentsRepository): Response
    {
        return $this->render('tax_documents/index.html.twig', [
            'tax_documents' => $taxDocumentsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tax_documents_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $taxDocument = new TaxDocuments();
        $form = $this->createForm(TaxDocumentsType::class, $taxDocument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($taxDocument);
            $entityManager->flush();

            return $this->redirectToRoute('tax_documents_index');
        }

        return $this->render('tax_documents/new.html.twig', [
            'tax_document' => $taxDocument,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tax_documents_show", methods={"GET"})
     */
    public function show(TaxDocuments $taxDocument): Response
    {
        return $this->render('tax_documents/show.html.twig', [
            'tax_document' => $taxDocument,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tax_documents_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TaxDocuments $taxDocument): Response
    {
        $form = $this->createForm(TaxDocumentsType::class, $taxDocument);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $p11D = $form['p11D']->getData();
            if($p11D)
            {
                $p11D_directory = $this->getParameter('attachments_directory');

                $fileName = pathinfo($p11D->getClientOriginalName(),PATHINFO_FILENAME);
                $file_extension = $p11D->guessExtension();
                $newFileName = $fileName.".".$file_extension;
                $p11D->move($p11D_directory,$newFileName);
                $taxDocument->setP11D($newFileName);
            }
            $p60 = $form['p60']->getData();
            if($p60)
            {
                $p60_directory = $this->getParameter('attachments_directory');

                $fileName = pathinfo($p60->getClientOriginalName(),PATHINFO_FILENAME);
                $file_extension = $p60->guessExtension();
                $newFileName = $fileName.".".$file_extension;
                $p60->move($p60_directory,$newFileName);
                $taxDocument->setP60($newFileName);
            }
            $selfAssessment = $form['selfAssessment']->getData();
            if($selfAssessment)
            {
                $selfAssessment_directory = $this->getParameter('attachments_directory');

                $fileName = pathinfo($selfAssessment->getClientOriginalName(),PATHINFO_FILENAME);
                $file_extension = $selfAssessment->guessExtension();
                $newFileName = $fileName.".".$file_extension;
                $selfAssessment->move($selfAssessment_directory,$newFileName);
                $taxDocument->setSelfAssessment($newFileName);
            }
            $this->getDoctrine()->getManager()->flush();

            




            return $this->redirectToRoute('tax_documents_index');
        }

        return $this->render('tax_documents/edit.html.twig', [
            'tax_document' => $taxDocument,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("show/attachment/{id}/{type}", name="show_tax_attachment")
     */
    public function showAttachment(string $type, int $id, TaxDocumentsRepository $taxDocumentsRepository)
    {
        $filename = '';
        if( $type == 'P11D') {
            $filename = $taxDocumentsRepository->find($id)->getP11D();
        }
        if( $type == 'P60') {
            $filename = $taxDocumentsRepository->find($id)->getP60();
        }
        if( $type == 'selfassessment') {
            $filename = $taxDocumentsRepository->find($id)->getSelfAssessment();
        }

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
     * @Route("/{id}", name="tax_documents_delete", methods={"POST"})
     */
    public function delete(Request $request, TaxDocuments $taxDocument): Response
    {
        if ($this->isCsrfTokenValid('delete'.$taxDocument->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($taxDocument);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tax_documents_index');
    }
}
