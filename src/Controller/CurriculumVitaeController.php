<?php

namespace App\Controller;

use App\Entity\CurriculumVitae;
use App\Form\CurriculumVitaeType;
use App\Repository\CurriculumVitaeRepository;
use App\Repository\StaticTextRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cv")
 */
class CurriculumVitaeController extends AbstractController
{
    /**
     * @Route("/", name="curriculum_vitae_index", methods={"GET"})
     */
    public function index(CurriculumVitaeRepository $curriculumVitaeRepository): Response
    {
       $candidates_Id = $curriculumVitaeRepository->distinctCandidate();
//dump($candidates_Id);
//exit;
        return $this->render('curriculum_vitae/index.html.twig', [
            'curriculum_vitaes' => $curriculumVitaeRepository->findAll(),
            'candidates_Id'=> $candidates_Id
        ]);
    }



    /**
     * @Route("/individual/{name}", name="curriculum_vitae_individual", methods={"GET"})
     */
    public function indexIndividual(string $name, CurriculumVitaeRepository $curriculumVitaeRepository, UserRepository $userRepository, StaticTextRepository $staticTextRepository){
        $user = $userRepository->findOneBy([
            'fullName'=>$name
            ]);
        return $this->render('curriculum_vitae/indexByPerson.html.twig', [
            'curriculum_vitaes' => $curriculumVitaeRepository->findBy(['candidate'=>$user]),
            'candidate' => $name,
            'static_text'=> $staticTextRepository->findAll()
        ]);
    }


    /**
     * @Route("/new", name="curriculum_vitae_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $curriculumVitae = new CurriculumVitae();
        $form = $this->createForm(CurriculumVitaeType::class, $curriculumVitae);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($curriculumVitae);
            $entityManager->flush();

            return $this->redirectToRoute('curriculum_vitae_index');
        }

        return $this->render('curriculum_vitae/new.html.twig', [
            'curriculum_vitae' => $curriculumVitae,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="curriculum_vitae_show", methods={"GET"})
     */
    public function show(CurriculumVitae $curriculumVitae): Response
    {
        return $this->render('curriculum_vitae/show.html.twig', [
            'curriculum_vitae' => $curriculumVitae,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="curriculum_vitae_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CurriculumVitae $curriculumVitae): Response
    {
        $form = $this->createForm(CurriculumVitaeType::class, $curriculumVitae);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('curriculum_vitae_index');
        }

        return $this->render('curriculum_vitae/edit.html.twig', [
            'curriculum_vitae' => $curriculumVitae,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="curriculum_vitae_delete", methods={"POST"})
     */
    public function delete(Request $request, CurriculumVitae $curriculumVitae): Response
    {
        if ($this->isCsrfTokenValid('delete'.$curriculumVitae->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($curriculumVitae);
            $entityManager->flush();
        }

        return $this->redirectToRoute('curriculum_vitae_index');
    }
}
