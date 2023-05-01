<?php

namespace App\Services;

use Psr\Container\ContainerInterface;

class FlightPrice
{
  public function getPrice(){


     $now = new \DateTime('now');
     $day_increment = 1;
     while($day_increment <= 30){
         $date = $now->format('Y-m-d');
         $url = "https://www.kayak.co.uk/flights/LON-PFO/".$date."?sort=bestflight_a&fs=stops=0";
         exec("node scrape/flightPrice.js"." " .$url." 2>&1");
         $file = $this->container->getParameter('scraper').'flightPrice.json';
         if(file_exists($file)){
             $file_content = file_get_contents($file);
             $file_content_array = json_decode($file_content);
             foreach($file_content_array as $content){
                 echo $content->price;
                 echo "<br>";
             }
         }
         $now->modify("+1 day");
         $day_increment++;
     }
  }
    public function getPricePfoLondon(){


        $now = new \DateTime('now');
        $day_increment = 1;
        while($day_increment <= 30){
            $date = $now->format('Y-m-d');
            $url = "https://www.kayak.co.uk/flights/PFO-LON/".$date."?sort=bestflight_a&fs=stops=0";
            exec("node scrape/flightPrice.js"." " .$url." 2>&1");
            $file = $this->container->getParameter('scraper').'flightPrice.json';
            if(file_exists($file)){
                $file_content = file_get_contents($file);
                $file_content_array = json_decode($file_content);
                foreach($file_content_array as $content){
                    echo $content->price;
                    echo "<br>";
                }
            }
            $now->modify("+1 day");
            $day_increment++;
        }
    }
  public function __construct(ContainerInterface $container){
      $this->container = $container;
  }
}