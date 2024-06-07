<?php

namespace App\Controller;

use App\Entity\ContentPage;
use App\Form\ContentPageType;
use App\Repository\ContentPageRepository;
use App\Repository\SubPageRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/content_page")
 * @Security("is_granted('ROLE_STAFF')")
 */
class ContentPageController extends AbstractController
{
    /**
     * @Route("/index", name="content_page_index", methods={"GET"})
     */
    public function index(ContentPageRepository $contentPageRepository, SubPageRepository $subPageRepository): Response
    {
        return $this->render('content_page/index.html.twig', [
            'content_pages' => $contentPageRepository->findAll(),
            'sub_pages' => $subPageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="content_page_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ContentPageRepository $contentPageRepository): Response
    {
        $contentPage = new ContentPage();
        $form = $this->createForm(ContentPageType::class, $contentPage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contentPageRepository->add($contentPage, true);

            return $this->redirectToRoute('content_page_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('content_page/new.html.twig', [
            'content_page' => $contentPage,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/show/{id}", name="content_page_show", methods={"GET"})
     */
    public function show(ContentPage $contentPage): Response
    {
        return $this->render('content_page/show.html.twig', [
            'content_page' => $contentPage,
        ]);
    }


    /**
     * @Route("/edit/{id}", name="content_page_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ContentPage $contentPage, ContentPageRepository $contentPageRepository): Response
    {
        $form = $this->createForm(ContentPageType::class, $contentPage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->has('picture')) {
                $photo = $form->get('picture')->getData();
                if ($photo) {
                    $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                    $newFilename = $contentPage->getArticlePage() . '.' . $photo->guessExtension();
                    $photo->move(
                        $this->getParameter('article_pictures_directory'),
                        $newFilename
                    );
                    $contentPage->setPicture($newFilename);
                }
            }

            $contentPageRepository->add($contentPage, true);

            return $this->redirectToRoute('content_page_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('content_page/edit.html.twig', [
            'content_page' => $contentPage,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="content_page_delete", methods={"POST"})
     */
    public function delete(Request $request, ContentPage $contentPage, ContentPageRepository $contentPageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contentPage->getId(), $request->request->get('_token'))) {
            $contentPageRepository->remove($contentPage  , true);
        }

        return $this->redirectToRoute('content_page_index', [], Response::HTTP_SEE_OTHER);
    }
}
