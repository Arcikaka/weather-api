<?php


namespace WeatherBundle\Service;


class WeatherCurl
{
    public const SEARCH_LOCATION_BY_NAME_URL = 'https://www.metaweather.com/api/location/search/?query=';
    public const GET_LOCATION_WEATHER_URL = 'https://www.metaweather.com/api/location/';



    public
    function getWeatherLocationByName($string) : array
    {
        $ch = curl_init();
        $url = self::SEARCH_LOCATION_BY_NAME_URL . $string;
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        $output = curl_exec($ch);
        curl_close($ch);

        return json_decode($output,true);
    }

    public function getLocationId($string): int
    {
        $data = $this->getWeatherLocationByName($string);
        $woeid = $data[0]['woeid'];

        return $woeid;
    }

    public function getWeatherById($id){
        $ch = curl_init();
        $url = self::GET_LOCATION_WEATHER_URL . $id . '/';
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        $output = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($output, 1);
        $weatherArray = $json['consolidated_weather']['0'];

        return $weatherArray;
    }
}