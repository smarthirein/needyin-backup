<?php require_once 'dbconfig.php';
$uname=ucfirst(base64_decode($_GET['jsn']));
$id=$_GET['jsi'];
$code=base64_decode($_GET['jsc']);
  $siteurl="http://needyin.com"; 
?>
<table width='750' border='0' cellspacing='0' cellpadding='0' style='font-family:arial; margin:0 auto;'>
                             <tr height='43'>
						            <td align='left' width='750' >
						                    <a href='<?php echo $siteurl;?>' target='_blank'><img src='<?php echo $siteurl;?>/img/logo.png' width='198'></a>
						               
						            </td>
						            <td align='right' width='750'>
						                <table>
						                    <tr height='70'>
						                        <td align='center' style='padding-right:10px;'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='<?php echo $siteurl;?>/about_us.php' target='_blank'>About Us</a> |</td>
						                        <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='<?php echo $siteurl;?>/contact.php' target='_blank'>Contact</a> 
						                       
						                    </tr>
						                </table>
						            </td>
       						 </tr>
        					 <tr>
								            <td  width='750'colspan='2' style='background:url(<?php echo $siteurl;?>/img/thankyou_img.png) no-repeat center 0; background-size: 750px 402px; height:375px;' >
								              <div style='padding: 15px; text-align: justify; margin-left: 405px; margin-top: 16px;width: 175px;  padding-left: 10px; font-size:14px;'>
								                   Dear <?php echo $uname;?>,<br><br>
								              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You have sucessfully registered your account with us. To complete your registration process, please click on the below link to validate your account for your account security. 
								              </div>
								              
								            </td>
       						 </tr>
					        <tr>
					            <td colspan='2' style='background:#90bd14;  height: 115px;' align='center'>
					                <p style='font-size:15px; line-height:25px; color:#fff; padding:10px 0; margin:0;'>To complete your registration process, please click on the below link to validate your account.</p>
					                <p style='font-size:20px; font-weight:bold; color:#fff; margin:0; padding-bottom:15px;  margin:0;'>Click here : <a href='<?php echo $siteurl.'/'.'verify.php?id='.$id.'&code='.$code?>'>Register me</a></p>
					            </td>
					        </tr>
					        <tr>
					            <td height='10' colspan='2' align='center'>
					                <!--<p style='font-size:15px; line-height:22px; color:#333; padding:0 10px; margin:0;'></p>-->
					            </td>
					        </tr>
					        <tr>
					            <td colspan='2' style='background:#0274bb; height: 55px;' align='center'>
					                <p style='font-size:13px; line-height:16px; color:#fff; '>You have received this mail because your e-mail ID is registered with Needyin.com. This is a system-generated e-mail regarding your Needyin account preferences, please don't reply to this message.</p>
					            </td>
					        </tr>
    
    </table>