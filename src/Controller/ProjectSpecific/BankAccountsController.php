<?php

namespace App\Controller\ProjectSpecific;

use App\Entity\ProjectSpecific\BankAccounts;
use App\Form\ProjectSpecific\BankAccountsType;
use App\Repository\ProjectSpecific\BankAccountsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/bank/accounts")
 */
class BankAccountsController extends AbstractController
{
    /**
     * @Route("/index", name="bank_accounts_index", methods={"GET"})
     */
    public function index(BankAccountsRepository $bankAccountsRepository): Response
    {
        return $this->render('bank_accounts/index.html.twig', [
            'bank_accounts' => $bankAccountsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="bank_accounts_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BankAccountsRepository $bankAccountsRepository): Response
    {
        $bankAccount = new BankAccounts();
        $form = $this->createForm(BankAccountsType::class, $bankAccount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bankAccountsRepository->add($bankAccount);
            return $this->redirectToRoute('bank_accounts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bank_accounts/new.html.twig', [
            'bank_account' => $bankAccount,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="bank_accounts_show", methods={"GET"})
     */
    public function show(BankAccounts $bankAccount): Response
    {
        return $this->render('bank_accounts/show.html.twig', [
            'bank_account' => $bankAccount,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="bank_accounts_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, BankAccounts $bankAccount, BankAccountsRepository $bankAccountsRepository): Response
    {
        $form = $this->createForm(BankAccountsType::class, $bankAccount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bankAccountsRepository->add($bankAccount);
            return $this->redirectToRoute('bank_accounts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bank_accounts/edit.html.twig', [
            'bank_account' => $bankAccount,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="bank_accounts_delete", methods={"POST"})
     */
    public function delete(Request $request, BankAccounts $bankAccount, BankAccountsRepository $bankAccountsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bankAccount->getId(), $request->request->get('_token'))) {
            $bankAccountsRepository->remove($bankAccount);
        }

        return $this->redirectToRoute('bank_accounts_index', [], Response::HTTP_SEE_OTHER);
    }
}
