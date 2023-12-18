<?php require_once 'dbconfig.php';
$jname=base64_decode($_GET['jname']);
$jobnames=base64_decode($_GET['jobnames']);
$job_names=explode(",",$jobnames);
$joblocations=base64_decode($_GET['joblocations']);
$job_locations=explode(",",$joblocations);
$jcomp=base64_decode($_GET['jcomp']);
?>
 <table width='750' border='0' cellspacing='0' cellpadding='0' style='font-family:arial; margin:0 auto;'>
       
        <tr height='43px'>
                <td align='left' width='750' >
                        <a href='<?php echo $siteurl ?>' target='_blank'><img src='<?php echo $siteurl ?>/img/logo.png' width='198'></a>
                </td>
                <td align='right' width='300px;'>
                    <table>
                        <tr height='70'>
                            <td align='center' style='padding-right:10px;'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='<?php echo $siteurl ?>/about_us.php' target='_blank'>About Us</a> |</td>
                            <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='<?php echo $siteurl ?>/contact.php' target='_blank'>Contact</a> </td>
                            <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='' target='_blank'></a> </td>
                           
                        </tr>
                    </table>
                </td>
        </tr>
         <tr>
                <td colspan='2' style='background:#90bd14;' align='center'>
                    <p style='font-size:15px; line-height:25px; color:#fff; padding:10px ; text-align: justify;'>Dear <?php echo  $jname;?>,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Congratulations!!! Your profile is short-listed for the below position and your current profile information as seen by recruiters:
 </p>
                </td>
        </tr>
        <tr>
                <td style='height:15px;'>
                </td>
        </tr>
        <tr height='320px'>
                <td colspan='2'   style='background:url(<?php echo $siteurl ?>/img/schedule8.png) no-repeat center 0;background-size: 750px 375px; height:375px;'>
                
                        <div style='color:white; float:left;margin-bottom: 150px;margin-left: 60px; padding-top: 15px; font-size:14px; width:200px;'>
                        
                         Your profile is short-listed.
                        </div>
                        <div style='color:white; float:right; margin-right: 175px; margin-top: -60px; font-size:14px;'>
                        <?php 
                        foreach($job_names as $jobname)
                                   { ?> Job Name&nbsp;&nbsp;: <?php echo $jobname;
                                   }?>
                                 <br>
                        
                        </div>
                         <div style='color:white; float:right; margin-right: 140px; margin-top: 50px;   font-size:14px;'>
                           Company Name&nbsp;: <?php echo  $jcomp;?> <br>
                            
                           <?php 
                        foreach($job_locations as $jobloc)
                                   { ?> Job Location&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $jobloc;
                                   }?>

                        </div>
                
				</td>
		</tr>		
		
    <tr>
            <td colspan='2' style='background:#0274bb;' align='center'>
                <p style='font-size:13px; line-height:20px; color:#fff; '>You have received this mail because your e-mail ID is registered with Needyin.com. This is a system-generated e-mail regarding your Needyin account preferences, please don't reply to this message.</p>
            </td>
        </tr>
        
       
    </table>