<?php

namespace App\Controller;

use App\Entity\Dogs;
use App\Form\DogsType;
use App\Repository\DogsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dogs')]
class DogsController extends AbstractController
{
    #[Route('/', name: 'dogs_index', methods: ['GET'])]
    public function index(DogsRepository $dogsRepository): Response
    {
        return $this->render('dogs/index.html.twig', [
            'dogs' => $dogsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'dogs_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DogsRepository $dogsRepository): Response
    {
        $dog = new Dogs();
        $form = $this->createForm(DogsType::class, $dog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dogsRepository->add($dog, true);
            $photo = $form->get('photo')->getData();
            if ($photo) {
                $safeFilename = $dog->getName();
                $newFilename = $safeFilename . '.' . $photo->guessExtension();
                try {
                    $photo->move(
                        $this->getParameter('dogs_attachments_directory'),
                        $newFilename
                    );
                    $dog->setPhoto($newFilename);
                } catch (FileException $e) {
                    die('Import failed');
                }
            }
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
                $safeFilename = $dog->getName();
                $newFilename = $safeFilename . '.' . $photo->guessExtension();
                try {
                    $photo->move(
                        $this->getParameter('dogs_attachments_directory'),
                        $newFilename
                    );
                    $dog->setPhoto($newFilename);
                } catch (FileException $e) {
                    die('Import failed');
                }
            }
            return $this->redirectToRoute('dogs_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('dogs/edit.html.twig', [
            'dog' => $dog,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'dogs_delete', methods: ['POST'])]
    public function delete(Request $request, Dogs $dog, DogsRepository $dogsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $dog->getId(), $request->request->get('_token'))) {
            $dogsRepository->remove($dog, true);
        }

        return $this->redirectToRoute('dogs_index', [], Response::HTTP_SEE_OTHER);
    }
}
