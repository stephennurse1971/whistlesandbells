<?php

namespace App\Controller\Project_Specific;

use App\Entity\Project_Specific\FxRatesHistory;
use App\Form\Project_Specific\FxRatesHistoryType;
use App\Repository\Project_Specific\FxRatesHistoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/fx/rates/history")
 */
class FxRatesHistoryController extends AbstractController
{
    /**
     * @Route("/index", name="fx_rates_history_index", methods={"GET"})
     */
    public function index(FxRatesHistoryRepository $fxRatesHistoryRepository): Response
    {
        return $this->render('fx_rates_history/index.html.twig', [
            'fx_rates_histories' => $fxRatesHistoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="fx_rates_history_new", methods={"GET", "POST"})
     */
    public function new(Request $request, FxRatesHistoryRepository $fxRatesHistoryRepository): Response
    {
        $fxRatesHistory = new FxRatesHistory();
        $form = $this->createForm(FxRatesHistoryType::class, $fxRatesHistory);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $fxRatesHistoryRepository->add($fxRatesHistory);
            return $this->redirectToRoute('fx_rates_history_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('fx_rates_history/new.html.twig', [
            'fx_rates_history' => $fxRatesHistory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="fx_rates_history_show", methods={"GET"})
     */
    public function show(FxRatesHistory $fxRatesHistory): Response
    {
        return $this->render('fx_rates_history/show.html.twig', [
            'fx_rates_history' => $fxRatesHistory,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="fx_rates_history_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, FxRatesHistory $fxRatesHistory, FxRatesHistoryRepository $fxRatesHistoryRepository): Response
    {
        $form = $this->createForm(FxRatesHistoryType::class, $fxRatesHistory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fxRatesHistoryRepository->add($fxRatesHistory);
            return $this->redirectToRoute('fx_rates_history_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('fx_rates_history/edit.html.twig', [
            'fx_rates_history' => $fxRatesHistory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="fx_rates_history_delete", methods={"POST"})
     */
    public function delete(Request $request, FxRatesHistory $fxRatesHistory, FxRatesHistoryRepository $fxRatesHistoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fxRatesHistory->getId(), $request->request->get('_token'))) {
            $fxRatesHistoryRepository->remove($fxRatesHistory);
        }

        return $this->redirectToRoute('fx_rates_history_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/delete/all", name="historic_fx_rates_delete_all", methods={"GET"})
     */
    public function deleteAll(Request $request, FxRatesHistoryRepository $fxRatesHistoryRepository): Response
    {
        $referer = $request->headers->get('referer');
        $allFXRates = $fxRatesHistoryRepository->findAll();
        foreach ($allFXRates as $FxRate) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($FxRate);
            $entityManager->flush();
        }
        return $this->redirect($referer);
    }
}
