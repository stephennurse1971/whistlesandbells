<?php

namespace App\Services;

use App\Entity\TennisCourtAvailability;
use App\Entity\TennisVenues;
use App\Repository\TennisCourtAvailabilityRepository;
use App\Repository\TennisVenuesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Validator\Constraints\DateTime;

class   ScrapeTHService
{

    public function CreateCourtAvailabilty()
    {


        $today = new \DateTime('now');
        $weekday = $today->format('N') - 1;
        $lastMonday = new \DateTime($today->format('Y-m-d'));
        $lastMonday->modify('-' . $weekday . ' days');

        $tennisVenuesRepository = $this->tennisVenuesRepository;
        $ThVenues = $tennisVenuesRepository->findByWebID();
        foreach ($ThVenues as $thVenue) {
            $url = $thVenue->getTowerHamletsId();
            $client = new Client();
            $crawler = $client->request('GET', $url);
            $node = $crawler->filter('.day_list li a ')->attr('onclick');
            $textCont = explode('?', $node);
            $textCont[1];
            $textCont1 = explode("'", $textCont[1]);
            $textCont2 = explode('&', $textCont1[0]);
            $sel_day = explode('=', $textCont2[0]);
            $start = explode('=', $textCont2[1]);
            $wid = explode('=', $textCont2[2]);

            $manager = $this->manager;
            $client = new Client();
            $THsiteId = $wid[1];

            $day = $start[1];
            $sel_date = $sel_day[1];
            for ($i = 0; $i <= 2; $i++) {


                $moveDate = 7*$i;
                $sel_date = $sel_date + $moveDate;


                $monday = new \DateTime($lastMonday->format('Y-m-d'));
                $monday->modify('+' . $moveDate . ' day');
                $dynamicMonday = $monday->format('Y-m-d');

                $tuesday = new \DateTime($dynamicMonday);
                $tuesday->modify('+1 day');

                $wednesday = new \DateTime($dynamicMonday);
                $wednesday->modify('+2 day');

                $thursday = new \DateTime($dynamicMonday);
                $thursday->modify('+3 day');

                $friday = new \DateTime($dynamicMonday);
                $friday->modify('+4 day');

                $saturday = new \DateTime($dynamicMonday);
                $saturday->modify('+5 day');

                $sunday = new \DateTime($dynamicMonday);
                $sunday->modify('+6 day');

                $crawler = $client->request('GET', 'https://uk.bookingbug.com/book/top_item_choose?sel_day=' . $sel_date . '&amp;start=' . $day . '&amp;wid=' . $THsiteId);

                //Monday
                $count = 7;
                $day = $crawler->filter('.cal_day_Mon .day')->text();

                $crawler->filter('.cal_day_Mon .inc')->each(function (Crawler $node) use ($manager, $thVenue, &$count, $monday) {

                    if ($node->children('div')->count() > 0) {
                        $tennisCourtAvailability = new TennisCourtAvailability();
                        $tennisCourtAvailability->setAvailable($node->children('div')->text())
                            ->setVenue($thVenue)
                            ->setDate($monday)
                            ->setHour($count);
                        $manager->persist($tennisCourtAvailability);
                        $manager->flush();
                        $count++;
                    }
                });


                //Tuesday
                $count = 7;
                $crawler->filter('.cal_day_Tue .inc')->each(function (Crawler $node) use ($manager, $thVenue, &$count, $tuesday) {
                    if ($node->children('div')->count() > 0) {
                        $tennisCourtAvailability = new TennisCourtAvailability();
                        $tennisCourtAvailability->setAvailable($node->children('div')->text())
                            ->setVenue($thVenue)
                            ->setDate($tuesday)
                            ->setHour($count);
                        $manager->persist($tennisCourtAvailability);
                        $manager->flush();
                        $count++;
                    }
                });


                //Wednesday
                $count = 7;
                $crawler->filter('.cal_day_Wed .inc')->each(function (Crawler $node) use ($manager, $thVenue, &$count, $wednesday) {
                    if ($node->children('div')->count() > 0) {
                        $tennisCourtAvailability = new TennisCourtAvailability();
                        $tennisCourtAvailability->setAvailable($node->children('div')->text())
                            ->setVenue($thVenue)
                            ->setDate($wednesday)
                            ->setHour($count);
                        $manager->persist($tennisCourtAvailability);
                        $manager->flush();
                        $count++;
                    }
                });

                //Thursday
                $count = 7;
                $crawler->filter('.cal_day_Thu .inc')->each(function (Crawler $node) use ($manager, $thVenue, &$count, $thursday) {
                    if ($node->children('div')->count() > 0) {
                        $tennisCourtAvailability = new TennisCourtAvailability();
                        $tennisCourtAvailability->setAvailable($node->children('div')->text())
                            ->setVenue($thVenue)
                            ->setDate($thursday)
                            ->setHour($count);
                        $manager->persist($tennisCourtAvailability);
                        $manager->flush();
                        $count++;
                    }
                });

                //Friday
                $count = 7;
                $crawler->filter('.cal_day_Fri .inc')->each(function (Crawler $node) use ($manager, $thVenue, &$count, $friday) {
                    if ($node->children('div')->count() > 0) {
                        $tennisCourtAvailability = new TennisCourtAvailability();
                        $tennisCourtAvailability->setAvailable($node->children('div')->text())
                            ->setVenue($thVenue)
                            ->setDate($friday)
                            ->setHour($count);
                        $manager->persist($tennisCourtAvailability);
                        $manager->flush();
                        $count++;
                    }
                });

                //Saturday
                $count = 7;
                $crawler->filter('.cal_day_Sat .inc')->each(function (Crawler $node) use ($manager, $thVenue, &$count, $saturday) {
                    if ($node->children('div')->count() > 0) {
                        $tennisCourtAvailability = new TennisCourtAvailability();
                        $tennisCourtAvailability->setAvailable($node->children('div')->text())
                            ->setVenue($thVenue)
                            ->setDate($saturday)
                            ->setHour($count);
                        $manager->persist($tennisCourtAvailability);
                        $manager->flush();
                        $count++;
                    }
                });

                //Sunday
                $count = 7;
                $crawler->filter('.cal_day_Sun .inc')->each(function (Crawler $node) use ($manager, $thVenue, &$count, $sunday) {
                    if ($node->children('div')->count() > 0) {
                        $tennisCourtAvailability = new TennisCourtAvailability();
                        $tennisCourtAvailability->setAvailable($node->children('div')->text())
                            ->setVenue($thVenue)
                            ->setDate($sunday)
                            ->setHour($count);
                        $manager->persist($tennisCourtAvailability);
                        $manager->flush();
                        $count++;
                    }
                });

            }


        }
    }


    public function __construct(EntityManagerInterface $manager, TennisVenuesRepository $tennisVenuesRepository)
    {
        $this->manager = $manager;
        $this->tennisVenuesRepository = $tennisVenuesRepository;


    }
}