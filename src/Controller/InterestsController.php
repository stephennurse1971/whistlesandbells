<?php

namespace App\Controller;

use App\Entity\Interests;
use App\Form\InterestsType;
use App\Repository\InterestsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/interests")
 */
class InterestsController extends AbstractController
{
    /**
     * @Route("/", name="interests_index", methods={"GET"})
     */
    public function index(InterestsRepository $interestsRepository): Response
    {
        return $this->render('interests/index.html.twig', [
            'interests' => $interestsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="interests_new", methods={"GET", "POST"})
     */
    public function new(Request $request, InterestsRepository $interestsRepository): Response
    {
        $interest = new Interests();
        $form = $this->createForm(InterestsType::class, $interest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $interestsRepository->add($interest);
            return $this->redirectToRoute('interests_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('interests/new.html.twig', [
            'interest' => $interest,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="interests_show", methods={"GET"})
     */
    public function show(Interests $interest): Response
    {
        return $this->render('interests/show.html.twig', [
            'interest' => $interest,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="interests_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Interests $interest, InterestsRepository $interestsRepository): Response
    {
        $form = $this->createForm(InterestsType::class, $interest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $interestsRepository->add($interest);
            return $this->redirectToRoute('interests_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('interests/edit.html.twig', [
            'interest' => $interest,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="interests_delete", methods={"POST"})
     */
    public function delete(Request $request, Interests $interest, InterestsRepository $interestsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$interest->getId(), $request->request->get('_token'))) {
            $interestsRepository->remove($interest);
        }

        return $this->redirectToRoute('interests_index', [], Response::HTTP_SEE_OTHER);
    }
}
