<?php

namespace App\Command;

class Geocode
{
    public function getLatLong($address){

        $address = str_replace(" ", "+", $address);
        $key="xxxxx";
        $array = array('lat'=> '' ,'lng'=>'');

        $data = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=$key");
        $geo = json_decode($data, true);

        if ($geo['status'] = 'OK') {
            $latitude = $geo['results'][0]['geometry']['location']['lat'];
            $longitude = $geo['results'][0]['geometry']['location']['lng'];
            $array = array('lat'=> $latitude ,'lng'=>$longitude);
        }

        return $array;


    }
}