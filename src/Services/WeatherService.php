<?php

namespace App\Services;

use App\Entity\Weather;
use App\Repository\CompanyDetailsRepository;
use App\Repository\WeatherRepository;
use Doctrine\ORM\EntityManagerInterface;

class WeatherService
{
    public function update()
    {
        $timeZone = $this->companyDetailsRepository->find(1)->getCompanyTimeZone();
        $lon = $this->companyDetailsRepository->find(1)->getCompanyAddressLongitude();
        $lat = $this->companyDetailsRepository->find(1)->getCompanyAddressLatitude();
        $location = $this->companyDetailsRepository->find(1)->getWeatherLocation();
        date_default_timezone_set($timeZone);
        $api = '13c3efa537a29520b090d83776daaa1b';
        $url = 'https://api.openweathermap.org/data/2.5/forecast?lat=' . $lat . '&lon=' . $lon . '&appid=' . $api . '&units=metric';
        $jsonfile = file_get_contents($url);
        $jsondata = json_decode($jsonfile);

        if ($jsondata->cod == 200) {
            foreach ($this->weatherRepository->findAll() as $weather) {
                $this->manager->remove($weather);
                $this->manager->flush();
            }
            foreach ($jsondata->list as $data) {
                $date_as_string = date("Y-m-d H:i", $data->dt);
                $date = new \DateTime($date_as_string);
                $time = date("H", $data->dt);
                $temperature = $data->main->temp;
                $rain = '';
                $rain_status = $data->weather[0]->main;
                if ($rain_status == "Rain") {
                    $rain = $data->rain->{'3h'};
                }
                $weather = new Weather();
                $weather->setDate($date)
                    ->setLocation($location)
                    ->setTime($time)
                    ->setWeather($temperature)
                    ->setRain($rain);
                $this->manager->persist($weather);
                $this->manager->flush();
            }
        }
        return null;
    }

    public function hourlyUpdate()
    {
        $timeZone = $this->companyDetailsRepository->find(1)->getCompanyTimeZone();
        $lon = $this->companyDetailsRepository->find(1)->getCompanyAddressLongitude();
        $lat = $this->companyDetailsRepository->find(1)->getCompanyAddressLatitude();
        $location = $this->companyDetailsRepository->find(1)->getWeatherLocation();
        date_default_timezone_set($timeZone);
        $api = '13c3efa537a29520b090d83776daaa1b';
        $url = 'https://api.openweathermap.org/data/3.0/onecall?lat=' . $lat . '&lon=' . $lon . '&exclude=current,minutely,daily,alert&appid=' . $api . '&units=metric';
        $jsonfile = file_get_contents($url);
        $jsondata = json_decode($jsonfile);
        foreach ($this->weatherRepository->findAll() as $weather) {
            $this->manager->remove($weather);
            $this->manager->flush();
        }
        foreach ($jsondata->hourly as $data) {
            $date_as_string = date("Y-m-d H:i", $data->dt);
            $date = new \DateTime($date_as_string);
            $time = date("H", $data->dt);
            $temperature = $data->temp;
            $rain = '';
            $rain_status = $data->weather[0]->main;
            if ($rain_status == "Rain") {
                $rain = $data->rain->{'1h'};
            }
            $weather = new Weather();
            $weather->setDate($date)
                ->setLocation($location)
                ->setTime($time)
                ->setWeather($temperature)
                ->setRain($rain);
            $this->manager->persist($weather);
            $this->manager->flush();

        }

        return null;
    }

    public function getWeather(string $datetime)
    {
        // $date_as_string = $dateTime." ".$time;
        $date = new \DateTime($datetime);
        $weather = $this->weatherRepository->findOneBy([
            'date' => $date,
            //'time' => $time
        ]);
        if ($weather) {
            return $weather;
        } else {
            return null;
        }
    }


    public function __construct(EntityManagerInterface $entityManager, WeatherRepository $weatherRepository, CompanyDetailsRepository $companyDetailsRepository)
    {
        $this->manager = $entityManager;
        $this->weatherRepository = $weatherRepository;
        $this->companyDetailsRepository = $companyDetailsRepository;
    }


}