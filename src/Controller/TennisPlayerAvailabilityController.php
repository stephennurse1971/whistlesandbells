<?php

namespace App\Controller;

use App\Entity\TennisCourtAvailability;
use App\Entity\TennisPlayerAvailability;
use App\Form\TennisCourtAvailabilityType;
use App\Form\TennisPlayerAvailabilityType;
use App\Repository\DefaultTennisPlayerAvailabilityHoursRepository;
use App\Repository\TennisCourtAvailabilityRepository;
use App\Repository\TennisCourtPreferencesRepository;
use App\Repository\TennisPlayerAvailabilityRepository;
use App\Repository\TennisPlayersRepository;
use App\Repository\TennisVenuesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tennis/player_availability")
 */
class TennisPlayerAvailabilityController extends AbstractController
{
    /**
     * @Route("/", name="tennis_player_availability_index", methods={"GET"})
     */
    public function index(Request $request, TennisPlayerAvailabilityRepository $tennisPlayerAvailabilityRepository, TennisCourtPreferencesRepository $tennisCourtPreferencesRepository, UserRepository $userRepository, TennisCourtAvailabilityRepository $tennisCourtAvailabilityRepository, TennisVenuesRepository $tennisVenuesRepository): Response
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

        return $this->render('tennis_player_availability/index.html.twig', [
            'tennis_player_availabilities' => $tennisPlayerAvailabilityRepository->findAll(),
            'tennis_court_availabilities' => $tennisCourtAvailabilityRepository->findAll(),
            'tennis_court_preferences' => $tennisCourtPreferencesRepository->findAll(),
            'dates' => $dates,
            'hours' => $hours,
            'tennis_players' => $userRepository->findAll(),
            'minDate' => $request->query->get('minDate'),
            'maxDate' => $request->query->get('maxDate'),
            'today' => $today,
            'lastMonday' => $lastMonday,
            'nextSunday' => $nextSunday,
            'monday2' => $monday2,
            'monday3' => $monday3,
            'sunday2' => $sunday2,
            'sunday3' => $sunday3,
        ]);
    }

    /**
     * @Route("/reset/", name="tennis_player_availability_reset_or_defaults", methods={"GET"})
     */
    public function editResetOrDefault(UserRepository $userRepository, DefaultTennisPlayerAvailabilityHoursRepository $defaultTennisPlayerAvailabilityHoursRepository, Request $request, TennisPlayerAvailabilityRepository $tennisPlayerAvailabilityRepository, EntityManagerInterface $entityManager)
    {
        $resetOrDefault = $request->query->get('resetOrDefault');
        $startDate = $request->query->get('startDate');
        $endDate = $request->query->get('endDate');
        $userId = $request->query->get('userID');

        $relevantValues = $tennisPlayerAvailabilityRepository->ByPlayerAndDateRange($userId, $startDate, $endDate);

        $defaultHourSettingsWeekday = $defaultTennisPlayerAvailabilityHoursRepository->findBy([
            'user' => $userId,
            'WeekdayOrWeekend' => 'Weekday'
        ]);
        $defaultHourSettingsWeekend = $defaultTennisPlayerAvailabilityHoursRepository->findBy([
            'user' => $userId,
            'WeekdayOrWeekend' => 'Weekend'
        ]);

        if ($resetOrDefault == 'reset') {
            foreach ($relevantValues as $relevantValue) {
                $this->getDoctrine()->getManager()->remove($relevantValue);
                $this->getDoctrine()->getManager()->flush();
            }
        }
        if ($resetOrDefault == 'default') {
            foreach ($relevantValues as $relevantValue) {
                $this->getDoctrine()->getManager()->remove($relevantValue);
                $this->getDoctrine()->getManager()->flush();
            }

            $minDate = new \DateTime($startDate);
            $maxDate = new \DateTime($endDate);
            $range = $maxDate->format('N') - $minDate->format('N');

            for ($count = 0; $count <= $range; $count++) {
                $date = new \DateTime($startDate);
                $date = $date->modify('+' . $count . 'day');
                $dayName = $date->format('D');

                if ($dayName == 'Sat' || $dayName == 'Sun') {
                    foreach ($defaultHourSettingsWeekend as $defaultHourSetting) {
                        $tennisPlayerAvailability = new TennisPlayerAvailability();
                        $tennisPlayerAvailability->setUser($defaultHourSetting->getUser());
                        $tennisPlayerAvailability->setDate($date);
                        $tennisPlayerAvailability->setHour($defaultHourSetting->getHour());
                        $tennisPlayerAvailability->setAvailable($defaultHourSetting->getDefaultAvailable());
                        $entityManager->persist($tennisPlayerAvailability);
                        $entityManager->flush();
                    }
                } else {
                    foreach ($defaultHourSettingsWeekday as $defaultHourSetting) {
                        $tennisPlayerAvailability = new TennisPlayerAvailability();
                        $tennisPlayerAvailability->setUser($defaultHourSetting->getUser());
                        $tennisPlayerAvailability->setDate($date);
                        $tennisPlayerAvailability->setHour($defaultHourSetting->getHour());
                        $tennisPlayerAvailability->setAvailable($defaultHourSetting->getDefaultAvailable());
                        $entityManager->persist($tennisPlayerAvailability);
                        $entityManager->flush();
                    }
                }
            }
        }


        $referer = $request->server->get('HTTP_REFERER');
        return $this->redirect($referer);
    }

    /**
     * @Route("/tennisplayerandcourt", name="tennis_player_and_courtavailability_index", methods={"GET"})
     */
    public function indexPlayerAndCourt(Request $request, TennisPlayerAvailabilityRepository $tennisPlayerAvailabilityRepository, TennisCourtPreferencesRepository $tennisCourtPreferencesRepository, UserRepository $userRepository, TennisCourtAvailabilityRepository $tennisCourtAvailabilityRepository, TennisVenuesRepository $tennisVenuesRepository): Response
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

        return $this->render('tennis_player_availability/playerandcourtindex.html.twig', [
            'tennis_player_availabilities' => $tennisPlayerAvailabilityRepository->findAll(),
            'tennis_court_availabilities' => $tennisCourtAvailabilityRepository->findAll(),
            'tennis_court_preferences' => $tennisCourtPreferencesRepository->findAll(),
            'dates' => $dates,
            'hours' => $hours,
            'tennis_players' => $userRepository->findAll(),
            'minDate' => $request->query->get('minDate'),
            'maxDate' => $request->query->get('maxDate'),
            'today' => $today,
            'lastMonday' => $lastMonday,
            'nextSunday' => $nextSunday,
            'monday2' => $monday2,
            'monday3' => $monday3,
            'sunday2' => $sunday2,
            'sunday3' => $sunday3,
        ]);
    }


    /**
     * @Route("/bookAndEmail", name="tennis_player_availability_book_and_email", methods={"GET","POST"})
     */
    public function bookAndEmail(TennisCourtAvailabilityRepository $tennisCourtAvailabilityRepository, TennisVenuesRepository $tennisVenuesRepository, UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer)
    {
        $tennisCourtAvailabilityID = $request->query->get('tennis_court_availability_id');
        $player1_ID = $request->query->get('player1');
        $player2_ID = $request->query->get('player2');
        $player3_ID = $request->query->get('player3');
        $player4_ID = $request->query->get('player4');

        $player1 = $userRepository->find($player1_ID);
        $player2 = $userRepository->find($player2_ID);
        $player3 = $userRepository->find($player3_ID);
        $player4 = $userRepository->find($player4_ID);
        $email1 = $player1->getEmail();
        $email2 = $player2->getEmail();
        $email3 = $player3->getEmail();
        $email4 = $player4->getEmail();
        $fullName1 = $player1->getFullName();
        $fullName2 = $player2->getFullName();
        $fullName3 = $player3->getFullName();
        $fullName4 = $player4->getFullName();

        $tennisCourtAvailability = $tennisCourtAvailabilityRepository->find($tennisCourtAvailabilityID);
        $tennisCourtAvailability->setCourtBooked('1');
        $entityManager->flush();
        $courtBookedVenueID =  $tennisCourtAvailability->getVenue('1');
        $tennisVenuesRepository = $tennisVenuesRepository->find($courtBookedVenueID);

        $courtBookedVenue=  $tennisVenuesRepository->getVenue();
        $courtBookedVenueAddress=  $tennisVenuesRepository->getAddress();


        $html = $this->renderView('emails/court_booked_email.html.twig', [
                'fullName1' => $fullName1,
                'fullName2' => $fullName2,
                'fullName3' => $fullName3,
                'fullName4' => $fullName4,
                'courtBookedVenue' =>$courtBookedVenue,
                'courtBookedVenueAddress' =>$courtBookedVenueAddress,
            ]
        );
        $email = (new Email())
            ->from('sjwn71@gmail.com')
            ->to($email1)
            //->to($email1.','.$email2.','.$email3.','.$email4)
            ->subject("Tennis Court Booked")
            ->html($html);
        $mailer->send($email);
        if ($email) {
            $this->addFlash('emailNotify', 'Email sent successfully');
        }

        $referer = $request->server->get('HTTP_REFERER');
        return $this->redirect($referer);
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
