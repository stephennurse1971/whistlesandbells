<?php

namespace App\Controller;

use App\Entity\FlightDestinations;
use App\Form\FlightDestinationsType;
use App\Repository\AirportsRepository;
use App\Repository\FlightDestinationsRepository;
use App\Repository\SettingsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/flight/destinations")
 */
class FlightDestinationsController extends AbstractController
{
    /**
     * @Route("/", name="flight_destinations_index", methods={"GET"})
     */
    public function index(FlightDestinationsRepository $flightDestinationsRepository, SettingsRepository $settingsRepository, EntityManagerInterface $entityManager): Response
    {
        $today = new \DateTime('now');
        $settings = $settingsRepository->find('1');
        $startDate = $settings->getFlightStatsStartDate();
        if ($startDate < $today) {
            $settings->setFlightStatsStartDate($today);
            $entityManager->flush();
        }
        return $this->render('flight_destinations/index.html.twig', [
            'flight_destinations' => $flightDestinationsRepository->findAll(),
            'settings' => $settings
        ]);
    }

    /**
     * @Route("/new", name="flight_destinations_new", methods={"GET", "POST"})
     */
    public function new(Request $request, FlightDestinationsRepository $flightDestinationsRepository): Response
    {
        $flightDestination = new FlightDestinations();
        $form = $this->createForm(FlightDestinationsType::class, $flightDestination);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $flightDestinationsRepository->add($flightDestination);
            return $this->redirectToRoute('flight_destinations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('flight_destinations/new.html.twig', [
            'flight_destination' => $flightDestination,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/newReturn/{id}", name="flight_destinations_new_return", methods={"GET", "POST"})
     */
    public function newReturn(Request $request, int $id, AirportsRepository $airportsRepository, FlightDestinationsRepository $flightDestinationsRepository): Response
    {
        $selected_flight_destination = $flightDestinationsRepository->find($id);
        $selected_flight_destination->setReturnLeg('Outbound');
        $originalDepartureCity = $selected_flight_destination->getDepartureCity();
        $originalArrivalCity = $selected_flight_destination->getArrivalCity();
        $originalDateStart = $selected_flight_destination->getDateStart();
        $originalDateEnd = $selected_flight_destination->getDateEnd();
        $originalAdminOnly = $selected_flight_destination->getAdminOnly();
        $originalisActive = $selected_flight_destination->getIsActive();
        $originalGrouping = $selected_flight_destination->getGrouping();
        $originalID = $selected_flight_destination->getID();

        $flightDestination = new FlightDestinations();
        $flightDestination->setReturnLeg($originalID);
        $form = $this->createForm(FlightDestinationsType::class, $flightDestination, [
            'odc'=>$originalDepartureCity,'oac'=>$originalArrivalCity,
            'ods'=>$originalDateStart, 'oadmin'=>$originalAdminOnly, 'oisactive'=>$originalisActive,
            'ode'=>$originalDateEnd,'ogrouping'=>$originalGrouping,
            'mode'=>'new',
            'rt'=>'Return'
            ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $flightDestinationsRepository->add($flightDestination);
            return $this->redirectToRoute('flight_destinations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('flight_destinations/new.html.twig', [
            'flight_destination' => $flightDestination,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="flight_destinations_show", methods={"GET"})
     */
    public function show(FlightDestinations $flightDestination): Response
    {
        return $this->render('flight_destinations/show.html.twig', [
            'flight_destination' => $flightDestination,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="flight_destinations_edit", methods={"GET", "POST"})
     *
     */
    public function edit(Request $request, FlightDestinations $flightDestination, FlightDestinationsRepository $flightDestinationsRepository): Response
    {
        $form = $this->createForm(FlightDestinationsType::class, $flightDestination);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $flightDestinationsRepository->add($flightDestination);
            return $this->redirectToRoute('flight_destinations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('flight_destinations/edit.html.twig', [
            'flight_destination' => $flightDestination,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/flight_destination_change_isactive_status/{id}/{active}", name="flight_destinations_change_isactive_status", methods={"GET", "POST"})
     */
    public function changeIsActiveStatus(Request $request, $id, $active, FlightDestinationsRepository $flightDestinationsRepository, EntityManagerInterface $manager): Response
    {
        $referer = $request->headers->get('Referer');
        $flightDestination = $flightDestinationsRepository->find($id);
        $flightDestination->setIsActive($active);
        $manager->flush();
        return $this->redirect($referer);
    }

    /**
     * @Route("/flight_destination_change_admin_status/{id}/{admin}", name="flight_destinations_change_admin_status", methods={"GET", "POST"})
     */
    public function changeAdminStatus(Request $request, $id, $admin, FlightDestinationsRepository $flightDestinationsRepository, EntityManagerInterface $manager): Response
    {
        $referer = $request->headers->get('Referer');
        $flightDestination = $flightDestinationsRepository->find($id);
        $flightDestination->setAdminOnly($admin);
        $manager->flush();
        return $this->redirect($referer);
    }

    /**
     * @Route("/flight_destination_reset_dates/{id}", name="flight_destinations_reset_dates", methods={"GET", "POST"})
     */
    public function resetDates(Request $request, $id, FlightDestinationsRepository $flightDestinationsRepository, SettingsRepository $settingsRepository, EntityManagerInterface $manager): Response
    {
        $referer = $request->headers->get('Referer');
        $settings = $settingsRepository->find('1');
        $startDate = $settings->getFlightStatsStartDate();
        $daysCount = $settings->getFlightStatsDays();
        $flightDestination = $flightDestinationsRepository->find($id);
        $flightDestination->setDateStart($startDate);
        $manager->flush();
        $endDate = date_modify($startDate, +$daysCount . ' days');
        $flightDestination->setDateEnd($endDate);
        $manager->flush();

        return $this->redirect($referer);
    }


    /**
     * @Route("/{id}", name="flight_destinations_delete", methods={"POST"})
     */
    public function delete(Request $request, FlightDestinations $flightDestination, FlightDestinationsRepository $flightDestinationsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $flightDestination->getId(), $request->request->get('_token'))) {
            $flightDestinationsRepository->remove($flightDestination);
        }

        return $this->redirectToRoute('flight_destinations_index', [], Response::HTTP_SEE_OTHER);
    }
}
