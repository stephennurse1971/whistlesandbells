<?php

namespace App\Controller;

use App\Entity\Health;
use App\Form\HealthType;
use App\Repository\HealthRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/health")
 */
class HealthController extends AbstractController
{
    /**
     * @Route("/", name="health_index", methods={"GET"})
     */
    public function index(HealthRepository $healthRepository): Response
    {
        return $this->render('health/index.html.twig', [
            'healths' => $healthRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="health_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $health = new Health();
        $form = $this->createForm(HealthType::class, $health);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($health);
            $entityManager->flush();

            return $this->redirectToRoute('health_index');
        }

        return $this->render('health/new.html.twig', [
            'health' => $health,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="health_show", methods={"GET"})
     */
    public function show(Health $health): Response
    {
        return $this->render('health/show.html.twig', [
            'health' => $health,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="health_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Health $health): Response
    {
        $form = $this->createForm(HealthType::class, $health);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('health_index');
        }

        return $this->render('health/edit.html.twig', [
            'health' => $health,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="health_delete", methods={"POST"})
     */
    public function delete(Request $request, Health $health): Response
    {
        if ($this->isCsrfTokenValid('delete'.$health->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($health);
            $entityManager->flush();
        }

        return $this->redirectToRoute('health_index');
    }
}
