<?php

namespace App\Controller;

use App\Entity\CmsCopy;
use App\Form\CmsCopyType;
use App\Repository\CmsCopyRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cmscopy")
 */
class CmsCopyController extends AbstractController
{
    /**
     * @Route("/", name="cms_copy_index", methods={"GET"})
     */
    public function index(CmsCopyRepository $cmsCopyRepository, ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('cms_copy/index.html.twig', [
            'cms_copies' => $cmsCopyRepository->findAll(),
            'products' => $products
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
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cmsCopy);
            $entityManager->flush();
            return $this->redirectToRoute('cms_copy_index');
        }

        return $this->render('cms_copy/edit.html.twig', [
            'cms_copy' => $cmsCopy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/copy_and_edit", name="cms_copy_copy_and_edit", methods={"GET","POST"})
     */
    public function copyAndEdit(Request $request, CmsCopy $cmsCopy, EntityManagerInterface $manager): Response
    {
        $product = $cmsCopy->getProduct();
        $sitePage = 'Test';
        $cmsCopy = new CmsCopy();
        $cmsCopy->setProduct($product)
            ->setContentText($sitePage . ' - Content text')
            ->setContentTitle($sitePage . ' - Title text')
            ->setContentTextFR($sitePage . ' - Content text (FR)')
            ->setContentTitleFR($sitePage . ' - Title text (FR)')
            ->setContentTextDE($sitePage . ' - Content text (DE)')
            ->setContentTitleDE($sitePage . ' - Title text (DE)');
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
     * @Route("/{id}", name="cms_copy_delete", methods={"POST"})
     */
    public function delete(Request $request, CmsCopy $cmsCopy): Response
    {
        if ($this->isCsrfTokenValid('delete' . $cmsCopy->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cmsCopy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cms_copy_index');
    }
}
