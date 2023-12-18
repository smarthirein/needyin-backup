<?php
require 'PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;
$Email="mahesh.careator@gmail.com";
$mail->IsSMTP();
//$mail->SMTPDebug = 1;

$mail->Host = 'needyin.com';
$mail->SMTPAuth = true;
$mail->Username = 'support@needyin.com';
$mail->Password = 'Support@123';
$mail->SMTPSecure = 'tls';

$mail->From = 'support@needyin.com';
$mail->FromName = 'Support';
$mail->addAddress($Email);

$mail->isHTML(true);

$mail->Subject = 'Test Mail Subject!';
$mail->Body    = "Testing";

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
 } else {
    echo 'Message has been sent';
}
?>