<?php
if(isset($_POST['forgot-password']))
{
	$email = $_POST['email'];
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
}?>