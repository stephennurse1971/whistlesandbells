<?php

namespace App\Controller;

use App\Entity\ClientDetails;
use App\Form\ClientDetailsType;
use App\Repository\ClientDetailsRepository;
use App\Repository\CompanyDetailsRepository;
use JeroenDesloovere\VCard\VCard;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/client/details')]
class ClientDetailsController extends AbstractController
{
    #[Route('/index', name: 'client_details_index', methods: ['GET'])]
    public function index(ClientDetailsRepository $clientDetailsRepository): Response
    {
        return $this->render('client_details/index.html.twig', [
            'client_details' => $clientDetailsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_client_details_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ClientDetailsRepository $clientDetailsRepository): Response
    {
        $clientDetail = new ClientDetails();
        $form = $this->createForm(ClientDetailsType::class, $clientDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clientDetailsRepository->add($clientDetail, true);

            return $this->redirectToRoute('client_details_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client_details/new.html.twig', [
            'client_detail' => $clientDetail,
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'client_details_show', methods: ['GET'])]
    public function show(ClientDetails $clientDetail): Response
    {
        return $this->render('client_details/show.html.twig', [
            'client_detail' => $clientDetail,
        ]);
    }

    #[Route('/edit/{id}', name: 'client_details_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ClientDetails $clientDetail, ClientDetailsRepository $clientDetailsRepository): Response
    {
        $form = $this->createForm(ClientDetailsType::class, $clientDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clientDetailsRepository->add($clientDetail, true);

            return $this->redirectToRoute('client_details_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client_details/edit.html.twig', [
            'client_detail' => $clientDetail,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'client_details_delete', methods: ['POST'])]
    public function delete(Request $request, ClientDetails $clientDetail, ClientDetailsRepository $clientDetailsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$clientDetail->getId(), $request->request->get('_token'))) {
            $clientDetailsRepository->remove($clientDetail, true);
        }

        return $this->redirectToRoute('client_details_index', [], Response::HTTP_SEE_OTHER);
    }



    /**
     * @Route("/create/VcardClient/{id}", name="create_vcard_client")
     */
    public function createVcardVenue(ClientDetailsRepository $clientDetailsRepository)
    {
        $client = $clientDetailsRepository->find($id);
        $vcard = new VCard();

        $firstName = $client->getUser()->getFirstName();
        $lastName = $client->getUser()->getLastName();
        $email = $client->getUser()->getEmail();
        $mobile = $client->getUser()->getMobile();

        $addressStreet = $client->getAddressStreet();
        $addressTown = $client->getAddressTown();
        $addressCity = $client->getAddressCounty();
        $addressPostalCode = $client->getAddressPostCode();
        $notes_all='';

        $vcard->addName($lastName, $firstName);
        $vcard->addEmail($email)
            ->addPhoneNumber($mobile, 'home')
            ->addAddress($name = '', $extended = '', $street = $addressStreet, $city = $addressTown, $region = $addressCity, $zip = $addressPostalCode, $country = $addressCountry, $type = 'WORK POSTAL')

            ->addNote(strip_tags($notes_all));
        $vcard->download();
        return new Response(null);
    }









}
