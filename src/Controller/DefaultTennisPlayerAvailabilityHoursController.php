<?php

namespace App\Controller;

use App\Entity\DefaultTennisPlayerAvailabilityHours;
use App\Entity\TennisPlayerAvailability;
use App\Form\DefaultTennisPlayerAvailabilityHoursType;
use App\Repository\DefaultTennisPlayerAvailabilityHoursRepository;
use App\Repository\TennisPlayerAvailabilityRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function index(DefaultTennisPlayerAvailabilityHoursRepository $defaultTennisPlayerAvailabilityHoursRepository,UserRepository $userRepository): Response
    {
        $hours = [];
        for ($i= 7; $i<=23; $i++)
        {
            $hours[$i]['hour']=$i.':00';
            $hours[$i]['sort']=$i;
        }
        return $this->render('default_tennis_player_availability_hours/index.html.twig', [
            'default_tennis_player_availability_hours' => $defaultTennisPlayerAvailabilityHoursRepository->findAll(),
            'hours' => $hours,
            'users'=> $userRepository->findByRole('ROLE_TENNIS_PLAYER')]);
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
     * @Route("/add", name="default_tennis_player_availability_hours_add")
     */
    public function newFromGrid(DefaultTennisPlayerAvailabilityHoursRepository $defaultTennisPlayerAvailabilityHoursRepository, EntityManagerInterface $entityManager, Request $request, UserRepository $userRepository)
    {
        $hour = $request->query->get('hour');
        $userID = $request->query->get('player');
        $day = $request->query->get('day');

        $user = $userRepository->find($userID);
        $tennisPlayerDefaultHours = new DefaultTennisPlayerAvailabilityHours();
        $tennisPlayerDefaultHours->setUser($user);
        $tennisPlayerDefaultHours->setHour($hour);
        $tennisPlayerDefaultHours->setWeekdayOrWeekend($day);
        $tennisPlayerDefaultHours->setDefaultAvailable('1');
        $entityManager->persist($tennisPlayerDefaultHours);
        $entityManager->flush();
        $referer = $request->server->get('HTTP_REFERER');
        return $this->redirect($referer);
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
        $available = $request->query->get('available');

        if ($available == '1') {
            $defaultTennisPlayerAvailabilityHour->setDefaultAvailable('0');
        } else {
            $defaultTennisPlayerAvailabilityHour->setDefaultAvailable('1');
        }
        $this->getDoctrine()->getManager()->flush();
        $referer = $request->server->get('HTTP_REFERER');
        return $this->redirect($referer);
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
