<?php

namespace App\Controller\ProjectSpecific;

use App\Entity\ProjectSpecific\TaxSchemes;
use App\Form\ProjectSpecific\TaxSchemesType;
use App\Repository\ProjectSpecific\TaxSchemesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/taxschemes")
 */
class TaxSchemesController extends AbstractController
{
    /**
     * @Route("/index", name="tax_schemes_index", methods={"GET"})
     */
    public function index(TaxSchemesRepository $taxSchemesRepository): Response
    {
        return $this->render('tax_schemes/index.html.twig', [
            'tax_schemes' => $taxSchemesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tax_schemes_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $taxScheme = new TaxSchemes();
        $form = $this->createForm(TaxSchemesType::class, $taxScheme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($taxScheme);
            $entityManager->flush();

            return $this->redirectToRoute('tax_schemes_index');
        }

        return $this->render('tax_schemes/new.html.twig', [
            'tax_scheme' => $taxScheme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="tax_schemes_show", methods={"GET"})
     */
    public function show(TaxSchemes $taxScheme): Response
    {
        return $this->render('tax_schemes/show.html.twig', [
            'tax_scheme' => $taxScheme,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="tax_schemes_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TaxSchemes $taxScheme): Response
    {
        $form = $this->createForm(TaxSchemesType::class, $taxScheme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tax_schemes_index');
        }

        return $this->render('tax_schemes/edit.html.twig', [
            'tax_scheme' => $taxScheme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="tax_schemes_delete", methods={"POST"})
     */
    public function delete(Request $request, TaxSchemes $taxScheme): Response
    {
        if ($this->isCsrfTokenValid('delete'.$taxScheme->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($taxScheme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tax_schemes_index');
    }
}
