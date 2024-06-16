<?php

namespace App\Controller;

use App\Form\FileUploadType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploadController extends AbstractController
{
    /**
     * @Route("/admin/fileupload", name="file_upload")
     */
    public function index(Request $request,SluggerInterface $slugger): Response
    {
        $form = $this->createForm(FileUploadType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $importFile = $form->get('file')->getData();
            if ($importFile) {
                $originalFilename = pathinfo($importFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $importFile->guessExtension();
                try {
                    $importFile->move(
                        $this->getParameter('files_upload_default_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    die('Import failed');
                }
                return $this->redirectToRoute('file_upload');
            }
        }

        return $this->render('file_upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
