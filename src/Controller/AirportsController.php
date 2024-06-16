<?php

namespace App\Controller;

use App\Entity\Airports;
use App\Form\AirportsType;
use App\Repository\AirportsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/airports")
 */
class AirportsController extends AbstractController
{
    /**
     * @Route("/index", name="airports_index", methods={"GET"})
     */
    public function index(AirportsRepository $airportsRepository): Response
    {
        return $this->render('airports/index.html.twig', [
            'airports' => $airportsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="airports_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AirportsRepository $airportsRepository): Response
    {
        $airport = new Airports();
        $form = $this->createForm(AirportsType::class, $airport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $airportsRepository->add($airport);
            return $this->redirectToRoute('airports_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('airports/new.html.twig', [
            'airport' => $airport,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="airports_show", methods={"GET"})
     */
    public function show(Airports $airport): Response
    {
        return $this->render('airports/show.html.twig', [
            'airport' => $airport,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="airports_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Airports $airport, AirportsRepository $airportsRepository): Response
    {
        $form = $this->createForm(AirportsType::class, $airport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $airportsRepository->add($airport);
            return $this->redirectToRoute('airports_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('airports/edit.html.twig', [
            'airport' => $airport,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="airports_delete", methods={"POST"})
     */
    public function delete(Request $request, Airports $airport, AirportsRepository $airportsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$airport->getId(), $request->request->get('_token'))) {
            $airportsRepository->remove($airport);
        }

        return $this->redirectToRoute('airports_index', [], Response::HTTP_SEE_OTHER);
    }
}
