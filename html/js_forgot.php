<?php require_once 'dbconfig.php';
$jname=ucfirst(base64_decode($_GET['sn']));
        $id=$_GET['jsi'];
        $code=$_GET['jsc'];
$siteurl="https://needyin.com"; ?>
 <table width='750' border='0' cellspacing='0' cellpadding='0' style='font-family:arial; margin:0 auto;'>
       
        <tr height='43px'>
            <td align='left' width='400px;' >
                    <a href='<?php echo $siteurl;?>' target='_blank'><img src='<?php echo $siteurl;?>/img/logo.png' width='198'></a>
               
            </td>
            <td align='right' width='300px;'>
                <table>
                    <tr height='70'>
                        <td align='center' style='padding-right:10px;'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='<?php echo $siteurl;?>/about_us.php' target='_blank'>About Us</a> |</td>
                        <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='<?php echo $siteurl;?>/contact.php' target='_blank'>Contact</a></td>
                       
                       
                    </tr>
                </table>
            </td>
        </tr>
        
        <tr>
                <td colspan='2' >
                              <div style='background:url(<?php echo $siteurl;?>/img/for-passw.png) no-repeat center 0; background-size: 750px 550px; height:350px; ' >
                              
                                      <div style='text-align: justify;font-size: 15px;padding: 20px; margin-left: 445px;   width: 285px;  color: white; padding-top: 70px; line-height: 18px;'> 
                                                Dear <?php echo $jname;?>,<br><br>
                                                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                           This Email is in reference to your request change in password of your account. To change your password, we request you to click on the below link which will redirect you to the password reset process.<br><br><br>

                                            Thanks<br>
                                            Team Needyin. 
                                    </div>
                              </div>
                </td>
        </tr>
        <tr>
            <td colspan='2' style='background:#90bd14;' align='center'>
                <p style='font-size:15px; line-height:75px; color:#fff; padding:10px 0; margin:0;'><a href='<?php echo $siteurl.'/'.'reset-pw.php?id='.$id.'&code='.$code?>'>Click here to set new password</a></p>
                <p style='font-size:20px; font-weight:bold; color:#fff; margin:0; padding-bottom:15px;  margin:0;'></p>
            </td> 
        </tr>
        <tr>
            <td height='10' colspan='2' align='center'>
                <!--<p style='font-size:15px; line-height:22px; color:#333; padding:0 10px; margin:0;'></p>-->
            </td>
        </tr>
        <tr>
            <td colspan='2' style='background:#0274bb;' align='center'>
                <p style='font-size:14px; line-height:30px; color:#fff; padding:0 27px;'>In case of any support required, please contact  @ <a style='color:#fff; text-decoration:underline;' href='mailto:support@needyin.com '>support@needyin.com  </a> to set your password.</p>
            </td>
        </tr>
        
        </tr>
    </table>"