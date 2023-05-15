<?php

namespace App\Services;

use App\Entity\FlightStats;
use App\Repository\FlightStatsRepository;
use App\Repository\SettingsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

class FlightPrice
{
    public function getPrice_LON_PFO()
    {
        $start_date = new \DateTime( $this->settingsRepository->find('1')->getFlightStatsStartDate()->format('Y-m-d'));
        $day_increment = 1;
        $flight_from = $this->settingsRepository->find('1')->getFlightStatsDepartureAirport();
        $flight_to = 'PFO,LCA';
        while ($day_increment <= $this->settingsRepository->find('1')->getFlightStatsDays()) {
            $date = $start_date->format('Y-m-d');
            $url = "https://www.kayak.co.uk/flights/PFO,LCA-LON/" . $date . "?sort=bestflight_a&fs=stops=0";
            exec("node /var/www/html/stehennurse/public/scrape/flightPrice.js" . " " . $url . " 2>&1");
            $file = $this->container->getParameter('scraper') . 'flightPrice.json';
            if (file_exists($file)) {
                $file_content = file_get_contents($file);
                $file_content_array = json_decode($file_content);
                foreach ($file_content_array as $content) {
                    $price_as_string = $content->price;
                    $price_explode = explode('£', $price_as_string);
                    $price = $price_explode[1];
                    $old_price = $this->fightStatsRepository->findOneBy([
                        'flightFrom' => $flight_from,
                        'flightTo' => $flight_to,
                        'date' => new \DateTime($date)
                    ]);
                    if ($old_price) {
                        $old_price->setLowestPrice($price);
                        $this->manager->flush();
                    } else {
                        $flightStats = new FlightStats();
                        $flightStats->setDate(new \DateTime($date))
                            ->setFlightFrom($flight_from)
                            ->setFlightTo($flight_to)
                            ->setLowestPrice($price)
                            ->setScrapeDate(new \DateTime('now'));
                        $this->manager->persist($flightStats);
                        $this->manager->flush();
                    }
                }
            }
            $start_date->modify("+1 day");
            $day_increment++;
        }
    }

    public function getPrice_PFO_LON()
    {
        $start_dateR = new \DateTime( $this->settingsRepository->find('1')->getFlightStatsStartDate()->format('Y-m-d'));
        $day_increment = 1;
        $flight_from = 'PFO,LCA';
        $flight_to = $this->settingsRepository->find('1')->getFlightStatsDepartureAirport();
        while ($day_increment <= $this->settingsRepository->find('1')->getFlightStatsDays()) {
            $dateR = $start_dateR->format('Y-m-d');
            $url = "https://www.kayak.co.uk/flights/LON-PFO,LCA/" . $dateR . "?sort=bestflight_a&fs=stops=0";
            exec("node /var/www/html/stehennurse/public/scrape/flightPrice.js" . " " . $url . " 2>&1");
            $file = $this->container->getParameter('scraper') . 'flightPrice.json';
            if (file_exists($file)) {
                $file_content = file_get_contents($file);
                $file_content_array = json_decode($file_content);
                foreach ($file_content_array as $content) {
                    $price_as_string = $content->price;
                    $price_explode = explode('£', $price_as_string);
                    $price = $price_explode[1];
                    $old_price = $this->fightStatsRepository->findOneBy([
                        'flightFrom' => $flight_from,
                        'flightTo' => $flight_to,
                        'date' => new \DateTime($dateR)
                    ]);
                    if ($old_price) {
                        $old_price->setLowestPrice($price);
                        $this->manager->flush();
                    } else {
                        $flightStats = new FlightStats();
                        $flightStats->setDate(new \DateTime($dateR))
                            ->setFlightFrom($flight_from)
                            ->setFlightTo($flight_to)
                            ->setLowestPrice($price)
                            ->setScrapeDate(new \DateTime('now'));
                        $this->manager->persist($flightStats);
                        $this->manager->flush();
                    }
                }
            }
            $start_dateR->modify("+1 day");
            $day_increment++;
        }
    }

    public function __construct(ContainerInterface $container, EntityManagerInterface $entityManager, FlightStatsRepository $flightStatsRepository, SettingsRepository $settingsRepository)
    {
        $this->container = $container;
        $this->manager = $entityManager;
        $this->fightStatsRepository = $flightStatsRepository;
        $this->settingsRepository = $settingsRepository;
    }
}