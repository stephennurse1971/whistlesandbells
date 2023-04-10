<?php

namespace App\Controller;

use App\Entity\MarketData;
use App\Form\MarketDataType;
use App\Repository\MarketDataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/marketdata")
 */
class MarketDataController extends AbstractController
{
    /**
     * @Route("/", name="market_data_index", methods={"GET"})
     */
    public function index(MarketDataRepository $marketDataRepository): Response
    {
        $assetclasses = ['Pubs', 'Storage', 'EIS', 'Pension', 'Shares', 'Bank Account', 'EBT', 'Loans'];
        return $this->render('market_data/index.html.twig', [
            'market_datas' => $marketDataRepository->findAll(),
            'asset_classes' => $assetclasses
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
     * @Route("/{id}", name="market_data_show", methods={"GET"})
     */
    public function show(MarketData $marketDatum): Response
    {
        return $this->render('market_data/show.html.twig', [
            'market_datum' => $marketDatum,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="market_data_edit", methods={"GET","POST"})
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
     * @Route("/{id}", name="market_data_delete", methods={"POST"})
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
