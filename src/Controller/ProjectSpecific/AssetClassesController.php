<?php

namespace App\Controller\ProjectSpecific;

use App\Entity\ProjectSpecific\AssetClasses;
use App\Form\ProjectSpecific\AssetClassesType;
use App\Repository\ProjectSpecific\AssetClassesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/assetclasses")
 */
class AssetClassesController extends AbstractController
{
    /**
     * @Route("/index", name="asset_classes_index", methods={"GET"})
     */
    public function index(AssetClassesRepository $assetClassesRepository): Response
    {
        return $this->render('asset_classes/index.html.twig', [
            'asset_classes' => $assetClassesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="asset_classes_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $assetClass = new AssetClasses();
        $form = $this->createForm(AssetClassesType::class, $assetClass);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($assetClass);
            $entityManager->flush();

            return $this->redirectToRoute('asset_classes_index');
        }

        return $this->render('asset_classes/new.html.twig', [
            'asset_class' => $assetClass,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="asset_classes_show", methods={"GET"})
     */
    public function show(AssetClasses $assetClass): Response
    {
        return $this->render('asset_classes/show.html.twig', [
            'asset_class' => $assetClass,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="asset_classes_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AssetClasses $assetClass): Response
    {
        $form = $this->createForm(AssetClassesType::class, $assetClass);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('asset_classes_index');
        }

        return $this->render('asset_classes/edit.html.twig', [
            'asset_class' => $assetClass,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/asset_class_change_status/{id}/{parameter}", name="asset_class_change_status", methods={"GET", "POST"})
     */
    public function assetClassChangeInputs(Request $request, $parameter, AssetClasses $assetClasses, EntityManagerInterface $manager): Response
    {
        $referer = $request->headers->get('Referer');

        if($parameter=="investmentPurchaseAndSaleDates")
        {
            if($assetClasses->getShowInvestmentPurchaseAndSaleDates()==1)
            {
                $assetClasses->setShowInvestmentPurchaseAndSaleDates(0);
            }
            else $assetClasses->setShowInvestmentPurchaseAndSaleDates(1);
        }

        if($parameter=="requireLegalDocs")
        {
            if($assetClasses->getShowDocs()==1)
            {
                $assetClasses->setShowDocs(0);
            }
            else $assetClasses->setShowDocs(1);
        }

        if($parameter=="updatedPriceAvailable")
        {
            if($assetClasses->getUpdatedPriceAvailable()==1)
            {
                $assetClasses->setUpdatedPriceAvailable(0);
            }
            else $assetClasses->setUpdatedPriceAvailable(1);
        }

        $manager->flush();
        return $this->redirect($referer);
    }



    /**
     * @Route("/delete/{id}", name="asset_classes_delete", methods={"POST"})
     */
    public function delete(Request $request, AssetClasses $assetClass): Response
    {
        if ($this->isCsrfTokenValid('delete'.$assetClass->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($assetClass);
            $entityManager->flush();
        }

        return $this->redirectToRoute('asset_classes_index');
    }
}
