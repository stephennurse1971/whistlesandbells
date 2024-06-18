<?php

namespace App\Controller\Project_Specific;

use App\Entity\Project_Specific\UkDays;
use App\Form\Project_Specific\UkDaysType;
use App\Repository\Project_Specific\AirportsRepository;
use App\Repository\Project_Specific\CountryRepository;
use App\Repository\Project_Specific\TaxYearRepository;
use App\Repository\Project_Specific\UkDayCalendarRepository;
use App\Repository\Project_Specific\UkDaysRepository;
use App\Services\Project_Specific\CountDaysByCountry;
use App\Services\Project_Specific\LocationByDate;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ukdays")
 */
class UkDaysController extends AbstractController
{
    /**
     * @Route("/index", name="uk_days_index", methods={"GET"})
     */
    public function index(UkDaysRepository $ukDaysRepository, UkDayCalendarRepository $ukDayCalendarRepository, CountryRepository $countryRepository, TaxYearRepository $taxYearRepository, CountDaysByCountry $countDaysByCountry, LocationByDate $locationByDate): Response
    {
        return $this->render('uk_days/index.html.twig', [
            'uk_days' => $ukDaysRepository->findAll(),
            'uk_calendar' => $ukDayCalendarRepository->findAll(),
            'countries' => $countryRepository->findAll(),
            'taxyears' => $taxYearRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="uk_days_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ukDay = new UkDays();
        $form = $this->createForm(UkDaysType::class, $ukDay);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('travelDocs')->getData()) {
                $file = $form->get('travelDocs')->getData();
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . "." . $file->guessExtension();
                $file->move(
                    $this->getParameter('uk_travel_days_directory'),
                    $newFilename
                );
                $ukDay->setTravelDocs($newFilename);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ukDay);
            $entityManager->flush();
            return $this->redirectToRoute('uk_days_index');
        }

        return $this->render('uk_days/new.html.twig', [
            'uk_day' => $ukDay,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="uk_days_show", methods={"GET"})
     */
    public function show(UkDays $ukDay): Response
    {
        return $this->render('uk_days/show.html.twig', [
            'uk_day' => $ukDay,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="uk_days_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UkDays $ukDay): Response
    {
        $form = $this->createForm(UkDaysType::class, $ukDay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('travelDocs')->getData()) {
                $file = $form->get('travelDocs')->getData();
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . "." . $file->guessExtension();
                $file->move(
                    $this->getParameter('uk_travel_days_directory'),
                    $newFilename
                );
                $ukDay->setTravelDocs($newFilename);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('uk_days_index');
        }

        return $this->render('uk_days/edit.html.twig', [
            'uk_day' => $ukDay,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="uk_days_delete", methods={"POST"})
     */
    public function delete(Request $request, UkDays $ukDay): Response
    {
        if ($this->isCsrfTokenValid('delete' . $ukDay->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ukDay);
            $entityManager->flush();
        }
        return $this->redirectToRoute('uk_days_index');
    }

    /**
     * @Route("/delete/attachment1/{id}", name="ukdays_delete_attachment1")
     */
    public function deleteAttachment1(Request $request, UkDays $ukDays, EntityManagerInterface $entityManager)
    {
        $referer = $request->headers->get('referer');
        $ukDays->setTravelDocs([]);
        $entityManager->flush();
        return $this->redirect($referer);
    }

    /**
     * @Route("/ajax/{countryId}")
     */
    public function getAirports($countryId, AirportsRepository $airportsRepository, CountryRepository $countryRepository)
    {
        $airports_by_country = $airportsRepository->findBy([
            'country' => $countryRepository->find($countryId)

        ]);
        foreach ($airports_by_country as $airport) {
            echo '<option value="' . $airport->getId() . '">' . $airport->getCity() . '</option>';
        }
        //$airports_by_country = json_encode($airports_by_country);
        return new Response(null);

    }

    /**
     * @Route("/view_file/{fileName}", name="travel_docs_view_file", methods={"GET"})
     */
    public function viewTravelDocs(string $fileName): Response
    {
        $publicResourcesFolderPath = $this->getParameter('uk_travel_days_directory');
        return new BinaryFileResponse($publicResourcesFolderPath . "/" . $fileName);
    }


    /**
     * @Route("/delete_travel_doc/{id}", name="travel_docs_delete_file", methods={"POST", "GET"})
     */
    public function deleteTravelDocFile(Request $request, int $id, UkDays $ukDays, EntityManagerInterface $entityManager)
    {
        $referer = $request->headers->get('referer');
        $travelDoc =$ukDays->getTravelDocs();
//        $file = glob($this->getParameter('uk_travel_days_directory') . "/" . $travelDoc);
//        unlink($file);

        $ukDays->setTravelDocs(null);
        $entityManager->flush();

        $entityManager->flush();
        return $this->redirect($referer);
    }
}
