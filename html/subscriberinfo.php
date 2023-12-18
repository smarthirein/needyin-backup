<?php 
session_start();
require_once 'class.user.php';
$reg_user = new USER();

if(isset($_POST['Subs']))
{
			
				$email=$_POST['subcribe-email'];
				$current_page=$_POST['current_page'];

				$sql="select email from subscriber where email='".$email."'";
				$sql_res=mysqli_query($con,$sql);
				$sql_data=mysqli_fetch_array($sql_res);
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
		{
			echo '<script type="text/javascript">alert("Please enter valid email");</script>';
			
		}
				if(empty($email))
				{?>
							<script>alert("Please give  email");history.go(-1);</script>
				<?php 
					
					
				}
				if($email==$sql_data['email'])
				{ ?>
							<script>alert("Already Subscribed with this Email Id");
                            var cpage='<?php echo $current_page;?>';
							window.location.href = cpage;</script>
				<?php 	}
				else 
				{
							$message="<table width='600' border='0' cellspacing='0' cellpadding='0' style='font-family:arial; margin:0 auto;'>
                             <tr height='43px'>
						            <td align='left' width='400px;' >
						                    <a href='".$siteurl."' target='_blank'><img src='".$siteurl."/img/logo.png' width='198'></a>
						               
						            </td>
						            <td align='right' width='300px;'>
						                <table>
						                    <tr height='70'>
						                        <td align='center' style='padding-right:10px;'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/about_us.php' target='_blank'>About Us</a> |</td>
						                        <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/contact.php' target='_blank'>Contact</a> |
						                        </td>
						                       
						                        <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/js_subscribe.php' target='_blank'>View in web</a> 
						                       
						                    </tr>
						                </table>
						            </td>
       						 </tr>
        					 <tr>
								            <td colspan='2' style='background:url(".$siteurl."/img/thankyou_img.png) no-repeat center 0; height:335px;' >
								              <div style='padding: 15px; text-align: justify; margin-left: 311px; margin-top: 16px; width: 175px;font-size: 13px; padding-left: 10px;'>
								                   Dear Subscriber,<br><br>
								              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Thanks for subscribing with needyin.com. We are available to take care of your requirements and created a platform to balance your personal and profesional life with haseel free. 
								              </div>
								              
								            </td>
       						 </tr>
					        <tr>
					            <td colspan='2' style='background:#90bd14;' align='center'>
					                <p style='font-size:15px; line-height:25px; color:#fff; padding:10px 0; margin:0;'>For any support or queries, please send a mail to support@needyin.com. Our team will revert you back with the required assistance.</p>
					               
					            </td>
					        </tr>
					        <tr>
					            <td height='10' colspan='2' align='center'>
					                <!--<p style='font-size:15px; line-height:22px; color:#333; padding:0 10px; margin:0;'></p>-->
					            </td>
					        </tr>					      
    
    </table>";

							$subject = "Subscription";							
							$ok=$reg_user->send_mail($email,$message,$subject);	                         

							$insert_edu = "INSERT INTO subscriber SET email='".$email."'";
							$edu= mysqli_query($con,$insert_edu);

							if($edu!=0)
							{ ?>		<script>alert("Thanks for subscribing with us");
						                var cpage='<?php echo $current_page;?>';
						                window.location.href = cpage;</script>
							<?php  }

							
							else { ?><script>alert("Please try again once");
                                     var cpage='<?php echo $current_page;?>';
							         window.location.href = cpage;</script>
							<?php 	}	
						
				}	
}
?>
