<?php

namespace App\Controller;

use App\Entity\TennisPlayers;
use App\Form\TennisPlayersType;
use App\Repository\TennisPlayersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tennis/players")
 */
class TennisPlayersController extends AbstractController
{
    /**
     * @Route("/", name="tennis_players_index", methods={"GET"})
     */
    public function index(TennisPlayersRepository $tennisPlayersRepository): Response
    {
        return $this->render('tennis_players/index.html.twig', [
            'tennis_players' => $tennisPlayersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tennis_players_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tennisPlayer = new TennisPlayers();
        $form = $this->createForm(TennisPlayersType::class, $tennisPlayer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tennisPlayer);
            $entityManager->flush();

            return $this->redirectToRoute('tennis_players_index');
        }

        return $this->render('tennis_players/new.html.twig', [
            'tennis_player' => $tennisPlayer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tennis_players_show", methods={"GET"})
     */
    public function show(TennisPlayers $tennisPlayer): Response
    {
        return $this->render('tennis_players/show.html.twig', [
            'tennis_player' => $tennisPlayer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tennis_players_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TennisPlayers $tennisPlayer): Response
    {
        $form = $this->createForm(TennisPlayersType::class, $tennisPlayer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tennis_players_index');
        }

        return $this->render('tennis_players/edit.html.twig', [
            'tennis_player' => $tennisPlayer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tennis_players_delete", methods={"POST"})
     */
    public function delete(Request $request, TennisPlayers $tennisPlayer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tennisPlayer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tennisPlayer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tennis_players_index');
    }
}
