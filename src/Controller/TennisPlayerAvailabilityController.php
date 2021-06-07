<?php

namespace App\Controller;

use App\Entity\TennisPlayerAvailability;
use App\Form\TennisPlayerAvailabilityType;
use App\Repository\TennisCourtAvailabilityRepository;
use App\Repository\TennisPlayerAvailabilityRepository;
use App\Repository\TennisPlayersRepository;
use App\Repository\TennisVenuesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tennis/player_appetite")
 */
class TennisPlayerAvailabilityController extends AbstractController
{
    /**
     * @Route("/", name="tennis_player_availability_index", methods={"GET"})
     */
    public function index(TennisPlayerAvailabilityRepository $tennisPlayerAvailabilityRepository, TennisPlayersRepository $tennisPlayersRepository, TennisCourtAvailabilityRepository $tennisAvailabilityRepository, TennisVenuesRepository $tennisVenuesRepository): Response
    {
        return $this->render('tennis_player_availability/index.html.twig', [
            'tennis_player_availabilities' => $tennisPlayerAvailabilityRepository->findAll(),
            'dates'=> $tennisPlayerAvailabilityRepository->UniqueDate(),
            'hours'=> $tennisPlayerAvailabilityRepository->UniqueHour(),
            'tennis_players'=>$tennisPlayersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tennis_player_availability_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tennisPlayerAvailability= new TennisPlayerAvailability();
        $form = $this->createForm(TennisPlayerAvailabilityType::class, $tennisPlayerAvailability);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tennisPlayerAvailability);
            $entityManager->flush();

            return $this->redirectToRoute('tennis_player_availability_index');
        }

        return $this->render('tennis_player_availability/new.html.twig', [
            'tennis_player_availability' => $tennisPlayerAvailability,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tennis_player_availability_show", methods={"GET"})
     */
    public function show(TennisPlayerAvailability $tennisPlayerAvailability): Response
    {
        return $this->render('tennis_player_availability/show.html.twig', [
            'tennis_player_availability' => $tennisPlayerAvailability,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tennis_player_availability_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TennisPlayerAvailability $tennisPlayerAvailability): Response
    {
        $form = $this->createForm(TennisPlayerAvailabilityType::class, $tennisPlayerAvailability);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tennis_player_availability_index');
        }

        return $this->render('tennis_player_availability/edit.html.twig', [
            'tennis_player_availability' => $tennisPlayerAvailability,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tennis_player_availability_delete", methods={"POST"})
     */
    public function delete(Request $request, TennisPlayerAvailability $tennisPlayerAvailability): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tennisPlayerAvailability->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tennisPlayerAvailability);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tennis_player_availability_index');
    }
}
