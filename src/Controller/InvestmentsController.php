<?php

namespace App\Controller;

use App\Entity\Investments;
use App\Form\InvestmentsType;
use App\Repository\InvestmentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/investments")
 */
class InvestmentsController extends AbstractController
{
    /**
     * @Route("/", name="investments_index", methods={"GET"})
     */
    public function index(InvestmentsRepository $investmentsRepository): Response
    {
        return $this->render('investments/index.html.twig', [
            'investments' => $investmentsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="investments_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $investment = new Investments();
        $form = $this->createForm(InvestmentsType::class, $investment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($investment);
            $entityManager->flush();

            return $this->redirectToRoute('investments_index');
        }

        return $this->render('investments/new.html.twig', [
            'investment' => $investment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="investments_show", methods={"GET"})
     */
    public function show(Investments $investment): Response
    {
        return $this->render('investments/show.html.twig', [
            'investment' => $investment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="investments_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Investments $investment): Response
    {
        $form = $this->createForm(InvestmentsType::class, $investment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('investments_index');
        }

        return $this->render('investments/edit.html.twig', [
            'investment' => $investment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="investments_delete", methods={"POST"})
     */
    public function delete(Request $request, Investments $investment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$investment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($investment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('investments_index');
    }
}
