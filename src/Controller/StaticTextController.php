<?php

namespace App\Controller;

use App\Entity\StaticText;
use App\Form\StaticTextType;
use App\Repository\StaticTextRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
    public function edit(Request $request, StaticText $staticText, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(StaticTextType::class, $staticText);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photo1 = $form->get('photo1')->getData();
            $photo2 = $form->get('photo2')->getData();
            $photo3 = $form->get('photo3')->getData();
            $photo4 = $form->get('photo4')->getData();
            $photo5 = $form->get('photo5')->getData();
            $photo6 = $form->get('photo6')->getData();
            $photo7 = $form->get('photo7')->getData();
            $photo8 = $form->get('photo8')->getData();
            $photo9 = $form->get('photo9')->getData();
            if ($photo1) {
                $originalFilename = pathinfo($photo1->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $photo1->guessExtension();
                try {
                    $photo1->move(
                        $this->getParameter('website_photos_directory'),
                        $newFilename
                    );
                    $staticText->setPhoto1($newFilename);
                } catch (FileException $e) {
                    die('Import failed');
                }
            }

            if ($photo2) {
                $originalFilename = pathinfo($photo2->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $photo2->guessExtension();
                try {
                    $photo2->move(
                        $this->getParameter('website_photos_directory'),
                        $newFilename
                    );
                    $staticText->setPhoto2($newFilename);
                } catch (FileException $e) {
                    die('Import failed');
                }
            }

            if ($photo3) {
                $originalFilename = pathinfo($photo3->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $photo3->guessExtension();
                try {
                    $photo3->move(
                        $this->getParameter('website_photos_directory'),
                        $newFilename
                    );
                    $staticText->setPhoto3($newFilename);
                } catch (FileException $e) {
                    die('Import failed');
                }
            }

            if ($photo4) {
                $originalFilename = pathinfo($photo4->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $photo4->guessExtension();
                try {
                    $photo4->move(
                        $this->getParameter('website_photos_directory'),
                        $newFilename
                    );
                    $staticText->setPhoto4($newFilename);
                } catch (FileException $e) {
                    die('Import failed');
                }
            }

            if ($photo5) {
                $originalFilename = pathinfo($photo5->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $photo5->guessExtension();
                try {
                    $photo5->move(
                        $this->getParameter('website_photos_directory'),
                        $newFilename
                    );
                    $staticText->setPhoto5($newFilename);
                } catch (FileException $e) {
                    die('Import failed');
                }
            }

            if ($photo6) {
                $originalFilename = pathinfo($photo6->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $photo6->guessExtension();
                try {
                    $photo6->move(
                        $this->getParameter('website_photos_directory'),
                        $newFilename
                    );
                    $staticText->setPhoto6($newFilename);
                } catch (FileException $e) {
                    die('Import failed');
                }
            }

            if ($photo7) {
                $originalFilename = pathinfo($photo7->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $photo7->guessExtension();
                try {
                    $photo7->move(
                        $this->getParameter('website_photos_directory'),
                        $newFilename
                    );
                    $staticText->setPhoto7($newFilename);
                } catch (FileException $e) {
                    die('Import failed');
                }
            }

            if ($photo8) {
                $originalFilename = pathinfo($photo8->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $photo8->guessExtension();
                try {
                    $photo8->move(
                        $this->getParameter('website_photos_directory'),
                        $newFilename
                    );
                    $staticText->setPhoto8($newFilename);
                } catch (FileException $e) {
                    die('Import failed');
                }
            }

            if ($photo9) {
                $originalFilename = pathinfo($photo9->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $photo9->guessExtension();
                try {
                    $photo9->move(
                        $this->getParameter('website_photos_directory'),
                        $newFilename
                    );
                    $staticText->setPhoto9($newFilename);
                } catch (FileException $e) {
                    die('Import failed');
                }
            }


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
        if ($this->isCsrfTokenValid('delete' . $staticText->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($staticText);
            $entityManager->flush();
        }

        return $this->redirectToRoute('static_text_index');
    }
}
