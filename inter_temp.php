<?php require_once 'dbconfig.php';
$message=base64_decode($_GET['message']);
$companyname=base64_decode($_GET['companyname']);
$Desig_Name=base64_decode($_GET['Desig_Name']);
$loc_name=base64_decode($_GET['loc_name']);
$dates=base64_decode($_GET['dates']);
$hours=base64_decode($_GET['hours']);
$mins=base64_decode($_GET['mins']);
?>
 <table width='750' border='0' cellspacing='0' cellpadding='0' style='font-family:arial; margin:0 auto;'>
       
        <tr height='43px'>
                <td align='left' width='750' >
                        <a href='<?php echo $siteurl;?>' target='_blank'><img src='<?php echo $siteurl;?>/img/logo.png' width='198'></a>
                </td>
                <td align='right' width='300px;'>
                    <table>
                        <tr height='70'>
                            <td align='center' style='padding-right:10px;'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='<?php echo $siteurl;?>/about_us.php' target='_blank'>About Us</a> |</td>
                            <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='<?php echo $siteurl;?>/contact.php' target='_blank'>Contact</a> </td>
                            <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='' target='_blank'></a> </td>
                           
                        </tr>
                    </table>
                </td>
        </tr>
  <tr>
                <td colspan='2' style='background:#90bd14;' align='center'>
                    <p style='font-size:15px; line-height:25px; color:#fff; padding:10px ; text-align: justify;'>Dear Job Seeker,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Your profile is schedled for the interview with the recuiter/ client/ Company in this week. You are hereby required to be avaiable for the interview. Following are the interview schedule details for your ready reference. 
</p>
                </td>
        </tr>
        <tr>
                <td style='height:15px;'>
                </td>
        </tr>
        <tr height='320px'>
                <td colspan='2'   style='background:url(<?php echo $siteurl;?>/img/schedule8.png) no-repeat center 0;'>
                
                        <div style='color:white; float:left;margin-bottom: 176px;margin-left: 140px; padding-top: 15px; font-size:14px; width:200px;'>
						<?php echo $message; ?> 
					  
                        </div>
                        <div style='color:white; float:right; margin-right: 183px; margin-bottom: 28px; margin-top: -11px;   font-size:14px;'>
                         Inteview Date: <?php echo $dates; ?> <br>
						 Interview Time: <?php echo "$hours:$mins"; ?> <br>
                           Inteview Venue : <?php echo $loc_name; ?>
 
						
                         
                        </div>
                         <div style='color:white; float:right; margin-right: 150px; margin-bottom: 20px;   font-size:14px;'>
						Company Name:<?php echo $companyname;?><br>
						Job Name: <?php echo $Desig_Name; ?>
                        </div>
                
				</td>
		</tr>		
				
     
            
        <tr>
            <td height='10' colspan='2' align='center'>
               <p style='font-size:15px; line-height:22px; color:#333; padding:0 10px; margin:0;'></p>
            </td>
        </tr>
    <tr>
            <td colspan='2' style='background:#0274bb;' align='center'>
                <p style='font-size:13px; line-height:20px; color:#fff; '>You have received this mail because your e-mail ID is registered with Needyin.com. This is a system-generated e-mail regarding your Needyin account preferences, please don't reply to this message.</p>
            </td>
        </tr>
        
        </tr>
    </table>