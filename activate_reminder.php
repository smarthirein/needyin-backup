<?php
require_once 'dbconfig.php';
require_once 'class.user.php';
$user_home = new USER();

$sql="SELECT JUser_Id,JEmail,JtokenCode from tbl_jobseeker WHERE JuserStatus='N'";
$result=mysqli_query($con,$sql);
while($row=mysqli_fetch_assoc($result))
{
	$email_to=$row['JEmail'];
	$key = base64_encode($row['JUser_Id']);
	$id = $key;
	$code= md5(uniqid(rand()));
	$update="UPDATE tbl_jobseeker SET JtokenCode='$code' WHERE JUser_id=".$row['JUser_Id'];
	mysqli_query($con,$update);
	$siteurl="https://needyin.com/"; 
	$message .= "Welcome to Needyin !<br /><br />";
	$message .= "Your old activation link has been deactivated. <br><br>To complete your registration  please , just click following link !<br /><br />";
	$message .= "<a href=".$siteurl."verify.php?id=".$id."&code=".$code.">Click here to Activate </a><br /><br />";
	$message .= "Thanks,<br>";	
		$message .= "Team Needyin<br>";
		$message .= "<img src='./img/logo.png' width='200px' height='100px'><br>";
	$subject = "Needyin Registration Activation Link Reminder";
	$res=$user_home->send_mail($email_to,$message,$subject);
	$message=null;
}
?>