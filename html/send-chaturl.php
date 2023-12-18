<?php
session_start();
header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire');
session_cache_limiter('public'); 
require_once 'class.user.php';
$user_home = new USER();
	
if(!isset($_SESSION['empSession']))
{
		 $user_home->redirect('index-recruiter.php');
   
} 
 if(isset($_POST['sendchaturl'])) {

 $jphone = $_POST['phone'];
 $jemail = $_POST['email'];
 $jname = $_POST['jname'];
 $chatlink = $_POST['chaturl'];
 $decode_chatlink = base64_decode($_POST['chaturl']);

$apiKey = urlencode('TreESbtR4n0-BRdjbXUVKuc841Y9bmIzRoDQWaEBzZ');	
// $numbers = array($jphone);
  $numbers = 9441227696;
    $sender = urlencode('NEEDYN');  //NEEDYN
    $message = "please click this link to chat ".$decode_chatlink;
    echo $message;
    $numbers = implode(',', $numbers);
	$data = array('apikey' => $apiKey, 'numbers' => $numbers, 'sender' => $sender, 'message' => $message);
	$ch = curl_init('https://api.textlocal.in/send/');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
	echo $response;
?>