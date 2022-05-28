<?php

namespace App\Controller;

use App\Entity\StaticText;
use App\Form\StaticTextType;
use App\Repository\StaticTextRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/static/text")
 */
class StaticTextController extends AbstractController
{
    /**
     * @Route("/", name="static_text_index", methods={"GET"})
     */
    public function index(StaticTextRepository $staticTextRepository): Response
    {
        return $this->render('static_text/index.html.twig', [
            'static_texts' => $staticTextRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="static_text_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $staticText = new StaticText();
        $form = $this->createForm(StaticTextType::class, $staticText);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($staticText);
            $entityManager->flush();

            return $this->redirectToRoute('static_text_index');
        }

        return $this->render('static_text/new.html.twig', [
            'static_text' => $staticText,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="static_text_show", methods={"GET"})
     */
    public function show(StaticText $staticText): Response
    {
        return $this->render('static_text/show.html.twig', [
            'static_text' => $staticText,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="static_text_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, StaticText $staticText): Response
    {
        $form = $this->createForm(StaticTextType::class, $staticText);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('static_text_index');
        }

        return $this->render('static_text/edit.html.twig', [
            'static_text' => $staticText,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="static_text_delete", methods={"POST"})
     */
    public function delete(Request $request, StaticText $staticText): Response
    {
        if ($this->isCsrfTokenValid('delete'.$staticText->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($staticText);
            $entityManager->flush();
        }

        return $this->redirectToRoute('static_text_index');
    }
}
