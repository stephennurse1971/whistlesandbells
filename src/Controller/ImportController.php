<?php

namespace App\Controller;

use App\Entity\Import;
use App\Form\ImportType;
use App\Services\UserImportService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ImportController extends AbstractController
{
    /**
     * @Route("/admin/import", name="admin_import")
     */
    public function index(Request $request, EntityManagerInterface $manager,SluggerInterface $slugger, UserImportService $userImportService): Response
    {
        $form = $this->createForm(ImportType::class);
        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            $importFile = $form->get('File')->getData();
//            if ($importFile) {
//                $originalFilename = pathinfo($importFile->getClientOriginalName(), PATHINFO_FILENAME);
//                $safeFilename = $slugger->slug($originalFilename);
//                $newFilename = $safeFilename .'.'. $importFile->guessExtension();
////                if ($import->getImportType() == 'users') {
//                    try {
//                        $importFile->move(
//                            $this->getParameter('import_user_directory'),
//                            $newFilename
//                        );
//                    } catch (FileException $e) {
//                        die('Import failed');
//                    }
//                    $userImportService->import($newFilename);
//                }
//            return new response(null);
//          //  return $this->redirectToRoute('user_index');
//            }
//        }


        return $this->render('admin/import/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}
