<?php

namespace App\Controller;

use App\Entity\MarketData;
use App\Form\MarketDataType;
use App\Repository\AssetClassesRepository;
use App\Repository\MarketDataRepository;
use App\Repository\SettingsRepository;
use App\Services\MarketDataPrice;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/marketdata")
 */
class MarketDataController extends AbstractController
{
    /**
     * @Route("/", name="market_data_index", methods={"GET"})
     * @IsGranted("ROLE_ACCOUNTANT")
     */
    public function index(MarketDataRepository $marketDataRepository, MarketDataPrice $marketDataPrice, AssetClassesRepository $assetClassesRepository, SettingsRepository $settingsRepository): Response
    {
        $settings=$settingsRepository->find('1');
        return $this->render('market_data/index.html.twig', [
            'marketDatas' => $marketDataRepository->findAll(),
            'assetClasses' => $assetClassesRepository->findAll(),
            'settings'=>$settings
        ]);
    }

    /**
     * @Route("/new", name="market_data_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $marketDatum = new MarketData();
        $form = $this->createForm(MarketDataType::class, $marketDatum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($marketDatum);
            $entityManager->flush();

            return $this->redirectToRoute('market_data_index');
        }

        return $this->render('market_data/new.html.twig', [
            'market_datum' => $marketDatum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="market_data_show", methods={"GET"})
     */
    public function show(MarketData $marketDatum): Response
    {
        return $this->render('market_data/show.html.twig', [
            'market_datum' => $marketDatum,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="market_data_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MarketData $marketData): Response
    {
        $form = $this->createForm(MarketDataType::class, $marketData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('market_data_index');
        }

        return $this->render('market_data/edit.html.twig', [
            'market_data' => $marketData,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="market_data_delete", methods={"POST"})
     */
    public function delete(Request $request, MarketData $marketDatum): Response
    {
        if ($this->isCsrfTokenValid('delete' . $marketDatum->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($marketDatum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('market_data_index');
    }
}
