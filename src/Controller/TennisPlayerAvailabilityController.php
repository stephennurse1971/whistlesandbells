<?php

namespace App\Controller;

use App\Entity\TennisPlayerAvailability;
use App\Form\TennisPlayerAvailabilityType;
use App\Repository\TennisCourtAvailabilityRepository;
use App\Repository\TennisPlayerAvailabilityRepository;
use App\Repository\TennisPlayersRepository;
use App\Repository\TennisVenuesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tennis/player_availability")
 */
class TennisPlayerAvailabilityController extends AbstractController
{
    /**
     * @Route("/", name="tennis_player_availability_index", methods={"GET"})
     */
    public function index(Request $request, TennisPlayerAvailabilityRepository $tennisPlayerAvailabilityRepository, UserRepository $userRepository, TennisCourtAvailabilityRepository $tennisCourtAvailabilityRepository, TennisVenuesRepository $tennisVenuesRepository): Response
    {
        $minDate = $request->query->get('minDate');
        $maxDate = $request->query->get('maxDate');

        $today = new \DateTime('now');
        $weekday = $today->format('N') - 1;
        $lastMonday = $today->modify('-' . $weekday . ' days');

        $nextSunday = new \DateTime($lastMonday->format('Y-m-d'));
        $nextSunday->modify('+6 days');

        if ($minDate && $maxDate) {
            $dates = $tennisPlayerAvailabilityRepository->UniqueDate($minDate, $maxDate);
        } else {
            $dates = $tennisPlayerAvailabilityRepository->UniqueDate($lastMonday->format('Y-m-d'), $nextSunday->format('Y-m-d'));
        }

        $monday2=new \DateTime($lastMonday->format('Y-m-d'));
        $monday3=new \DateTime($lastMonday->format('Y-m-d'));
        $sunday2=new \DateTime($nextSunday->format('Y-m-d'));
        $sunday3=new \DateTime($nextSunday->format('Y-m-d'));

        $monday2->modify('+7 days');
        $monday3->modify('+14 days');
        $sunday2->modify('+7 days');
        $sunday3->modify('+14 days');


        return $this->render('tennis_player_availability/index.html.twig', [
            'tennis_player_availabilities' => $tennisPlayerAvailabilityRepository->findAll(),
            'dates' => $dates,
            'hours' => $tennisPlayerAvailabilityRepository->UniqueHour(),
            'tennis_players' => $userRepository->findAll(),
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
     * @Route("/new", name="tennis_player_availability_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tennisPlayerAvailability = new TennisPlayerAvailability();
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
     * @Route("/add", name="tennis_player_availability_add")
     */
    public function newFromCalendar(TennisPlayerAvailabilityRepository $tennisPlayerAvailabilityRepository, EntityManagerInterface $entityManager, Request $request, UserRepository $userRepository)
    {
        $hour = $request->query->get('hour');
        $date = $request->query->get('date');
        $userID = $request->query->get('player');
        $user = $userRepository->find($userID);
        $date = new \DateTime($date);
        $tennisPlayerAvailability = new TennisPlayerAvailability();
        $tennisPlayerAvailability->setUser($user);
        $tennisPlayerAvailability->setDate($date);
        $tennisPlayerAvailability->setHour($hour);
        $tennisPlayerAvailability->setAvailable('1');
        $entityManager->persist($tennisPlayerAvailability);
        $entityManager->flush();
        $referer = $request->server->get('HTTP_REFERER');
        return $this->redirect($referer);
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
    public function edit(Request $request, TennisPlayerAvailability $tennisPlayerAvailability, EntityManagerInterface $entityManager): Response
    {
        $available = $request->query->get('available');

        if ($available == '1') {
            $tennisPlayerAvailability->setAvailable('0');
        } else {
            $tennisPlayerAvailability->setAvailable('1');
        }
        $this->getDoctrine()->getManager()->flush();

        $referer = $request->server->get('HTTP_REFERER');
        return $this->redirect($referer);

    }

    /**
     * @Route("/{id}", name="tennis_player_availability_delete", methods={"POST"})
     */
    public function delete(Request $request, TennisPlayerAvailability $tennisPlayerAvailability): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tennisPlayerAvailability->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tennisPlayerAvailability);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tennis_player_availability_index');
    }
}
