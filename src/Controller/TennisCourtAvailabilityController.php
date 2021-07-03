<?php

namespace App\Controller;

use App\Entity\TennisCourtAvailability;
use App\Form\TennisCourtAvailabilityType;
use App\Repository\TennisAvailabilityRepository;
use App\Repository\TennisCourtAvailabilityRepository;
use App\Repository\TennisVenuesRepository;
use App\Services\ScrapeTHService;
use Doctrine\ORM\EntityManagerInterface;
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
    public function index(Request $request, TennisCourtAvailabilityRepository $tennisCourtAvailabilityRepository, TennisVenuesRepository $tennisVenuesRepository): Response
    {
        $hours = [];
        for ($i = 7; $i <= 23; $i++) {
            $hours[$i]['hour'] = $i . ':00';
            $hours[$i]['sort'] = $i;
        }

        $minDate = $request->query->get('minDate');
        $maxDate = $request->query->get('maxDate');

        $today = new \DateTime('now');
        $weekday = $today->format('N') - 1;
        $lastMonday = new \DateTime($today->format('Y-m-d'));
        $lastMonday->modify('-' . $weekday . ' days');

        $nextSunday = new \DateTime($lastMonday->format('Y-m-d'));
        $nextSunday->modify('+6 days');
        $daysRemainingThisWeek = 7 - $weekday;

        if ($minDate && $maxDate) {

            if ($minDate == $today->format('Y-m-d')) {
                $dates = [];
                for ($i = 0; $i < $daysRemainingThisWeek; $i++) {
                    $next_date = new \DateTime($today->format('Y-m-d'));
                    $next_date->modify($i . 'days');
                    $dates[$i] = $next_date;
                }
            } else {
                $dates = [];
                $dates[0] = new \DateTime($minDate);
                for ($i = 1; $i <= 6; $i++) {
                    $next_date = new \DateTime($minDate);
                    $next_date->modify($i . 'days');
                    $dates[$i] = $next_date;
                }
            }
        } else {
            $dates = [];
            for ($i = 0; $i < $daysRemainingThisWeek; $i++) {
                $next_date = new \DateTime($today->format('Y-m-d'));
                $next_date->modify($i . 'days');
                $dates[$i] = $next_date;
            }
        }

        $monday2 = new \DateTime($lastMonday->format('Y-m-d'));
        $monday3 = new \DateTime($lastMonday->format('Y-m-d'));
        $sunday2 = new \DateTime($nextSunday->format('Y-m-d'));
        $sunday3 = new \DateTime($nextSunday->format('Y-m-d'));

        $monday2->modify('+7 days');
        $monday3->modify('+14 days');
        $sunday2->modify('+7 days');
        $sunday3->modify('+14 days');


        return $this->render('tennis_court_availability/index.html.twig', [
            'tennis_venues' => $tennisVenuesRepository->findAll(),
            'tennis_court_availabilities' => $tennisCourtAvailabilityRepository->findAll(),
            'dates' => $dates,
            'hours' => $hours,
            'today' => $today,
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
     * @Route("/newFromCalendar", name="tennis_court_availability_newfromcalendar", methods={"GET","POST"})
     */
    public function newFromCalendar(Request $request, TennisVenuesRepository $tennisVenuesRepository, EntityManagerInterface $entityManager): Response
    {
        $tennisCourtAvailability = new TennisCourtAvailability();
        $venueId = $request->query->get('venue');
        $date = $request->query->get('date');
        $hour = $request->query->get('hour');
        $date = new \DateTime($date);

        $venue = $tennisVenuesRepository->find($venueId);
        $tennisCourtAvailability = new TennisCourtAvailability();
        $tennisCourtAvailability->setVenue($venue);
        $tennisCourtAvailability->setDate($date);
        $tennisCourtAvailability->setHour($hour);
        $tennisCourtAvailability->setAvailable('1');
        $entityManager->persist($tennisCourtAvailability);
        $entityManager->flush();
        $referer = $request->server->get('HTTP_REFERER');
        return $this->redirect($referer);
    }

    /**
     * @Route("/delete/all", name="tennis_court_availability_delete_all", methods={"GET"})
     */
    public function deleteAll(TennisCourtAvailabilityRepository $tennisCourtAvailabilityRepository): Response
    {
        $allEntries = $tennisCourtAvailabilityRepository->findAll();
        foreach ($allEntries as $allEntry) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($allEntry);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tennis_court_availability_index');
    }


    /**
     * @Route("/scrape", name="tennis_court_availability_scrape", methods={"GET"})
     */
    public function scrapeCourtAvailability(TennisVenuesRepository $tennisVenuesRepository,TennisCourtAvailabilityRepository $tennisCourtAvailabilityRepository, ScrapeTHService $scrapeTHService): Response
    {
//       $tennisVenues= $tennisVenuesRepository->findByWebID();
//       dump($tennisVenues);
//        return new Response(null);
        $scrapeTHService->CreateCourtAvailabilty();

         return $this->redirectToRoute('tennis_court_availability_index');
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
    public function delete(Request $request, TennisCourtAvailability $tennisCourtAvailability): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tennisCourtAvailability->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tennisCourtAvailability);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tennis_court_availability_index');
    }


}
