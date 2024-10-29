<?php

namespace App\Controller;

use App\Entity\BusinessContacts;
use App\Form\BusinessContactsType;
use App\Form\ImportType;
use App\Repository\BusinessContactsRepository;
use App\Repository\BusinessTypesRepository;
use App\Repository\UserRepository;
use App\Services\BusinessContactsImportService;
use App\Services\UserImportService;
use Doctrine\ORM\EntityManagerInterface;
use JeroenDesloovere\VCard\VCard;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/businesscontacts")
 */
class BusinessContactsController extends AbstractController
{
    /**
     * @Route("/", name="business_contacts_index", methods={"GET"})
     */
    public function index(BusinessContactsRepository $businessContactsRepository, BusinessTypesRepository $businessTypesRepository): Response
    {
        $business_contacts = $businessContactsRepository->findBy([
            'status' => 'Approved'
        ]);

        if ($this->isGranted('ROLE_ADMIN')) {
            $business_contacts = $businessContactsRepository->findAll();
        }
        $business_types = [];

        foreach ($businessTypesRepository->findAll() as $businessTypes) {
            $business_types[] = $businessTypes->getBusinessType();
        }
        $business_types = array_unique($business_types);
        return $this->render('business_contacts/index.html.twig', [
            'business_contacts' => $business_contacts,
            'business_types' => $business_types
        ]);
    }

