 <?php 
session_start();
require_once 'class.user.php';
$user_obj = new USER();

$skills=$_POST['secskills'];
$skill_query="SELECT pri_skills from tbl_jobseeker where JUser_Id='".$_SESSION['userSession']."' ";
$skill_res=mysqli_query($con,$skill_query);
$skill_row=mysqli_fetch_array($skill_res);
$primary_skills=explode(",",$skill_row['pri_skills']); 
if(array_intersect($skills,$primary_skills)){?>
	<script language="javascript">alert("Can't have primary and secondary skills same.");
	window.location.href="jobseeker-profile.php"; </script>
<?php
}
else
{

$newskills=$_POST['newsecskill'];
if($newskills!='')
{
$master_query = "INSERT into tbl_masterskills SET  skill_Name='".$newskills."',skill_Status=1"; 
$mq1 = mysqli_query($con,$master_query);
$skill1="select skill_Id from tbl_masterskills where skill_Name='".$newskills."' ";
$q_sk=mysqli_query($con,$skill1);
$sk_data=mysqli_fetch_array($q_sk);
$sk_Id=$sk_data['skill_Id'];
$skill_ids1=implode(",",$skills);
$add_skills=$skill_ids1.','.$sk_Id;
$newsk=explode(",",$add_skills);
array_shift($newsk);
//$skill_ids=implode(",",$newsk); 
$askills=implode(",",$newsk); 
$pri_skills=implode(",",$primary_skills); 
$skill_ids=$askills.",".$pri_skills;
}
else
{ //$skill_ids=implode(",",$skills);
 $askills=implode(",",$skills); 
$pri_skills=implode(",",$primary_skills); 
$skill_ids=$askills.",".$pri_skills;
}
if($skill_ids!=$pre_skills)
{
		$user_query="select JFullName,JPLoc_Id,JEmail from tbl_jobseeker where JUser_Id=".$_SESSION['userSession'];
		$user_res=mysqli_query($con,$user_query);
		$user_data=mysqli_fetch_array($user_res);
		$user_email=$user_data['JEmail'];
		$user_name=ucfirst($user_data['JFullName']);

		$csal="select * from tbl_currentexperience where JUser_Id=".$_SESSION['userSession'];
        $csal_res=mysqli_query($con,$csal);
        $csal_data=mysqli_fetch_array($csal_res);
		foreach($skills as $skill)
             {
			      $cj2="select Job_Id,Job_Skill from tbl_jobposted where Loc_Id='".$user_data['JPLoc_Id']."' and Sal_Range<='".$csal_data['ExpSalL']."' and  FIND_IN_SET('".$skill."', Job_Skill) ";
                  $resultcj2 = mysqli_query($con,$cj2);  
                  while($result_cj2=mysqli_fetch_array($resultcj2))
                  {
                         $job_ids[]=$result_cj2['Job_Id'];
                         $skillids[]=$result_cj2['Job_Skill'];
                  }
            } 
		$jobs=array_unique($job_ids);
					foreach($jobs as $job)
					{
						$cj3="select emp_id from tbl_jobposted where Job_Id='".$job."'";
						$resultcj3 = mysqli_query($con,$cj3);  
						$result_cj3=mysqli_fetch_array($resultcj3); 
						$description="Dear Bhavana,<br>
						To keep you posted, xxxxxx has changed his/ her skill sets/ Location. Pls. click on below link to view his/ her details<br>
						Link:<br>
			 <a href='https://www.needyin.com/'>Needyin</a><br>				
							Thanks<br>
							Team Needyin.";
						        
						$insert_query = "INSERT into tbl_notifications SET  job_id='".$job."',description='".$description."',job_owner_id='".$result_cj3['emp_id']."',profile_id='".$_SESSION['userSession']."',notification_to='".$job."',notification_from='".$_SESSION['userSession']."',mode='jobseeker'"; 
						$rr1 = mysqli_query($con,$insert_query);
						$emp_query="select emp_email from tbll_emplyer where emp_id=".$result_cj3['emp_id'];
						$emp_res=mysqli_query($con,$emp_query);
						$emp_data=mysqli_fetch_array($emp_res);
						$emp_email=$emp_data['emp_email'];
						$subject="Needyin- Update of Jobseeker skills";
						//$mm=$user_obj->send_mail2($emp_email,$description,$subject);
						
					}
				}
       $user_update_query = "UPDATE tbl_jobseeker SET Sec_Skills='".$askills."',Job_Skills='".$skill_ids."' where JUser_Id='".$_SESSION['userSession']."' "; 
        $rr = mysqli_query($con,$user_update_query);
	$username = base64_encode($user_name);
		  if($rr!="")
		  {
		  	$subject="Needyin- Your Skill Updates";
	
             $message="<table width='600' border='0' cellspacing='0' cellpadding='0' style='font-family:arial; margin:0 auto;'>
       
        <tr height='43px'>
            <td align='left' width='400px;' >
                    <a href='https://www.needyin.com/' target='_blank'><img src='https://www.needyin.com/img/logo.png' width='198'></a>
               
            </td>
            <td align='right' width='300px;'>
                <table>
                    <tr height='70'>
                        <td align='center' style='padding-right:10px;'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='https://www.needyin.com/about_us.php' target='_blank'>About Us</a> |</td>
                        <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='https://www.needyin.com/contact.php' target='_blank'>Contact</a> |</td>
                        <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='https://www.needyin.com/current_skillsv.php?name=".$username."' target='_blank'>View in web</a> </td>
                       
                    </tr>
                </table>
            </td>
        </tr>
        
        <tr>
            <td colspan='2' style='background:url(https://www.needyin.com/img/thankyou_img.png) no-repeat center 0; height:335px;' >
            
              <div style='padding: 10px; text-align: justify; margin-left: 297px; margin-right: 10px; margin-top: 3px;transform: rotate(-28deg) !important; width: 200px;'><font color=#000000> Dear ".$user_name.",<br>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;we have noticed that, you recently made changes to your skills. We will keep you posted with the matching jobs as per the changes made, please click on the below link to view your details.
				  Link:<a href=".$siteurl."/js_activities.php?uid=".$_SESSION['userSession']."></font>

              </div>
              
            </td>
        </tr>
        
        <tr>
            <td height='10' colspan='2' align='center'>
                <!--<p style='font-size:15px; line-height:22px; color:#333; padding:0 10px; margin:0;'></p>-->
            </td>
        </tr>
        <tr>
            <td colspan='2' style='background:#0274bb;' align='center'>
                <p style='font-size:15px; line-height:25px; color:#fff; padding:0 50px;'>You have received this mail because your e-mail ID is registered with Needyin.com. This is a system-generated e-mail regarding your Needyin account preferences, please don't reply to this message.</p>
            </td>
        </tr>
        
        </tr>
    </table>";
   
		  	$mm2=$user_obj->send_mail2($user_email,$message,$subject);
		?>
		<script>
		alert("Your Skills Succesfully Updated");
		window.location.href="jobseeker-profile.php";
		</script>

		<?php }
}		   
 ?>
      