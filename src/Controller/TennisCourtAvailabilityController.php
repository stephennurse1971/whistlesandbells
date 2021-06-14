<?php

namespace App\Controller;

use App\Entity\TennisCourtAvailability;
use App\Form\TennisCourtAvailabilityType;
use App\Repository\TennisAvailabilityRepository;
use App\Repository\TennisCourtAvailabilityRepository;
use App\Repository\TennisPlayerAvailabilityRepository;
use App\Repository\TennisPlayersRepository;
use App\Repository\TennisVenuesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tennis/availability")
 */
class TennisCourtAvailabilityController extends AbstractController
{
    /**
     * @Route("/", name="tennis_court_availability_index", methods={"GET"})
     */
    public function index(Request $request,TennisCourtAvailabilityRepository $tennisCourtAvailabilityRepository, TennisVenuesRepository $tennisVenuesRepository): Response
    {
        $minDate = $request->query->get('minDate');
        $maxDate = $request->query->get('maxDate');

        $today = new \DateTime('now');
        $weekday = $today->format('N') - 1;
        $lastMonday = $today->modify('-' . $weekday . ' days');

        $nextSunday = new \DateTime($lastMonday->format('Y-m-d'));
        $nextSunday->modify('+6 days');

        if ($minDate && $maxDate) {
            $dates = $tennisCourtAvailabilityRepository->UniqueDate($minDate, $maxDate);
        } else {
            $dates = $tennisCourtAvailabilityRepository->UniqueDate($lastMonday->format('Y-m-d'), $nextSunday->format('Y-m-d'));
        }

        $monday2=new \DateTime($lastMonday->format('Y-m-d'));
        $monday3=new \DateTime($lastMonday->format('Y-m-d'));
        $sunday2=new \DateTime($nextSunday->format('Y-m-d'));
        $sunday3=new \DateTime($nextSunday->format('Y-m-d'));

        $monday2->modify('+7 days');
        $monday3->modify('+14 days');
        $sunday2->modify('+7 days');
        $sunday3->modify('+14 days');


        return $this->render('tennis_court_availability/index.html.twig', [
            'tennis_venues'=>$tennisVenuesRepository->findAll(),
            'tennis_court_availabilities' =>  $tennisCourtAvailabilityRepository->findAll(),
            'dates' => $dates,
//            'dates'=> $tennisCourtAvailabilityRepository->UniqueDate(),
            'hours'=> $tennisCourtAvailabilityRepository->UniqueHours(),

            'minDate' => $request->query->get('minDate'),
            'maxDate' => $request->query->get('maxDate'),
            'lastMonday' => $lastMonday,
            'nextSunday' => $nextSunday,
            'monday2' => $monday2,
            'monday3' => $monday3,
            'sunday2' => $sunday2,
            'sunday3' => $sunday3,
        ]);
    }

    /**
     * @Route("/new", name="tennis_court_availability_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tennisCourtAvailability = new TennisCourtAvailability();
        $form = $this->createForm(TennisCourtAvailabilityType::class, $tennisCourtAvailability);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tennisCourtAvailability);
            $entityManager->flush();
            return $this->redirectToRoute('tennis_court_availability_index');
        }

        return $this->render('tennis_court_availability/new.html.twig', [
            'tennis_court_availabilities' => $tennisCourtAvailability,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tennis_court_availability_show", methods={"GET"})
     */
    public function show(TennisCourtAvailability $tennisAvailability): Response
    {
        return $this->render('tennis_court_availability/show.html.twig', [
            'tennis_court_availability' => $tennisAvailability,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tennis_court_availability_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TennisCourtAvailability $tennisAvailability): Response
    {
        $form = $this->createForm(TennisCourtAvailabilityType::class, $tennisAvailability);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tennis_court_availability_index');
        }

        return $this->render('tennis_court_availability/edit.html.twig', [
            'tennis_court_availability' => $tennisAvailability,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tennis_court_availability_delete", methods={"POST"})
     */
    public function delete(Request $request, TennisCourtAvailability $tennisAvailability): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tennisAvailability->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tennisAvailability);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tennis_court_availability_index');
    }
}