    /**
     * @Route("/new", name="business_contacts_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BusinessContactsRepository $businessContactsRepository, EntityManagerInterface $entityManager): Response
    {
        $businessContact = new BusinessContacts();
        $form = $this->createForm(BusinessContactsType::class, $businessContact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form['photo']->getData();
            if ($photo) {
                $files_name = [];
                $photo_directory = $this->getParameter('business_contacts_photos_directory');
                $fileName = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                $file_extension = $photo->guessExtension();
                $newFileName = $fileName . "." . $file_extension;
                $photo->move($photo_directory, $newFileName);
                $businessContact->setPhoto($newFileName);
            }
            $businessContactsRepository->add($businessContact, true);
            $firstName = $businessContact->getFirstName();
            $lastName = $businessContact->getLastName();
            $entityManager->persist($businessContact);
            $entityManager->flush();
            return $this->redirectToRoute('business_contacts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('business_contacts/new.html.twig', [
            'business_contact' => $businessContact,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/suggestion", name="business_contacts_suggestion", methods={"GET", "POST"})
     */
    public function suggestion(Request $request, BusinessContactsRepository $businessContactsRepository): Response
    {
        $businessContact = new BusinessContacts();
        $form = $this->createForm(BusinessContactsType::class, $businessContact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $businessContactsRepository->add($businessContact, true);
            $businessContact->setStatus('Pending');

            return $this->redirectToRoute('business_contacts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('business_contacts/new.html.twig', [
            'business_contact' => $businessContact,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="business_contacts_show", methods={"GET"})
     */
    public function show(BusinessContacts $businessContact): Response
    {
        return $this->render('business_contacts/show.html.twig', [
            'business_contact' => $businessContact,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="business_contacts_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, BusinessContacts $businessContact, BusinessContactsRepository $businessContactsRepository): Response
    {
        $form = $this->createForm(BusinessContactsType::class, $businessContact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $businessContactsRepository->add($businessContact, true);

            return $this->redirectToRoute('business_contacts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('business_contacts/edit.html.twig', [
            'business_contact' => $businessContact,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="business_contacts_delete", methods={"POST"})
     */
    public function delete(Request $request, BusinessContacts $businessContact, BusinessContactsRepository $businessContactsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $businessContact->getId(), $request->request->get('_token'))) {
            $businessContactsRepository->remove($businessContact, true);
        }

        return $this->redirectToRoute('business_contacts_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route ("/export/business_contacts", name="business_contacts_export" )
     */
    public function businessContactsExport(BusinessContactsRepository $businessContactsRepository)
    {
        $data = [];
        $exported_date = new \DateTime('now');
        $exported_date_formatted = $exported_date->format('d-M-Y');
        $exported_date_formatted_for_file = $exported_date->format('d-m-Y');
        $fileName = 'business_contacts_export'.$exported_date_formatted_for_file.'csv';

        $count = 0;
        $business_contact_list = $businessContactsRepository->findAll();
        foreach ($business_contact_list as $business_contact) {
            $concatenatedNotes = "Exported on: " . $exported_date_formatted;
            $data[] = [
                $business_contact->getPhoto(),
                $business_contact->getStatus(),
                $business_contact->getBusinessOrPerson(),
                $business_contact->getBusinessType(),
                $business_contact->getCompany(),
                $business_contact->getFirstName(),
                $business_contact->getLastName(),
                $business_contact->getWebsite(),
                $business_contact->getEmail(),
                $business_contact->getLandline(),
                $business_contact->getMobile(),
                $business_contact->getAddressStreet(),
                $business_contact->getAddressCity(),
                $business_contact->getAddressPostCode(),
                $business_contact->getAddressCountry(),
                $business_contact->getLocationLongitude(),
                $business_contact->getLocationLatitude(),

                $business_contact->getPublicPrivate(),
                $concatenatedNotes,
                $business_contact->getId()
            ];
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Business Contacts');
        $sheet->getCell('A1')->setValue('Photo');
        $sheet->getCell('B1')->setValue('Status');
        $sheet->getCell('C1')->setValue('Business Or Person');
        $sheet->getCell('D1')->setValue('Business Type');
        $sheet->getCell('E1')->setValue('Company Name');
        $sheet->getCell('F1')->setValue('First Name');
        $sheet->getCell('G1')->setValue('Last Name');
        $sheet->getCell('H1')->setValue('Website');
        $sheet->getCell('I1')->setValue('Email');
        $sheet->getCell('J1')->setValue('Mobile1');
        $sheet->getCell('K1')->setValue('Landline');
        $sheet->getCell('L1')->setValue('Company');
        $sheet->getCell('M1')->setValue('Address Street');
        $sheet->getCell('N1')->setValue('Address City');
        $sheet->getCell('O1')->setValue('Address Post Code');
        $sheet->getCell('P1')->setValue('Address Country');
        $sheet->getCell('Q1')->setValue('Location Longitude');
        $sheet->getCell('R1')->setValue('Location Latitude');
        $sheet->getCell('S1')->setValue('Public or Private');
        $sheet->getCell('T1')->setValue('Business or Person');
        $sheet->getCell('U1')->setValue('Notes');
        $sheet->getCell('V1')->setValue('Id');

        $sheet->fromArray($data, null, 'A2', true);
        $total_rows = $sheet->getHighestRow();
        for ($i = 2; $i <= $total_rows; $i++) {
            $cell = "L" . $i;
            $sheet->getCell($cell)->getHyperlink()->setUrl("https://google.com");
        }
        $writer = new Csv($spreadsheet);
        $response = new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        });
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', sprintf('attachment;filename="%s"', $fileName));
        $response->headers->set('Cache-Control', 'max-age=0');
        return $response;
    }


    /**
     * @Route ("/import/business_contacts", name="business_contacts_import" )
     */
    public function businessContactsImport(Request $request, SluggerInterface $slugger, BusinessContactsRepository $businessContactsRepository, BusinessContactsImportService $businessContactsImportService): Response
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
                        $this->getParameter('business_contact_attachments_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    die('Import failed');
                }
                $businessContactsImportService->importBusinessContacts($newFilename);
                return $this->redirectToRoute('business_contacts_index');
            }
        }
        return $this->render('business_contacts/import.html.twig', [
            'form' => $form->createView(),
            'heading'=>'Business Contacts Import',
        ]);
    }


    /**
     * @Route("/create/Vcard/{id}", name="create_vcard")
     */
    public function createVcard(int $id, BusinessContactsRepository $businessContactsRepository)
    {
        $business_contact = $businessContactsRepository->find($id);
        $vcard = new VCard();
        $firstName = $business_contact->getFirstName();
        $lastName = $business_contact->getLastName();
        $company = $business_contact->getCompany();
        $website = $business_contact->getWebsite();
        $address = $business_contact->getAddressStreet();
        $addressCity = $business_contact->getAddressCity();
        $addressPostalCode = $business_contact->getAddressPostcode();
        $addressCountry = $business_contact->getAddressCountry();
        $notes = "GPS location: " . $business_contact->getLocationLongitude();
        $vcard->addName($lastName, $firstName);
        $vcard->addEmail($business_contact->getEmail())
            ->addPhoneNumber($business_contact->getLandline(), 'work')
            ->addCompany($company)
            ->addURL($website)
            ->addNote($notes)
            ->addAddress($name = '', $extended = '', $street = $address, $city = $addressCity, $region = '', $zip = $addressPostalCode, $country = $addressCountry, $type = 'WORK;POSTAL');
        $vcard->download();
        return new Response(null);
    }

    /**
     * @Route("/gps/GoogleMap/show/{id}", name="show_location_google_maps", methods={"GET"})
     */
    public function showMap(int $id, BusinessContactsRepository $businessContactsRepository): Response
    {
        $business_contact = $businessContactsRepository->find($id);
        $longitude = $business_contact->getLocationLongitude();
        $latitude = $business_contact->getLocationLatitude();
        return $this->render('business_contacts/gpsGoogleMaps.html.twig', [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'business' => $business_contact->getCompany()
        ]);
    }

    /**
     * @Route("/update/user/location", name="update_user_location", methods={"POST"})
     */
    public function updateLocation(BusinessContactsRepository $businessContactsRepository, EntityManagerInterface $manager): Response
    {
        $id = $_POST['id'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $gps = $latitude . ',' . $longitude;
        $business_contact = $businessContactsRepository->find($id);
        $business_contact->setGpsLocation($gps);
        $manager->flush();
        return new Response(null);
    }

    /**
     * @Route("/gps_location_clear/{id}", name="tourist_attraction_clear_gps_location")
     */
    public
    function clearGPSLocation(Request $request, TouristAttraction $touristAttraction, EntityManagerInterface $entityManager)
    {
        $referer = $request->headers->get('referer');
        $touristAttraction->setGpsLocation(null);
        $entityManager->flush();
        return $this->redirect($referer);
    }

    /**
     * @Route("/importContacts", name="importContacts")
     */
    public
    function userImportContacts(Request $request, SluggerInterface $slugger, BusinessContactsImportService $touristAttractionImportOutlookService): Response
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
                        $this->getParameter('user_attachments_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    die('Import failed');
                }
                $touristAttractionImportOutlookService->importTouristAttraction($newFilename);
                return $this->redirectToRoute('tourist_attraction_index');
            }
        }
        return $this->render('admin/import/index.html.twig', [
            'form' => $form->createView(),
            'heading' => 'Cyprus Tourist Attractions'
        ]);
    }

}
