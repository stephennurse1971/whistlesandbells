<?php

namespace App\Controller;

use App\Entity\JpmIcHistory;
use App\Form\JpmIcHistoryType;
use App\Repository\JpmIcHistoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/jpm/ic/history")
 */
class JpmIcHistoryController extends AbstractController
{
    /**
     * @Route("/", name="jpm_ic_history_index", methods={"GET"})
     */
    public function index(JpmIcHistoryRepository $jpmIcHistoryRepository): Response
    {
        return $this->render('jpm_ic_history/index.html.twig', [
            'jpm_ic_histories' => $jpmIcHistoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="jpm_ic_history_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $jpmIcHistory = new JpmIcHistory();
        $form = $this->createForm(JpmIcHistoryType::class, $jpmIcHistory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($jpmIcHistory);
            $entityManager->flush();

            return $this->redirectToRoute('jpm_ic_history_index');
        }

        return $this->render('jpm_ic_history/new.html.twig', [
            'jpm_ic_history' => $jpmIcHistory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="jpm_ic_history_show", methods={"GET"})
     */
    public function show(JpmIcHistory $jpmIcHistory): Response
    {
        return $this->render('jpm_ic_history/show.html.twig', [
            'jpm_ic_history' => $jpmIcHistory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="jpm_ic_history_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, JpmIcHistory $jpmIcHistory): Response
    {
        $form = $this->createForm(JpmIcHistoryType::class, $jpmIcHistory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('jpm_ic_history_index');
        }

        return $this->render('jpm_ic_history/edit.html.twig', [
            'jpm_ic_history' => $jpmIcHistory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="jpm_ic_history_delete", methods={"POST"})
     */
    public function delete(Request $request, JpmIcHistory $jpmIcHistory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$jpmIcHistory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($jpmIcHistory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('jpm_ic_history_index');
    }
}
