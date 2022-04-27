<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/aboutSN", name="aboutSN", methods={"GET"})
     */
    public function aboutSN(): Response
    {
        return $this->render('home/aboutSN.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }




    /**
     * @Route("/webdesign", name="webdesign", methods={"GET"})
     */
    public function webDesign(): Response
    {
        return $this->render('template_parts/webdesign.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }


    /**
     * @Route("/chaveyDownBackground", name="chaveyDownBackground", methods={"GET"})
     */
    public function chaveyDownBackground(): Response
    {
        return $this->render('chavey_down/chaveyDownBackground.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }








}
