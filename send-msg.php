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
 if(isset($_POST['sendmesg'])) {

 $jphone = $_POST['phone'];
 $jname = $_POST['jname'];

 
	// $email_to = $_POST['email'];
	$email = "arjunkomarapu@gmail.com";
	$email_to1=explode(",",$email_to);
	$comp_names = $_POST['comp_name'];
 if(empty($_POST['subject'])||empty($_POST['message']))
 {
	 ?>
	 <script lang="javascript">
	 alert("Subject or message canot be empty");
	 
	 
	 
	 </script>
	 <?php
 }
 else
 {
    $email_subject = $_POST['subject'];
	 $message = $_POST['message'];
	 $name_sql="SELECT JFullName from tbl_jobseeker WHERE JUser_Id='".$email_to."'";
	 $name_js=mysqli_query($con,$name_sql);
	 $jsname=mysqli_fetch_array($name_js);
	  $mess=base64_encode( $message);
	 $name=base64_encode($jsname['JFullName']);
	 $comname=base64_encode($comp_names);
	 $siteurl = "smarthirein.ai";
	 $mail->From ='arkomarapu@smarthirein.ai';
	 $email_to = $email; 
	 // $email_subject = "".$_POST['Cu_Fullname']." Booked a Demo from Needyin";
	 $email_subject = $email_subject;
	 $message= "<table width='600' border='0' cellspacing='0' cellpadding='0' style='font-family:arial; margin:0 auto;'>
	 <tr height='43px'>
			<td align='left' width='400px;' >
					<a href='".$siteurl."' target='_blank'><img src='".$siteurl."/img/logo.png' width='198'></a>
			   
			</td>
			<td align='right' width='300px;'>
				<table>
					<tr height='70'>
						<td align='center' style='padding-right:10px;'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/about_us.php' target='_blank'>About Us</a> |</td>
						<td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/contact.php' target='_blank'>Contact</a>
						|</td>
						
						 <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/emp_msg.php?mess=".$mess."&name=".$name."&comname=".$comname."' target='_blank'>View In Web</a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	 <tr>
					<td colspan='2' style='background:url(https://www.needyin.com/img/thankyou1.png) no-repeat center 0; height:335px;' >
					  <div style='padding: 15px; text-align: justify; margin-left: 311px; margin-top: 16px; width: 175px;font-size: 13px; padding-left: 10px;'>
						   Dear ".$jname.",<br><br>
					 Following message for you:<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$message."<br><br>
					  
					<strong>  Thanks<br>
					  ".$comp_names."
				   </strong>
					  </div>
					  
					</td>
		</tr>
	<tr>
		<td colspan='2' style='background:#90bd14;' align='center'>
		  
			<p style='font-size:20px; font-weight:bold; color:#fff; margin:0; padding-bottom:31px;  margin:0;'>
			<br>
			<a href=".$siteurl.">smarthirein.ai </a></p>
		</td>
	</tr>
	<tr>
		<td height='10' colspan='2' align='center'>
			<!--<p style='font-size:15px; line-height:22px; color:#333; padding:0 10px; margin:0;'></p>-->
		</td>
	</tr>
	<tr>
		<td colspan='2' style='background:#0274bb;' align='center'>
			<p style='font-size:13px; line-height:16px; color:#fff; '>You have received this mail because your e-mail ID is registered with Needyin.com. This is a system-generated e-mail regarding your Needyin account preferences, please don't reply to this message.</p>
		</td>
	</tr>

</table>";
	 $mail = new PHPMailer;
	 $email_to=$email;
	 $mail->IsSMTP();
	 
	 $mail->Host = 'mail.webmailcommunications.com';
	 $mail->SMTPAuth = true;
	 $mail->Username = 'arkomarapu@smarthirein.ai';
	 $mail->Password = 'Arjun@123';
	 // $mail->Password = 'Master@2772';
	 $mail->SMTPSecure = 'tls';
	 
	 $mail->From ='arkomarapu@smarthirein.ai';
	 $mail->FromName = $_POST['name'];
	 $mail->addAddress($email_to);
	 
	 // $mail->isHTML(true);
	 
	 $mail->Subject = $email_subject;
	 $mail->Body    = $message;
				  if($mail->send())
					  { ?> <script lang="text/javascript">
						 alert("Message sent successfully.");
						 window.location.href = "screened-profles.php";
						 </script>
				 <?php	
					  }
					 else
					 { ?> <script lang="text/javascript">
				 alert("Your Request hasn't been sent");
					 </script>
						   <?php
		 
					 }			
	   }		
 
}
 
?>
<?php
$apiKey = urlencode('TreESbtR4n0-BRdjbXUVKuc841Y9bmIzRoDQWaEBzZ');	
$numbers = array($jphone);
  // $numbers = 9441227696;
    $sender = urlencode('NEEDYN');  //NEEDYN
	$message = "Dear ".$jname.",your profile is matched our job description.";
    $numbers = implode(',', $numbers);
	$data = array('apikey' => $apiKey, 'numbers' => $numbers, 'sender' => $sender, 'message' => $message);
	$ch = curl_init('https://api.textlocal.in/send/');

	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
	// echo $response;
?>
 <!-- <script>
	 alert("Message sent successfully");
window.location.href = "screened-profles.php"</script> -->