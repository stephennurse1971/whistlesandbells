<?php

namespace App\Controller;

use App\Entity\Investments;
use App\Entity\TaxDocuments;
use App\Entity\TaxInputs;
use App\Entity\TaxSchemes;
use App\Form\TaxDocumentsType;
use App\Form\TaxInputsType;
use App\Repository\InvestmentsRepository;
use App\Repository\TaxInputsRepository;
use App\Repository\TaxSchemesRepository;
use App\Repository\TaxYearRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tax/inputs")
 */
class TaxInputsController extends AbstractController
{
    /**
     * @Route("/", name="tax_inputs_index", methods={"GET"})
     */
    public function index(TaxInputsRepository $taxInputsRepository): Response
    {
        return $this->render('tax_inputs/index.html.twig', [
            'taxinputs' => $taxInputsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/taxOverview", name="tax_inputs_overview_index", methods={"GET"})
     */
    public function indexTaxOverview(TaxInputsRepository $taxInputsRepository, InvestmentsRepository $investmentsRepository,TaxSchemesRepository $taxSchemesRepository,TaxYearRepository $taxYearRepository): Response
    {
        return $this->render('tax_inputs/indexTaxOverview.html.twig', [
            'taxinputs' => $taxInputsRepository->findAll(),
            'taxYears' => $taxYearRepository->findAllByAsc(),
            'investments' => $investmentsRepository->findAll(),
            'taxschemes'=> $taxSchemesRepository->findAll()
        ]);
    }

    /**
     * @Route("/new", name="tax_inputs_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $taxInput = new TaxInputs();
        $form = $this->createForm(TaxInputsType::class, $taxInput);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($taxInput);
            $entityManager->flush();

            return $this->redirectToRoute('tax_inputs_index');
        }

        return $this->render('tax_inputs/new.html.twig', [
            'tax_input' => $taxInput,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tax_inputs_show", methods={"GET"})
     */
    public function show(TaxInputs $taxInput): Response
    {
        return $this->render('tax_inputs/show.html.twig', [
            'tax_input' => $taxInput,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tax_inputs_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TaxInputs $taxInput): Response
    {
        $year = $taxInput->getYear()->getTaxYearRange();
        $P11D_file_name = $taxInput->getP11D();
        $p60_file_name = $taxInput->getP60();
        $p45_file_name = $taxInput->getP45();
        $selfAssessment_file_name = $taxInput->getSelfAssessment();
        $form = $this->createForm(TaxInputsType::class, $taxInput, [
            'p11d_file_name' => $P11D_file_name,
            'p60_file_name' => $p60_file_name,
            'p45_file_name' => $p45_file_name,
            'selfAssessment_file_name' => $selfAssessment_file_name
        ]);
        $form->handleRequest($request);
        $form = $this->createForm(TaxInputsType::class, $taxInput);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $p11D = $form['p11D']->getData();
            if ($p11D) {
                $p11D_directory = $this->getParameter('tax_documents_attachments_directory');
                $fileName = pathinfo($p11D->getClientOriginalName(), PATHINFO_FILENAME);
                $file_extension = $p11D->guessExtension();
                $newFileName = "P11D_" . $year."." . $file_extension;
                $p11D->move($p11D_directory, $newFileName);
                $taxInput->setP11D($newFileName);
            }
            $p60 = $form['p60']->getData();
            if ($p60) {
                $p60_directory = $this->getParameter('tax_documents_attachments_directory');
                $fileName = pathinfo($p60->getClientOriginalName(), PATHINFO_FILENAME);
                $file_extension = $p60->guessExtension();
                $newFileName = "P60_" . $year."." . $file_extension;
                $p60->move($p60_directory, $newFileName);
                $taxInput->setP60($newFileName);
            }
            $p45 = $form['p45']->getData();
            if ($p45) {
                $p45_directory = $this->getParameter('tax_documents_attachments_directory');
                $fileName = pathinfo($p45->getClientOriginalName(), PATHINFO_FILENAME);
                $file_extension = $p45->guessExtension();
                $newFileName = "P45_" . $year."." . $file_extension;
                $p45->move($p45_directory, $newFileName);
                $taxInput->setP45($newFileName);
            }
            $selfAssessment = $form['selfAssessment']->getData();
            if ($selfAssessment) {
                $selfAssessment_directory = $this->getParameter('tax_documents_attachments_directory');
                $fileName = pathinfo($selfAssessment->getClientOriginalName(), PATHINFO_FILENAME);
                $file_extension = $selfAssessment->guessExtension();
                $newFileName = "SelfAssessment_" . $year."." . $file_extension;
                $selfAssessment->move($selfAssessment_directory, $newFileName);
                $taxInput->setSelfAssessment($newFileName);
            }
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('tax_inputs_index');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tax_inputs_index');
        }

        return $this->render('tax_inputs/edit.html.twig', [
            'tax_input' => $taxInput,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tax_inputs_delete", methods={"POST"})
     */
    public function delete(Request $request, TaxInputs $taxInput): Response
    {
        if ($this->isCsrfTokenValid('delete'.$taxInput->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($taxInput);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tax_inputs_index');
    }

    /**
     * @Route("/{id}/delete/{type}", name="tax_input_delete_attachment")
     */
    public function deleteAttachment(string $type, int $id, Request $request, TaxInputs $taxInputs, EntityManagerInterface $entityManager)
    {
        if ($type == 'P11D') {
            $taxInputs->setP11D(null);
        }
        if ($type == 'P60') {
            $taxInputs->setP60(null);
        }
        if ($type == 'P45') {
            $taxInputs->setP45(null);
        }
        if ($type == 'SelfAssessment') {
            $taxInputs->setSelfAssessment(null);
        }
        $entityManager->flush();
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }

    /**
     * @Route("/view/file/{filetype}/{id}", name="taxdocument_viewfile", methods={"GET"})
     */
    public function investmentFileLaunch(string $filetype,TaxInputs $taxInputs): Response
    {
        $fileName = '';
        if ($filetype == 'SelfAssessment') {
            $fileName = $taxInputs->getSelfAssessment();
        } elseif ($filetype == 'P11D') {
            $fileName = $taxInputs->getP11D();
        } elseif ($filetype == 'P45') {
            $fileName = $taxInputs->getP45();
        } elseif ($filetype == 'P60') {
            $fileName = $taxInputs->getP60();
        }
        if ($fileName != '') {
            $publicResourcesFolderPath = $this->getParameter('tax_documents_attachments_directory');
            return new BinaryFileResponse($publicResourcesFolderPath . "/" . $fileName);
        }
return $this->render('error/file_not_found.html.twig');
    }


}
