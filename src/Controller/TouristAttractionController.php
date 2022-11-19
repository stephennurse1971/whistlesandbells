<?php

namespace App\Controller;

use App\Entity\TouristAttraction;
use App\Form\TouristAttractionType;
use App\Repository\TouristAttractionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tourist/attraction")
 */
class TouristAttractionController extends AbstractController
{
    /**
     * @Route("/", name="tourist_attraction_index", methods={"GET"})
     */
    public function index(TouristAttractionRepository $touristAttractionRepository): Response
    {
        return $this->render('tourist_attraction/index.html.twig', [
            'tourist_attractions' => $touristAttractionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tourist_attraction_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $touristAttraction = new TouristAttraction();
        $form = $this->createForm(TouristAttractionType::class, $touristAttraction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($touristAttraction);
            $entityManager->flush();

            return $this->redirectToRoute('tourist_attraction_index');
        }

        return $this->render('tourist_attraction/new.html.twig', [
            'tourist_attraction' => $touristAttraction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tourist_attraction_show", methods={"GET"})
     */
    public function show(TouristAttraction $touristAttraction): Response
    {
        return $this->render('tourist_attraction/show.html.twig', [
            'tourist_attraction' => $touristAttraction,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tourist_attraction_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TouristAttraction $touristAttraction): Response
    {
        $form = $this->createForm(TouristAttractionType::class, $touristAttraction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tourist_attraction_index');
        }

        return $this->render('tourist_attraction/edit.html.twig', [
            'tourist_attraction' => $touristAttraction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tourist_attraction_delete", methods={"POST"})
     */
    public function delete(Request $request, TouristAttraction $touristAttraction): Response
    {
        if ($this->isCsrfTokenValid('delete'.$touristAttraction->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($touristAttraction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tourist_attraction_index');
    }
}
