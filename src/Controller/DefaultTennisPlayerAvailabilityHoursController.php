<?php

namespace App\Controller;

use App\Entity\DefaultTennisPlayerAvailabilityHours;
use App\Form\DefaultTennisPlayerAvailabilityHoursType;
use App\Repository\DefaultTennisPlayerAvailabilityHoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/default/tennis/player/availability/hours")
 */
class DefaultTennisPlayerAvailabilityHoursController extends AbstractController
{
    /**
     * @Route("/", name="default_tennis_player_availability_hours_index", methods={"GET"})
     */
    public function index(DefaultTennisPlayerAvailabilityHoursRepository $defaultTennisPlayerAvailabilityHoursRepository): Response
    {
        return $this->render('default_tennis_player_availability_hours/index.html.twig', [
            'default_tennis_player_availability_hours' => $defaultTennisPlayerAvailabilityHoursRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="default_tennis_player_availability_hours_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $defaultTennisPlayerAvailabilityHour = new DefaultTennisPlayerAvailabilityHours();
        $form = $this->createForm(DefaultTennisPlayerAvailabilityHoursType::class, $defaultTennisPlayerAvailabilityHour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($defaultTennisPlayerAvailabilityHour);
            $entityManager->flush();

            return $this->redirectToRoute('default_tennis_player_availability_hours_index');
        }

        return $this->render('default_tennis_player_availability_hours/new.html.twig', [
            'default_tennis_player_availability_hour' => $defaultTennisPlayerAvailabilityHour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="default_tennis_player_availability_hours_show", methods={"GET"})
     */
    public function show(DefaultTennisPlayerAvailabilityHours $defaultTennisPlayerAvailabilityHour): Response
    {
        return $this->render('default_tennis_player_availability_hours/show.html.twig', [
            'default_tennis_player_availability_hour' => $defaultTennisPlayerAvailabilityHour,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="default_tennis_player_availability_hours_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DefaultTennisPlayerAvailabilityHours $defaultTennisPlayerAvailabilityHour): Response
    {
        $form = $this->createForm(DefaultTennisPlayerAvailabilityHoursType::class, $defaultTennisPlayerAvailabilityHour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('default_tennis_player_availability_hours_index');
        }

        return $this->render('default_tennis_player_availability_hours/edit.html.twig', [
            'default_tennis_player_availability_hour' => $defaultTennisPlayerAvailabilityHour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="default_tennis_player_availability_hours_delete", methods={"POST"})
     */
    public function delete(Request $request, DefaultTennisPlayerAvailabilityHours $defaultTennisPlayerAvailabilityHour): Response
    {
        if ($this->isCsrfTokenValid('delete'.$defaultTennisPlayerAvailabilityHour->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($defaultTennisPlayerAvailabilityHour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('default_tennis_player_availability_hours_index');
    }
}
