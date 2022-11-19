<?php

namespace App\Controller;

use App\Entity\CmsCopy;
use App\Form\CmsCopyType;
use App\Repository\CmsCopyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cms/copy")
 */
class CmsCopyController extends AbstractController
{
    /**
     * @Route("/", name="cms_copy_index", methods={"GET"})
     */
    public function index(CmsCopyRepository $cmsCopyRepository): Response
    {
        return $this->render('cms_copy/index.html.twig', [
            'cms_copies' => $cmsCopyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="cms_copy_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $cmsCopy = new CmsCopy();
        $form = $this->createForm(CmsCopyType::class, $cmsCopy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cmsCopy);
            $entityManager->flush();

            return $this->redirectToRoute('cms_copy_index');
        }

        return $this->render('cms_copy/new.html.twig', [
            'cms_copy' => $cmsCopy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cms_copy_show", methods={"GET"})
     */
    public function show(CmsCopy $cmsCopy): Response
    {
        return $this->render('cms_copy/show.html.twig', [
            'cms_copy' => $cmsCopy,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cms_copy_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CmsCopy $cmsCopy): Response
    {
        $form = $this->createForm(CmsCopyType::class, $cmsCopy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cms_copy_index');
        }

        return $this->render('cms_copy/edit.html.twig', [
            'cms_copy' => $cmsCopy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cms_copy_delete", methods={"POST"})
     */
    public function delete(Request $request, CmsCopy $cmsCopy): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cmsCopy->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cmsCopy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cms_copy_index');
    }
}
