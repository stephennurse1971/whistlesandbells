<?php

namespace App\Controller;

use App\Entity\Translation;
use App\Form\TranslationType;
use App\Repository\TranslationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/translation')]
class TranslationController extends AbstractController
{
    #[Route('/inde', name: 'translation_index', methods: ['GET'])]
    public function index(TranslationRepository $translationRepository): Response
    {
        return $this->render('translation/index.html.twig', [
            'translations' => $translationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'translation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TranslationRepository $translationRepository): Response
    {
        $translation = new Translation();
        $form = $this->createForm(TranslationType::class, $translation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $translationRepository->add($translation, true);

            return $this->redirectToRoute('translation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('translation/new.html.twig', [
            'translation' => $translation,
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'translation_show', methods: ['GET'])]
    public function show(Translation $translation): Response
    {
        return $this->render('translation/show.html.twig', [
            'translation' => $translation,
        ]);
    }

    #[Route('/edit/{id}', name: 'translation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Translation $translation, TranslationRepository $translationRepository): Response
    {
        $form = $this->createForm(TranslationType::class, $translation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $translationRepository->add($translation, true);

            return $this->redirectToRoute('translation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('translation/edit.html.twig', [
            'translation' => $translation,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'translation_delete', methods: ['POST'])]
    public function delete(Request $request, Translation $translation, TranslationRepository $translationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$translation->getId(), $request->request->get('_token'))) {
            $translationRepository->remove($translation, true);
        }

        return $this->redirectToRoute('translation_index', [], Response::HTTP_SEE_OTHER);
    }
}
