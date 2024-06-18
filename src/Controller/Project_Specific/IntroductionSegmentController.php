<?php

namespace App\Controller\Project_Specific;

use App\Entity\Project_Specific\IntroductionSegment;
use App\Form\Project_Specific\IntroductionSegmentType;
use App\Repository\Project_Specific\IntroductionSegmentRepository;
use App\Repository\Project_Specific\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/introduction/email/segment")
 * @IsGranted("ROLE_JOB_APPLICANT")
 */
class IntroductionSegmentController extends AbstractController
{
    /**
     * @Route("/index", name="introduction_segment_index", methods={"GET"})
     */
    public function index(IntroductionSegmentRepository $introductionSegmentRepository): Response
    {
        return $this->render('introduction_segment/index.html.twig', [
            'introduction_segments' => $introductionSegmentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="introduction_segment_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $introductionSegment = new IntroductionSegment();
        $form = $this->createForm(IntroductionSegmentType::class, $introductionSegment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($introductionSegment);
            $entityManager->flush();

            return $this->redirectToRoute('introduction_segment_index');
        }

        return $this->render('introduction_segment/new.html.twig', [
            'introduction_segment' => $introductionSegment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="introduction_segment_show", methods={"GET"})
     */
    public function show(IntroductionSegment $introductionSegment): Response
    {
        return $this->render('introduction_segment/show.html.twig', [
            'introduction_segment' => $introductionSegment,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="introduction_segment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, IntroductionSegment $introductionSegment): Response
    {
        $form = $this->createForm(IntroductionSegmentType::class, $introductionSegment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('introduction_segment_index');
        }

        return $this->render('introduction_segment/edit.html.twig', [
            'introduction_segment' => $introductionSegment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="introduction_segment_delete", methods={"POST"})
     */
    public function delete(Request $request, IntroductionSegment $introductionSegment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$introductionSegment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($introductionSegment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('introduction_segment_index');
    }
}
