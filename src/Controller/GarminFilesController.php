<?php

namespace App\Controller;

use App\Entity\GarminFiles;
use App\Entity\Introduction;
use App\Entity\RecruiterEmails;
use App\Entity\StaticText;
use App\Form\GarminFilesType;
use App\Form\RecruiterEmailsType;
use App\Repository\GarminFilesRepository;
use App\Repository\IntroductionRepository;
use App\Repository\StaticTextRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/garminfiles")
 */
class GarminFilesController extends AbstractController
{
    /**
     * @Route("/", name="garmin_files_index", methods={"GET"})
     */
    public function index(GarminFilesRepository $garminFilesRepository): Response
    {
        return $this->render('garmin_files/index.html.twig', [
            'garmin_files' => $garminFilesRepository->findAll(),
        ]);
    }


    /**
     * @Route("/new", name="garmin_files_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger): Response
    {
        $garminFile = new GarminFiles();
        $form = $this->createForm(GarminFilesType::class, $garminFile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attachment = $form->get('gpxFile')->getData();
            if ($attachment) {
                $originalFilename = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.gpx';
                try {
                    $attachment->move(
                        $this->getParameter('garmin_attachments_directory'),
                        $newFilename
                    );
                    $garminFile->setGpxFile($newFilename);
                } catch (FileException $e) {
                    die('Import failed');
                }
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($garminFile);
            $entityManager->flush();
            return $this->redirectToRoute('garmin_files_index');
        }
        return $this->render('garmin_files/new.html.twig', [
            'garmin_file' => $garminFile,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="garmin_files_show", methods={"GET"})
     */
    public function show(GarminFiles $garminFile): Response
    {
        return $this->render('garmin_files/show.html.twig', [
            'garmin_file' => $garminFile,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="garmin_files_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, GarminFiles $garminFile, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(GarminFilesType::class, $garminFile);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $attachment = $form->get('gpxFile')->getData();
            if ($attachment) {
                $originalFilename = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.gpx' ;
                try {
                    $attachment->move(
                        $this->getParameter('garmin_attachments_directory'),
                        $newFilename
                    );
                    $garminFile->setGpxFile($newFilename);
                } catch (FileException $e) {
                    die('Import failed');
                }
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($garminFile);
            $entityManager->flush();
            return $this->redirectToRoute('garmin_files_index');
        }

        return $this->render('garmin_files/edit.html.twig', [
            'garmin_file' => $garminFile,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="garmin_files_delete", methods={"POST"})
     */
    public function delete(Request $request, GarminFiles $garminFile): Response
    {
        if ($this->isCsrfTokenValid('delete' . $garminFile->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($garminFile);
            $entityManager->flush();
        }
        return $this->redirectToRoute('garmin_files_index');
    }


    /**
     * @Route("/{id}/delete/attachment", name="garmin_files_delete_attachment")
     */
    public function deleteAttachment(Request $request, GarminFiles $garminFiles, EntityManagerInterface $entityManager)
    {
        $referer = $request->headers->get('referer');
        $garminFiles->setGpxFile('');
        $entityManager->flush();
        return $this->redirect($referer);
    }


    /**
     * @Route("/{garminid}/{recipientid}/email_gpxfile", name="garmin_file_email")
     */
    public function emailGPXFile(Security $security,int $garminid, int $recipientid, Request $request,
                                 StaticTextRepository $staticTextRepository, UserRepository $userRepository, GarminFilesRepository $garminFilesRepository, MailerInterface $mailer)
    {
        $garminFile = $garminFilesRepository->find($garminid);
        $senderEmail = $security->getUser()->getEmail();
        $recipient = $userRepository->find($recipientid);
        $subject = 'GPX file';
        $html = $this->renderView('emails/gpxfile_email.html.twig', [
            'description' => $garminFile->getDescription(),
            'starting_point' => $garminFile->getStartingPoint(),
            'end_point' => $garminFile->getEndPoint(),
            'kilometres' => $garminFile->getKilometres(),
            'climb' => $garminFile->getClimb(),
            'country' => $garminFile->getCountry()->getCountry(),
        ]);

        $gpx_attachment = $garminFile->getGpxFile();
        $email = (new Email())
            ->to($recipient-> getEmail())
            ->subject($subject)
            ->from($senderEmail)
            ->html($html);
        if ($gpx_attachment) {
            $attachment_path = $this->getParameter('garmin_attachments_directory') . "/" . $gpx_attachment;
            $email->attachFromPath($attachment_path);
        }

        $mailer->send($email);
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }


}
