<?php

namespace App\Controller;

use App\Entity\Photos;
use App\Form\PhotosType;
use App\Repository\PhotoLocationsRepository;
use App\Repository\PhotosRepository;
use App\Services\ImageResize;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/photos")
 */
class PhotosController extends AbstractController
{
    /**
     * @Route("/", name="photos_index", methods={"GET"})
     */
    public function index(PhotosRepository $photosRepository, PhotoLocationsRepository $photoLocationsRepository): Response
    {
        $photos = $photosRepository->findAll();
        $photolocations = $photoLocationsRepository->findAll();
        return $this->render('photos/index.html.twig', [
            'photos' => $photos,
            'locations' => $photolocations
        ]);
    }

    /**
     * @Route("/location-{locationName}", name="show_photos_by_location")
     */
    public function showPhotosByLocation(string $locationName, PhotosRepository $photosRepository, PhotoLocationsRepository $locationsRepository)
    {
        $photos = $photosRepository->findBy([
            'location' => $locationsRepository->findOneBy([
                'location' => $locationName
            ])
        ]);
        return $this->render('photos/showByLocation.html.twig', [
            'photos' => $photos,
            'location' => $locationsRepository->findOneBy(['location' => $locationName]),
            'photo_date' => $locationsRepository->findOneBy(['location' => $locationName])->getDate()
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
    public function new(string $location = null, Request $request, EntityManagerInterface $manager, PhotoLocationsRepository $locationsRepository): Response
    {
        phpinfo();
        $photo = new Photos();
        $form = $this->createForm(PhotosType::class, $photo, ['location' => $locationsRepository->findOneBy(['location' => $location])]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $photos = $form->get('photos')->getData();
            foreach ($photos as $single_photo) {
                $photo_single = new Photos();
                $originalFilename = pathinfo($single_photo->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '.' . $single_photo->guessExtension();
                $single_photo->move(
                    $this->getParameter('photos_upload_default_directory'),
                    $newFilename
                );
                $photo_single->setLocation($photo->getLocation());
                $photo_single->setPhotoFile($newFilename);
                $photo_single->setRotate(0);
                $manager->persist($photo_single);
                $manager->flush();
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
            $entityManager->remove($photo);

        }
        $entityManager->flush();
        return $this->redirect($referer);
    }
}
