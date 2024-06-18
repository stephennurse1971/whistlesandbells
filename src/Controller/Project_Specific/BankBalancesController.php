<?php

namespace App\Controller\Project_Specific;

use App\Entity\Project_Specific\BankBalances;
use App\Form\Project_Specific\BankBalancesType;
use App\Repository\Project_Specific\BankAccountsRepository;
use App\Repository\Project_Specific\BankBalancesRepository;
use App\Repository\Project_Specific\SettingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/bank/balances")
 */
class BankBalancesController extends AbstractController
{
    /**
     * @Route("/index", name="bank_balances_index", methods={"GET"})
     */
    public function index(BankBalancesRepository $bankBalancesRepository, BankAccountsRepository $bankAccountsRepository, SettingsRepository $settingsRepository): Response
    {
        $settings= $settingsRepository->find('1');
        return $this->render('bank_balances/index.html.twig', [
            'bank_accounts' => $bankAccountsRepository->findAll(),
            'bank_balances' => $bankBalancesRepository->findAll(),
            'settings'=>$settings
        ]);
    }

    /**
     * @Route("/new", name="bank_balances_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BankBalancesRepository $bankBalancesRepository): Response
    {
        $bankBalance = new BankBalances();
        $form = $this->createForm(BankBalancesType::class, $bankBalance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bankBalancesRepository->add($bankBalance);
            return $this->redirectToRoute('bank_balances_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bank_balances/new.html.twig', [
            'bank_balance' => $bankBalance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="bank_balances_show", methods={"GET"})
     */
    public function show(BankBalances $bankBalance): Response
    {
        return $this->render('bank_balances/show.html.twig', [
            'bank_balance' => $bankBalance,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="bank_balances_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, BankBalances $bankBalance, BankBalancesRepository $bankBalancesRepository): Response
    {
        $form = $this->createForm(BankBalancesType::class, $bankBalance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bankBalancesRepository->add($bankBalance);
            return $this->redirectToRoute('bank_balances_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bank_balances/edit.html.twig', [
            'bank_balance' => $bankBalance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="bank_balances_delete", methods={"POST"})
     */
    public function delete(Request $request, BankBalances $bankBalance, BankBalancesRepository $bankBalancesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bankBalance->getId(), $request->request->get('_token'))) {
            $bankBalancesRepository->remove($bankBalance);
        }

        return $this->redirectToRoute('bank_balances_index', [], Response::HTTP_SEE_OTHER);
    }
}
