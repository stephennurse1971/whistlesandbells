<?php

namespace App\Controller;

use App\Entity\FxRates;
use App\Entity\FxRatesHistory;
use App\Form\FxRatesType;
use App\Repository\FxRatesHistoryRepository;
use App\Repository\FxRatesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/fxrates")
 */
class FxRatesController extends AbstractController
{
    /**
     * @Route("/index", name="fx_rates_index", methods={"GET"})
     */
    public function index(FxRatesRepository $fxRatesRepository): Response
    {
        return $this->render('fx_rates/index.html.twig', [
            'fx_rates' => $fxRatesRepository->findAll(),
            'USDGBPFXrate' => $fxRatesRepository->findOneBy([
                'fx' => 'GBP'
            ]),
        ]);
    }

    /**
     * @Route("/new", name="fx_rates_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $fxRate = new FxRates();
        $form = $this->createForm(FxRatesType::class, $fxRate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fxRate);
            $entityManager->flush();

            return $this->redirectToRoute('fx_rates_index');
        }

        return $this->render('fx_rates/new.html.twig', [
            'fx_rate' => $fxRate,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="fx_rates_show", methods={"GET"})
     */
    public function show(FxRates $fxRate): Response
    {
        return $this->render('fx_rates/show.html.twig', [
            'fx_rate' => $fxRate,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="fx_rates_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, FxRates $fxRate): Response
    {
        $form = $this->createForm(FxRatesType::class, $fxRate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fx_rates_index');
        }

        return $this->render('fx_rates/edit.html.twig', [
            'fx_rate' => $fxRate,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="fx_rates_delete", methods={"POST"})
     */
    public function delete(Request $request, FxRates $fxRate): Response
    {
        if ($this->isCsrfTokenValid('delete' . $fxRate->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fxRate);
            $entityManager->flush();
        }

        return $this->redirectToRoute('fx_rates_index');
    }

    /**
     * @Route("/ajax/update/currency/rate", name="ajax_update_currency_rate",methods={"POST"})
     */
    public function fxRateUpdate(FxRatesRepository $fxRatesRepository, FxRatesHistoryRepository $fxRatesHistoryRepository, EntityManagerInterface $manager)
    {
        $now = new \DateTime('now');
        if (isset($_POST['fx_rate'])) {
            $rate = $_POST['fx_rate'];
            $fxRate_id = $_POST['fxRate_id'];
            $getFxRateById = $fxRatesRepository->find($fxRate_id);
            $getFxRateById->setCurrentFxRate($rate);
            $getFxRateById->setUpdatedDate($now);

            $dateToday = $now->format('Y-m-d');
            $fxRateHistoryPrevious = $fxRatesHistoryRepository->findOneBy(['date' => new \DateTime($dateToday)]);
            if ($fxRateHistoryPrevious) {
                if ($getFxRateById->getFx() == 'CHF') {
                    $fxRateHistoryPrevious->setCHFFXRate($rate);
                } elseif ($getFxRateById->getFx() == 'EUR') {
                    $fxRateHistoryPrevious->setEURFXRate($rate);
                } elseif ($getFxRateById->getFx() == 'GBP') {
                    $fxRateHistoryPrevious->setGBPFXRate($rate);
                }
            }
            else{
                $fxHistoryNew= new FxRatesHistory();
                $fxHistoryNew->setDate(new \datetime($dateToday));
                if ($getFxRateById->getFx() == 'CHF') {
                    $fxHistoryNew->setCHFFXRate($rate);
                } elseif ($getFxRateById->getFx() == 'EUR') {
                    $fxHistoryNew->setEURFXRate($rate);
                } elseif ($getFxRateById->getFx() == 'GBP') {
                    $fxHistoryNew->setGBPFXRate($rate);
                }
                $manager->persist($fxHistoryNew);
            }

            $manager->flush();

        }
        return new Response(null);
    }
}
