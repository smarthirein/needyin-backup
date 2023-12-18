<?php require_once 'dbconfig.php';
$jsname=base64_decode($_GET['jsname']);
$jobname=base64_decode($_GET['jobname']);
$cmpname=base64_decode($_GET['cmpname'])
?>
<table width='600' border='0' cellspacing='0' cellpadding='0' style='font-family:arial; margin:0 auto;'>
       
        <tr height='43px'>
                <td align='left' width='400px;' >
                        <a href='<?php echo $siteurl;?>' target='_blank'><img src='<?php echo $siteurl ?>/img/logo.png' width='198'></a>
                </td>
                <td align='right' width='300px;'>
                    <table>
                        <tr height='70'>
                            <td align='center' style='padding-right:10px;'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='<?php echo $siteurl ?>/about_us.php' target='_blank'>About Us</a> |</td>
                            <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='<?php echo $siteurl ?>/contact.php' target='_blank'>Contact</a> </td>
                            
                           
                        </tr>
                    </table>
                </td>
        </tr>
         <tr>
               <td colspan='2' style='background:#90bd14;' align='center'>
                    <p style='font-size:15px; line-height:20px; color:#fff; padding:5px ; text-align: justify;'>Dear <?php echo $jsname;?>,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;We have identified one job posted matching you profile with your preferred criterias. </p>
                </td>
        </tr>
        <tr>
                <td style='height:15px;'>
                </td>
        </tr>
        <tr height='370'>
                <td colspan='2'   style='background:url(<?php echo $siteurl; ?>/img/notif.png) no-repeat center 0;'>
                <table style='margin-bottom: 185px; width: 400px; margin-left: 60px;'>
                        <tr >
                            <td align='center'>
                            <p style='padding-right:10px;font-size:14px; color:white; text-decoration:none;width:120px; '>One New job is posted match with your Profile.  </p></td>


                            <td align='center'>
                            <p style='font-size:14px; margin-left: 45px; color:white;;width:120px; text-decoration:none;'>  
                            Job Name : <?php echo $jobname;?></br>
                            Company Name : <?php echo $cmpname;?></p></td>

                            <td   align='center' ><p style='font-size:14px; color:white; width:120px; text-decoration:none;margin-left: 50px;'>To view job details please click on the link below<br><br><a href='<?php echo $siteurl;?>'>NeedyIn </a></p>
	                      </td>
                           
                        </tr>
                    </table>
                    
                </td>
        </tr>       
                
     
            
        <tr>
            <td height='10' colspan='2' align='center'>
               <p style='font-size:15px; line-height:22px; color:#333; padding:0 10px; margin:0;'></p>
            </td>
        </tr>
    <tr>
            <td colspan='2' style='background:#0274bb;' align='center'>
                <p style='font-size:13px; line-height:30px; color:#fff; '>You have received this mail because your e-mail ID is registered with Needyin.com. This is a system-generated e-mail regarding your Needyin account preferences, please dont reply to this message.</p>
            </td>
        </tr>
        
        </tr>
    </table>
                