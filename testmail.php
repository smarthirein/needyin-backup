<?php
require 'mail/PHPMailer/PHPMailerAutoload.php';

$email=array("13WH1A0433@bvrithyderabad.edu.in","divyavemula17@gmail.com","maheshkumar6225@gmail.com","noor.shaik95@hotmail.com","punamasawa@gmail.com","kondisaikumar1@gmail.com","venkat.shot@gmail.com","noorshaik4@gmail.com","noorullah.careator@gmail.com","mahesh.careator@gmail","venkat.careator@gmail","divya.careator@gmail","dhruthi.careator@gmail");

foreach($email as $i)
{
	$subject="Test mail";
	$message="This is a test";
	send_mail2($i,$message,$subject);
}
function send_mail2($email,$message,$subject)
	{						
			
$mail = new PHPMailer;
$email_to=$email;
$mail->IsSMTP();


$mail->Host = 'mail.webmailcommunications.com';
$mail->SMTPAuth = true;
$mail->Username = 'divya.vemula@needyin.com';
$mail->Password = 'Divya@123';
$mail->SMTPSecure = 'tls';

$mail->From = 'divya.vemula@needyin.com';
$mail->FromName = 'Needyin';
$mail->addAddress($email_to);

$mail->isHTML(true);

$mail->Subject = $subject;
$mail->Body    = $message;

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
 } else {
	
  
	return true;
	}	
	}
?>