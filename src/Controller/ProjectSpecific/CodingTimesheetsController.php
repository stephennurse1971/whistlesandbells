<?php

namespace App\Controller\ProjectSpecific;

use App\Entity\ProjectSpecific\CodingTimesheets;
use App\Form\ProjectSpecific\CodingTimesheetsType;
use App\Repository\ProjectSpecific\CodingTimesheetsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/coding/timesheets")
 */
class CodingTimesheetsController extends AbstractController
{
    /**
     * @Route("/index", name="coding_timesheets_index", methods={"GET"})
     */
    public function index(CodingTimesheetsRepository $codingTimesheetsRepository): Response
    {
        return $this->render('coding_timesheets/index.html.twig', [
            'coding_timesheets' => $codingTimesheetsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="coding_timesheets_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CodingTimesheetsRepository $codingTimesheetsRepository): Response
    {
        $codingTimesheet = new CodingTimesheets();
        $form = $this->createForm(CodingTimesheetsType::class, $codingTimesheet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $codingTimesheetsRepository->add($codingTimesheet);
            return $this->redirectToRoute('coding_timesheets_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('coding_timesheets/new.html.twig', [
            'coding_timesheet' => $codingTimesheet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="coding_timesheets_show", methods={"GET"})
     */
    public function show(CodingTimesheets $codingTimesheet): Response
    {
        return $this->render('coding_timesheets/show.html.twig', [
            'coding_timesheet' => $codingTimesheet,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="coding_timesheets_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CodingTimesheets $codingTimesheet, CodingTimesheetsRepository $codingTimesheetsRepository): Response
    {
        $form = $this->createForm(CodingTimesheetsType::class, $codingTimesheet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $codingTimesheetsRepository->add($codingTimesheet);
            return $this->redirectToRoute('coding_timesheets_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('coding_timesheets/edit.html.twig', [
            'coding_timesheet' => $codingTimesheet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="coding_timesheets_delete", methods={"POST"})
     */
    public function delete(Request $request, CodingTimesheets $codingTimesheet, CodingTimesheetsRepository $codingTimesheetsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$codingTimesheet->getId(), $request->request->get('_token'))) {
            $codingTimesheetsRepository->remove($codingTimesheet);
        }

        return $this->redirectToRoute('coding_timesheets_index', [], Response::HTTP_SEE_OTHER);
    }
}
