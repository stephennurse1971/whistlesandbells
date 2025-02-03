<?php

namespace App\Controller;

use App\Entity\CmsPhoto;
use App\Entity\Dogs;
use App\Form\DogsType;
use App\Repository\CmsPhotoRepository;
use App\Repository\DogsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dogs')]
class DogsController extends AbstractController
{
    #[Route('/index', name: 'dogs_index', methods: ['GET'])]
    public function index(DogsRepository $dogsRepository): Response
    {
        $today = new \DateTime('now');
        return $this->render('dogs/index.html.twig', [
            'dogs' => $dogsRepository->findAll(),
            'today' => $today,
        ]);
    }

    #[Route('/new', name: 'dogs_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DogsRepository $dogsRepository): Response
    {
        $dog = new Dogs();
        $form = $this->createForm(DogsType::class, $dog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form->get('photo')->getData();
            if ($photo) {
                $safeFilename = $dog->getOwner()->getFullName().'-'.$dog->getName();
                $newFilename = $safeFilename . '.' . $photo->guessExtension();
                try {
                    $photo->move(
                        $this->getParameter('dog_photo_directory'),
                        $newFilename
                    );
                    $dog->setPhoto($newFilename);
                } catch (FileException $e) {
                    die('Import failed');
                }
            }
            $dogsRepository->add($dog, true);
            return $this->redirectToRoute('dogs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dogs/new.html.twig', [
            'dog' => $dog,
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'dogs_show', methods: ['GET'])]
    public function show(Dogs $dog): Response
    {
        return $this->render('dogs/show.html.twig', [
            'dog' => $dog,
        ]);
    }

    #[Route('/edit/{id}', name: 'dogs_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dogs $dog, DogsRepository $dogsRepository): Response
    {
        $form = $this->createForm(DogsType::class, $dog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dogsRepository->add($dog, true);
            $photo = $form->get('photo')->getData();
            if ($photo) {
                $safeFilename = $dog->getName().'-'.$dog->getOwner()->getFullName();
                $newFilename = $safeFilename . '.' . $photo->guessExtension();
                try {
                    $photo->move(
                        $this->getParameter('dog_photo_directory'),
                        $newFilename
                    );
                    $dog->setPhoto($newFilename);
                } catch (FileException $e) {
                    die('Import failed');
                }
            }
            $dogsRepository->add($dog, true);

            return $this->redirectToRoute('dogs_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('dogs/edit.html.twig', [
            'dog' => $dog,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'dogs_delete', methods: ['POST'])]
    public function delete(Request $request, Dogs $dogs, DogsRepository $dogsRepository, EntityManagerInterface $entityManager): Response
    {
        $file_name = $dogs->getPhoto();
        if ($file_name) {
            $file = $this->getParameter('dog_photo_directory') . $file_name;
            if (file_exists($file)) {
                unlink($file);
            }
            $dogs->setPhoto('');
            $entityManager->flush();
        }

        if ($this->isCsrfTokenValid('delete' . $dogs->getId(), $request->request->get('_token'))) {
            $dogsRepository->remove($dogs, true);
        }

        return $this->redirectToRoute('dogs_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/delete_dog_photo/{id}", name="delete_dog_photo", methods={"POST", "GET"})
     */
    public function deleteDogPhoto(int $id, Request $request, Dogs $dogs, EntityManagerInterface $entityManager)
    {
        $referer = $request->headers->get('referer');
        $file_name = $dogs->getPhoto();
        if ($file_name) {
            $file = $this->getParameter('dog_photo_directory') . $file_name;
            if (file_exists($file)) {
                unlink($file);
            }
            $dogs->setPhoto('');
            $entityManager->flush();
        }
        return $this->redirect($referer);
    }


    /**
     * @Route ("/view_dog_photo/{id}", name="dog_photo_view")
     */
    public function viewDogPhoto(int $id, DogsRepository $dogsRepository)
    {
        $cms_photo = $dogsRepository->find($id);
        return $this->render('dogs/image_view.html.twig', ['imagename' => $cms_photo]);
    }


}
