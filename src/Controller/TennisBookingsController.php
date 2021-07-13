<?php

namespace App\Controller;

use App\Entity\TennisBookings;
use App\Form\TennisBookingsType;
use App\Repository\TennisBookingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tennis/bookings")
 */
class TennisBookingsController extends AbstractController
{
    /**
     * @Route("/", name="tennis_bookings_index", methods={"GET"})
     */
    public function index(TennisBookingsRepository $tennisBookingsRepository): Response
    {
        return $this->render('tennis_bookings/index.html.twig', [
            'tennis_bookings' => $tennisBookingsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tennis_bookings_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tennisBooking = new TennisBookings();
        $form = $this->createForm(TennisBookingsType::class, $tennisBooking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tennisBooking);
            $entityManager->flush();

            return $this->redirectToRoute('tennis_bookings_index');
        }

        return $this->render('tennis_bookings/new.html.twig', [
            'tennis_booking' => $tennisBooking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tennis_bookings_show", methods={"GET"})
     */
    public function show(TennisBookings $tennisBooking): Response
    {
        return $this->render('tennis_bookings/show.html.twig', [
            'tennis_booking' => $tennisBooking,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tennis_bookings_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TennisBookings $tennisBooking): Response
    {
        $form = $this->createForm(TennisBookingsType::class, $tennisBooking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tennis_bookings_index');
        }

        return $this->render('tennis_bookings/edit.html.twig', [
            'tennis_booking' => $tennisBooking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tennis_bookings_delete", methods={"POST"})
     */
    public function delete(Request $request, TennisBookings $tennisBooking): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tennisBooking->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tennisBooking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tennis_bookings_index');
    }
}
