<?php

namespace App\Command;

class Geocode
{
    public function getLatLong($address){

        $address = str_replace(" ", "+", $address);

        $array = array('lat'=> '' ,'lng'=>'');

        $data = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=AIzaSyDMP1_zMlTEy15t1s85ja6EPtxcp5IOBRU");
        $geo = json_decode($data, true);

        if ($geo['status'] = 'OK') {
            $latitude = $geo['results'][0]['geometry']['location']['lat'];
            $longitude = $geo['results'][0]['geometry']['location']['lng'];
            $array = array('lat'=> $latitude ,'lng'=>$longitude);
        }

        return $array;


    }
}