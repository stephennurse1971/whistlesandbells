<?php

namespace App\Controller;

use App\Entity\CurriculumVitae;
use App\Entity\JpmIcHistory;
use App\Form\CurriculumVitaeType;
use App\Form\JpmIcHistoryType;
use App\Repository\CurriculumVitaeRepository;
use App\Repository\StaticTextRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/cv")
 */
class CurriculumVitaeController extends AbstractController
{
    /**
     * @Route("/", name="curriculum_vitae_index", methods={"GET"})
     */
    public function index(CurriculumVitaeRepository $curriculumVitaeRepository, UserRepository $userRepository): Response
    {
        $candidates_Id = $curriculumVitaeRepository->distinctCandidate();
        $candidates = [];
        foreach ($candidates_Id as $candidate) {

            $candidates[] = $userRepository->find($candidate[1]);
        }

        return $this->render('curriculum_vitae/index.html.twig', [
            'curriculum_vitaes' => $curriculumVitaeRepository->findAll(),
            //'candidates_Id'=> $candidates_Id,
            'candidates' => $candidates
        ]);
    }


    /**
     * @Route("/stephen_nurse", name="curriculum_vitae", methods={"GET"})
     */
    public function indexIndividual(CurriculumVitaeRepository $curriculumVitaeRepository, UserRepository $userRepository, StaticTextRepository $staticTextRepository)
    {


        $user = $userRepository->findOneBy([
            'fullName' => "Stephen Nurse"]);
        return $this->render('curriculum_vitae/cv.html.twig', [
            'curriculum_vitaes' => $curriculumVitaeRepository->findByCandidate($user),
            'candidate' => $user,
            'static_text' => $staticTextRepository->findAll()
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
        if ($this->isCsrfTokenValid('delete' . $curriculumVitae->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($curriculumVitae);
            $entityManager->flush();
        }

        return $this->redirectToRoute('curriculum_vitae_index');
    }


    /**
     * @Route("/update/cv", name="update_cv", methods={"GET","POST"})
     */
    public function uploadCV(Request $request): Response
    {
        if (isset($_FILES['file'])) {
            $newFilename = 'CV - Stephen Nurse.docx';
             $files = $this->getParameter('files_cv_directory') . "/" . $newFilename;
             if(file_exists($files)){
                 unlink($files);
             }
            $file_name = $_FILES['file']['name'];
            $file_tmp = $_FILES['file']['tmp_name'];
            $file_type = $_FILES['file']['type'];
            $file_ext = explode('.', $_FILES['file']['name']);
            move_uploaded_file($file_tmp, $this->getParameter('files_cv_directory') . "/" . $newFilename);
        }
        return $this->redirectToRoute('curriculum_vitae_index');
    }
}
