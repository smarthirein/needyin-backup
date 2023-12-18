<?php
// Address
$address = 'Hyderabad, india';

// Get JSON results from this request
$geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false');

// Convert the JSON to an array
$geo = json_decode($geo, true);

if ($geo['status'] == 'OK') {
  // Get Lat & Long
echo  $latitude = $geo['results'][0]['geometry']['location']['lat'];
  $longitude = $geo['results'][0]['geometry']['location']['lng'];
}
?>