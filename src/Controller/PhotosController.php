<?php

namespace App\Controller;

use App\Entity\Photos;
use App\Entity\User;
use App\Form\PhotosType;
use App\Repository\FileAttachmentsRepository;
use App\Repository\PhotoLocationsRepository;
use App\Repository\PhotosRepository;
use App\Repository\UserRepository;
use App\Services\ImageResize;
use App\Services\PhotoAuthorsByLocation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\Response\CurlResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Security;


/**
 * @Route("/photos")
 * @IsGranted("ROLE_GUEST")
 */
class PhotosController extends AbstractController
{
    /**
     * @Route("/", name="photos_index", methods={"GET"})
     * @IsGranted("ROLE_GUEST")
     */
    public function index(PhotosRepository $photosRepository, PhotoLocationsRepository $photoLocationsRepository): Response
    {
        $photos = $photosRepository->findAll();
        $photolocations_public = $photoLocationsRepository->findBy([
            'publicPrivate' => 'Public'
        ]);
        $photolocations_private = $photoLocationsRepository->findBy([
            'publicPrivate' => 'Private'
        ]);
        return $this->render('photos/index.html.twig', [
            'photos' => $photos,
            'locations_public' => $photolocations_public,
            'locations_private' => $photolocations_private
        ]);
    }

    /**
     * @Route("/location/{location}/{author}/{format}", name="show_photos_by_location")
     */
    public function showPhotosByLocation(Security $security, Request $request, string $author, string $format, string $location, PhotosRepository $photosRepository, PhotoLocationsRepository $locationsRepository, UserRepository $userRepository, PhotoLocationsRepository $photoLocationsRepository, PhotoAuthorsByLocation $authorsByLocation)
    {
        $locationID = $photoLocationsRepository->findOneBy([
            'location' => $location
        ]);
        $authors = $authorsByLocation->authorList($locationID);

        if ($author == "All") {
            $all_or_by_author = "All";
            $photos = $photosRepository->findBy([
                'location' => $locationsRepository->findOneBy([
                    'location' => $location
                ])
            ]);
        }
        if ($author != "All") {
            $all_or_by_author = "By author";
            $photos = $photosRepository->findBy([
                'location' => $locationsRepository->findOneBy([
                    'location' => $location
                ]),
                'uploadedBy' => $userRepository->findOneBy([
                    'fullName' => $author
                ])
            ]);
        }
        $favourite_photos = [];
        $unfavourite_photos = [];
        foreach ($photos as $photo) {
            if (in_array($security->getUser(), $photo->getFavourites()->toArray())) {
                $favourite_photos[] = $photo;
            } else {
                $unfavourite_photos[] = $photo;
            }
        }
        $photos = array_merge($favourite_photos, $unfavourite_photos);

        return $this->render('photos/showByLocation.html.twig', [
            'photos' => $photos,
            'location' => $locationsRepository->findOneBy(['location' => $location]),
            'photo_date' => $locationsRepository->findOneBy(['location' => $location])->getDate(),
            'format' => $format,
            'authors' => $authors,
            'all_or_by_author' => $all_or_by_author,
            'specified_author' => $author
        ]);
    }

    /**
     * @Route("/rotate/photo/{photoID}", name="rotate_photo")
     */
    public function rotatePhoto(Request $request, int $photoID, PhotosRepository $photosRepository, EntityManagerInterface $manager)
    {
        $referer = $request->server->get('HTTP_REFERER');
        $photo = $photosRepository->find($photoID);
        if ($photo->getRotate() == null or $photo->getRotate() == 0) {
            $photo->setRotate(1);
            $manager->flush();
        } else {
            $photo->setRotate(0);
            $manager->flush();
        }

        return $this->redirect($referer);
    }

