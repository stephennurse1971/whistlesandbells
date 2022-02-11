<?php

namespace App\Controller;

use App\Entity\TaxSupportingDocs;
use App\Form\TaxSupportingDocsType;
use App\Repository\TaxSupportingDocsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tax/supporting/docs")
 */
class TaxSupportingDocsController extends AbstractController
{
    /**
     * @Route("/", name="tax_supporting_docs_index", methods={"GET"})
     */
    public function index(TaxSupportingDocsRepository $taxSupportingDocsRepository): Response
    {
        return $this->render('tax_supporting_docs/index.html.twig', [
            'tax_supporting_docs' => $taxSupportingDocsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="tax_supporting_docs_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $taxSupportingDoc = new TaxSupportingDocs();
        $form = $this->createForm(TaxSupportingDocsType::class, $taxSupportingDoc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($taxSupportingDoc);
            $entityManager->flush();

            return $this->redirectToRoute('tax_supporting_docs_index');
        }

        return $this->render('tax_supporting_docs/new.html.twig', [
            'tax_supporting_doc' => $taxSupportingDoc,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tax_supporting_docs_show", methods={"GET"})
     */
    public function show(TaxSupportingDocs $taxSupportingDoc): Response
    {
        return $this->render('tax_supporting_docs/show.html.twig', [
            'tax_supporting_doc' => $taxSupportingDoc,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tax_supporting_docs_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TaxSupportingDocs $taxSupportingDoc): Response
    {
        $form = $this->createForm(TaxSupportingDocsType::class, $taxSupportingDoc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tax_supporting_docs_index');
        }

        return $this->render('tax_supporting_docs/edit.html.twig', [
            'tax_supporting_doc' => $taxSupportingDoc,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tax_supporting_docs_delete", methods={"POST"})
     */
    public function delete(Request $request, TaxSupportingDocs $taxSupportingDoc): Response
    {
        if ($this->isCsrfTokenValid('delete'.$taxSupportingDoc->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($taxSupportingDoc);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tax_supporting_docs_index');
    }
}
