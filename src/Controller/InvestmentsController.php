<?php

namespace App\Controller;

use App\Entity\Investments;
use App\Repository\BankAccountsRepository;
use App\Repository\BankBalancesRepository;
use App\Repository\LoansBondsRepository;
use App\Repository\SettingsRepository;
use App\Services\FXRatesOnAsOfDate;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Form\InvestmentsType;
use App\Repository\AssetClassesRepository;
use App\Repository\FxRatesRepository;
use App\Repository\InvestmentFutureCommsRepository;
use App\Repository\InvestmentsRepository;
use App\Repository\TaxInputsRepository;
use App\Repository\TaxYearRepository;
use App\Services\Investment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/investments")
 * @IsGranted("ROLE_ACCOUNTANT")
 */
class InvestmentsController extends AbstractController
{
    /**
     * @Route("/index/tax/{grouping}", name="investments_tax_view_index", methods={"GET"})
     */
    public function index(string $grouping, InvestmentsRepository $investmentsRepository, InvestmentFutureCommsRepository $investmentFutureCommsRepository, AssetClassesRepository $assetClassesRepository, FxRatesRepository $fxRatesRepository, SettingsRepository $settingsRepository): Response
    {
        $settings = $settingsRepository->find('1');
        if ($grouping == 'Tax Details - Aggregated') {
            return $this->render('investments/indexAggregated.html.twig', [
                'settings' => $settings,
                'investmentsCurrent' => $investmentsRepository->findBy([
                    'investmentSaleDate' => null
                ]),
                'investmentsAll' => $investmentsRepository->findAll(),
                'investmentsSold' => $investmentsRepository->findByInvestmentSold(),

                'asset_classes' => $assetClassesRepository->findAll(),
                'investmentsFutureComms' => $investmentFutureCommsRepository->findAll(),
                'fxRates' => $fxRatesRepository->findAll(),
                'USDGBPFXrate' => $fxRatesRepository->findOneBy([
                    'fx' => 'GBP'
                ]),
                'grouping' => $grouping
            ]);
        }
        if ($grouping == 'Tax Details - By Asset Class') {
            return $this->render('investments/indexByAssetClass.html.twig', [
                'settings' => $settings,
                'investmentsCurrent' => $investmentsRepository->findBy([
                    'investmentSaleDate' => null
                ]),
                'investmentsAll' => $investmentsRepository->findAll(),
                'investmentsSold' => $investmentsRepository->findByInvestmentSold(),
                'asset_classes' => $assetClassesRepository->findAll(),
                'investmentsFutureComms' => $investmentFutureCommsRepository->findAll(),
                'fxRates' => $fxRatesRepository->findAll(),
                'USDGBPFXrate' => $fxRatesRepository->findOneBy([
                    'fx' => 'GBP'
                ]),
                'grouping' => $grouping
            ]);
        }

    }


    /**
     * @Route("/index/economic/{subset}", name="investments_economic_index", methods={"GET"})
     */
    public function indexEconomic(Request $request, string $subset, InvestmentsRepository $investmentsRepository, InvestmentFutureCommsRepository $investmentFutureCommsRepository, AssetClassesRepository $assetClassesRepository, FxRatesRepository $fxRatesRepository, BankBalancesRepository $bankBalancesRepository, BankAccountsRepository $bankAccountsRepository, LoansBondsRepository $loansBondsRepository, SettingsRepository $settingsRepository, FXRatesOnAsOfDate $FXRatesOnAsOfDate): Response
    {
        $settings = $settingsRepository->find('1');
        $loans_bonds = $loansBondsRepository->findAll();
        $bank_accounts = $bankAccountsRepository->findAll();
        $bank_balances = $bankBalancesRepository->findAll();
        $investmentsSold = [];
        $all_investments = $investmentsRepository->findAll();
        foreach ($all_investments as $investment) {
            if ($investment->getInvestmentSaleDate() != null) {
                $investmentsSold[] = $investment;
            }
        }
        if ($subset == "All") {
            $investments = $all_investments;
        }
        if ($subset == "Active") {
            $investments = $investmentsRepository->findBy([
                'investmentSaleDate' => null
            ]);
        }
        if ($subset == "Sold") {
            $investments = $investmentsSold;
        }

        return $this->render('investments/indexEconomicView.html.twig', [
            'settings' => $settings,
            'loans_bonds' => $loans_bonds,
            'bank_accounts' => $bank_accounts,
            'bank_balances' => $bank_balances,
            'investments' => $investments,
            'asset_classes' => $assetClassesRepository->findAll(),
            'investmentsFutureComms' => $investmentFutureCommsRepository->findAll(),
            'fxRates' => $fxRatesRepository->findAll(),
            'USDGBPFXrate' => $fxRatesRepository->findOneBy([
                'fx' => 'GBP'
            ]),
            'grouping' => 'Economics - Active'
        ]);
    }


