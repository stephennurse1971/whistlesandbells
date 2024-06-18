<?php

namespace App\Controller\Project_Specific;

use App\Entity\Project_Specific\Flying;
use App\Form\Project_Specific\FlyingType;
use App\Repository\Project_Specific\FlyingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/flying")
 */
class FlyingController extends AbstractController
{
    /**
     * @Route("/index", name="flying_index", methods={"GET"})
     */
    public function index(FlyingRepository $flyingRepository): Response
    {
        return $this->render('flying/index.html.twig', [
            'flyings' => $flyingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="flying_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $flying = new Flying();
        $form = $this->createForm(FlyingType::class, $flying);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($flying);
            $entityManager->flush();

            return $this->redirectToRoute('flying_index');
        }

        return $this->render('flying/new.html.twig', [
            'flying' => $flying,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="flying_show", methods={"GET"})
     */
    public function show(Flying $flying): Response
    {
        return $this->render('flying/show.html.twig', [
            'flying' => $flying,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="flying_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Flying $flying): Response
    {
        $form = $this->createForm(FlyingType::class, $flying);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('flying_index');
        }

        return $this->render('flying/edit.html.twig', [
            'flying' => $flying,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="flying_delete", methods={"POST"})
     */
    public function delete(Request $request, Flying $flying): Response
    {
        if ($this->isCsrfTokenValid('delete'.$flying->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($flying);
            $entityManager->flush();
        }

        return $this->redirectToRoute('flying_index');
    }
}
