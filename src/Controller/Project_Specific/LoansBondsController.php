<?php

namespace App\Controller\Project_Specific;

use App\Entity\Project_Specific\LoansBonds;
use App\Form\Project_Specific\LoansBondsType;
use App\Repository\Project_Specific\LoansBondsRepository;
use App\Repository\Project_Specific\SettingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/loans/bonds")
 */
class LoansBondsController extends AbstractController
{
    /**
     * @Route("/index", name="loans_bonds_index", methods={"GET"})
     */
    public function index(LoansBondsRepository $loansBondsRepository, SettingsRepository $settingsRepository): Response
    {
        $settings= $settingsRepository->find('1');
        return $this->render('loans_bonds/index.html.twig', [
            'loans_bonds' => $loansBondsRepository->findAll(),
            'settings'=>$settings
        ]);
    }

    /**
     * @Route("/new", name="loans_bonds_new", methods={"GET", "POST"})
     */
    public function new(Request $request, LoansBondsRepository $loansBondsRepository): Response
    {
        $loansBond = new LoansBonds();
        $form = $this->createForm(LoansBondsType::class, $loansBond);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $loansBondsRepository->add($loansBond);
            return $this->redirectToRoute('loans_bonds_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('loans_bonds/new.html.twig', [
            'loans_bond' => $loansBond,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="loans_bonds_show", methods={"GET"})
     */
    public function show(LoansBonds $loansBond): Response
    {
        return $this->render('loans_bonds/show.html.twig', [
            'loans_bond' => $loansBond,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="loans_bonds_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, LoansBonds $loansBond, LoansBondsRepository $loansBondsRepository): Response
    {
        $form = $this->createForm(LoansBondsType::class, $loansBond);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $loansBondsRepository->add($loansBond);
            return $this->redirectToRoute('loans_bonds_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('loans_bonds/edit.html.twig', [
            'loans_bond' => $loansBond,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="loans_bonds_delete", methods={"POST"})
     */
    public function delete(Request $request, LoansBonds $loansBond, LoansBondsRepository $loansBondsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$loansBond->getId(), $request->request->get('_token'))) {
            $loansBondsRepository->remove($loansBond);
        }

        return $this->redirectToRoute('loans_bonds_index', [], Response::HTTP_SEE_OTHER);
    }
}
