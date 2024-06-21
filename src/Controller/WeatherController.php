<?php

namespace App\Controller;

use App\Entity\Weather;
use App\Form\WeatherType;
use App\Repository\WeatherRepository;
use App\Services\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/weather")
 */
class WeatherController extends AbstractController
{
    /**
     * @Route("/index", name="weather_index", methods={"GET"})
     */
    public function index(WeatherRepository $weatherRepository): Response
    {
        $today = new \DateTime('now');
        return $this->render('weather/index.html.twig', [
            'weather' => $weatherRepository->findAll(),
            'today' => $today
        ]);
    }

    /**
     * @Route("/new", name="weather_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $weather = new Weather();
        $form = $this->createForm(WeatherType::class, $weather);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($weather);
            $entityManager->flush();

            return $this->redirectToRoute('weather_index');
        }

        return $this->render('weather/new.html.twig', [
            'weather' => $weather,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="weather_show", methods={"GET"})
     */
    public function show(Weather $weather): Response
    {
        return $this->render('weather/show.html.twig', [
            'weather' => $weather,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="weather_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Weather $weather): Response
    {
        $form = $this->createForm(WeatherType::class, $weather);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('weather_index');
        }

        return $this->render('weather/edit.html.twig', [
            'weather' => $weather,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="weather_delete", methods={"POST"})
     */
    public function delete(Request $request, Weather $weather): Response
    {
        if ($this->isCsrfTokenValid('delete' . $weather->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($weather);
            $entityManager->flush();
        }

        return $this->redirectToRoute('weather_index');
    }

    /**
     * @Route("/weather/delete_all", name="weather_delete_all")
     */
    public function deleteAllWeatherData(WeatherRepository $weatherRepository)
    {
        $weathers = $weatherRepository->findAll();
        foreach ($weathers as $weather) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($weather);
            $entityManager->flush();
        }
        return $this->redirectToRoute('weather_index');
    }


    /**
     * @Route("/weather/fetch_weather_data", name="fetch_weather_data", methods={"GET"})
     */
    public function weather(WeatherService $weatherService, Request $request)
    {
        $referer = $request->headers->get('Referer');
        $weatherService->update();
        $weatherService->hourlyUpdate();
        return $this->redirect($referer);
    }


    /**
     * @Route("/weather/fetch_weather_data_hourly", name="fetch_weather_data_hourly", methods={"GET"})
     */
    public function weatherHourly(WeatherService $weatherService, Request $request)
    {
        $referer = $request->headers->get('Referer');
        $weatherService->hourlyUpdate();
        return $this->redirect($referer);
    }
}
