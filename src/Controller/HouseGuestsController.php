<?php

namespace App\Controller;

use App\Entity\HouseGuests;
use App\Form\HouseGuestsType;
use App\Repository\CmsCopyRepository;
use App\Repository\CmsPhotoRepository;
use App\Repository\FlightDestinationsRepository;
use App\Repository\FlightStatsRepository;
use App\Repository\HouseGuestsRepository;
use App\Repository\SettingsRepository;
use App\Repository\UserRepository;
use App\Services\FlightPrice;
use App\Services\HouseGuestPerDayList;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/houseguests")
 * @IsGranted("ROLE_GUEST")
 */
class HouseGuestsController extends AbstractController
{
    /**
     * @Route("/", name="house_guests_index", methods={"GET"})
     */
    public function index(HouseGuestsRepository $houseGuestsRepository, HouseGuestPerDayList $houseGuestPerDayList, FlightStatsRepository $flightStatsRepository, SettingsRepository $settingsRepository, FlightDestinationsRepository $flightDestinationsRepository): Response
    {
        $flightDestinations = $flightDestinationsRepository->findAll();
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
            'flight_destinations' => $flightDestinations,
            'house_guests' => $lists = $houseGuestPerDayList->guestList(),
            'dates' => $dates,
            'flights' => $flightStatsRepository->findAll(),
            'settings' => $settingsRepository->find('1')
        ]);
    }

    /**
     * @Route("/new/{startdate}", name="house_guests_new", methods={"GET","POST"})
     */
    public function new(string $startdate, Request $request, Security $security, MailerInterface $mailer, UserRepository $userRepository): Response
    {
        $calendar = new HouseGuests();
        $defaultDepartureDate = new \DateTime($startdate);
        $defaultDepartureDate = $defaultDepartureDate->modify("+1 day");

        $logged_user = $security->getUser();
        $referenceInformation = '';
        if (in_array("ROLE_ADMIN", $logged_user->getRoles())) {
            $user_list = $userRepository->findByRole('ROLE_GUEST');

        } else {
            $user_list = $userRepository->findBy(['id' => $logged_user->getId()]);
            $referenceInformation = "Guest Booking";
        }
        $houseGuest = new HouseGuests();
        $form = $this->createForm(HouseGuestsType::class, $houseGuest, ['user_list' => $user_list,'referenceInformation'=>$referenceInformation]);
        $houseGuest->setDateArrival(new \DateTime($startdate));
        $houseGuest->setDateDeparture($defaultDepartureDate);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($houseGuest);
            $entityManager->flush();
            if ($houseGuest->getGuestName()) {
                $senderEmail = $security->getUser()->getEmail();
                $guest = $houseGuest->getGuestName()->getFullName();
                $arrivalDate = $houseGuest->getDateArrival()->format('d-M-Y');
                $departureDate = $houseGuest->getDateDeparture()->format('d-M-Y');
                $meetingStartTime = new \DateTime('now');
                $meetingEndTime = new \DateTime('now');
                $meetingEndTime->modify("+1 day");
                $recipient = 'nurse_stephen@hotmail.com';
                $subject = 'New guest booking' . ' - ' . $guest;
                $html = '<p>New booking for ' . $guest . ' - Arriving on ' . $arrivalDate . ' and departing ' . $departureDate . '</p>';
                $email = (new Email())
                    ->to($recipient)
                    ->subject($subject)
                    ->from('nurse_stephen@hotmail.com')
                    ->html($html);
                $mailer->send($email);
            }
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
    public function edit(Request $request, HouseGuests $houseGuest, Security $security, MailerInterface $mailer, UserRepository $userRepository): Response
    {
        $logged_user = $security->getUser();
        $referenceInformation = '';
        if (in_array("ROLE_ADMIN", $logged_user->getRoles())) {
            $user_list = $userRepository->findByRole('ROLE_GUEST');

        } else {
            $user_list = $userRepository->findBy(['id' => $logged_user->getId()]);
            $referenceInformation = "Guest Booking";
        }
        $startdate = $houseGuest->getDateArrival()->format('d-m-y');
        $form = $this->createForm(HouseGuestsType::class, $houseGuest, ['user_list' => $user_list,'referenceInformation'=>$referenceInformation]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            if ($houseGuest->getGuestName()) {
                $senderEmail = $security->getUser()->getEmail();
                $guest = $houseGuest->getGuestName()->getFullName();
                $arrivalDate = $houseGuest->getDateArrival()->format('d-M-Y');
                $departureDate = $houseGuest->getDateDeparture()->format('d-M-Y');
                $recipient = 'nurse_stephen@hotmail.com';
                $subject = 'New guest booking' . ' - ' . $guest;
                $html = '<p>New booking for ' . $guest . ' - Arriving on ' . $arrivalDate . ' and departing ' . $departureDate . '</p>';
                $email = (new Email())
                    ->to($recipient)
                    ->subject($subject)
                    ->from('nurse_stephen@hotmail.com')
                    ->html($html);
                $mailer->send($email);
            }
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

    /**
     * @Route("/flight/price/scrape/all", name="house_guests_flight_price_scrape_all")
     */
    public function getPrice(FlightPrice $flightPrice, FlightDestinationsRepository $flightDestinationsRepository): Response
    {
        $flightPrice->getPrice('all');
        return $this->redirectToRoute('house_guests_index');
    }

    /**
     * @Route("/flight/price/scrape_one_destination/{id}", name="house_guests_flight_price_scrape_one_destination")
     */
    public function getPriceOne(Request $request, $id, FlightPrice $flightPrice, FlightDestinationsRepository $flightDestinationsRepository): Response
    {
        $flightPrice->getPrice($id);
        return $this->redirectToRoute('house_guests_index');
    }
}
