<?php
$message=base64_decode($_GET['mess']);
$js_name=base64_decode($_GET['name']);
$company_name=base64_decode($_GET['comname']);
$siteurl="http://needyin.com"; 
?>

 <table width='750' border='0' cellspacing='0' cellpadding='0' style='font-family:arial; margin:0 auto;'>
                             <tr height='43'>
						            <td align='left' width='750' >
						                    <a href='https://www.needyin.com' target='_blank'><img src='img/logo.png' width='198'></a>
						               
						            </td>
						            <td align='right' width='750'>
						                <table>
						                    <tr height='70'>
						                        <td align='center' style='padding-right:10px;'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='https://www.needyin.com/about_us.php' target='_blank'>About Us</a> |</td>
						                        <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='https://www.needyin.com/contact.php' target='_blank'>Contact</a> 
						                        </td>
						                       
						                       
						                    </tr>
						                </table>
						            </td>
       						 </tr>
        					 <tr>
								            <td  width='750'colspan='2' style='background:url(img/thankyou1.png) no-repeat center 0; background-size: 750px 402px; height:375px;' >
								              <div style='padding: 15px; text-align: justify; margin-left: 405px; margin-top: 16px;width: 175px;  padding-left: 10px; font-size:14px;'>
								                   Dear <?php echo $js_name;?>,<br><br>
								               Following message for you:<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $message;?><br><br>
											  
											<strong>  Thanks<br>
												<?php echo $company_name;?></strong>
								              </div>
								              
								            </td>
       						 </tr>
					        <tr>
					             <td colspan='2' style='background:#90bd14;' align='center'>
					              
					                <p style='font-size:25px; font-weight:bold; color:#fff; margin:0; padding-bottom:15px;  margin:0;'>
									<br>
									<a href="https://needyin.com">Needyin.com </a></p>
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