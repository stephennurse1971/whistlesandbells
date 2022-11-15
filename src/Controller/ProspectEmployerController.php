<?php

namespace App\Controller;

use App\Entity\ProspectEmployer;
use App\Form\ProspectEmployerType;
use App\Repository\ProspectEmployerRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/prospect/employer")
 */
class ProspectEmployerController extends AbstractController
{
    /**
     * @Route("/", name="prospect_employer_index", methods={"GET"})
     */
    public function index(ProspectEmployerRepository $prospectEmployerRepository): Response
    {
        return $this->render('prospect_employer/index.html.twig', [
            'prospect_employers' => $prospectEmployerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{recruiterid}/{applicantid}", name="prospect_employer_new", methods={"GET","POST"})
     */
    public function new(Request $request,int $recruiterid,int $applicantid,UserRepository $userRepository): Response
    {
        $recruiter = $userRepository->find($recruiterid);
        $applicant = $userRepository->find($applicantid);
        $prospectEmployer = new ProspectEmployer();
        $prospectEmployer->setApplicant($applicant);
        $prospectEmployer->setRecruiter($recruiter);
        $form = $this->createForm(ProspectEmployerType::class, $prospectEmployer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($prospectEmployer);
            $entityManager->flush();

            return $this->redirectToRoute('prospect_employer_index');
        }

        return $this->render('prospect_employer/new.html.twig', [
            'prospect_employer' => $prospectEmployer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="prospect_employer_show", methods={"GET"})
     */
    public function show(ProspectEmployer $prospectEmployer): Response
    {
        return $this->render('prospect_employer/show.html.twig', [
            'prospect_employer' => $prospectEmployer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="prospect_employer_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProspectEmployer $prospectEmployer): Response
    {
       $employer = $prospectEmployer->getEmployer();
        $form = $this->createForm(ProspectEmployerType::class, $prospectEmployer,['employer'=>$employer]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('prospect_employer_index');
        }

        return $this->render('prospect_employer/edit.html.twig', [
            'prospect_employer' => $prospectEmployer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="prospect_employer_delete", methods={"POST"})
     */
    public function delete(Request $request, ProspectEmployer $prospectEmployer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$prospectEmployer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($prospectEmployer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('prospect_employer_index');
    }
}
