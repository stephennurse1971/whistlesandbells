<?php

namespace App\Controller;

use App\Entity\FlightStats;
use App\Form\FlightStatsType;
use App\Repository\FlightDestinationsRepository;
use App\Repository\FlightStatsRepository;
use App\Repository\SettingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/flight/stats")
 */
class FlightStatsController extends AbstractController
{
    /**
     * @Route("/index", name="flight_stats_index", methods={"GET"})
     */
    public function index(FlightStatsRepository $flightStatsRepository, FlightDestinationsRepository $flightDestinationsRepository,SettingsRepository $settingsRepository): Response
    {
        $settings=$settingsRepository->find(1);
        $flightDestinations=$flightDestinationsRepository->findAll();
        return $this->render('flight_stats/index.html.twig', [
            'flight_stats' => $flightStatsRepository->findAll(),
            'flight_destinations'=>$flightDestinations,
            'settings'=>$settings
        ]);
    }

    /**
     * @Route("/new", name="flight_stats_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $flightStat = new FlightStats();
        $form = $this->createForm(FlightStatsType::class, $flightStat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($flightStat);
            $entityManager->flush();

            return $this->redirectToRoute('flight_stats_index');
        }

        return $this->render('flight_stats/new.html.twig', [
            'flight_stat' => $flightStat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="flight_stats_show", methods={"GET"})
     */
    public function show(FlightStats $flightStat): Response
    {
        return $this->render('flight_stats/show.html.twig', [
            'flight_stat' => $flightStat,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="flight_stats_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, FlightStats $flightStat): Response
    {
        $form = $this->createForm(FlightStatsType::class, $flightStat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('flight_stats_index');
        }

        return $this->render('flight_stats/edit.html.twig', [
            'flight_stat' => $flightStat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="flight_stats_delete", methods={"POST"})
     */
    public function delete(Request $request, FlightStats $flightStat): Response
    {
        if ($this->isCsrfTokenValid('delete'.$flightStat->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($flightStat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('flight_stats_index');
    }

    /**
     * @Route("/delete/all", name="flight_stats_delete_all", methods={"GET"})
     */
    public function deleteAll(Request $request, FlightStatsRepository $flightStatsRepository, FlightDestinationsRepository $flightDestinationsRepository): Response
    {
        $referer = $request->headers->get('referer');
        $allPrices = $flightStatsRepository->findAll();
        $allDestinations = $flightDestinationsRepository->findAll();

        foreach ($allPrices as $price) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($price);
            $entityManager->flush();
        }
        foreach ($allDestinations as $destination) {
            $destination->setLastScraped(null);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
        }
        return $this->redirect($referer);
    }



}
