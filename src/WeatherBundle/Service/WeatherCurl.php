<?php


namespace WeatherBundle\Service;


class WeatherCurl
{
    public const SEARCH_LOCATION_BY_NAME_URL = 'https://www.metaweather.com/api/location/search/?query=';
    public const GET_LOCATION_WEATHER_URL = 'https://www.metaweather.com/api/location/';

    private $searchLocationByNameUrl;
    private $getLocationWeatherUrl;
    private $ch;

    public function __construct()
    {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_HEADER, false);

    }

    public
    function getWeatherLocationByName($string)
    {
        curl_setopt($this->ch, CURLOPT_URL, self::SEARCH_LOCATION_BY_NAME_URL . $string);
        $output = curl_exec($this->ch);
        curl_close($this->ch);
        //$url = self::SEARCH_LOCATION_BY_NAME_URL . $string;
        //$url2 = "https://www.metaweather.com/api/location/search/?query={$string}";

        //$ch = curl_init($url2);
        //curl_setopt($ch, CURLOPT_HEADER, 0);
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //$url = self::SEARCH_LOCATION_BY_NAME_URL . $string;
        //curl_setopt($ch, CURLOPT_URL, "" .$url . "");
        //$output = curl_exec($ch);
        return json_decode($output,true);
    }

    public function getLocationId($string): int
    {
        $data = $this->getWeatherLocationByName($string);
        $woeid = $data[0]['woeid'];

        return $woeid;
    }

    public function getWeatherById($id){
        curl_setopt($this->ch, CURLOPT_URL, self::GET_LOCATION_WEATHER_URL . $id);
        $output = curl_exec($this->ch);
        curl_close($this->ch);

        return json_decode($output,true);
    }
}