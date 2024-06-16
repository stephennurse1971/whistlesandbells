<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\ToDoList;
use App\Entity\UkDays;
use App\Form\UkDaysType;
use App\Repository\CountryRepository;
use App\Repository\TaxYearRepository;
use App\Repository\UkDaysRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function index(UkDaysRepository $ukDaysRepository, CountryRepository $countryRepository, TaxYearRepository $taxYearRepository): Response
    {
        return $this->render('uk_days/index.html.twig', [
            'uk_days' => $ukDaysRepository->findAll(),
            'countries' => $countryRepository->findAll(),
            'taxyears' => $taxYearRepository->findAll()
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
//            $attachments = $form['travelDocs']->getData();
//            if ($attachments) {
//                $files_name = [];
//                $attachment_directory = $this->getParameter('uk_travel_days_directory');
//                foreach ($attachments as $attachment) {
//                    $fileName = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
//                    $file_extension = $attachment->guessExtension();
//                    $newFileName = $fileName . "." . $file_extension;
//                    $attachment->move($attachment_directory, $newFileName);
//                    $files_name[] = $newFileName;
//                }
//                $ukDay->setTravelDocs($files_name);
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

//            if ($form->get('travelDocs')->getData()) {
//
//                $files = $form->get('travelDocs')->getData();
//                $file_names = [];
//                foreach ($files as $file) {
//                    $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
//                    $newFilename = $originalFilename . "." . $file->guessExtension();
//                    $file->move(
//                        $this->getParameter('files_upload_default_directory'),
//                        $newFilename
//                    );
//                    $file_names[] = $newFilename;
//                }
//                $ukDay->setTravelDocs($file_names);
//            }

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
     * @Route("/delete/attachment2/{id}", name="ukdays_delete_attachment2")
     */
    public function deleteAttachment2(Request $request, UkDays $ukDays, EntityManagerInterface $entityManager)
    {
        $referer = $request->headers->get('referer');
        $ukDays->setTravelDocs2('');
        $entityManager->flush();
        return $this->redirect($referer);
    }
}
