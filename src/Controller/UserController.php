<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\DefaultTennisPlayerAvailabilityHoursRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/role/{role}", name="user_role_index", methods={"GET"})
     */
    public function indexRole(string $role, UserRepository $userRepository): Response
    {

        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'role' => $role,
            'role_title' => $role_title
        ]);
    }


    /**
     * @Route("/admin/new", name="user_new", methods={"GET","POST"})
     */

    public function new(MailerInterface $mailer, Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, ['email1'=>$user->getEmail(),'email2'=>$user->getEmail2()]);
        $roles = $this->getUser()->getRoles();

        if (!in_array('ROLE_SUPER_ADMIN',$roles)) {
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
            $user->setFullName($firstName . ' '.$lastName);

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
    public function edit(int $id, MailerInterface $mailer, Request $request, User $user,DefaultTennisPlayerAvailabilityHoursRepository $defaultTennisPlayerAvailabilityHoursRepository ,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $hours = [];
        for ($i= 7; $i<=23; $i++)
        {
            $hours[$i]['hour']=$i.':00';
            $hours[$i]['sort']=$i;
        }

        $hasAccess = in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles());
        if ($this->getUser()->getId() == $id || $hasAccess)
        {
            $plainPassword = $user->getPlainPassword();
            $roles = $user->getRoles();
            $form = $this->createForm(UserType::class, $user, ['email1'=>$user->getEmail(),'email2'=>$user->getEmail2()]);
            $logged_user_roles = $this->getUser()->getRoles();
            if (!in_array('ROLE_SUPER_ADMIN',$logged_user_roles)) {
                $form->remove('role');
                $form->remove('tennisRank');
                $form->remove('tennisRankScore');
            }
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                if($form->has('role')){
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
                $user->setFullName($firstName . ' '.$lastName);

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
                return $this->redirectToRoute('user_index');
            }

            return $this->render('user/edit.html.twig', [

                'default_tennis_player_availability_hours' => $defaultTennisPlayerAvailabilityHoursRepository->findAll(),
                'user' => $user,
                'form' => $form->createView(),
                'password' => $plainPassword,
                'roles' => $roles,
                'hours' => $hours
            ]);
        }
        $referer = $request->server->get('HTTP_REFERER');
        if($referer){
            return $this->redirect($referer);

        }
        else{
            return $this->redirectToRoute('user_index');
        }
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


}
