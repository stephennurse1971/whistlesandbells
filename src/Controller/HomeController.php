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
        $get_all_static_texts = $staticTextRepository->findAll();
        $first_static_text = $get_all_static_texts[0];

        return $this->render('home/index.html.twig', [
            'staticText' => $first_static_text,
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/aboutSN", name="aboutSN", methods={"GET"})
     */
    public function aboutSN(StaticTextRepository $staticTextRepository): Response
    {
        $get_all_static_texts = $staticTextRepository->findAll();
        $first_static_text = $get_all_static_texts[0];

        return $this->render('home/aboutSN.html.twig', [
            'staticText' => $first_static_text,
            'controller_name' => 'HomeController',
        ]);
    }




    /**
     * @Route("/webdesign", name="webdesign", methods={"GET"})
     */
    public function webDesign(StaticTextRepository $staticTextRepository): Response
    {
        $get_all_static_texts = $staticTextRepository->findAll();
        $first_static_text = $get_all_static_texts[0];

        return $this->render('template_parts/webdesign.html.twig', [
            'staticText' => $first_static_text,
            'controller_name' => 'HomeController',
        ]);
    }


}