    /**
     * @Route("/new/{location}", name="photos_new", methods={"GET","POST"})
     */
    public function new(string $location = null, Request $request, EntityManagerInterface $manager, PhotoLocationsRepository $locationsRepository, UserRepository $userRepository): Response
    {
        $logged_user = $this->getUser();
        $now = new \DateTime('now');
        $photo = new Photos();
        $form = $this->createForm(PhotosType::class, $photo, ['location' => $locationsRepository->findOneBy(['location' => $location]), 'mode' => 'new']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $photos = $form->get('photos')->getData();
            foreach ($photos as $single_photo) {
                $photo_single = new Photos();
                $originalFilename = pathinfo($single_photo->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '.' . $single_photo->guessExtension();
                if (!file_exists($this->getParameter('photos_upload_default_directory') . $newFilename)) {
                    $single_photo->move(
                        $this->getParameter('photos_upload_default_directory'),
                        $newFilename
                    );
                    $photo_single->setLocation($photo->getLocation());
                    $photo_single->setPhotoFile($newFilename);
                    $photo_single->setUploadedBy($logged_user);
                    $photo_single->setRotate(0);
                    $manager->persist($photo_single);
                    $manager->flush();
                }
            }
            return $this->redirectToRoute('photos_index');
        }

        return $this->render('photos/new.html.twig', [
            'photo' => $photo,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="photos_show", methods={"GET"})
     */
    public
    function show(Photos $photo): Response
    {
        return $this->render('photos/show.html.twig', [
            'photo' => $photo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="photos_edit", methods={"GET","POST"})
     */
    public
    function edit(Request $request, Photos $photo, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(PhotosType::class, $photo);
        $form->remove('photos');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($photo->getPerson() as $person) {
                $photo->addPerson($person);
            }

            $manager->flush();
            return $this->redirectToRoute('photos_index');
        }
        return $this->render('photos/edit.html.twig', [
            'photo' => $photo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/switchPublicPrivate", name="photos_public_private", methods={"GET","POST"})
     */
    public
    function switchPublicPrivate(Request $request, Photos $photo, EntityManagerInterface $manager): Response
    {
        $publicPrivate = $request->query->get('action');
        if ($publicPrivate == '1') {
            $photo->setPublic('0');
        } else {
            $photo->setPublic('1');
        }
        $this->getDoctrine()->getManager()->flush();
        $referer = $request->server->get('HTTP_REFERER');
        return $this->redirect($referer);
    }


    /**
     * @Route("/{id}", name="photos_delete", methods={"POST"})
     */
    public
    function delete(Request $request, Photos $photo): Response
    {
        $referer = $request->server->get('HTTP_REFERER');
        if ($this->isCsrfTokenValid('delete' . $photo->getId(), $request->request->get('_token'))) {
            $get_photo_file = $this->getParameter('photos_upload_default_directory') . $photo->getPhotoFile();
            unlink($get_photo_file);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($photo);
            $entityManager->flush();
        }
        return $this->redirect($referer);
    }


    /**
     * @Route("/deleteAll/photos", name="photos_delete_all",)
     */
    public
    function deleteAll(Request $request, PhotosRepository $photosRepository, EntityManagerInterface $entityManager): Response
    {
        $referer = $request->server->get('HTTP_REFERER');
        foreach ($photosRepository->findAll() as $photo) {
            $get_photo_file = $this->getParameter('photos_upload_default_directory') . $photo->getPhotoFile();
            unlink($get_photo_file);
            $entityManager->remove($photo);
        }
        $entityManager->flush();
        return $this->redirect($referer);
    }

    /**
     * @Route("/deleteAllByLocation/photos/{location}", name="photos_delete_all_by_location",)
     */
    public
    function deleteAllByLocation(Request $request, string $location, PhotosRepository $photosRepository, PhotoLocationsRepository $photoLocationsRepository, EntityManagerInterface $entityManager): Response
    {
        $referer = $request->server->get('HTTP_REFERER');
        foreach ($photosRepository->findBy([
                'location' => $photoLocationsRepository->findOneBy([
                    'location' => $location
                ])
            ]
        ) as $photo) {
            $get_photo_file = $this->getParameter('photos_upload_default_directory') . $photo->getPhotoFile();
            unlink($get_photo_file);
            $entityManager->remove($photo);
        }
        $entityManager->flush();
        return $this->redirect($referer);
    }


    /**
     * @Route("/delete/All/files/public/photos", name="photos_delete_all_files_in_public_photos",)
     */
    public
    function deleteAllFilesInPublicPhotos(Request $request): Response
    {
        $referer = $request->server->get('HTTP_REFERER');
        $files = glob($this->getParameter('photos_upload_default_directory') . "/*");
        foreach ($files as $file) {
            unlink($file);
        }
        return $this->redirect($referer);
    }

    /**
     * @Route("/{photo}/{user}/{favoured}/photo_favourite", name="photo_edit_favourite_status", methods={"GET","POST"})
     */
    public function editAddVenuePreference($photo, string $favoured, int $user, Request $request, PhotosRepository $photosRepository, UserRepository $userRepository, \Symfony\Component\Security\Core\Security $security, EntityManagerInterface $manager): Response
    {
        $referer = $request->headers->get('referer');
        $photo = $photosRepository->find($photo);
        $user = $userRepository->find($user);
        if ($favoured == 'favourite') {
            $photo->addFavourite($userRepository->find($user));
        } else {
            $photo->removeFavourite($userRepository->find($user));
        }
        $manager->flush();
        return $this->redirect($referer);
    }


    /**
     * @Route ("/view/photo/{photoId}", name="view_photo")
     */
    public function viewPhoto(Request $request, $photoId, PhotosRepository $photosRepository)
    {
        $photo = $photosRepository->find($photoId);
        return $this->render('photos/view_photo.html.twig', ['photo' => $photo]);
    }

    /**
     * @Route("/{photoId}/email_photo", name="email_photo")
     */
    public function emailPhoto(Request $request, Security $security, string $photoId, UserRepository $userRepository, PhotosRepository $photosRepository, MailerInterface $mailer)
    {
        $referer = $request->headers->get('referer');
        $photo = $photosRepository->find($photoId);
        $senderEmail = 'nurse_stephen@hotmail.com';
        $recipient = $userRepository->findOneBy([
            'email' => $security->getUser()->getEmail()]);
        $subject = 'Photo: ' . $photo->getLocation()->getLocation();
        $html = $this->renderView('emails/photo_email.html.twig', [
            'description' => $photo->getLocation()->getLocation(),
        ]);
        $photo_file_name = $photo->getPhotoFile();
        $attachments = [];
        $attachments[] = $photo_file_name;
        $email = (new Email())
            ->to($recipient->getEmail())
            ->subject($subject)
            ->from($senderEmail)
            ->html($html);
        if ($attachments) {
            foreach ($attachments as $attachment) {
                $attachment_path = $this->getParameter('photos_upload_default_directory') . $attachment;
                $email->attachFromPath($attachment_path);
            }
        }
        $mailer->send($email);
        return $this->redirect($referer);
    }


    /**
     * @Route("/{photoId}/download/photo", name="download_photo")
     */
    public function downloadPhoto(Request $request, string $photoId, PhotosRepository $photosRepository)
    {
        $referer = $request->headers->get('referer');
        $photo = $photosRepository->find($photoId);
        $file = $this->getParameter('photos_upload_default_directory') . $photo->getPhotoFile();
        $response = new BinaryFileResponse($file);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);
        return $response;
    }

    /**
     * @Route("/download/all_photos/{author}/{location}", name="download_all_photo_all_by_author_and_location")
     */
    public function downloadAllPhotoByAuthorAndLocation(Request $request, string $author, string $location, PhotosRepository $photosRepository, UserRepository $userRepository, PhotoLocationsRepository $photoLocationsRepository)
    {
        $referer = $request->headers->get('referer');
        $author = $userRepository->findOneBy([
            'fullName' => $author
            ]);
        $photos = [];
        $photos = $photosRepository->findBy([
            'uploadedBy' => $author,
            'location' => $photoLocationsRepository->findOneBy([
                'location' => $location
            ]),
        ]);


        $zipname = 'file.zip';
        $zip = new \ZipArchive();
        $zip->open($zipname, \ZipArchive::CREATE);
        foreach ($photos as $photo) {
            $file = $this->getParameter('photos_upload_default_directory') . $photo->getPhotoFile();
            $zip->addFromString(basename($file),  file_get_contents($file));
        }
        $zip->close();
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename='.$zipname);
        header('Content-Length: ' . filesize($zipname));
        readfile($zipname);

    }
}