    /**
     * @Route("/tax_summary_of_investments/{show}", name="investments_tax_consequences", methods={"GET"})
     */
    public function indexTaxConsequences(string $show, TaxInputsRepository $taxInputsRepository, InvestmentsRepository $investmentsRepository, InvestmentFutureCommsRepository $investmentFutureCommsRepository, TaxYearRepository $taxYearRepository, FxRatesRepository $fxRatesRepository): Response
    {
        $investments = [];
        $all_investments = $investmentsRepository->findAll();
        foreach ($all_investments as $investment) {
            if ($investment->getAssetClass()->getTaxScheme()->getIncludeTaxSummary() == 1) {
                $investments[] = $investment;
            }
        }
        return $this->render('investments/taxConsequencesInvestmentindex.html.twig', [
            'taxinputs' => $taxInputsRepository->findAll(),
            'investments' => $investments,
            'investmentsFutureComms' => $investmentFutureCommsRepository->findAll(),
            'fxRates' => $fxRatesRepository->findAll(),
            'taxYears' => $taxYearRepository->findAllByAsc(),
            'show' => $show
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
            return $this->redirectToRoute('investments_tax_view_index', ['grouping' => 'All']);
        }

        return $this->render('investments/new.html.twig', [
            'investment' => $investment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="investments_show", methods={"GET"})
     */
    public function show(Investments $investment): Response
    {
        return $this->render('investments/show.html.twig', [
            'investment' => $investment,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="investments_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Investments $investment): Response
    {
        $investmentDate = new \DateTime('now');
        $investmentDate = $investmentDate->format('d-m-y');
        if ($investment->getInvestmentDate()) {
            $investmentDate = $investment->getInvestmentDate()->format('d-m-y');
        }
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
        $newFileNameSuffix = $investment->getInvestmentCompany()->getShareCompany() . "_" . $investment->getInvestmentAmount() . "_" . $investmentDate;

        if ($form->isSubmitted()) {
            $data_container = $_POST["investments"];
            $investment->setInvestmentAmount($data_container['investmentAmount']);
            $investment->setNumberOfShares($data_container['numberOfShares']);
            $investment->setCrystallisedGainLossInGBP($data_container['crystallisedGainLossInGBP']);
            $investment->setLossDeductibleAgainstIncome($data_container['lossDeductibleAgainstIncome']);
            $share_cert = $form['shareCert']->getData();
            if ($share_cert) {
                $share_cert_directory = $this->getParameter('investments_attachment_directory');
                $fileName = pathinfo($share_cert->getClientOriginalName(), PATHINFO_FILENAME);
                $file_extension = $share_cert->guessExtension();
                $newFileName = "Share_Certificate_" . $newFileNameSuffix . "." . $file_extension;
                $share_cert->move($share_cert_directory, $newFileName);
                $investment->setShareCert($newFileName);
            }
            $eisCert = $form['eisCert']->getData();
            if ($eisCert) {
                $eis_cert_directory = $this->getParameter('investments_attachment_directory');
                $fileName = pathinfo($eisCert->getClientOriginalName(), PATHINFO_FILENAME);
                $file_extension = $eisCert->guessExtension();
                $newFileName = "EIS_Certificate_" . $newFileNameSuffix . "." . $file_extension;
                $eisCert->move($eis_cert_directory, $newFileName);
                $investment->setEisCert($newFileName);
            }

            $other_docs = $form['otherDocs']->getData();
            if ($other_docs) {
                $other_docs_directory = $this->getParameter('investments_attachment_directory');
                $fileName = pathinfo($other_docs->getClientOriginalName(), PATHINFO_FILENAME);
                $file_extension = $other_docs->guessExtension();
                $newFileName = $fileName . "_" . $newFileNameSuffix . "." . $file_extension;
                $other_docs->move($other_docs_directory, $newFileName);
                $investment->setOtherDocs($newFileName);
            }

            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('investments_tax_view_index', ['grouping' => 'Tax Details - By Asset Class']);
        }

        return $this->render('investments/edit.html.twig', [
            'investment' => $investment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="investments_delete", methods={"POST"})
     */
    public function delete(Request $request, Investments $investment): Response
    {
        $referer = $request->headers->get('referer');
        if ($this->isCsrfTokenValid('delete' . $investment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($investment);
            $entityManager->flush();
        }
        return $this->redirectToRoute('investments_tax_view_index', ['grouping' => 'Tax Details - By Asset Class']);
    }


    /**
     * @Route("/delete/attachment1/{id}", name="investments_delete_attachment1")
     */
    public function deleteAttachment1(Request $request, Investments $investments, EntityManagerInterface $entityManager)
    {
        $referer = $request->headers->get('referer');
        $investments->setShareCert('');
        $entityManager->flush();
        return $this->redirect($referer);
    }

    /**
     * @Route("/delete/attachment2/{id}", name="investments_delete_attachment2")
     */
    public function deleteAttachment2(Request $request, Investments $investments, EntityManagerInterface $entityManager)
    {
        $referer = $request->headers->get('referer');
        $investments->setEisCert('');
        $entityManager->flush();
        return $this->redirect($referer);
    }

    /**
     * @Route("/delete/attachment3/{id}", name="investments_delete_attachment3")
     */
    public function deleteAttachment3(Request $request, Investments $investments, EntityManagerInterface $entityManager)
    {
        $referer = $request->headers->get('referer');
        $investments->setOtherDocs('');
        $entityManager->flush();
        return $this->redirect($referer);
    }

    /**
     * @Route("/checkboxes/reset_self_assessment_checks", name="investments_reset_self_assessment_checks")
     */
    public function resetSelfAssessmentChecks(Request $request, InvestmentsRepository $investmentsRepository, EntityManagerInterface $entityManager)
    {
        $referer = $request->headers->get('referer');
        $all_investments = $investmentsRepository->findAll();
        foreach ($all_investments as $investment) {
            $investment->setEisPurchaseYear1SelfAssessmentCheck('No');
            $investment->setEisPurchaseYear2SelfAssessmentCheck('No');
            $investment->setEisSaleYear1SelfAssessmentCheck('No');
            $investment->setEisSaleYear2SelfAssessmentCheck('No');
            $entityManager->persist($investment);
            $entityManager->flush($investment);
        }
        return $this->redirect($referer);
    }

    /**
     * @Route("/view/file/{filetype}/{id}", name="investment_viewfile", methods={"GET"})
     */
    public function investmentFileLaunch(string $filetype, Investments $investments): Response
    {
        if ($filetype == 'shareCert') {
            $fileName = $investments->getShareCert();
        } elseif ($filetype == 'eisCert') {
            $fileName = $investments->getEisCert();
        } elseif ($filetype == 'otherDocs') {
            $fileName = $investments->getOtherDocs();
        }
        $publicResourcesFolderPath = $this->getParameter('investments_attachment_directory');
        return new BinaryFileResponse($publicResourcesFolderPath . "/" . $fileName);
    }

    /**
     * @Route("/ajax/company/assetclass/{id}", name="investment_ajax_find_company_asset_class")
     */
    public function ajaxFindCompanyAssetClass(int $id, Investment $investment): Response
    {
        $asset_class = $investment->getAssetClass($id);
        $json_data = json_encode($asset_class);
        return new JsonResponse($asset_class);
    }
}
