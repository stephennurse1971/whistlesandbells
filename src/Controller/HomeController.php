<?php

namespace App\Controller;

use App\Repository\CmsCopyRepository;
use App\Repository\CmsPhotoRepository;
use App\Repository\StaticTextRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(CmsCopyRepository $cmsCopyRepository, CmsPhotoRepository $cmsPhotoRepository): Response
    {
        return $this->render('user-templates/home.html.twig', [
            'Photo1' => $cmsPhotoRepository->findOneBy([
                'name' => 'HomePage1'
            ]),
            'Photo2' => $cmsPhotoRepository->findOneBy([
                'name' => 'HomePage2'
            ]),
            'Photo3' => $cmsPhotoRepository->findOneBy([
                'name' => 'HomePage2'
            ]),


            'Text1' => $cmsPhotoRepository->findOneBy([
                'name' => 'HomePage1'
            ]),
            'Text2' => $cmsPhotoRepository->findOneBy([
                'name' => 'HomePage2'
            ]),
            'Text3' => $cmsPhotoRepository->findOneBy([
                'name' => 'HomePage3'
            ]),

            'Text1FR' => $cmsPhotoRepository->findOneBy([
                'name' => 'HomePageFR1'
            ]),
            'Text2FR' => $cmsPhotoRepository->findOneBy([
                'name' => 'HomePageFR2'
            ]),
            'Text3FR' => $cmsPhotoRepository->findOneBy([
                'name' => 'HomePageFR3'
            ]),

            'Text1DE' => $cmsPhotoRepository->findOneBy([
                'name' => 'HomePageDE1'
            ]),
            'Text2DE' => $cmsPhotoRepository->findOneBy([
                'name' => 'HomePageDE2'
            ]),
            'Text3DE' => $cmsPhotoRepository->findOneBy([
                'name' => 'HomePageDE3'
            ]),

            'Hyperlink' => $cmsPhotoRepository->findOneBy([
                'name' => 'HomePageHyperlink'
            ]),


            'SpecialisingPhoto1' => $cmsPhotoRepository->findOneBy([
                'name' => 'Specialising1'
            ]),
            'SpecialisingPhoto2' => $cmsPhotoRepository->findOneBy([
                'name' => 'Specialising2'
            ]),
            'SpecialisingPhoto3' => $cmsPhotoRepository->findOneBy([
                'name' => 'Specialising3'
            ]),
            'WhyMePhoto' => $cmsPhotoRepository->findOneBy([
                'name' => 'WhyMe'
            ]),


        ]);
    }

    /**
     * @Route("/aboutSN", name="aboutSN", methods={"GET"})
     */
    public function aboutSN(CmsCopyRepository $cmsCopyRepository, CmsPhotoRepository $cmsPhotoRepository): Response
    {
        return $this->render('home/aboutSN.html.twig', [
            'photos' => $cmsPhotoRepository->findAll(),

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
     * @Route("/PrivateEquity", name="private_equity", methods={"GET"})
     */
    public function privateEquity(CmsCopyRepository $cmsCopyRepository, CmsPhotoRepository $cmsPhotoRepository): Response
    {
        return $this->render('home/privateEquity.twig', [
            'photos' => $cmsPhotoRepository->findAll(),

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
     * @Route("/webdesign", name="webdesign", methods={"GET"})
     */
    public function webDesign(CmsCopyRepository $cmsCopyRepository, CmsPhotoRepository $cmsPhotoRepository): Response
    {
        return $this->render('home/webDesign.twig', [
            'photos' => $cmsPhotoRepository->findAll(),

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
     * @Route("/Tennis", name="tennis", methods={"GET"})
     */
    public function tennis(CmsCopyRepository $cmsCopyRepository, CmsPhotoRepository $cmsPhotoRepository): Response
    {
        return $this->render('home/tennis.twig', [
            'photos' => $cmsPhotoRepository->findAll(),

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
     * @Route("/Flying", name="flying", methods={"GET"})
     */
    public function flying(CmsCopyRepository $cmsCopyRepository, CmsPhotoRepository $cmsPhotoRepository): Response
    {
        return $this->render('home/flying.twig', [
            'photos' => $cmsPhotoRepository->findAll(),

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
            'HomePage2Text' => $cmsPhotoRepository->findOneBy([
                'name' => 'HomePage2'
            ]),
        ]);
    }


    /**
     * @Route("/XVAConsulting", name="XVAConsulting", methods={"GET"})
     */
    public function xvaconsulting(CmsCopyRepository $cmsCopyRepository, CmsPhotoRepository $cmsPhotoRepository): Response
    {
        return $this->render('home/xvaconsulting.twig', [
            'photos' => $cmsPhotoRepository->findAll(),

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
     * @Route("/cyprus", name="cyprus", methods={"GET"})
     */
    public function cyprus(CmsCopyRepository $cmsCopyRepository, CmsPhotoRepository $cmsPhotoRepository): Response
    {
        return $this->render('home/cyprus.twig', [
            'photos' => $cmsPhotoRepository->findAll(),

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
     * @Route("/volunteering", name="volunteering", methods={"GET"})
     */
    public function volunteering(CmsCopyRepository $cmsCopyRepository, CmsPhotoRepository $cmsPhotoRepository): Response
    {
        return $this->render('home/volunteering.twig', [
            'photos' => $cmsPhotoRepository->findAll(),
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
     * @Route("/homeaddress", name="/homeaddress", methods={"GET"})
     */
    public function homeAddress(StaticTextRepository $staticTextRepository, CmsCopyRepository $cmsCopyRepository, CmsPhotoRepository $cmsPhotoRepository): Response
    {
        return $this->render('home/homeaddress.html.twig', [
            'photos' => $cmsPhotoRepository->findAll(),
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


}
