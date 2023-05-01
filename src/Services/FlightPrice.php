<?php

namespace App\Services;

use App\Entity\FlightStats;
use App\Repository\FlightStatsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

class FlightPrice
{
  public function getPrice_LON_PFO(){
     $now = new \DateTime('now');
     $day_increment = 1;
     $flight_from = 'LON';
     $flight_to = 'PFO';
     while($day_increment <= 60){
         $date = $now->format('Y-m-d');
         $url = "https://www.kayak.co.uk/flights/LON-PFO/".$date."?sort=bestflight_a&fs=stops=0";
         exec("node scrape/flightPrice.js"." " .$url." 2>&1");
         $file = $this->container->getParameter('scraper').'flightPrice.json';
         if(file_exists($file)){
             $file_content = file_get_contents($file);
             $file_content_array = json_decode($file_content);
             foreach($file_content_array as $content){
                 $price_as_string = $content->price;
                 $price_explode = explode('£',$price_as_string);
                 $price = $price_explode[1];
                 $old_price =  $this->fightStatsRepository->findOneBy([
                     'flightFrom'=>$flight_from,
                     'flightTo'=>$flight_to,
                     'date'=>new \DateTime($date)
                 ]);
                 if($old_price){
                     $old_price->setLowestPrice($price);
                     $this->manager->flush();
                 }
                 else{
                     $flightStats = new FlightStats();
                     $flightStats->setDate(new \DateTime($date))
                         ->setFlightFrom($flight_from)
                         ->setFlightTo($flight_to)
                         ->setLowestPrice($price);
                     $this->manager->persist($flightStats);
                     $this->manager->flush();
                 }

             }
         }
         $now->modify("+1 day");
         $day_increment++;
     }
  }
    public function getPrice_PFO_LON(){
        $now = new \DateTime('now');
        $day_increment = 1;
        $flight_from = 'PFO';
        $flight_to = 'LON';
        while($day_increment <= 60){
            $date = $now->format('Y-m-d');
            $url = "https://www.kayak.co.uk/flights/PFO-LON/".$date."?sort=bestflight_a&fs=stops=0";
            exec("node scrape/flightPrice.js"." " .$url." 2>&1");
            $file = $this->container->getParameter('scraper').'flightPrice.json';
            if(file_exists($file)){
                $file_content = file_get_contents($file);
                $file_content_array = json_decode($file_content);
                foreach($file_content_array as $content){
                    $price_as_string = $content->price;
                    $price_explode = explode('£',$price_as_string);
                    $price = $price_explode[1];
                    $old_price =  $this->fightStatsRepository->findOneBy([
                        'flightFrom'=>$flight_from,
                        'flightTo'=>$flight_to,
                        'date'=>new \DateTime($date)
                    ]);
                    if($old_price){
                        $old_price->setLowestPrice($price);
                        $this->manager->flush();
                    }
                    else{
                        $flightStats = new FlightStats();
                        $flightStats->setDate(new \DateTime($date))
                            ->setFlightFrom($flight_from)
                            ->setFlightTo($flight_to)
                            ->setLowestPrice($price);
                        $this->manager->persist($flightStats);
                        $this->manager->flush();
                    }

                }
            }
            $now->modify("+1 day");
            $day_increment++;
        }
    }
  public function __construct(ContainerInterface $container,EntityManagerInterface $entityManager,FlightStatsRepository $flightStatsRepository){
      $this->container = $container;
      $this->manager = $entityManager;
      $this->fightStatsRepository = $flightStatsRepository;
  }
}