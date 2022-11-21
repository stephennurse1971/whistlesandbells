<?php

namespace App\Controller;

use App\Entity\RecruiterEmails;
use App\Entity\User;
use App\Form\RecruiterEmailsType;
use App\Form\UserType;
use App\Repository\IntroductionRepository;
use App\Repository\IntroductionSegmentRepository;
use App\Repository\ProspectEmployerRepository;
use App\Repository\RecruiterEmailsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;


use JeroenDesloovere\VCard\VCard;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'role' => 'All',
            'role_title' => 'All'
        ]);
    }

    /**
     * @Route("/addresses", name="user_index_addresses", methods={"GET"})
     */
    public function indexAddresses(UserRepository $userRepository): Response
    {
        return $this->render('user/indexAddresses.html.twig', [
            'users' => $userRepository->findAll(),
            'role' => 'All',
            'role_title' => 'All'
        ]);
    }

    /**
     * @Route("/telnumbers", name="user_index_telnumbers", methods={"GET"})
     */
    public function indexTelNumbers(UserRepository $userRepository): Response
    {
        return $this->render('user/indexTelephoneNumbers.html.twig', [
            'users' => $userRepository->findAll(),
            'role' => 'All',
            'role_title' => 'All'
        ]);
    }

    /**
     * @Route("/role/{role}", name="user_role_index", methods={"GET"})
     */
    public function indexRole(string $role, UserRepository $userRepository): Response
    {

        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findByRole($role),
            'role' => $role,
            'role_title' => $role
        ]);
    }

    /**
     * @Route("/recruiters", name="user_index_recruiters", methods={"GET"})
     */
    public function indexRecruiters(UserRepository $userRepository, ProspectEmployerRepository $prospectEmployerRepository, RecruiterEmailsRepository $recruiterEmailsRepository): Response
    {
        return $this->render('user/indexRecruiters.html.twig', [
            'users' => $userRepository->findByRole('ROLE_RECRUITER'),
            'prospect_employers' => $prospectEmployerRepository->findAll(),
            'recruiterEmails' => $recruiterEmailsRepository->findAll(),
            'role' => "Recruiters",
            'role_title' => "Recruiters"
        ]);
    }

    /**
     * @Route("/group/AX", name="user_ax", methods={"GET"})
     */
    public function indexAX(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findByCompany('AX'),
            'role' => "AX"
        ]);
    }

    /**
     * @Route("/group/Personal", name="user_personal", methods={"GET"})
     */
    public function indexPersonal(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findByCompany('Personal'),
            'role' => "Personal"
        ]);
    }

    /**
     * @Route("/group/Birthdays", name="user_birthdays", methods={"GET"})
     */
    public function indexBirthdays(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        $users_container = [];
        foreach ($users as $user) {
            if ($user->getBirthday() != '') {
                $users_container[] = $user;
            }
        }
        return $this->render('user/indexBirthday.html.twig', [
            'users' => $users_container,
            'role' => "Personal"
        ]);
    }


    /**
     * @Route("/delete_all_AX", name="/user/delete_all_AX")
     */
    public function deleteAllAXUsers(UserRepository $userRepository)
    {
        $allAXUser = $userRepository->findByCompany('AX');
        foreach ($allAXUser as $AXUser) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($AXUser);
            $entityManager->flush();
        }
        return $this->redirectToRoute('user_index');
    }

    /**
     * @Route("/delete_all_Personal", name="/user/delete_all_Personal")
     */
    public function deleteAllPersonalUsers(UserRepository $userRepository)
    {
        $allPersonalUser = $userRepository->findByCompany('Personal');
        foreach ($allPersonalUser as $PersonalUser) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($PersonalUser);
            $entityManager->flush();
        }
        return $this->redirectToRoute('user_index');
    }

    /**
     * @Route("/delete_all_non_admin", name="/user/delete_all_non_admin")
     */
    public function deleteAllNonAdminUsers(UserRepository $userRepository)
    {

        $users = $userRepository->findAll();
        foreach ($users as $user) {
            $roles = $user->getRoles();
            if (!in_array('ROLE_ADMIN', $roles) && !in_array('ROLE_SUPER_ADMIN', $roles)) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($user);
                $entityManager->flush();
            }
        }
        return $this->redirectToRoute('user_index');
    }

    /**
     * @Route("/admin/new", name="user_new", methods={"GET","POST"})
     */
    public function new(MailerInterface $mailer, Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, ['email1' => $user->getEmail(), 'email2' => $user->getEmail2(), 'user' => $user]);
        $roles = $this->getUser()->getRoles();

        if (!in_array('ROLE_SUPER_ADMIN', $roles)) {
            $form->remove('role');
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $get_roles = $form->get('role')->getData();
            $roles = $get_roles;
            $password = $form->get('password')->getData();
            if ($password != '') {
                $user->setPlainPassword($password);
                $user->setPassword($passwordEncoder->encodePassword($user, $password));
            }
            $user->setRoles($roles);

            $firstName = $user->getFirstName();
            $lastName = $user->getLastName();
            $user->setFullName($firstName . ' ' . $lastName);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            if ($form['sendEmail']->getData() == 1) {
                $html = $this->renderView('emails/welcome_email.html.twig');
                $email = (new Email())
                    ->from('nurse_stephen@hotmail.com')
                    ->to($user->getEmail())
                    ->cc('nurse_stephen@hotmail.com')
                    ->subject("Welcome to SN's personal website")
                    ->html($html);
                $mailer->send($email);
            }
            return $this->redirectToRoute('user_index');
        }
        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(int $id, MailerInterface $mailer, Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        $hasAccess = in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles());
        if ($this->getUser()->getId() == $id || $hasAccess) {
            $logged_user_id = $this->getUser()->getId();
            $plainPassword = $user->getPlainPassword();
            $roles = $user->getRoles();
            $form = $this->createForm(UserType::class, $user, ['email1' => $user->getEmail(), 'email2' => $user->getEmail2(), 'user' => $user]);
            $logged_user_roles = $this->getUser()->getRoles();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                if ($form->has('role')) {
                    $get_roles = $form->get('role')->getData();

                    $roles = $get_roles;
                    $user->setRoles($roles);
                }
                $password = $form->get('password')->getData();
                if ($password != '') {
                    $user->setPassword($passwordEncoder->encodePassword($user, $password));
                    $user->setPlainPassword($password);
                }

                $firstName = $user->getFirstName();
                $lastName = $user->getLastName();
                $user->setFullName($firstName . ' ' . $lastName);

                $this->getDoctrine()->getManager()->flush();

                if ($form['sendEmail']->getData() == 1) {
                    $html = $this->renderView('emails/welcome_email.html.twig');
                    $email = (new Email())
                        ->from('nurse_stephen@hotmail.com')
                        ->to($user->getEmail())
                        ->cc('nurse_stephen@hotmail.com')
                        ->subject("Welcome to SN's personal website")
                        ->html($html);
                    $mailer->send($email);
                }
                if ($logged_user_id != $id) {
                    return $this->redirectToRoute('user_index');
                } else {
                    $this->redirectToRoute('app_login');
                }
            }

            return $this->render('user/edit.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
                'password' => $plainPassword,
                'roles' => $roles
            ]);
        }
        $referer = $request->server->get('HTTP_REFERER');
        if ($referer) {
            return $this->redirect($referer);

        } else {
            return $this->redirectToRoute('user_index');
        }
    }

    /**
     * @Route("/{id}/{role}/{active}/edit", name="user_edit_button", methods={"GET","POST"})
     */
    public function editAuto(string $role, Request $request, User $user, EntityManagerInterface $entityManager): Response
    {

        $get_roles = $user->getRoles();
        if (!in_array($role, $get_roles)) {
            $get_roles[] = $role;
        } else {
            $get_roles = array_merge(array_diff($get_roles, [$role]));
        }
        $user->setRoles($get_roles);
        $entityManager->flush();
        $referer = $request->server->get('HTTP_REFERER');
        return $this->redirect($referer);
    }

    /**
     * @Route("/admin/{id}", name="user_delete", methods={"POST"})
     * @Security("is_granted('ROLE_SUPER_ADMIN')")
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }
        return $this->redirectToRoute('user_index');
    }


    /**
     * @Route("/{userid}/invite-email", name="user_invite", methods={"GET"})
     */
    public function inviteEmail(int $userid, MailerInterface $mailer, Request $request, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($userid);
        $html = $this->renderView('emails/welcome_email.html.twig', [
            'user' => $user
        ]);
        $email = (new Email())
            ->from('nurse_stephen@hotmail.com')
            ->to($user->getEmail())
            ->cc('nurse_stephen@hotmail.com')
            ->subject("Welcome to SN's personal website")
            ->html($html);
        $mailer->send($email);
        $referer = $request->server->get('HTTP_REFERER');
        return $this->redirect($referer);
    }

    /**
     * @Route("/{authorId}/{recruiterId}/{recruiterCountry}/{editable}/recruiter_intro_email", name="recruiter_intro", methods={"GET","POST"})
     */
    public function recruiterInviteEmail(string                 $recruiterCountry, int $authorId, int $recruiterId, string $editable, MailerInterface $mailer, Request $request, UserRepository $userRepository,
                                         IntroductionRepository $introductionRepository, IntroductionSegmentRepository $introductionSegmentRepository, EntityManagerInterface $manager): Response
    {
        $author = $userRepository->find($authorId);
        $recruiter = $userRepository->find($recruiterId);
        $subject = $introductionRepository->find($authorId)->getSubjectLine();
        $additional_segment = '';
        $segment = $introductionSegmentRepository->findOneBy(['user' => $author, 'country' => $recruiterCountry]);
        if ($segment) {
            $additional_segment = $introductionSegmentRepository->findOneBy(['user' => $author, 'country' => $recruiterCountry])->getEmailSegment();
        }
        $html = $this->renderView('emails/recruiter_intro_email.html.twig', [
            'user' => $author,
            'content1' => $introductionRepository->find($authorId)->getIntroductoryEmail(),
            'content2' => $introductionRepository->find($authorId)->getIntroductoryEmail2(),
            'additional_segment' => $additional_segment
        ]);
        $html = 'Dear ' . $recruiter->getSalutation() . ' ' . $recruiter->getLastName() . ',' . $html;
        $introduction_attachment = $introductionRepository->find($authorId)->getAttachment();

        $recruiterEmail = new RecruiterEmails();
        if ($editable == "editable") {
            $recruiterEmail->setAuthorFullName($author->getFullName())
                ->setSendBccFullName($author->getFullName())
                ->setSendToFullName($recruiter->getFullName())
                ->setSendDate(new \DateTime('now'));

            $recruiterEmail->setAuthor($author->getEmail())
                ->setSendTo('nurse_stephen@hotmail.com')
//            ->setSendTo($recruiter->getEmail())
                ->setSendBcc($author->getEmail())
                ->setSubject($subject)
                ->setBody($html)
                ->setAttachment($introduction_attachment);
            $form = $this->createForm(RecruiterEmailsType::class, $recruiterEmail);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $email = (new Email())
                    ->to('nurse_stephen@hotmail.com')
//                    ->to($recruiterEmail->getSendTo())
                    ->bcc($recruiterEmail->getSendBcc())
                    ->subject($recruiterEmail->getSubject())
                    ->from($author->getEmail())
                    ->html($recruiterEmail->getBody());
                if ($introduction_attachment) {
                    $attachment_path = $this->getParameter('files_upload_default_directory') . "/" . $introduction_attachment;
                    $email->attachFromPath($attachment_path);
                }
                $mailer->send($email);
                $manager->persist($recruiterEmail);
                $manager->flush();
                return $this->redirectToRoute("recruiter_emails_index");
            }
            return $this->render("recruiter_emails/new.html.twig", [
                'form' => $form->createView(),
            ]);
        } else {

            $email = (new Email())
                ->to('nurse_stephen@hotmail.com')
                ->bcc($author->getEmail())
                ->subject($subject)
                ->from($author->getEmail())
                ->html($html);
            if ($introduction_attachment) {
                $attachment_path = $this->getParameter('files_upload_default_directory') . "/" . $introduction_attachment;
                $email->attachFromPath($attachment_path);
            }
            $recruiterEmail
                ->setSendTo('nurse_stephen@hotmail.com')
                ->setSendToFullName($recruiter->getFullName())
                ->setSendBcc($author->getEmail())
                ->setsendBccFullName($author->getFullName())
                ->setAuthor($author->getEmail())
                ->setauthorFullName($author->getFullName())
                ->setSubject($subject)
                ->setSendDate(new \DateTime('now'))
                ->setBody($html)
                ->setAttachment($introduction_attachment);
            $mailer->send($email);
            $manager->persist($recruiterEmail);
            $manager->flush();
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }
    }

    /**
     * @Route("/recruiter/email/CV/", name="recruiter_email_CV", methods={"GET","POST"})
     */
    public function recruiterEmailCV(\Symfony\Component\Security\Core\Security $security, MailerInterface $mailer, Request $request,
                                     UserRepository                            $userRepository, EntityManagerInterface $manager): Response
    {
        if($request->isMethod('POST'))
        {
            $recipientEmail = $_POST['email'];
        } else {
            $recipient = $security->getUser();
            $recipientEmail = $recipient->getEmail();
        }


            $subject = "CV for Stephen Nurse";
            $html = $this->renderView('template_parts/emailCV.html.twig', [
                'content' => 'xxx',
            ]);
            $email = (new Email())
                ->to($recipientEmail)
                ->cc('nurse_stephen@hotmail.com')
                ->subject($subject)
                ->from('nurse_stephen@hotmail.com')
                ->html($html);
            $attachment_path = $this->getParameter('files_cv_directory') . "/CV_StephenNurse.pdf";
            $email->attachFromPath($attachment_path);
            $mailer->send($email);


        $referer = $request->headers->get('referer');
        return $this->redirect($referer);

    }


    /**
     * @Route("/create/Vcarduser/{userid}", name="create_vcard_user")
     */
    public function createVcardUser(int $userid, UserRepository $userRepository)
    {
        $user = $userRepository->find($userid);
        $vcard = new VCard();
        $userFirstName = $user->getFirstName();
        $userLastName = $user->getLastName();
        $vcard->addName($userFirstName, $userLastName);
        $vcard->addEmail($user->getEmail())
            ->addJobtitle($user->getJobTitle())
            ->addBirthday($user->getBirthday())
            ->addCompany($user->getCompany())
            ->addPhoneNumber($user->getBusinessPhone(), 'work')
            ->addPhoneNumber($user->getMobile(), 'home')
            ->addURL($user->getWebPage());
        $vcard->download();
        return new Response(null);
    }

    /**
     * @Route("/create/StephenNurse/Vcarduser", name="create_vcard_SN")
     */
    public function createVcardSN(UserRepository $userRepository)
    {

        $user = $userRepository->find(1);
        $vcard = new VCard();
        $userFirstName = $user->getFirstName();
        $userLastName = $user->getLastName();
        $vcard->addName($userFirstName, $userLastName);
        $vcard->addEmail($user->getEmail())
            ->addJobtitle($user->getJobTitle())
            ->addBirthday($user->getBirthday()->format('d-m-y'))
            ->addCompany($user->getCompany())
            ->addPhoneNumber($user->getBusinessPhone(), 'work')
            ->addPhoneNumber($user->getMobile(), 'home')
            ->addURL($user->getWebPage());
        $vcard->download();
        return new Response(null);
    }

    /**
     * @Route ("/user/export/file/{Subset}", name="user_export" )
     */
    public function export(string $Subset, UserRepository $userRepository)
    {

        $data = [];
        if ($Subset == 'All') {
            $user_list = $userRepository->findAll();
            $fileName = 'all_users_export.csv';
        }
        if ($Subset == 'Recruiters') {
            $user_list = $userRepository->findByRole('ROLE_RECRUITER');
            $fileName = 'recruiters_export.csv';
        }

        $exported_date = new \DateTime('now');
        $exported_date = $exported_date->format('d-M-Y h:m');
        $count = 0;
        foreach ($user_list as $user) {
            $birthday = "N/A";
            $landline = "N/A";
            $concatenatedNotes =
                "Exported from Stephen-Nurse.com on: " . $exported_date . ";       " .
                "Notes: " . $user->getNotes();

            if ($user->getBirthday() != null) {
                $birthday = $user->getBirthday()->format('d-m-Y');
            }
            $data[] = [
                "Blank",
                $user->getSalutation(),
                $user->getFirstName(),
                $user->getLastName(),
                $user->getJobTitle(),
                $user->getCompany(),
                $user->getBirthday(),

                $user->getBusinessStreet(),
                $user->getBusinessCity(),
                $user->getBusinessPostalCode(),
                $user->getBusinessCountry(),
                $user->getHomeStreet(),
                $user->getHomeCity(),
                $user->getHomePostalCode(),
                $user->getHomeCountry(),

                $user->getMobile(),
                $user->getMobile2(),
                $user->getBusinessPhone(),
                $user->getHomePhone(),
                $user->getHomePhone2(),
                $user->getEmail(),
                $user->getEmail2(),
                $user->getEmail3(),
                $concatenatedNotes
            ];
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Users');
        $sheet->getCell('A1')->setValue('Blank');
        $sheet->getCell('B1')->setValue('Salutation');
        $sheet->getCell('C1')->setValue('First Name');
        $sheet->getCell('D1')->setValue('Last Name');
        $sheet->getCell('E1')->setValue('JobTitle');
        $sheet->getCell('F1')->setValue('Company');
        $sheet->getCell('G1')->setValue('Birthday');

        $sheet->getCell('H1')->setValue('Business Street');
        $sheet->getCell('I1')->setValue('Business City');
        $sheet->getCell('J1')->setValue('Business PostalCode');
        $sheet->getCell('K1')->setValue('Business Country');
        $sheet->getCell('L1')->setValue('Home Street');
        $sheet->getCell('M1')->setValue('Home City');
        $sheet->getCell('N1')->setValue('Home PostalCode');
        $sheet->getCell('O1')->setValue('Home Country');

        $sheet->getCell('P1')->setValue('Mobile1');
        $sheet->getCell('Q1')->setValue('Mobile2');
        $sheet->getCell('R1')->setValue('Business phone');
        $sheet->getCell('S1')->setValue('Home Phone1');
        $sheet->getCell('T1')->setValue('Home Phone2');
        $sheet->getCell('U1')->setValue('Email1');
        $sheet->getCell('V1')->setValue('Email2');
        $sheet->getCell('W1')->setValue('Email3');

        $sheet->getCell('X1')->setValue('Notes');

        $sheet->fromArray($data, null, 'A2', true);
        $total_rows = $sheet->getHighestRow();
        for ($i = 2; $i <= $total_rows; $i++) {
            $cell = "L" . $i;
            $sheet->getCell($cell)->getHyperlink()->setUrl("https://google.com");
        }
        $writer = new Csv($spreadsheet);


        $response = new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', sprintf('attachment;filename="%s"', $fileName));
        $response->headers->set('Cache-Control', 'max-age=0');
        return $response;
    }
}
