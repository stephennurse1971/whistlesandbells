<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


/**
 * @Route("/user")
 *
 */
class UserController extends AbstractController
{
    /**
     * @Route("/index", name="user_index", methods={"GET"})
     * @Security("is_granted('ROLE_STAFF')")
     */
    public function index(UserRepository $userRepository, ProductRepository $servicesOfferedRepository): Response
    {
        $now = new \DateTime('now');
        $users = $userRepository->findAll();

        return $this->render('user/index_template.html.twig', [
            'users' => $users,
            'services' => $servicesOfferedRepository->findAll(),
            'now' => $now
        ]);
    }


    /**
     * @Route("/new", name="user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, UserRepository $userRepository, \Symfony\Component\Security\Core\Security $security, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $now = new \DateTime('now');
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form['roles']->getData()) {
                $roles = $form['roles']->getData();
                $user->setRoles($roles);
            }
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $user->getPassword()
                )
            );
            $userRepository->add($user, true);

            return $this->redirectToRoute('user_index', ['status' => 'All'], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/show/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, int $id, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher, \Symfony\Component\Security\Core\Security $security): Response
    {
        $referer = $request->request->get('referer');
        $user = $userRepository->find($id);
        $old_password = $user->getPassword();
        $form = $this->createForm(UserType::class, $user, ['user' => $user]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->has('roles')) {
                $roles = $form['roles']->getData();
                $user->setRoles($roles);
            }

            $new_Password = $form['password']->getData();
            if ($new_Password) {
                $user->setPassword(
                    $userPasswordHasher->hashPassword($user, $new_Password));
            } else {
                $user->setPassword(
                    $userPasswordHasher->hashPassword($user, $old_password));
            }

            $userRepository->add($user, true);
            return $this->redirect($referer);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);

    }

    /**
     * @Route("/delete/{id}", name="user_delete", methods={"POST"})
     * @Security("is_granted('ROLE_STAFF')")
     */
    public
    function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }


}
