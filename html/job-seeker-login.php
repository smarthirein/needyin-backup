<?php 
require_once 'class.user.php';
$user_login = new USER();

if($user_login->is_logged_in()!="")
{
	$user_login->redirect('index.php');
}

if(isset($_GET['t'])) {
	$actualNumber='';
	for($i=0;$i<strlen($_GET['t']);$i++) {
		switch($_GET['t'][$i]) { 
			case 'x':
				$actualNumber =$actualNumber.'0';
				break;
			case 'a':
				$actualNumber =$actualNumber.'1';
				break;
			case 'v':
				$actualNumber =$actualNumber.'2';
				break;
			case 'n':
				$actualNumber =$actualNumber.'3';
				break;
			case 'i':
				$actualNumber = $actualNumber.'4';
				break;
			case 'e':
				$actualNumber = $actualNumber.'5';
				break;
			case 'd':
				$actualNumber = $actualNumber.'6';
				break;
			case 'j':
				$actualNumber = $actualNumber.'7';
				break;
			case 'y':
				$actualNumber = $actualNumber.'8';
				break;
			case 'z':
				$actualNumber = $actualNumber.'9';
				break; 
		}
	}
	if(strlen($actualNumber) >= 10) { 
		$select_query="SELECT Campaign_Name FROM tbl_campaign_details WHERE Mobile_No='$actualNumber'";
		$select_res=mysqli_query($con,$select_query);
		if(mysqli_num_rows($select_res)==0)	{
			$insert_query= "INSERT INTO tbl_campaign_details (Campaign_Name, Campaign_Des, Mobile_No, Email) VALUES ('SMS Campaign','', '$actualNumber','')";
			mysqli_query($con,$insert_query);
		}
	}
	
	
}


if(isset($_GET['w'])) {
	$actualNumber='';
	for($i=0;$i<strlen($_GET['w']);$i++) {
		switch($_GET['w'][$i]) { 
			case 'x':
				$actualNumber =$actualNumber.'0';
				break;
			case 'a':
				$actualNumber =$actualNumber.'1';
				break;
			case 'v':
				$actualNumber =$actualNumber.'2';
				break;
			case 'n':
				$actualNumber =$actualNumber.'3';
				break;
			case 'i':
				$actualNumber = $actualNumber.'4';
				break;
			case 'e':
				$actualNumber = $actualNumber.'5';
				break;
			case 'd':
				$actualNumber = $actualNumber.'6';
				break;
			case 'j':
				$actualNumber = $actualNumber.'7';
				break;
			case 'y':
				$actualNumber = $actualNumber.'8';
				break;
			case 'z':
				$actualNumber = $actualNumber.'9';
				break; 
		}
	}
	if(strlen($actualNumber) >= 10) { 
		$select_query="SELECT Campaign_Name FROM tbl_campaign_details WHERE Mobile_No='$actualNumber'";
		$select_res=mysqli_query($con,$select_query);
		if(mysqli_num_rows($select_res)==0)	{
			$insert_query= "INSERT INTO tbl_campaign_details (Campaign_Name, Campaign_Des, Mobile_No, Email) VALUES ('WhatsApp Campaign','', '$actualNumber','')";
			mysqli_query($con,$insert_query);
		}
	}
	
	
}


$curl='job-detail-postlogin.php'.'?loc='.$_GET['loc'].'&skills='.$_GET['sids'].'&jid='.$_GET['job_id'].'&uid='.$_GET['emp_id'];

