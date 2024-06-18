<?php

namespace App\Controller\Project_Specific;

use App\Entity\Project_Specific\InvestmentFutureComms;
use App\Form\Project_Specific\InvestmentFutureCommsType;
use App\Repository\Project_Specific\InvestmentFutureCommsRepository;
use App\Repository\Project_Specific\InvestmentsRepository;
use App\Repository\Project_Specific\MarketDataRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("investment/futurecomms")
 * @IsGranted("ROLE_ACCOUNTANT")
 */
class InvestmentFutureCommsController extends AbstractController
{
    /**
     * @Route("/index", name="investment_future_comms_index", methods={"GET"})
     */
    public function index(InvestmentFutureCommsRepository $investmentFutureCommsRepository): Response
    {
        return $this->render('investment_future_comms/index.html.twig', [
            'investment_future_comms' => $investmentFutureCommsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="investment_future_comms_new", methods={"GET","POST"})
     */
    public function new(int $id, Request $request, InvestmentsRepository $investmentsRepository, MarketDataRepository $marketDataRepository): Response
    {
//        $investment = $investmentsRepository->find($id);
        $marketData = $marketDataRepository->find($id);
        $investmentFutureComm = new InvestmentFutureComms();
        $form = $this->createForm(InvestmentFutureCommsType::class, $investmentFutureComm, [
            // 'investment'=>$investment,
            'marketData' => $marketData
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attachments = $form->get('attachment')->getData();
            if ($attachments) {
                $files_name = [];
                foreach ($attachments as $attachment) {
                    $originalFilename = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);

                    $newFilename = $originalFilename . '.' . $attachment->guessExtension();

                    $attachment->move(
                        $this->getParameter('investments_future_comms_attachment_directory'),
                        $newFilename
                    );
                    $files_name[] = $newFilename;
                }
                $investmentFutureComm->setAttachment($files_name);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($investmentFutureComm);
            $entityManager->flush();

            return $this->redirectToRoute('investment_future_comms_index');
        }

        return $this->render('investment_future_comms/new.html.twig', [
            'investment_future_comm' => $investmentFutureComm,
            'form' => $form->createView(),
            // 'investment' => $investment,
            'marketData' => $marketData
        ]);
    }


    /**
     * @Route("/show/{id}", name="investment_future_comms_show", methods={"GET"})
     */
    public function show(InvestmentFutureComms $investmentFutureComm): Response
    {
        return $this->render('investment_future_comms/show.html.twig', [
            'investment_future_comm' => $investmentFutureComm,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="investment_future_comms_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, InvestmentFutureComms $investmentFutureComm): Response
    {
        $form = $this->createForm(InvestmentFutureCommsType::class, $investmentFutureComm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attachments = $form->get('attachment')->getData();
            if ($attachments) {
                $files_name = [];
                foreach ($attachments as $attachment) {
                    $originalFilename = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);

                    $newFilename = $originalFilename . '.' . $attachment->guessExtension();

                    $attachment->move(
                        $this->getParameter('investments_future_comms_attachment_directory'),
                        $newFilename
                    );
                    $files_name[] = $newFilename;
                }
                $investmentFutureComm->setAttachment($files_name);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('investment_future_comms_index');
        }

        return $this->render('investment_future_comms/edit.html.twig', [
            'investment_future_comm' => $investmentFutureComm,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="investment_future_comms_delete", methods={"POST"})
     */
    public function delete(Request $request, InvestmentFutureComms $investmentFutureComm): Response
    {
        if ($this->isCsrfTokenValid('delete' . $investmentFutureComm->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($investmentFutureComm);
            $entityManager->flush();
        }

        return $this->redirectToRoute('investment_future_comms_index');
    }
}
