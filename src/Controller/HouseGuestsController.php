<?php

namespace App\Controller;

use App\Entity\HouseGuests;
use App\Form\HouseGuestsType;
use App\Repository\HouseGuestsRepository;
use App\Services\HouseGuestPerDayList;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/house/guests")
 */
class HouseGuestsController extends AbstractController
{
    /**
     * @Route("/", name="house_guests_index", methods={"GET"})
     */
    public function index(HouseGuestsRepository $houseGuestsRepository, HouseGuestPerDayList $houseGuestPerDayList): Response
    {

        $date = new \DateTime('now');
        $month = $date->format('m');
        $year = $date->format('Y');
        $dates = [];
        $sixth_month = $month + 6;

        if ($sixth_month > 12) {
            $sixth_month = $sixth_month - 12;
            $year = $year + 1;
        }
        $first_date_of_sixth_month = "01-" . $sixth_month . "-" . $year;
        $new_date = new \DateTime($first_date_of_sixth_month);
        $last_day_of_six_month = $new_date->modify('last day of');
        $current_date = new \DateTime('now');
        while ($current_date <= $last_day_of_six_month) {
            $dates[] = new \DateTime($current_date->format('d-m-Y'));
            $current_date = new \DateTime($current_date->modify("+1 day")->format('d-m-Y'));
        }

        return $this->render('house_guests/calendarindex.html.twig', [
            'house_guests' => $lists = $houseGuestPerDayList->guestList(),
            'dates' => $dates
        ]);
    }


    /**
     * @Route("/indexSimple", name="house_guests_index_simple", methods={"GET"})
     */
    public function indexSimple(HouseGuestsRepository $houseGuestsRepository): Response
    {

        return $this->render('house_guests/index.html.twig', [
            'house_guests' => $houseGuestsRepository->findAll()
        ]);
    }

    /**
     * @Route("/new", name="house_guests_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $houseGuest = new HouseGuests();
        $form = $this->createForm(HouseGuestsType::class, $houseGuest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($houseGuest);
            $entityManager->flush();

            return $this->redirectToRoute('house_guests_index');
        }

        return $this->render('house_guests/new.html.twig', [
            'house_guest' => $houseGuest,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="house_guests_show", methods={"GET"})
     */
    public function show(HouseGuests $houseGuest): Response
    {
        return $this->render('house_guests/show.html.twig', [
            'house_guest' => $houseGuest,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="house_guests_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, HouseGuests $houseGuest): Response
    {
        $form = $this->createForm(HouseGuestsType::class, $houseGuest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('house_guests_index');
        }

        return $this->render('house_guests/edit.html.twig', [
            'house_guest' => $houseGuest,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="house_guests_delete", methods={"POST"})
     */
    public function delete(Request $request, HouseGuests $houseGuest): Response
    {
        if ($this->isCsrfTokenValid('delete' . $houseGuest->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($houseGuest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('house_guests_index');
    }
}
