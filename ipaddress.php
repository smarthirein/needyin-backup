<?php
require 'dbconfig.php';
$ip=$_GET['ip'];
$city=$_GET['city'];
$country_name=$_GET['country'];
$latitude=$_GET['latitude'];
$longitude=$_GET['longitude'];
$query="SELECT * from tbl_visits WHERE ip='$ip'";
$res=mysqli_query($con,$query);
$count=mysqli_num_rows($res);
if($count==0)
mysqli_query($con,"INSERT INTO tbl_visits (ip,city,country,latitude,longitude) VALUES ('$ip','$city','$country_name','$latitude','$longitude')");

?>