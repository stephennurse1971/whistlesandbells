<?php

namespace App\Controller;

use App\Entity\TaxInputs;
use App\Form\TaxInputsType;
use App\Repository\TaxInputsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tax/inputs")
 */
class TaxInputsController extends AbstractController
{
    /**
     * @Route("/", name="tax_inputs_index", methods={"GET"})
     */
    public function index(TaxInputsRepository $taxInputsRepository): Response
    {
        return $this->render('tax_inputs/index.html.twig', [
            'tax_inputs' => $taxInputsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tax_inputs_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $taxInput = new TaxInputs();
        $form = $this->createForm(TaxInputsType::class, $taxInput);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($taxInput);
            $entityManager->flush();

            return $this->redirectToRoute('tax_inputs_index');
        }

        return $this->render('tax_inputs/new.html.twig', [
            'tax_input' => $taxInput,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tax_inputs_show", methods={"GET"})
     */
    public function show(TaxInputs $taxInput): Response
    {
        return $this->render('tax_inputs/show.html.twig', [
            'tax_input' => $taxInput,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tax_inputs_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TaxInputs $taxInput): Response
    {
        $form = $this->createForm(TaxInputsType::class, $taxInput);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tax_inputs_index');
        }

        return $this->render('tax_inputs/edit.html.twig', [
            'tax_input' => $taxInput,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tax_inputs_delete", methods={"POST"})
     */
    public function delete(Request $request, TaxInputs $taxInput): Response
    {
        if ($this->isCsrfTokenValid('delete'.$taxInput->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($taxInput);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tax_inputs_index');
    }
}
