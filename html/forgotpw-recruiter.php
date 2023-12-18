<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with Needyin</title>
   
    <?php include"source.php" ?>
</head>

<body>
    <?php
	include_once("analyticstracking.php");
	include"includes-recruiter/prelogin-header-recruiter.php"; ?>
       
        <main>
           
            <section class="signin signin-rec">
                <div class="container">
                    <div class="row sign">
                        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                            <div class="signin-main">
                                <div class="signin-in">
                                    <!-- forgot password -->
                                    <div id="forgotpw-rec">
                                        <h3 class="h3 text-center flight">FORGOT <span class="fbold txt-blue">PASSWORD? </span></h3>
                                        <form class="login-form" method="post" action="#">
                                            <div class="input-field">
                                                <p class="text-justify pb15">Please enter your registered e-mail id to reset the password.</p>
                                            </div>
                                            <div class="input-field">
                                                <input id="last_name" name="last_name" type="email" class="validate"  required>
                                                <label for="Email ID">Email Id</label>
                                            </div>
                                            <div class="input-field forgotpwbtn">
                                               <input type="submit" value="Submit" onclick="return emailvalidate()" name="btn-reset-submit" class="btn pull-left">
                                               <a class="btn pull-right" href="index-recruiter.php"> CANCEL </a>                                               
                                            </div>
                                        </form>
                                    </div>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<script lang="javascript">
				function emailvalidate()
				{
				var email=document.getElementById('last_name').value;
            	if(email=="")
            	{
            		alert("Please Enter Your email");
            		document.getElementById('last_name').focus();
            		return false;
            	}
				if(!emailverify(email))
				{
					document.getElementById('last_name').focus();
            		return false;
					
				}
				}
				</script>
            </section>
          
        </main>
      
        <?php include"footer.php"; ?>
</body>
<?php
require_once 'class.user.php';
$user = new USER();

if($user->is_logged_in()!="")
{
	$user->redirect('login.php');
}
if(isset($_POST['btn-reset-submit']))
{
if(!empty($_POST['last_name']))
{

	$email = $_POST['last_name'];
	
	/*$pwdresetquery=("SELECT * FROM `tbll_emplyer` WHERE emp_email='$email'");
	$pwdresetqueryres=mysqli_query($con,$pwdresetquery);
	$pwdresetqueryrow = mysqli_fetch_array($pwdresetqueryres);*/
	
	/*$stmt = $user->runQuery("SELECT * FROM `tbll_emplyer` emp_email=:email");
	$stmt->execute(array(":email"=>$email));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);	*/
	$pwdresetquery="SELECT * FROM tbll_emplyer WHERE emp_email='".$email."'";
	$pwdresetqueryres=mysqli_query($con,$pwdresetquery);
	$pwdresetqueryrow = mysqli_fetch_array($pwdresetqueryres);
	$jscompanyname = $pwdresetqueryrow['companyname'];
	$js_com_name = base64_encode($jscompanyname);
	
	if(mysqli_num_rows($pwdresetqueryres) == 1)
	{
		$id = base64_encode($pwdresetqueryrow['emp_id']);
		$code = md5(uniqid(rand()));
	
		
		$codequery="UPDATE tbll_emplyer SET emp_code='$code' WHERE emp_email='$email'";
		$codequeryres=mysqli_query($con,$codequery);
		
                $siteurl="http://needyin.com"; 
		
		$message= "<table width='600' border='0' cellspacing='0' cellpadding='0' style='font-family:arial; margin:0 auto;'>
       
        <tr height='43px'>
            <td align='left' width='400px;' >
                    <a href='".$siteurl."' target='_blank'><img src='".$siteurl."/img/logo.png' width='198'></a>
               
            </td>
            <td align='right' width='300px;'>
                <table>
                    <tr height='70'>
                        <td align='center' style='padding-right:10px;'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/about_us.php' target='_blank'>About Us</a> |</td>
                        <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/contact.php' target='_blank'>Contact</a> </td>
                       <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/emp_forgotviw.php?id=".$id."&js_com_name=".$js_com_name."&jsc=".$code."' target='_blank'>View in web</a> 
						</td>
                       
                    </tr>
                </table>
            </td>
        </tr>
        
        <tr>
                <td colspan='2' >
                              <div style='background:url(".$siteurl."/img/for-passw.png) no-repeat center 0; background-size: 597px 396px; height:245px; ' >
                              
                                      <div style='text-align: justify;font-size: 14px;padding: 20px; margin-left: 330px;   width: 187px;  color: white; padding-top: 45px; line-height: 18px;'> 
                                                Dear ".$jscompanyname.",<br>
                                                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                          To change your password, we request you to click on the below link which will redirect you to set new password.<br><br>

                                            Thanks<br>
                                            Team Needyin. 
                                    </div>
                              </div>
                </td>
        </tr>
        <tr>
            <td colspan='2' style='background:#90bd14;' align='center'>
                <p style='font-size:15px; line-height:25px; color:#fff; padding:10px 0; margin:0;'><a href=".$siteurl."/reset-pw-rec.php?id=".$id."&code=".$code.">Click here to set new password</a></p>
                <p style='font-size:20px; font-weight:bold; color:#fff; margin:0; padding-bottom:15px;  margin:0;'></p>
            </td> 
        </tr>
        <tr>
            <td height='5' colspan='2' align='center'>
                <!--<p style='font-size:15px; line-height:22px; color:#333; padding:0 10px; margin:0;'></p>-->
            </td>
        </tr>
        <tr>
            <td colspan='2' style='background:#0274bb;' align='center'>
                <p style='font-size:14px; line-height:18px; color:#fff; padding:0 27px;'>In case of any support required, please contact at <a style='color:#fff; text-decoration:underline;' href='mailto:support@needyin.com '>support@needyin.com  </a> to set your password.</p>
            </td>
        </tr>
        
        </tr>
    </table>";
		$subject = "Password Reset";
		
		
		$user->send_mail($email,$message,$subject);
		
		echo "<script lang='javascript' >alert('A link has been sent to your email regarding resetting password , please check your mail!!');</script>";
		 
	}
	else
	{
		echo "<script lang='javascript' >alert('Entered email does not exist');</script>";
	}
}
}
?>
</html>