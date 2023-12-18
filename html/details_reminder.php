<?php
session_start();
require_once 'dbconfig.php';
require_once 'class.user.php';
$user_home = new USER();

$sql="SELECT JUser_Id,JEmail,JtokenCode from tbl_jobseeker WHERE JuserStatus='V'";
$result=mysqli_query($con,$sql);
if($result)
{
	while($row=mysqli_fetch_assoc($result))
	{
		$email_to=$row['JEmail'];
		$siteurl="https://needyin.com/"; 
		$message .= "Welcome to Needyin !<br /><br />";
		$message .= "To apply for jobs and have full access to Needyin services please complete your profile<br /><br />";
		$message.="<a href=".$siteurl.">Click here to visit Needyin.</a> <br><br>";
		$message .= "Thanks,<br><br>";
			$message .= "Team Needyin<br>";
			$message .= "<img src='./img/logo.png' width='200px' height='100px'><br>";
		$subject = "Needyin Reminder";
		$user_home->send_mail($email_to,$message,$subject);	
	}
}


?>