if(isset($_POST['btn-login']))
{
	$email = trim($_POST['txtemail']);
	$upass = trim($_POST['txtupass']);
	$loginsql="SELECT * FROM `tbl_jobseeker` WHERE `JEmail`='$email'";
	$loginres=mysqli_query($con,$loginsql);
	$numrows=mysqli_num_rows($loginres);

	$login_data=mysqli_fetch_array($loginres);
	$dnd=$login_data['jdndstatus'];
if($numrows>0)
{
	if($user_login->login($email,$upass))
	{
		if($dnd=='2')
	    {
	    	$user_login->redirect('jobseeker-profile-update-password.php?dmsg=dmsg');
	    }
		else if($_GET['sids']=="")
		{
		$user_login->redirect('jobseeker-profile.php');
	    } 
	    else 
	    {   
	    	$user_login->redirect($curl);
	    }
	}
	if(!$user_login->login($email,$upass))
	{
		echo "<script lang='javascript'>alert('Email ID or password is wrong')</script>";
	}
}
	else
	{
	echo '<script lang="javascript">alert("Your email Id isn\'t registered with us or Please check your email id '.$user_login->login($email,$upass).'")</script>';
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Needyin - Top Job Hunting Site in India | Best Job Search Engine</title>
	<meta name="description" content="NeedyIn is an online job portal for Job seekers who are looking for a job Opportunities to relocate due to personal contingencies. Upload your resume to apply for job vacancies.">


  
    <?php //include "source.php"; ?>
	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-select.css">
<script type="text/javascript" src="js/custom.js"></script>
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/materialize.css">
<link rel="stylesheet" href="css/bootstrap-responsive-tabs.css">
<link rel="stylesheet" href="css/reset-styles.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/responsive.css">
<link rel="stylesheet" href="css/easy-responsive-tabs.css">

<link rel="stylesheet" href="css/recruiter.css">
<!--<link rel="stylesheet" href="css/jquery.mobile-1.4.5.min.css">-->


<!-- <script src="js-webshim/minified/polyfiller.js"></script>-->
 <script type="text/javascript" src="js/modernAlert.min.js"></script>
<!--/ modern alert -->
<!-- js includes -->
<script type="text/javascript" src="js/jquery.min.js"></script>
<!--<script type="text/javascript" src="js/image-scale.js"></script>-->
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrap-select.js"></script>

<script type="text/javascript" src="js/materialize.min.js"></script>
<!--<script type="text/javascript" src="js/jquery.bootstrap-responsive-tabs.min.js"></script>-->
<script type="text/javascript" src="js/html5shiv.min.js"></script>


<!-- data tables for bootstrap -->


</head>
<body>
    <?php
include_once("analyticstracking.php");
include "prelogin-header1.php"; ?>
      
        <main>

            <section class="signin">
                <div class="container">
                    <div class="row sign">
                        <div class="col-md-6 col-xs-12 col-md-offset-3 col-sm-8 col-sm-offset-2">
                            <div class="signin-main">
                                <div class="signin-in">
                                  
                                    <div id="signin">
                                   <?php  if($_GET['job_id']!="")
									{ ?>
									 <div class="visible-div2">
									    <p>Please login to view job details</p>
									</div> 
									<?php   } ?>
									
                                        <h1 class="h3 text-center flight">LOGIN FOR <span class="fbold txt-blue">JOB SEEKER </span></h1>
                                        <form class="login-form" method="POST">
										<?php
										if(isset($_GET['error']))
											{
												?>
												<div class='alert alert-success'>
												<button class='close' data-dismiss='alert'>&times;</button>
												<strong>Wrong Details!</strong> 
												</div>
												<?php
											}
												?>
                                            <div class="input-field">
                                               <label for="txtemail">E-mail ID</label>
                                                <input name="txtemail" id="txtemail"   type="text" class="validate"> 
                                            </div>
                                            <div class="input-field">
                                                <label for="txtupass">Password</label>
                                                <input id="txtupass"  name="txtupass"  type="password" class="validate" pattern = ".{6,}">
                                               
                                            </div>
                                            <div class="input-field loginbtns">
                                                <button class="btn waves-effect waves-light" type="submit" name="btn-login" onclick="return validate()"><i class="fa fa-sign-in" aria-hidden="true"></i> LOGIN </button>
                                                <a class="btn pull-right waves-effect waves-light" href="index.php">CANCEL</a>
                                            </div>
                                            <div class="input-field mob-input">
												<span class="pull-left">
												<a class="txt-black" href="#" onclick="forgot()">Forgot Password?</a>
												</span> 
												<span class="pull-right">Not a Member?
												<a href="signup-jobseekar.php" class="fbold"> Sign Up</a>
												</span> 
											</div>
                                        </form>
                                    </div>
                               
                                    <div id="forgotpw">
                                        <h3 class="h3 text-center flight">FORGOT <span class="fbold txt-blue">PASSWORD? </span></h3>
                                        <form class="login-form" method="post" action="#">
                                            <div class="input-field">
                                                <p class="text-justify pb15">Please enter your registered e-mail id to reset the password.</p>
                                            </div>
                                            <div class="input-field">
                                                <input id="last_name" type="email" name="last_name"  class="validate" >
                                                <label for="Email ID">E-mail Id</label>
                                            </div>
                                            <div class="input-field forgotpwbtn">
                                                      <input  type="submit" onclick="return fvalidate()" value="Submit" name="btn-jobseeker-reset-submit" class="btn pull-left">
                                                <button class="btn pull-right waves-effect waves-light"  name="action" onclick="showlogin()"> CANCEL </button>
                                            </div>
                                        </form>
                                    </div>
                         
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<script>
				function validate()
				{		
					var email=document.getElementById("txtemail").value;
					if(email=="")
					{
						alert("Please enter valid e-mail ID ");
						document.getElementById("txtemail").focus();
						return false;
					}
					if(!emailverify(email))
					{	
					document.getElementById("txtemail").focus();
					return false;		
					}
					var pwd=document.getElementById("txtupass").value;
					if(pwd=="")
					{
					alert("Please enter password.");
					document.getElementById("txtupass").focus();
					return false;
					}												
				}
				</script>
				<script>
				function fvalidate()
				{		
					
					var lemail=document.getElementById("last_name").value;
					if(lemail=="")
					{
						alert("Please enter e-mail ID ");
						document.getElementById("last_name").focus();
						return false;
					}
					if(!emailverify(lemail))
					{	
					document.getElementById("last_name").focus();
					return false;		
					}
					
				}
				</script>
            </section>
        </main>

</body>
<?php
session_start();
require_once 'class.user.php';
$user = new USER();
if($user->is_logged_in()!="")
{
$user->redirect('login.php');
}
if(!empty($_POST['last_name']))
{
if(isset($_POST['btn-jobseeker-reset-submit']))
{
	$email = $_POST['last_name'];
	$pwdresetquery=("SELECT * FROM `tbl_jobseeker` WHERE JEmail='$email'");
	$pwdresetqueryres=mysqli_query($con,$pwdresetquery);
	$pwdresetqueryrow = mysqli_fetch_array($pwdresetqueryres);	
	$jsname=ucfirst($pwdresetqueryrow['JFullName']);
	$sname=base64_encode($jsname);
	if(mysqli_num_rows($pwdresetqueryres) == 1)
	{
		$id = base64_encode($pwdresetqueryrow['JEmail']);
		$code = md5(uniqid(rand()));
	
		$stmt = $user->runQuery("UPDATE tbl_jobseeker SET JtokenCode=:token WHERE JEmail=:email");
		$stmt->execute(array(":token"=>$code,"email"=>$email));
                $siteurl="http://needyin.com"; 		
		$message="<table width='600' border='0' cellspacing='0' cellpadding='0' style='font-family:arial; margin:0 auto;'>
       
        <tr height='43px'>
            <td align='left' width='400px;' >
                    <a href='".$siteurl."' target='_blank'><img src='".$siteurl."/img/logo.png' width='198'></a>
               
            </td>
            <td align='right' width='300px;'>
                <table>
                    <tr height='70'>
                        <td align='center' style='padding-right:10px;'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/about_us.php' target='_blank'>About Us</a> |</td>
                        <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/contact.php' target='_blank'>Contact</a> |</td>
                       <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/js_forgot.php?sn=".$sname."&jsi=".$id."&jsc=".$code."' target='_blank'>View in web</a> 
		                </td>
                       
                    </tr>
                </table>
            </td>
        </tr>
        
        <tr>
                <td colspan='2' >
                              <div style='background:url(https://www.needyin.com/img/for-passw.png) no-repeat center 0; background-size: 597px 396px; height:245px; ' >
                              
                                      <div style='text-align: justify;font-size: 15px;padding: 20px; margin-left: 350px;   width: 210px;  color: white; padding-top: 45px; line-height: 18px;'> 
                                                Dear ".$jsname.",<br><br>
                                                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                            To change your password, we request you to click on the below link which will redirect you to set new password.<br><br><br>

                                            Thanks<br>
                                            Team Needyin. 
                                    </div>
                              </div>
                </td>
        </tr>
        <tr>
            <td colspan='2' style='background:#90bd14;' align='center'>
                <p style='font-size:15px; line-height:25px; color:#fff; padding:10px 0; margin:0;'><a href=".$siteurl."/reset-pw.php?id=".$id."&code=".$code.">Click here to set new password</a></p>
                <p style='font-size:20px; font-weight:bold; color:#fff; margin:0; padding-bottom:15px;  margin:0;'></p>
            </td> 
        </tr>
        <tr>
            <td height='5' colspan='2' align='center'>
            </td>
        </tr>
        <tr>
            <td colspan='2' style='background:#0274bb;' align='center'>
                <p style='font-size:14px; line-height:18px; color:#fff; padding:0 27px;'>In case of any support required, please contact  <a style='color:#fff; text-decoration:underline;' href='mailto:support@needyin.com '>support@needyin.com  </a> to set your password.</p>
            </td>
        </tr>
        
        </tr>
    </table>";
		$subject = "Needyin- Forgot Password";				
		$user->send_mail($email,$message,$subject);		
		echo "<script lang='javascript' >alert('A link has been sent your email to set a new password. Please check your mail');</script>";		 
	}
	else
	{
		echo "<script lang='javascript' >alert('Entered Email does not exist');</script>";
	}
}
}
?>
<script>
$.getJSON('https://ipinfo.io/json', function(data) {
  var nVer = navigator.appVersion;
var nAgt = navigator.userAgent;
var browserName  = navigator.appName;
var fullVersion  = ''+parseFloat(navigator.appVersion); 
var majorVersion = parseInt(navigator.appVersion,10);
var nameOffset,verOffset,ix;

// In Opera, the true version is after "Opera" or after "Version"
if ((verOffset=nAgt.indexOf("Opera"))!=-1) {
 browserName = "Opera";
 fullVersion = nAgt.substring(verOffset+6);
 if ((verOffset=nAgt.indexOf("Version"))!=-1) 
   fullVersion = nAgt.substring(verOffset+8);
}
// In MSIE, the true version is after "MSIE" in userAgent
else if ((verOffset=nAgt.indexOf("MSIE"))!=-1) {
 browserName = "Microsoft Internet Explorer";
 fullVersion = nAgt.substring(verOffset+5);
}
// In Chrome, the true version is after "Chrome" 
else if ((verOffset=nAgt.indexOf("Chrome"))!=-1) {
 browserName = "Chrome";
 fullVersion = nAgt.substring(verOffset+7);
}
// In Safari, the true version is after "Safari" or after "Version" 
else if ((verOffset=nAgt.indexOf("Safari"))!=-1) {
 browserName = "Safari";
 fullVersion = nAgt.substring(verOffset+7);
 if ((verOffset=nAgt.indexOf("Version"))!=-1) 
   fullVersion = nAgt.substring(verOffset+8);
}
// In Firefox, the true version is after "Firefox" 
else if ((verOffset=nAgt.indexOf("Firefox"))!=-1) {
 browserName = "Firefox";
 fullVersion = nAgt.substring(verOffset+8);
}
// In most other browsers, "name/version" is at the end of userAgent 
else if ( (nameOffset=nAgt.lastIndexOf(' ')+1) < 
          (verOffset=nAgt.lastIndexOf('/')) ) 
{
 browserName = nAgt.substring(nameOffset,verOffset);
 fullVersion = nAgt.substring(verOffset+1);
 if (browserName.toLowerCase()==browserName.toUpperCase()) {
  browserName = navigator.appName;
 }
}
// trim the fullVersion string at semicolon/space if present
if ((ix=fullVersion.indexOf(";"))!=-1)
   fullVersion=fullVersion.substring(0,ix);
if ((ix=fullVersion.indexOf(" "))!=-1)
   fullVersion=fullVersion.substring(0,ix);

majorVersion = parseInt(''+fullVersion,10);
if (isNaN(majorVersion)) {
 fullVersion  = ''+parseFloat(navigator.appVersion); 
 majorVersion = parseInt(navigator.appVersion,10);
}
var userAgent = window.navigator.userAgent,
      platform = window.navigator.platform,
      macosPlatforms = ['Macintosh', 'MacIntel', 'MacPPC', 'Mac68K'],
      windowsPlatforms = ['Win32', 'Win64', 'Windows', 'WinCE'],
      iosPlatforms = ['iPhone', 'iPad', 'iPod'],
      os = null;

  if (macosPlatforms.indexOf(platform) !== -1) {
    os = 'Mac OS';
  } else if (iosPlatforms.indexOf(platform) !== -1) {
    os = 'iOS';
  } else if (windowsPlatforms.indexOf(platform) !== -1) {
    os = 'Windows';
  } else if (/Android/.test(userAgent)) {
    os = 'Android';
  } else if (!os && /Linux/.test(platform)) {
    os = 'Linux';
  }

  var screenWidth = (window.innerWidth > 0) ? window.innerWidth : screen.width;
  
  var deviceType = (screenWidth > 500) ? "Desktop" : "Mobile";
//  console.log(deviceType);
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET", "ipaddress.php?ip="+data.ip+"&city="+data.city+"&country="+data.country+"&latitude="+data.latitude+"&longitude="+data.longitude+"&browser="+browserName+"&os="+os+"&deviceType="+deviceType, true);
        xmlhttp.send();
});

</script>											
</html>