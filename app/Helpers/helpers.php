<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('calculate_mileage')) {
    function calculate_mileage($start_point, $delivery_point)
    {
        $mileage = null;
        $api_key = env('MAPS_API_KEY');
        $url = "https://maps.googleapis.com/maps/api/directions/json?origin={$start_point}&destination={$delivery_point}&key={$api_key}";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);
        if ($data['status'] === 'OK') {
            $mileage = $data['routes'][0]['legs'][0]['distance']['text'];
        }
        return $mileage;
    }
}
if (!function_exists('calculate_address')) {
    function calculate_address($zipcode)
    {
        $api_key = env('MAPS_API_KEY');
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$zipcode}&sensor=true&key={$api_key}";
        $ch = curl_init($url);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);
        
        if ($data['status'] === 'OK') {
            $result = $data['results'][0];
            $components = $result['address_components'];
            $city = null;
            $state_or_province = null;
            $country = null;

            foreach ($components as $component) {
                $types = $component['types'];

                if (in_array('locality', $types)) {
                    $city = $component['long_name'];
                } elseif (in_array('administrative_area_level_1', $types)) {
                    $state_or_province = $component['long_name'];
                } elseif (in_array('country', $types)) {
                    $country = $component['long_name'];
                }
                if ($city && $state_or_province && $country) {
                    break;
                }
            }
            $mail_address_1 = $result['formatted_address'];
        }
        $address = array(
            'city' => $city,
            'state_or_province' => $state_or_province,
            'country' => $country,
            'mail_address' => $mail_address_1,
        );
        return $address;
    }
}
