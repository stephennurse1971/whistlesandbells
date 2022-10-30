<?php

namespace App\Controller;

use App\Entity\Import;
use App\Form\ImportType;
use App\Services\ChaveyDownImportService;
use App\Services\UserImportGrapevineService;
use App\Services\UserImportOutlookService;
use App\Services\UserImportService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


/**
 * @Route("/admin")
 */
class ImportController extends AbstractController
{
    /**
     * @Route("/import", name="chaveydownimport")
     */
    public function chaveyDownImport(Request $request, SluggerInterface $slugger, ChaveyDownImportService $chaveyDownImportService): Response
    {
        $form = $this->createForm(ImportType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $importFile = $form->get('File')->getData();
            if ($importFile) {
                $originalFilename = pathinfo($importFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $importFile->guessExtension();
                try {
                    $importFile->move(
                        $this->getParameter(' chavey_down_attachments_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    die('Import failed');
                }
                $chaveyDownImportService->importCD($newFilename);
                return $this->redirectToRoute('chavey_down_index');
            }
        }

        return $this->render('admin/import/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/importContacts/{source}", name="userImport")
     */
    public function userImport(Request $request, string $source, SluggerInterface $slugger, UserImportOutlookService $userImportOutlookService, UserImportGrapevineService $userImportGrapevineService): Response
    {
        $form = $this->createForm(ImportType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $importFile = $form->get('File')->getData();
            if ($importFile) {
                $originalFilename = pathinfo($importFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . 'csv';
                try {
                    $importFile->move(
                        $this->getParameter('user_attachments_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    die('Import failed');
                }
                if($source == 'Outlook'){
                    $userImportOutlookService->importUser($newFilename);
                    return $this->redirectToRoute('user_index');
                }
              if($source == 'Grapevine'){
                  $userImportGrapevineService->importUser($newFilename);
                  return $this->redirectToRoute('user_role_index',['role'=>'ROLE_RECRUITER']);
              }


            }
        }
        return $this->render('admin/import/index.html.twig', [
            'form' => $form->createView(),
            'heading' => $source
        ]);
    }
}
