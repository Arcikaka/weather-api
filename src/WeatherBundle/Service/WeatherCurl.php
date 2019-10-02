<?php


namespace WeatherBundle\Service;


class WeatherCurl
{
    //Two const for future changes
    public const SEARCH_LOCATION_BY_NAME_URL = 'https://www.metaweather.com/api/location/search/?query=';
    public const GET_LOCATION_WEATHER_URL = 'https://www.metaweather.com/api/location/';

    //this method is getting from www.metaweather.com information about location and returning array
    public
    function getWeatherLocationByName($string): array
    {
        $ch = curl_init();
        $url = self::SEARCH_LOCATION_BY_NAME_URL . $string;
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        $output = curl_exec($ch);
        curl_close($ch);

        return json_decode($output, 1);
    }
    //this method is changing location to global woeid needed in next step
    public function getLocationId($string): int
    {
        $data = $this->getWeatherLocationByName($string);
        $woeid = $data['0']['woeid'];

        return $woeid;
    }
    //this final method is getting weather state from www.metaweather.com after changing location name into woeid
    //with next step method gets information about weather if localisation exist in metawaether database
    public function getWeatherById($id)
    {
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