<?php

namespace App\Controller;

use App\Entity\Import;
use App\Form\ImportType;
use App\Repository\UserRepository;
use App\Services\ChaveyDownImportService;
use App\Services\UserImportGrapevineService;
use App\Services\UserImportOutlookService;
use App\Services\UserImportService;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Stmt\Continue_;
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
     * @Route("/importContacts/{source}", name="userImport")
     */
    public function userImport(Request $request, string $source, SluggerInterface $slugger, UserRepository $userRepository, UserImportOutlookService $userImportOutlookService, UserImportGrapevineService $userImportGrapevineService): Response
    {
        $anyConflicts = $userRepository->findBy([
            'entryConflict' => 'Conflict'
        ]);
        if (!$anyConflicts) {
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
                    if ($source == 'Outlook') {
                        $userImportOutlookService->importUser($newFilename);
                        return $this->redirectToRoute('user_index');
                    }
                    if ($source == 'Grapevine') {
                        $userImportGrapevineService->importUser($newFilename);
                        return $this->redirectToRoute('user_role_index', ['role' => 'ROLE_RECRUITER']);
                    }
                }
            }
            return $this->render('admin/import/index.html.twig', [
                'form' => $form->createView(),
                'heading' => $source
            ]);

        }

        return $this->redirectToRoute('user_index');
    }
}
