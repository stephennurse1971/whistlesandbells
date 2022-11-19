<?php

namespace App\Controller;

use App\Repository\StaticTextRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(StaticTextRepository $staticTextRepository): Response
    {
        return $this->render('user-templates/home.html.twig');
//        return $this->render('home/index.html.twig', [
//            'controller_name' => 'HomeController',
//        ]);
    }

    /**
     * @Route("/aboutSN", name="aboutSN", methods={"GET"})
     */
    public function aboutSN(StaticTextRepository $staticTextRepository): Response
    {
        return $this->render('home/aboutSN.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }


    /**
     * @Route("/webdesign", name="webdesign", methods={"GET"})
     */
    public function webDesign(StaticTextRepository $staticTextRepository): Response
    {

        return $this->render('template_parts/webdesign.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }


}
