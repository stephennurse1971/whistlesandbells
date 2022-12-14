<?php

namespace App\Controller;

use App\Entity\FileAttachments;
use App\Entity\TouristAttraction;
use App\Form\TouristAttractionType;
use App\Repository\LocationPinRepository;
use App\Repository\TouristAttractionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use JeroenDesloovere\VCard\VCard;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tourist/attraction")
 */
class TouristAttractionController extends AbstractController
{
    /**
     * @Route("/", name="tourist_attraction_index", methods={"GET"})
     */
    public function index(TouristAttractionRepository $touristAttractionRepository): Response
    {
        $types = ['Beach','Historical interest','Hotel','Restaurant','Cafe','Sport venue','Cycling Stop','Shop'];
        return $this->render('tourist_attraction/index.html.twig', [
            'tourist_attractions' => $touristAttractionRepository->findAll(),
            'types' => $types
        ]);
    }

    /**
     * @Route("/new", name="tourist_attraction_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $touristAttraction = new TouristAttraction();
        $form = $this->createForm(TouristAttractionType::class, $touristAttraction);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form['photo']->getData();
            if ($photo) {
                $files_name = [];
                $photo_directory = $this->getParameter('tourist_attraction_photos_directory');

                    $fileName = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                    $file_extension = $photo->guessExtension();
                    $newFileName = $fileName . "." . $file_extension;
                    $photo->move($photo_directory, $newFileName);
                    $touristAttraction->setPhoto($newFileName);
            }
            $firstName = $touristAttraction->getFirstName();
            $lastName = $touristAttraction->getLastName();
            $touristAttraction->setFullName($firstName . ' ' . $lastName);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($touristAttraction);
            $entityManager->flush();
            return $this->redirectToRoute('tourist_attraction_index');
        }

        return $this->render('tourist_attraction/new.html.twig', [
            'tourist_attraction' => $touristAttraction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tourist_attraction_show", methods={"GET"})
     */
    public function show(TouristAttraction $touristAttraction): Response
    {
        return $this->render('tourist_attraction/show.html.twig', [
            'tourist_attraction' => $touristAttraction,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tourist_attraction_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TouristAttraction $touristAttraction): Response
    {
        $form = $this->createForm(TouristAttractionType::class, $touristAttraction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form['photo']->getData();
            if ($photo) {
                $files_name = [];
                $photo_directory = $this->getParameter('tourist_attraction_photos_directory');

                $fileName = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                $file_extension = $photo->guessExtension();
                $newFileName = $fileName . "." . $file_extension;
                $photo->move($photo_directory, $newFileName);
                $touristAttraction->setPhoto($newFileName);
            }


            $firstName = $touristAttraction->getFirstName();
            $lastName = $touristAttraction->getLastName();
            $touristAttraction->setFullName($firstName . ' ' . $lastName);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tourist_attraction_index');
        }

        return $this->render('tourist_attraction/edit.html.twig', [
            'tourist_attraction' => $touristAttraction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tourist_attraction_delete", methods={"POST"})
     */
    public function delete(Request $request, TouristAttraction $touristAttraction): Response
    {
        if ($this->isCsrfTokenValid('delete'.$touristAttraction->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($touristAttraction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tourist_attraction_index');
    }


    /**
     * @Route("/create/VcarduserTA/{touristattractionid}", name="create_vcard_user_ta")
     */
    public function createVcardUserTA(int $touristattractionid, TouristAttractionRepository $touristAttractionRepository)
    {
        $touristattraction = $touristAttractionRepository->find($touristattractionid);
        $vcard = new VCard();
        $userFirstName = $touristattraction->getFirstName();
        $userLastName = $touristattraction->getLastName();
        $vcard->addName($userLastName, $userFirstName);
        $vcard->addEmail($touristattraction->getEmail())
            ->addEmail($touristattraction->getEmail2())
            ->addCompany($touristattraction->getCompany())
            ->addAddress('London', 'A123', 'street', 'worktown', null, 'workpostcode',
                'Belgium','Work')
           // ->addAddress($touristattraction->getBusinessStreet(), 'street')
          //  ->addAddress($touristattraction->getBusinessCity(), 'city')
         //   ->addAddress($touristattraction->getBusinessPostCode(), 'zip')
         //   ->addAddress($touristattraction->getCountry()->getCountry())
            ->addPhoneNumber($touristattraction->getBusinessPhone(), 'work')
            ->addPhoneNumber($touristattraction->getMobile(), 'home')
            ->addURL($touristattraction->getWebPage())
           ->addNote($touristattraction->getNotes());
        $vcard->download();
        return new Response(null);
    }

    /**
     * @Route("/gps/GoogleMap/show/{pin}", name="show_location_google_maps", methods={"GET"})
     */
    public function showMap(String $pin,TouristAttractionRepository $touristAttractionRepository): Response
    {
        $get_latitude_longitude = explode(',',$pin);
        return $this->render('tourist_attraction/GpsGoogleMaps.html.twig', [
            'latitude'=>$get_latitude_longitude[0],
            'longitude'=>$get_latitude_longitude[1]
        ]);
    }
    /**
     * @Route("/{id}/delete/attachment", name="tourist_attraction_delete_photo")
     */
    public function deletePhoto(Request $request, TouristAttraction $touristAttraction, EntityManagerInterface $entityManager)
    {
        $referer = $request->headers->get('referer');
        $touristAttraction->setPhoto(null);
        $entityManager->flush();
        return $this->redirect($referer);
    }
}
