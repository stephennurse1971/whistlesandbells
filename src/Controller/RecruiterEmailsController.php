<?php

namespace App\Controller;

use App\Entity\RecruiterEmails;
use App\Form\RecruiterEmailsType;
use App\Repository\RecruiterEmailsRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/recruiter/emails")
 */
class RecruiterEmailsController extends AbstractController
{
    /**
     * @Route("/", name="recruiter_emails_index", methods={"GET"})
     */
    public function index(RecruiterEmailsRepository $recruiterEmailsRepository): Response
    {
        return $this->render('recruiter_emails/index.html.twig', [
            'recruiter_emails' => $recruiterEmailsRepository->findAll(),

        ]);
    }

    /**
     * @Route("/new", name="recruiter_emails_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $recruiterEmail = new RecruiterEmails();
        $form = $this->createForm(RecruiterEmailsType::class, $recruiterEmail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($recruiterEmail);
            $entityManager->flush();

            return $this->redirectToRoute('recruiters_index');
        }

        return $this->render('recruiter_emails/new.html.twig', [
            'recruiter_email' => $recruiterEmail,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="recruiter_emails_show", methods={"GET"})
     */
    public function show(RecruiterEmails $recruiterEmail): Response
    {
        return $this->render('recruiter_emails/show.html.twig', [
            'recruiter_email' => $recruiterEmail,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="recruiter_emails_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RecruiterEmails $recruiterEmail): Response
    {
        $form = $this->createForm(RecruiterEmailsType::class, $recruiterEmail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('recruiter_emails_index');
        }

        return $this->render('recruiter_emails/edit.html.twig', [
            'recruiter_email' => $recruiterEmail,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="recruiter_emails_delete", methods={"POST"})
     */
    public function delete(Request $request, RecruiterEmails $recruiterEmail): Response
    {
        if ($this->isCsrfTokenValid('delete' . $recruiterEmail->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($recruiterEmail);
            $entityManager->flush();
        }

        return $this->redirectToRoute('recruiter_emails_index');
    }


    /**
     * @Route("/delete/all_emails", name="recruiter_emails_delete_all")
     */
    public function deleteAllRecruiterEmails(RecruiterEmailsRepository $recruiterEmailsRepository)
    {
        $recruiterEmails = $recruiterEmailsRepository->findAll();
        foreach ($recruiterEmails as $recruiterEmail) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($recruiterEmail);
            $entityManager->flush();
        }
        return $this->redirectToRoute('recruiter_emails_index');
    }


}
