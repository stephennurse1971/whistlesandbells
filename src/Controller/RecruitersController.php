<?php

namespace App\Controller;

use App\Entity\Recruiters;
use App\Form\RecruitersType;
use App\Repository\RecruitersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/recruiters")
 */
class RecruitersController extends AbstractController
{
    /**
     * @Route("/", name="recruiters_index", methods={"GET"})
     */
    public function index(RecruitersRepository $recruitersRepository): Response
    {
        return $this->render('recruiters/index.html.twig', [
            'recruiters' => $recruitersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="recruiters_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $recruiter = new Recruiters();
        $form = $this->createForm(RecruitersType::class, $recruiter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($recruiter);
            $entityManager->flush();

            return $this->redirectToRoute('recruiters_index');
        }

        return $this->render('recruiters/new.html.twig', [
            'recruiter' => $recruiter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="recruiters_show", methods={"GET"})
     */
    public function show(Recruiters $recruiter): Response
    {
        return $this->render('recruiters/show.html.twig', [
            'recruiter' => $recruiter,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="recruiters_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Recruiters $recruiter): Response
    {
        $form = $this->createForm(RecruitersType::class, $recruiter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('recruiters_index');
        }

        return $this->render('recruiters/edit.html.twig', [
            'recruiter' => $recruiter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="recruiters_delete", methods={"POST"})
     */
    public function delete(Request $request, Recruiters $recruiter): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recruiter->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($recruiter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('recruiters_index');
    }
}
