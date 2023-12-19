<?php

namespace App\Controller;

use App\Entity\FlightDestinations;
use App\Form\FlightDestinationsType;
use App\Repository\FlightDestinationsRepository;
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
    public function index(FlightDestinationsRepository $flightDestinationsRepository): Response
    {
        return $this->render('flight_destinations/index.html.twig', [
            'flight_destinations' => $flightDestinationsRepository->findAll(),
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
     * @Route("/{id}", name="flight_destinations_delete", methods={"POST"})
     */
    public function delete(Request $request, FlightDestinations $flightDestination, FlightDestinationsRepository $flightDestinationsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$flightDestination->getId(), $request->request->get('_token'))) {
            $flightDestinationsRepository->remove($flightDestination);
        }

        return $this->redirectToRoute('flight_destinations_index', [], Response::HTTP_SEE_OTHER);
    }
}
