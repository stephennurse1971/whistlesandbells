<?php

namespace App\Controller;

use App\Entity\HouseGuests;
use App\Form\HouseGuestsType;
use App\Repository\HouseGuestsRepository;
use App\Repository\UserRepository;
use App\Services\HouseGuestPerDayList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/houseguests")
 * @IsGranted("ROLE_GUEST")
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
     * @Route("/new/{startdate}", name="house_guests_new", methods={"GET","POST"})
     */
    public function new(String $startdate,Request $request, Security $security, MailerInterface $mailer,UserRepository $userRepository): Response
    {
        $defaultDepartureDate = new \DateTime($startdate);
        $defaultDepartureDate = $defaultDepartureDate->modify("+1 day");

        $logged_user = $security->getUser();
        if(in_array("ROLE_ADMIN",$logged_user->getRoles()))
        {
            $user_list = $userRepository->findByRole('ROLE_GUEST');
        }
        else{
            $user_list = $userRepository->findBy(['id'=>$logged_user->getId()]);
        }
        $houseGuest = new HouseGuests();
        $form = $this->createForm(HouseGuestsType::class, $houseGuest,['user_list'=>$user_list]);
        $houseGuest->setDateArrival(new \DateTime($startdate));
        $houseGuest->setDateDeparture($defaultDepartureDate);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($houseGuest);
            $entityManager->flush();
            $senderEmail = $security->getUser()->getEmail();
            $senderName = $security->getUser()->getFullName();

            $recipient = 'nurse_stephen@hotmail.com';
            $subject = 'New guest booking'. ' - ' . $senderName;
            $html = 'New booking';
            $email = (new Email())
                ->to($recipient)
                ->subject($subject)
                ->from($senderEmail)
                ->html($html);
            $mailer->send($email);


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
    public function edit(Request $request, HouseGuests $houseGuest,Security $security,UserRepository $userRepository): Response
    {
        $logged_user = $security->getUser();
        if(in_array("ROLE_ADMIN",$logged_user->getRoles()))
        {
            $user_list = $userRepository->findByRole('ROLE_GUEST');
        }
        else{
            $user_list = $userRepository->findBy(['id'=>$logged_user->getId()]);
        }
        $startdate = $houseGuest->getDateArrival()->format('d-m-y');
        $form = $this->createForm(HouseGuestsType::class, $houseGuest,['user_list'=>$user_list]);

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
