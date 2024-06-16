<?php

namespace App\Controller;

use App\Entity\Introduction;
use App\Form\IntroductionType;
use App\Repository\IntroductionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/introduction")
 * @IsGranted("ROLE_JOB_APPLICANT")
 */
class IntroductionController extends AbstractController
{
    /**
     * @Route("/index", name="introduction_index", methods={"GET"})
     */
    public function index(IntroductionRepository $introductionRepository): Response
    {
        return $this->render('introduction/index.html.twig', [
            'introductions' => $introductionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="introduction_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserRepository $userRepository, SluggerInterface $slugger): Response
    {
        $introduction = new Introduction();
        $form = $this->createForm(IntroductionType::class, $introduction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $attachment =  $form->get('attachment')->getData();
            if ($attachment) {
                $originalFilename = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $attachment->guessExtension();
                try {
                    $attachment->move(
                        $this->getParameter('recruiter_introductions_attachments_directory'),
                        $newFilename
                    );
                    $introduction->setAttachment($newFilename);
                } catch (FileException $e) {
                    die('Import failed');
                }
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($introduction);
            $entityManager->flush();

            return $this->redirectToRoute('introduction_index');
        }


        return $this->render('introduction/new.html.twig', [
            'introduction' => $introduction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="introduction_show", methods={"GET"})
     */
    public function show(Introduction $introduction): Response
    {
        return $this->render('introduction/show.html.twig', [
            'introduction' => $introduction,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="introduction_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Introduction $introduction, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(IntroductionType::class, $introduction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attachment = $form->get('attachment')->getData();
            if ($attachment) {
                $originalFilename = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $attachment->guessExtension();
                try {
                    $attachment->move(
                        $this->getParameter('recruiter_introductions_attachments_directory'),
                        $newFilename
                    );
                    $introduction->setAttachment($newFilename);
                } catch (FileException $e) {
                    die('Import failed');
                }
            }
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('introduction_index');
        }

        return $this->render('introduction/edit.html.twig', [
            'introduction' => $introduction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="introduction_delete", methods={"POST"})
     */
    public function delete(Request $request, Introduction $introduction): Response
    {
        if ($this->isCsrfTokenValid('delete' . $introduction->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($introduction);
            $entityManager->flush();
        }
        return $this->redirectToRoute('introduction_index');
    }

    /**
     * @Route("/delete/attachment/{id}", name="introduction_delete_attachment")
     */
    public function deleteAttachment(Request $request, Introduction $introduction, EntityManagerInterface $entityManager)
    {
        $referer = $request->headers->get('referer');
        $introduction->setAttachment('');
        $entityManager->flush();
        return $this->redirect($referer);
    }
}
