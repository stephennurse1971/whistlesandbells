<?php

namespace App\Controller;

use App\Entity\UsefulLinks;
use App\Form\UsefulLinksType;
use App\Repository\UsefulLinksRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/useful/links")
 */
class UsefulLinksController extends AbstractController
{
    /**
     * @Route("/{category}", name="useful_links_index", methods={"GET"})
     */
    public function index(Request $request, string $category, UsefulLinksRepository $usefulLinksRepository): Response
    {
        $categories = ['ATS', 'Finance', 'Health', 'Cyprus Estate Agent', 'Other Estate Agent',
            'Shopping', 'Gwenny', 'AX', 'IT', 'Recruitment'];
        $useful_links = $usefulLinksRepository->findAll();
        return $this->render('useful_links/index.html.twig', [
            'useful_links' => $useful_links,
            'categories' => $categories,
            'category' => $category
        ]);
    }

    /**
     * @Route("/new", name="useful_links_new", methods={"GET", "POST"})
     */
    public function new(Request $request, UsefulLinksRepository $usefulLinksRepository): Response
    {
        $usefulLink = new UsefulLinks();
        $form = $this->createForm(UsefulLinksType::class, $usefulLink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $usefulLinksRepository->add($usefulLink);
            return $this->redirectToRoute('useful_links_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('useful_links/new.html.twig', [
            'useful_link' => $usefulLink,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="useful_links_show", methods={"GET"})
     */
    public function show(UsefulLinks $usefulLink): Response
    {
        return $this->render('useful_links/show.html.twig', [
            'useful_link' => $usefulLink,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="useful_links_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, UsefulLinks $usefulLink, UsefulLinksRepository $usefulLinksRepository): Response
    {
        $form = $this->createForm(UsefulLinksType::class, $usefulLink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $usefulLinksRepository->add($usefulLink);
            return $this->redirectToRoute('useful_links_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('useful_links/edit.html.twig', [
            'useful_link' => $usefulLink,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="useful_links_delete", methods={"POST"})
     */
    public function delete(Request $request, UsefulLinks $usefulLink, UsefulLinksRepository $usefulLinksRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $usefulLink->getId(), $request->request->get('_token'))) {
            $usefulLinksRepository->remove($usefulLink);
        }

        return $this->redirectToRoute('useful_links_index', [], Response::HTTP_SEE_OTHER);
    }
}
