<?php

namespace WeatherBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WeatherBundle\Form\WeatherType;
use WeatherBundle\Service\WeatherCurl;

class WeatherController extends Controller
{
    /**
     * @return Response
     * @Route("/", methods={"GET"}, name="weather_form")
     */
    public function weatherTypeAction()
    {
        $form = $this->createForm(WeatherType::class);
        return $this->render('@Weather/Default/formWeather.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/", methods={"POST"}, name="weather_form_action")
     * @param Request $request
     * @param WeatherCurl $weatherCurl
     * @return Response
     */
    public function getWeatherAction(Request $request, WeatherCurl $weatherCurl)
    {
        $form = $this->createForm(WeatherType::class);
        $form->handleRequest($request);

        //after checkin form we take from $request all information send by user, in this case location name.
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $location = $data['location'];
            //after getting location we need location id (woeid)
            //for this we can use our service to check weather
            $weatherLocationId = $weatherCurl->getLocationId($location);
            $weather = $weatherCurl->getWeatherById($weatherLocationId);

            return $this->render('@Weather/Default/weather.html.twig', ['weather' => $weather, 'location' => $location]);
        }
    }


}
