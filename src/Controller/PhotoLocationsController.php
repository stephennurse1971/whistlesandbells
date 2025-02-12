<?php

namespace App\Controller;

use App\Entity\PhotoLocations;
use App\Form\PhotoLocationsType;
use App\Repository\PhotoLocationsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/photolocations")
 * @Security("is_granted('ROLE_ADMIN')")
 *
 */
class PhotoLocationsController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private PhotoLocationsRepository $photoLocationsRepository;

    public function __construct(EntityManagerInterface $entityManager, PhotoLocationsRepository $photoLocationsRepository)
    {
        $this->entityManager = $entityManager;
        $this->photoLocationsRepository = $photoLocationsRepository;
    }


    /**
     * @Route("/index", name="photo_locations_index", methods={"GET"})
     */
    public function index(PhotoLocationsRepository $photoLocationsRepository): Response
    {
        return $this->render('photo_locations/index.html.twig', [
            'photo_locations' => $photoLocationsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="photo_locations_new", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $photoLocation = new PhotoLocations();
        $form = $this->createForm(PhotoLocationsType::class, $photoLocation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $usersID_container = [];
            $enabledUsers = $form['enabledUsers']->getData();
            foreach ($enabledUsers as $user) {
                $usersID_container[] = $user->getID();
            }
            $photoLocation->setEnabledUsers($usersID_container);
            $entityManager->persist($photoLocation);
            $entityManager->flush();
            return $this->redirectToRoute('photo_locations_index');
        }

        return $this->render('photo_locations/new.html.twig', [
            'photo_location' => $photoLocation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="photo_locations_show", methods={"GET"})
     */
    public function show(PhotoLocations $photoLocation): Response
    {
        return $this->render('photo_locations/show.html.twig', [
            'photo_location' => $photoLocation,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="photo_locations_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PhotoLocations $photoLocation, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $users = [];
        foreach ($photoLocation->getEnabledUsers() as $userId) {
            $users[] = $userRepository->find($userId);
        }
        $form = $this->createForm(PhotoLocationsType::class, $photoLocation, ['Users' => $users]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $usersID_container = [];
            $enabledUsers = $form['enabledUsers']->getData();
            foreach ($enabledUsers as $user) {
                $usersID_container[] = $user->getID();

            }
            $photoLocation->setEnabledUsers($usersID_container);
            $entityManager = $this->entityManager;
            $entityManager->persist($photoLocation);
            $entityManager->flush();
            return $this->redirectToRoute('photo_locations_index');
        }

        return $this->render('photo_locations/edit.html.twig', [
            'photo_location' => $photoLocation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="photo_locations_delete", methods={"POST"})
     */
    public function delete(Request $request, PhotoLocations $photoLocation): Response
    {
        if ($this->isCsrfTokenValid('delete' . $photoLocation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->entityManager;
            $entityManager->remove($photoLocation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('photo_locations_index');
    }

    /**
     * @Route("/locationSwitchPublicPrivate/{id}", name="photo_location_public_private", methods={"GET","POST"})
     */
    public function switchPublicPrivate(Request $request, PhotoLocations $photoLocations, EntityManagerInterface $entityManager): Response
    {
        $publicPrivate = $photoLocations->getPublicPrivate();
        if ($publicPrivate == 'Public') {
            $photoLocations->setPublicPrivate('Private');
        } else {
            $photoLocations->setPublicPrivate('Public');
        }
        $entityManager = $this->entityManager;
        $entityManager->persist($photoLocations);
        $entityManager->flush();
        $referer = $request->server->get('HTTP_REFERER');
        return $this->redirect($referer);
    }


}
