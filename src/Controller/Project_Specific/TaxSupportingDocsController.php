<?php

namespace App\Controller\Project_Specific;

use App\Entity\Project_Specific\TaxSupportingDocs;
use App\Form\Project_Specific\TaxSupportingDocsType;
use App\Repository\Project_Specific\TaxSupportingDocsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/taxsupportingdocs")
 */
class TaxSupportingDocsController extends AbstractController
{
    /**
     * @Route("/index", name="tax_supporting_docs_index", methods={"GET"})
     */
    public function index(TaxSupportingDocsRepository $taxSupportingDocsRepository): Response
    {
        return $this->render('tax_supporting_docs/index.html.twig', [
            'tax_supporting_docs' => $taxSupportingDocsRepository->findAll(),
        ]);
    }

    /**
     * @Route("show/attachment/{id}/", name="tax_supporting_attachment_show")
     */
    public function showAttachment(int $id,TaxSupportingDocsRepository $taxSupportingDocsRepository)
    {
        $taxSupportingDoc = $taxSupportingDocsRepository->find($id);
        $attachment = $taxSupportingDoc->getAttachment();
        $filepath = $this->getParameter('tax_supporting_documents_attachments_directory')."/".$attachment;
        return $this->file($filepath, $attachment, ResponseHeaderBag::DISPOSITION_INLINE);
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
                $attachment = $form['attachment']->getData();
                if ($attachment) {
                    $taxSupportingDoc_directory = $this->getParameter('tax_supporting_documents_attachments_directory');
                    $fileName = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
                    $file_extension = $attachment->guessExtension();
                    $newFileName = $fileName . "." . $file_extension;
                    $attachment->move($taxSupportingDoc_directory, $newFileName);
                    $taxSupportingDoc->setAttachment($newFileName);
                }
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
     * @Route("/show/{id}", name="tax_supporting_docs_show", methods={"GET"})
     */
    public function show(TaxSupportingDocs $taxSupportingDoc): Response
    {
        return $this->render('tax_supporting_docs/show.html.twig', [
            'tax_supporting_doc' => $taxSupportingDoc,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="tax_supporting_docs_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TaxSupportingDocs $taxSupportingDoc): Response
    {
        $attachment = $taxSupportingDoc->getAttachment();
        $form = $this->createForm(TaxSupportingDocsType::class, $taxSupportingDoc,[
            'tax_supporting_doc'=>$attachment]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attachment = $form['attachment']->getData();
            if ($attachment) {
                $taxSupportingDoc_directory = $this->getParameter('tax_supporting_documents_attachments_directory');
                $fileName = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
                $file_extension = $attachment->guessExtension();
                $newFileName = $fileName . "." . $file_extension;
                $attachment->move($taxSupportingDoc_directory, $newFileName);
                $taxSupportingDoc->setAttachment($newFileName);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($taxSupportingDoc);
            $entityManager->flush();

            return $this->redirectToRoute('tax_supporting_docs_index');
        }

        return $this->render('tax_supporting_docs/edit.html.twig', [
            'tax_supporting_doc' => $taxSupportingDoc,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="tax_supporting_docs_delete", methods={"POST"})
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
