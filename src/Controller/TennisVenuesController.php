<?php

namespace App\Controller;

use App\Entity\TennisVenues;
use App\Form\TennisVenuesType;
use App\Repository\TennisVenuesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tennis/venues")
 */
class TennisVenuesController extends AbstractController
{
    /**
     * @Route("/", name="tennis_venues_index", methods={"GET"})
     */
    public function index(TennisVenuesRepository $tennisVenuesRepository): Response
    {
        return $this->render('tennis_venues/index.html.twig', [
            'tennis_venues' => $tennisVenuesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tennis_venues_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tennisVenue = new TennisVenues();
        $form = $this->createForm(TennisVenuesType::class, $tennisVenue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tennisVenue);
            $entityManager->flush();

            return $this->redirectToRoute('tennis_venues_index');
        }

        return $this->render('tennis_venues/new.html.twig', [
            'tennis_venue' => $tennisVenue,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tennis_venues_show", methods={"GET"})
     */
    public function show(TennisVenues $tennisVenue): Response
    {
        return $this->render('tennis_venues/show.html.twig', [
            'tennis_venue' => $tennisVenue,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tennis_venues_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TennisVenues $tennisVenue): Response
    {
        $form = $this->createForm(TennisVenuesType::class, $tennisVenue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tennis_venues_index');
        }

        return $this->render('tennis_venues/edit.html.twig', [
            'tennis_venue' => $tennisVenue,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tennis_venues_delete", methods={"POST"})
     */
    public function delete(Request $request, TennisVenues $tennisVenue): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tennisVenue->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tennisVenue);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tennis_venues_index');
    }
}
