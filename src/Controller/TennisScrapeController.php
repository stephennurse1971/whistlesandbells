<?php

namespace App\Controller;

use Goutte\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TennisScrapeController extends AbstractController
{
    /**
     * @Route("/tennis/scrape", name="tennis_scrape")
     */
    public function index(): Response
    {
       $url = 'https://uk.bookingbug.com/book/top_item_choose?sel_day=2459366&amp;start=2459368&amp;wid=4899532';
        $client = new Client();
        $crawler=$client->request('GET',$url);

        $html=$crawler->filter('.cal_day_Wed')->html();
        echo $html;
        return new Response(null);

//        return $this->render('tennis_scrape/index.html.twig', [
//            'controller_name' => 'TennisScrapeController',
//
//        ]);
    }
}
