<?php 
// PHP code to obtain country, city,  
// continent, etc using IP Address 
  
function getVisIpAddr() { 
	
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) { 
		return $_SERVER['HTTP_CLIENT_IP']; 
	} 
	else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
		return $_SERVER['HTTP_X_FORWARDED_FOR']; 
	} 
	else { 
		return $_SERVER['REMOTE_ADDR']; 
	} 
} 

$vis_ip = getVisIPAddr(); 
echo $vis_ip;
echo "<br>";
// $visitor_ip = $_SERVER['REMOTE_ADDR'];
// $ip = '183.82.142.187';
  
// Use JSON encoded string and converts 
// it into a PHP variable 
$ipdat = @json_decode(file_get_contents( 
    "http://www.geoplugin.net/json.gp?ip=" . $vis_ip)); 
echo $country_Name = $ipdat->geoplugin_countryName. "\n";    
echo $city_Name = $ipdat->geoplugin_city. "\n"; 
echo $continent_Name = $ipdat->geoplugin_continentName . "\n"; 
echo $latitude = $ipdat->geoplugin_latitude. "\n"; 
echo $longitude = $ipdat->geoplugin_longitude. "\n"; 
echo $timezone = $ipdat->geoplugin_timezone. "\n"; 
?>
