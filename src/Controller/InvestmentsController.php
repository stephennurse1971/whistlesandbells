<?php

namespace App\Controller;

use App\Entity\Investments;
use App\Entity\TaxYear;
use App\Entity\UkDays;
use App\Form\InvestmentsType;
use App\Repository\FxRatesRepository;
use App\Repository\InvestmentFutureCommsRepository;
use App\Repository\InvestmentsRepository;
use App\Repository\TaxYearRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/investments")
 */
class InvestmentsController extends AbstractController
{
    /**
     * @Route("/", name="investments_index", methods={"GET"})
     */
    public function index(InvestmentsRepository $investmentsRepository, InvestmentFutureCommsRepository $investmentFutureCommsRepository, FxRatesRepository $fxRatesRepository): Response
    {
        return $this->render('investments/index.html.twig', [
            'investmentsCurrent' => $investmentsRepository->findBy([
                'investmentSaleDate' => null
            ]),
            'investmentsAll' => $investmentsRepository->findAll(),
            'investmentsSold' => $investmentsRepository->findByInvestmentSold(),
            'investmentsFutureComms' => $investmentFutureCommsRepository->findAll(),
            'fxRates' => $fxRatesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/tax_summary", name="investments_index_tax_consequences", methods={"GET"})
     */
    public function indexTaxConsequences(InvestmentsRepository $investmentsRepository, InvestmentFutureCommsRepository $investmentFutureCommsRepository, TaxYearRepository $taxYearRepository, FxRatesRepository $fxRatesRepository): Response
    {

        return $this->render('investments/taxConsequencesInvestmentindex.html.twig', [
            'investmentsCurrent' => $investmentsRepository->findBy([
                'investmentSaleDate' => null
            ]),
            'investmentsAll' => $investmentsRepository->findAll(),
            'investmentsSold' => $investmentsRepository->findByInvestmentSold(),
            'investmentsFutureComms' => $investmentFutureCommsRepository->findAll(),
            'fxRates' => $fxRatesRepository->findAll(),
            'taxYears' => $taxYearRepository->findAllByAsc()
        ]);
    }

    /**
     * @Route("/new", name="investments_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $investment = new Investments();
        $form = $this->createForm(InvestmentsType::class, $investment, ['edit' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($investment);
            $entityManager->flush();
            return $this->redirectToRoute('investments_index');
        }

        return $this->render('investments/new.html.twig', [
            'investment' => $investment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="investments_show", methods={"GET"})
     */
    public function show(Investments $investment): Response
    {
        return $this->render('investments/show.html.twig', [
            'investment' => $investment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="investments_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Investments $investment): Response
    {
//        $referer = $request->headers->get('Referer');
        $currency = $investment->getCurrency();
        $share_cert = $investment->getShareCert();
        $eis_cert = $investment->getEisCert();
        $other_docs = $investment->getOtherDocs();
        $form = $this->createForm(InvestmentsType::class, $investment, [
            'share_cert' => $share_cert,
            'eis_cert' => $eis_cert,
            'other_docs' => $other_docs,
            'currency' => $currency,
            'edit' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $share_cert = $form['shareCert']->getData();
            if ($share_cert) {
                $share_cert_directory = $this->getParameter('investments_attachment_directory');
                $fileName = pathinfo($share_cert->getClientOriginalName(), PATHINFO_FILENAME);
                $file_extension = $share_cert->guessExtension();
                $newFileName = $fileName . "." . $file_extension;
                $share_cert->move($share_cert_directory, $newFileName);
                $investment->setShareCert($newFileName);
            }

            $eisCert = $form['eisCert']->getData();
            if ($eisCert) {
                $eis_cert_directory = $this->getParameter('investments_attachment_directory');
                $fileName = pathinfo($eisCert->getClientOriginalName(), PATHINFO_FILENAME);
                $file_extension = $eisCert->guessExtension();
                $newFileName = $fileName . "." . $file_extension;
                $eisCert->move($eis_cert_directory, $newFileName);
                $investment->setEisCert($newFileName);
            }

            $other_docs = $form['otherDocs']->getData();
            if ($other_docs) {
                $other_docs_directory = $this->getParameter('investments_attachment_directory');
                $fileName = pathinfo($other_docs->getClientOriginalName(), PATHINFO_FILENAME);
                $file_extension = $other_docs->guessExtension();
                $newFileName = $fileName . "." . $file_extension;
                $other_docs->move($other_docs_directory, $newFileName);
                $investment->setOtherDocs($newFileName);
            }

            $this->getDoctrine()->getManager()->flush();
//            return $this->redirect($referer);
            return $this->redirectToRoute('investments_index');
        }

        return $this->render('investments/edit.html.twig', [
            'investment' => $investment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="investments_delete", methods={"POST"})
     */
    public function delete(Request $request, Investments $investment): Response
    {
        if ($this->isCsrfTokenValid('delete' . $investment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($investment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('investments_index');
    }


    /**
     * @Route("/{id}/delete/attachment1", name="investments_delete_attachment1")
     */
    public function deleteAttachment1(Request $request, Investments $investments, EntityManagerInterface $entityManager)
    {
        $referer = $request->headers->get('referer');
        $investments->setShareCert('');
        $entityManager->flush();
        return $this->redirect($referer);
    }

    /**
     * @Route("/{id}/delete/attachment2", name="investments_delete_attachment2")
     */
    public function deleteAttachment2(Request $request, Investments $investments, EntityManagerInterface $entityManager)
    {
        $referer = $request->headers->get('referer');
        $investments->setEisCert('');
        $entityManager->flush();
        return $this->redirect($referer);
    }

    /**
     * @Route("/{id}/delete/attachment3", name="investments_delete_attachment3")
     */
    public function deleteAttachment3(Request $request, Investments $investments, EntityManagerInterface $entityManager)
    {
        $referer = $request->headers->get('referer');
        $investments->setOtherDocs('');
        $entityManager->flush();
        return $this->redirect($referer);
    }

    /**
     * @Route("/view/file/{filetype}/{id}", name="investment_viewfile", methods={"GET"})
     */
    public function investmentFileLaunch(Investments $investments): Response
    {
        $fileName = $investments->$filetype();
        $publicResourcesFolderPath = $this->getParameter('investments_attachment_directory');
        return new BinaryFileResponse($publicResourcesFolderPath . "/" . $fileName);
    }


}
