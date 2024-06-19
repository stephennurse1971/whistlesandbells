<?php

namespace App\Controller\ProjectSpecific;

use App\Entity\ProjectSpecific\TaxYear;
use App\Form\ProjectSpecific\TaxYearType;
use App\Repository\ProjectSpecific\TaxYearRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/taxyear")
 */
class TaxYearController extends AbstractController
{
    /**
     * @Route("/index", name="tax_year_index", methods={"GET"})
     */
    public function index(TaxYearRepository $taxYearRepository): Response
    {
        return $this->render('tax_year/index.html.twig', [
            'tax_years' => $taxYearRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tax_year_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $taxYear = new TaxYear();
        $form = $this->createForm(TaxYearType::class, $taxYear);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($taxYear);
            $entityManager->flush();

            return $this->redirectToRoute('tax_year_index');
        }

        return $this->render('tax_year/new.html.twig', [
            'tax_year' => $taxYear,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="tax_year_show", methods={"GET"})
     */
    public function show(TaxYear $taxYear): Response
    {
        return $this->render('tax_year/show.html.twig', [
            'tax_year' => $taxYear,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="tax_year_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TaxYear $taxYear): Response
    {
        $form = $this->createForm(TaxYearType::class, $taxYear);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tax_year_index');
        }

        return $this->render('tax_year/edit.html.twig', [
            'tax_year' => $taxYear,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="tax_year_delete", methods={"POST"})
     */
    public function delete(Request $request, TaxYear $taxYear): Response
    {
        if ($this->isCsrfTokenValid('delete'.$taxYear->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($taxYear);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tax_year_index');
    }
}
