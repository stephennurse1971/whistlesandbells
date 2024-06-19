<?php

namespace App\Controller\ProjectSpecific;

use App\Entity\ProjectSpecific\UkDayCalendar;
use App\Form\ProjectSpecific\UkDayCalendarType;
use App\Repository\ProjectSpecific\SettingsRepository;
use App\Repository\ProjectSpecific\UkDayCalendarRepository;
use App\Repository\ProjectSpecific\UkDaysRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/uk_day/calendar")
 */
class UkDayCalendarController extends AbstractController
{
    /**
     * @Route("/index", name="uk_day_calendar_index", methods={"GET"})
     */
    public function index(UkDayCalendarRepository $ukDayCalendarRepository): Response
    {
        return $this->render('uk_day_calendar/index.html.twig', [
            'uk_day_calendars' => $ukDayCalendarRepository->findAll(),
        ]);
    }


    /**
     * @Route("/createCalendar", name="uk_day_calendar_create", methods={"GET"})
     */
    public function createCalendar(UkDayCalendarRepository $ukDayCalendarRepository, UkDaysRepository $ukDaysRepository, SettingsRepository $settingsRepository, EntityManagerInterface $entityManager): Response
    {
        $startDate = $settingsRepository->find('1')->getUkDaysStartDate();
        $endDate = new \DateTime('now');
        $number_of_days = $startDate->diff($endDate);
        $number_of_days = $number_of_days->days;
        $current_location = null;
        for ($i = 0; $i < $number_of_days; $i++) {
            $entry_exists = $ukDayCalendarRepository->findOneBy([
                'date' => $startDate
            ]);

            $travelDay = $ukDaysRepository->findOneBy([
                'flightDate' => $startDate
            ]);
            if ($travelDay) {
                $current_location = $travelDay->getArrivalCountry();
            }
            if (!$entry_exists) {
                $newEntry = new UkDayCalendar();
                $date = new \DateTime($startDate->format('Y-m-d'));
                $newEntry->setDate($date)
                    ->setLocationAtMidnight($current_location);
                $entityManager->persist($newEntry);

            } else {
                $entry_exists->setLocationAtMidnight($current_location);
            }
            $entityManager->flush();
            $startDate->modify("+1 day");
        }

        return $this->render('uk_day_calendar/index.html.twig', ['uk_day_calendars' => $ukDayCalendarRepository->findAll(),]);
    }


    /**
     * @Route("/delete_all_calendar", name="uk_day_calendar_delete_all", methods={"GET"})
     */
    public function deleteAllCalendar(Request $request, UkDayCalendarRepository $ukDayCalendarRepository, EntityManagerInterface $entityManager): Response
    {
        $referer = $request->headers->get('referer');
        $calendar_dates = $ukDayCalendarRepository->findAll();
        foreach ($calendar_dates as $calendar_date) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($calendar_date);
            $entityManager->flush();
        }
        return $this->redirect($referer);
    }

    /**
     * @Route("/new", name="uk_day_calendar_new", methods={"GET", "POST"})
     */
    public function new(Request $request, UkDayCalendarRepository $ukDayCalendarRepository): Response
    {
        $referer = $request->headers->get('referer');
        $ukDayCalendar = new UkDayCalendar();
        $form = $this->createForm(UkDayCalendarType::class, $ukDayCalendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ukDayCalendarRepository->add($ukDayCalendar);
            return $this->redirectToRoute('uk_day_calendar_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->redirect($referer);
    }

    /**
     * @Route("/show/{id}", name="uk_day_calendar_show", methods={"GET"})
     */
    public function show(UkDayCalendar $ukDayCalendar): Response
    {
        return $this->render('uk_day_calendar/show.html.twig', [
            'uk_day_calendar' => $ukDayCalendar,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="uk_day_calendar_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, UkDayCalendar $ukDayCalendar, UkDayCalendarRepository $ukDayCalendarRepository): Response
    {
        $form = $this->createForm(UkDayCalendarType::class, $ukDayCalendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ukDayCalendarRepository->add($ukDayCalendar);
            return $this->redirectToRoute('uk_day_calendar_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('uk_day_calendar/edit.html.twig', [
            'uk_day_calendar' => $ukDayCalendar,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="uk_day_calendar_delete", methods={"POST"})
     */
    public function delete(Request $request, UkDayCalendar $ukDayCalendar, UkDayCalendarRepository $ukDayCalendarRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $ukDayCalendar->getId(), $request->request->get('_token'))) {
            $ukDayCalendarRepository->remove($ukDayCalendar);
        }

        return $this->redirectToRoute('uk_day_calendar_index', [], Response::HTTP_SEE_OTHER);
    }
}
