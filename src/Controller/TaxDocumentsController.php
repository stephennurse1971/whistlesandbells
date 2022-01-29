<?php

namespace App\Controller;

use App\Entity\TaxDocuments;
use App\Form\TaxDocumentsType;
use App\Repository\TaxDocumentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tax_documents_index');
        }

        return $this->render('tax_documents/edit.html.twig', [
            'tax_document' => $taxDocument,
            'form' => $form->createView(),
        ]);
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
