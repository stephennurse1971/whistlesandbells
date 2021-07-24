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
//        $url = 'https://uk.bookingbug.com/book/all?height=470&id=w981356&iframe=bb_all_ukw981356_62aaf&palette=THT+BR&service=101099&style=medium-small&width=310&category=';
        $url = 'https://www.towerhamletstennis.org.uk/victoria-park';
        $client = new Client();
        $crawler = $client->request('GET', $url);

//        $node = $crawler->filter('.day_list li a ')->attr('onclick');
//        $textCont = explode('?',$node);
//         $textCont[1];
//         $textCont1 = explode("'",$textCont[1]);
//
//          $textCont2= explode('&', $textCont1[0]);
//         $sel_day = explode('=', $textCont2[0]);
//       $start =  explode('=', $textCont2[1]);
//       $wid =  explode('=', $textCont2[2]);
//        $THsiteId = $wid[1];
//
//        $day = $start[1];
//        $sel_date = $sel_day[1];
//        $crawler = $client->request('GET', 'https://uk.bookingbug.com/book/top_item_choose?sel_day='.$sel_date.'&amp;start='. $day.'&amp;wid='.$THsiteId);
//        $node = $crawler->filter('html');
//        $html = $node->html();
//        $html = htmlspecialchars_decode($html);
$html = $crawler->filter('body')->html();
        echo $html;
        return new Response();
//        return $this->render('tennis_scrape/index.html.twig', [
//            'controller_name' => 'TennisScrapeController',
//
//        ]);
    }

}
