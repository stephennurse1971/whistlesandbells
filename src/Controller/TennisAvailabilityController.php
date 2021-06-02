<?php

namespace App\Controller;

use App\Entity\TennisAvailability;
use App\Form\TennisAvailabilityType;
use App\Repository\TennisAvailabilityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tennis/availability")
 */
class TennisAvailabilityController extends AbstractController
{
    /**
     * @Route("/", name="tennis_availability_index", methods={"GET"})
     */
    public function index(TennisAvailabilityRepository $tennisAvailabilityRepository): Response
    {
        return $this->render('tennis_availability/index.html.twig', [
            'tennis_availabilities' => $tennisAvailabilityRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tennis_availability_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tennisAvailability = new TennisAvailability();
        $form = $this->createForm(TennisAvailabilityType::class, $tennisAvailability);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tennisAvailability);
            $entityManager->flush();

            return $this->redirectToRoute('tennis_availability_index');
        }

        return $this->render('tennis_availability/new.html.twig', [
            'tennis_availability' => $tennisAvailability,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tennis_availability_show", methods={"GET"})
     */
    public function show(TennisAvailability $tennisAvailability): Response
    {
        return $this->render('tennis_availability/show.html.twig', [
            'tennis_availability' => $tennisAvailability,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tennis_availability_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TennisAvailability $tennisAvailability): Response
    {
        $form = $this->createForm(TennisAvailabilityType::class, $tennisAvailability);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tennis_availability_index');
        }

        return $this->render('tennis_availability/edit.html.twig', [
            'tennis_availability' => $tennisAvailability,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tennis_availability_delete", methods={"POST"})
     */
    public function delete(Request $request, TennisAvailability $tennisAvailability): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tennisAvailability->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tennisAvailability);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tennis_availability_index');
    }
}
