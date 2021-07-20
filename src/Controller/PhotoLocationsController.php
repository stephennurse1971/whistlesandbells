<?php

namespace App\Controller;

use App\Entity\PhotoLocations;
use App\Form\PhotoLocationsType;
use App\Repository\PhotoLocationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/photo/locations")
 */
class PhotoLocationsController extends AbstractController
{
    /**
     * @Route("/", name="photo_locations_index", methods={"GET"})
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
    public function new(Request $request): Response
    {
        $photoLocation = new PhotoLocations();
        $form = $this->createForm(PhotoLocationsType::class, $photoLocation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
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
     * @Route("/{id}", name="photo_locations_show", methods={"GET"})
     */
    public function show(PhotoLocations $photoLocation): Response
    {
        return $this->render('photo_locations/show.html.twig', [
            'photo_location' => $photoLocation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="photo_locations_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PhotoLocations $photoLocation): Response
    {
        $form = $this->createForm(PhotoLocationsType::class, $photoLocation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('photo_locations_index');
        }

        return $this->render('photo_locations/edit.html.twig', [
            'photo_location' => $photoLocation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="photo_locations_delete", methods={"POST"})
     */
    public function delete(Request $request, PhotoLocations $photoLocation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$photoLocation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($photoLocation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('photo_locations_index');
    }
}
