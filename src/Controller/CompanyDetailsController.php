<?php

namespace App\Controller;

use App\Entity\CompanyDetails;

use App\Form\CompanyDetailsType;
use App\Repository\CompanyDetailsRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/company_details")
 * @Security("is_granted('ROLE_ADMIN')")
 */
class CompanyDetailsController extends AbstractController
{
    /**
     * @Route("/index", name="company_details_index", methods={"GET"})
     */
    public function index(CompanyDetailsRepository $companyDetailsRepository): Response
    {
        return $this->render('company_details/index.html.twig', [
            'company_details'=>$companyDetailsRepository->findAll()
        ]);
    }

    /**
     * @Route("/new", name="company_details_new", methods={"GET", "POST"})
     */
    public function new(Request $request,CompanyDetailsRepository $companyDetailsRepository): Response
    {
        $companyDetails = new CompanyDetails();
        $form = $this->createForm(CompanyDetailsType::class, $companyDetails);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $companyDetailsRepository->add($companyDetails, true);

            return $this->redirectToRoute('company_details_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('company_details/new.html.twig', [
            'company_details' => $companyDetails,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="company_details_show", methods={"GET"})
     */
    public function show(CompanyDetails $companyDetails): Response
    {
        return $this->render('company_details/show.html.twig', [
            'company_details' => $companyDetails,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="company_details_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CompanyDetails $companyDetails, CompanyDetailsRepository $companyDetailsRepository): Response
    {
        $form = $this->createForm(CompanyDetailsType::class, $companyDetails);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $faviconDev=$form['faviconDev']->getData();
            $faviconLive=$form['faviconLive']->getData();

            if ($faviconDev) {
                $originalFilename = pathinfo($faviconDev->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $companyDetails->getCompanyName() .'_dev.'. $faviconDev->guessExtension();
                $faviconDev->move(
                    $this->getParameter('favicon_directory'),
                    $newFilename
                );
                $companyDetails->setFaviconDev($newFilename);
            }
            if ($faviconLive) {
                $originalFilenameLive = pathinfo($faviconLive->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilenameLive = $companyDetails->getCompanyName() .'_live.'. $faviconLive->guessExtension();
                $faviconLive->move(
                    $this->getParameter('favicon_directory'),
                    $newFilenameLive
                );
                $companyDetails->setFaviconLive($newFilenameLive);
            }
            $companyDetailsRepository->add($companyDetails, true);

            return $this->redirectToRoute('company_details_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('company_details/edit.html.twig', [
            'company_details' => $companyDetails,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="company_details_delete", methods={"POST"})
     */
    public function delete(Request $request, CompanyDetails $companyDetails, CompanyDetailsRepository $companyDetailsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$companyDetails->getId(), $request->request->get('_token'))) {
            $companyDetailsRepository->remove($companyDetails, true);
        }

        return $this->redirectToRoute('company_details_index', [], Response::HTTP_SEE_OTHER);
    }
}
