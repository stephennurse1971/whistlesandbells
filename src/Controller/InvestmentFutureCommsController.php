<?php

namespace App\Controller;

use App\Entity\InvestmentFutureComms;
use App\Form\InvestmentFutureCommsType;
use App\Repository\InvestmentFutureCommsRepository;
use App\Repository\InvestmentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/investment/future/comms")
 */
class InvestmentFutureCommsController extends AbstractController
{
    /**
     * @Route("/", name="investment_future_comms_index", methods={"GET"})
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
    public function new(int $id,Request $request, InvestmentsRepository $investmentsRepository): Response
    {
        $investment = $investmentsRepository->find($id);
        $investmentFutureComm = new InvestmentFutureComms();
        $form = $this->createForm(InvestmentFutureCommsType::class, $investmentFutureComm, [
            'investment'=>$investment
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attachments = $form->get('attachment')->getData();
            if ($attachments) {
                $files_name=[];
                foreach($attachments as $attachment) {
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

            return $this->redirectToRoute('investments_index');
        }

        return $this->render('investment_future_comms/new.html.twig', [
            'investment_future_comm' => $investmentFutureComm,
            'form' => $form->createView(),
            'investment' => $investment
        ]);
    }





    /**
     * @Route("/{id}", name="investment_future_comms_show", methods={"GET"})
     */
    public function show(InvestmentFutureComms $investmentFutureComm): Response
    {
        return $this->render('investment_future_comms/show.html.twig', [
            'investment_future_comm' => $investmentFutureComm,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="investment_future_comms_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, InvestmentFutureComms $investmentFutureComm): Response
    {
        $form = $this->createForm(InvestmentFutureCommsType::class, $investmentFutureComm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attachments = $form->get('attachment')->getData();
            if ($attachments) {
                $files_name=[];
                foreach($attachments as $attachment) {
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
     * @Route("/{id}", name="investment_future_comms_delete", methods={"POST"})
     */
    public function delete(Request $request, InvestmentFutureComms $investmentFutureComm): Response
    {
        if ($this->isCsrfTokenValid('delete'.$investmentFutureComm->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($investmentFutureComm);
            $entityManager->flush();
        }

        return $this->redirectToRoute('investment_future_comms_index');
    }
}
