<?php

namespace App\Controller;

use App\Entity\CompanyDetails;
use App\Entity\WineList;
use App\Form\WineListType;
use App\Repository\WineListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cyrpuswines")
 */
class WineListController extends AbstractController
{
    /**
     * @Route("/index", name="wine_list_index", methods={"GET"})
     */
    public function index(WineListRepository $wineListRepository): Response
    {
        return $this->render('wine_list/index.html.twig', [
            'wine_lists' => $wineListRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="wine_list_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $wineList = new WineList();
        $form = $this->createForm(WineListType::class, $wineList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form->get('labelPicture')->getData();
            if ($photo) {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $wineList->getName() . $wineList->getYear() . '.' . $photo->guessExtension();
                $photo->move(
                    $this->getParameter('winelist_directory'),
                    $newFilename
                );
                $wineList->setLabelPicture($newFilename);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($wineList);
            $entityManager->flush();
            return $this->redirectToRoute('wine_list_index');

        }
        return $this->render('wine_list/new.html.twig', [
            'wine_list' => $wineList,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/show/{id}", name="wine_list_show", methods={"GET"})
     */
    public function show(WineList $wineList): Response
    {
        return $this->render('wine_list/show.html.twig', [
            'wine_list' => $wineList,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="wine_list_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, WineList $wineList): Response
    {
        $form = $this->createForm(WineListType::class, $wineList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form->get('labelPicture')->getData();
            if ($photo) {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $wineList->getName() . $wineList->getYear() . '.' . $photo->guessExtension();
                $photo->move(
                    $this->getParameter('winelist_directory'),
                    $newFilename
                );
                $wineList->setLabelPicture($newFilename);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('wine_list_index');
        }

        return $this->render('wine_list/edit.html.twig', [
            'wine_list' => $wineList,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/delete/{id}", name="wine_list_delete", methods={"POST"})
     */
    public function delete(Request $request, WineList $wineList): Response
    {
        if ($this->isCsrfTokenValid('delete' . $wineList->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($wineList);
            $entityManager->flush();
        }

        return $this->redirectToRoute('wine_list_index');
    }


    /**
     * @Route("/viewphoto/{id}", name="winelist_viewlabel")
     */
    public function viewUserPhoto(int $id, WineList $wineList, EntityManagerInterface $entityManager)
    {
        $imagename = $wineList->getLabelPicture();
        return $this->render('wine_list/image_view.html.twig', ['imagename' => $imagename]);
    }

    /**
     * @Route("/delete_label/{id}", name="winelist_delete_label", methods={"POST", "GET"})
     */
    public function deleteWineLabel(Request $request, int $id, WineList $wineList, EntityManagerInterface $entityManager)
    {
        $referer = $request->headers->get('referer');
        $filename = $wineList->getLabelPicture();
        $files = glob($this->getParameter('winelist_directory') . "/" . $filename);
        foreach ($files as $file) {
            unlink($file);
        }
        $entityManager->flush();
        $wineList->setLabelPicture(null);
        $entityManager->flush();




        return $this->redirect($referer);
    }

}
