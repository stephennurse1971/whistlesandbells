<?php

namespace App\Controller;

use App\Entity\CmsPhoto;
use App\Entity\StaticText;
use App\Form\CmsPhotoType;
use App\Repository\CmsPhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/admin/cmsphoto")
 */
class CmsPhotoController extends AbstractController
{
    /**
     * @Route("/", name="cms_photo_index", methods={"GET"})
     */
    public function index(CmsPhotoRepository $cmsPhotoRepository): Response
    {
        $site_pages = ['HomePage','AboutSN','Cyprus','Flying','Tennis','WebDesign','PrivateEquity','Risk & Capital Consulting'];
        return $this->render('cms_photo/index.html.twig', [
            'cms_photos' => $cmsPhotoRepository->findAll(),
            'site_pages'=>$site_pages
        ]);
    }

    /**
     * @Route("/new", name="cms_photo_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger): Response
    {
        $cmsPhoto = new CmsPhoto();
        $form = $this->createForm(CmsPhotoType::class, $cmsPhoto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form->get('photo')->getData();
            if ($photo) {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $cmsPhoto->getProduct()->getProduct();
                $newFilename = $safeFilename . '.' . $photo->guessExtension();
                try {
                    $photo->move(
                        $this->getParameter('website_pictures_directory'),
                        $newFilename
                    );
                    $cmsPhoto->setPhoto($newFilename);
                } catch (FileException $e) {
                    die('Import failed');
                }
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cmsPhoto);
            $entityManager->flush();

            return $this->redirectToRoute('cms_photo_index');
        }

        return $this->render('cms_photo/new.html.twig', [
            'cms_photo' => $cmsPhoto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cms_photo_show", methods={"GET"})
     */
    public function show(CmsPhoto $cmsPhoto): Response
    {
        return $this->render('cms_photo/show.html.twig', [
            'cms_photo' => $cmsPhoto,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cms_photo_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CmsPhoto $cmsPhoto,SluggerInterface $slugger): Response
    {
        $form = $this->createForm(CmsPhotoType::class, $cmsPhoto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form->get('photo')->getData();
            if ($photo) {

                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $cmsPhoto->getProduct()->getProduct();
                $newFilename = $safeFilename . '.' . $photo->guessExtension();


                try {
                    $photo->move(
                        $this->getParameter('website_pictures_directory'),
                        $newFilename
                    );
                    $cmsPhoto->setPhoto($newFilename);
                } catch (FileException $e) {
                    die('Import failed');
                }
            }

            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('cms_photo_index');
        }

        return $this->render('cms_photo/edit.html.twig', [
            'cms_photo' => $cmsPhoto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="cms_photo_delete", methods={"POST"})
     */
    public function delete(Request $request, CmsPhoto $cmsPhoto): Response
    {
        if ($this->isCsrfTokenValid('delete' . $cmsPhoto->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cmsPhoto);
            $entityManager->flush();
        }
        return $this->redirectToRoute('cms_photo_index');
    }

    /**
     * @Route("/delete_photo_file/{id}", name="cms_photo_file_delete", methods={"POST", "GET"})
     */
    public function deleteCMSPhotoFile(int $id,Request $request, CmsPhoto $cmsPhoto, EntityManagerInterface $entityManager)
    {
        $referer = $request->headers->get('referer');
        $cmsPhoto->setPhoto('');
        $entityManager->flush();
        return $this->redirect($referer);
    }


    /**
     * @Route("/{id}/viewphoto", name="cms_view_photo")
     */
    public function viewCMSPhotoFile(int $id, CmsPhoto $cmsPhoto, EntityManagerInterface $entityManager)
    {
        $imagename = $cmsPhoto->getPhoto();
        return $this->render('static_text/image_view.html.twig', ['imagename' => $imagename]);
    }

}
