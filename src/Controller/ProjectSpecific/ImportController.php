<?php

namespace App\Controller\ProjectSpecific;

use App\Entity\Import;
use App\Form\ProjectSpecific\ImportType;
use App\Repository\ProjectSpecific\FxRatesHistoryRepository;
use App\Repository\ProjectSpecific\MarketDataHistoryRepository;
use App\Repository\ProjectSpecific\MarketDataRepository;
use App\Repository\ProjectSpecific\UserRepository;
use App\Services\ChaveyDownImportService;
use App\Services\ProjectSpecific\FXRatesImportService;
use App\Services\ProjectSpecific\SecurityPricesImportService;
use App\Services\ProjectSpecific\UserImportGrapevineService;
use App\Services\ProjectSpecific\UserImportOutlookService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


/**
 * @Route("/admin")
 */
class ImportController extends AbstractController
{
    /**
     * @Route("/importContacts/{source}", name="userImport")
     */
    public function userImport(Request $request, string $source, SluggerInterface $slugger, UserRepository $userRepository, UserImportOutlookService $userImportOutlookService, UserImportGrapevineService $userImportGrapevineService): Response
    {
        $anyConflicts = $userRepository->findBy([
            'entryConflict' => 'Conflict'
        ]);
        if (!$anyConflicts) {
            $form = $this->createForm(ImportType::class);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $importFile = $form->get('File')->getData();
                if ($importFile) {
                    $originalFilename = pathinfo($importFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '.' . 'csv';
                    try {
                        $importFile->move(
                            $this->getParameter('user_attachments_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        die('Import failed');
                    }
                    if ($source == 'Outlook') {
                        $userImportOutlookService->importUser($newFilename);
                        return $this->redirectToRoute('user_index');
                    }
                    if ($source == 'Grapevine') {
                        $userImportGrapevineService->importUser($newFilename);
                        return $this->redirectToRoute('recruiters_index');
                    }
                }
            }
            return $this->render('admin/import/index.html.twig', [
                'form' => $form->createView(),
                'heading' => $source
            ]);

        }
        return $this->redirectToRoute('user_index');
    }


    /**
     * @Route("/import/FXRates", name="fx_rates_import")
     */
    public function fxRatesImport(Request $request, SluggerInterface $slugger, FXRatesImportService $fxRatesImportService,FxRatesHistoryRepository $fxRatesHistoryRepository): Response
    {
        $form = $this->createForm(ImportType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $importFile = $form->get('File')->getData();
            if ($importFile) {
                $originalFilename = pathinfo($importFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . 'csv';
                try {
                    $importFile->move(
                        $this->getParameter('fx_attachments_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    die('Import failed');
                }

                $fxRatesImportService->importFXRates($newFilename);
                return $this->redirectToRoute('fx_rates_history_index');
            }
        }
        return $this->render('admin/import/index.html.twig', [
            'form' => $form->createView(),
            'heading'=> 'FX Rates'
        ]);
    }


    /**
     * @Route("/import/securityPrice/{security}", name="security_prices_import")
     */
    public function securityPricesImport(Request $request, $security, SluggerInterface $slugger, SecurityPricesImportService $securityPricesImportService, MarketDataRepository $marketDataRepository,MarketDataHistoryRepository $marketDataHistoryRepository): Response
    {
        $security = $marketDataRepository->find($security);
        $form = $this->createForm(ImportType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $importFile = $form->get('File')->getData();
            if ($importFile) {
                $originalFilename = pathinfo($importFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . 'csv';
                try {
                    $importFile->move(
                        $this->getParameter('security_prices_attachments_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    die('Import failed');
                }

                $securityPricesImportService->importSecurityPrices($newFilename,$security);
                return $this->redirectToRoute('app_home');
            }
        }
        return $this->render('admin/import/index.html.twig', [
            'form' => $form->createView(),
            'heading'=> 'Security Prices'
        ]);



    }



}
