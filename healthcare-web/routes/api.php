<?php
// PHP function to get nearby hospitals
function getNearbyHospitals($lat, $lng) {
    $url = "http://your-api-domain/api/nearby-hospitals?lat={$lat}&lng={$lng}";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}