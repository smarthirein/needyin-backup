<?php
require_once("config.php");
require_once 'class.user.php';
$reg_user = new USER();
if(isset($_POST['apply']))
{
			$juserid=$_POST['juserid'];
			$empid=$_POST['empid'];
			$jobid=$_POST['jobid'];
			$minexp=$_POST['minexp'];
			$maxexp=$_POST['maxexp'];
			 $current_page=$_POST['current_page']; 
              $ss="select JPLoc_Id,Job_Skills,JTotalEy from tbl_jobseeker where JUser_Id=".$juserid;
                 $ss_res=mysqli_query($con,$ss);
                 $ss_data=mysqli_fetch_array($ss_res);
                  $loc=$ss_data['JPLoc_Id']; 
                  $prof_skills=$ss_data['Job_Skills'];
	 			$js_exp=$ss_data['JTotalEy'];
                  $jobseeker_skills=explode(",",$prof_skills);

              $rr="select Loc_Id,Job_Skill,Min_Exp,Max_Exp,Job_Name from tbl_jobposted  where Job_Status='1' and Job_Id=".$jobid;
                 $rr_res=mysqli_query($con,$rr);
                 $rr_data=mysqli_fetch_array($rr_res);
                 $job_loc=$rr_data['Loc_Id']; 
                 $jb_skills=$rr_data['Job_Skill']; 

               $yy="select ExpSalL,ExpMaxSalL from tbl_currentexperience where JUser_Id=".$juserid;
               $yy_res=mysqli_query($con,$yy);
               $sal_data=mysqli_fetch_array($yy_res);

               $nri="select country from  tbl_address where user_id=".$juserid;
               $nri_res=mysqli_query($con,$nri);
               $nri_data=mysqli_fetch_array($nri_res);

               if($nri_data['country']!='101')
               {
                    	foreach($jobseeker_skills as $js_skill)
		                {
	               			$aa="select emp_id from tbl_jobposted, tbl_currentexperience as js where Job_Status='1' and FIND_IN_SET('".$js_skill."', Job_Skill) and ((js.ExpSalL between Sal_Range and MSal_Range ) or (js.ExpMaxSalL between Sal_Range and MSal_Range)) and Job_Id='$jobid' and js.JUser_Id='$juserid'";
	                	    $aa_res=mysqli_query($con,$aa);
	                	    $aa_data=mysqli_fetch_array($aa_res);
	                	    $emp_ids[]=$aa_data['emp_id'];
                	   }
               }
                else
                {
		                foreach($jobseeker_skills as $js_skill)
		                {
		            

		                	$aa="select emp_id from tbl_jobposted, tbl_currentexperience as js where Job_Status='1' and  FIND_IN_SET('".$js_skill."', Job_Skill) and tbl_jobposted.Loc_Id='".$loc."' and (js.ExpSalL between Sal_Range and MSal_Range ) or (js.ExpMaxSalL between Sal_Range and MSal_Range) and js.JUser_Id='$juserid' and Job_Id='".$jobid."'"; 

		                	$aa_res=mysqli_query($con,$aa);
		                	$aa_data=mysqli_fetch_array($aa_res);
		                	$emp_ids[]=$aa_data['emp_id'];
		                } 
              }
	
                 $empids=array_filter(array_unique($emp_ids)); 
                $sc=count(array_filter($empids));
   if($sc!='0')
   {

			$user_query2="select * from tbl_applied where JobId='".$jobid."' and (JUser_Id='".$juserid."' and emp_id='".$empid."')";
				$rrlk2= mysqli_query($con,$user_query2); 
				 $count=mysqli_num_rows($rrlk2);
			 if($count ==0)
			{
				 $irr_relavent="select emp_id from tbl_jobposted where Job_Status='1'  and (Min_Exp<='".$js_exp."' and Max_Exp>='".$js_exp."') and Job_Id=".$jobid;
                	$irr_rel=mysqli_query($con,$irr_relavent);
                	$irr_relav=mysqli_fetch_array($irr_rel);
					
					if($irr_relav['emp_id']){
		             $insert_jexp ="INSERT INTO tbl_applied SET JUser_Id='".$juserid."',emp_id='".$empid."',JobId='".$jobid."',status='yes',relavent='yes'";
					}
					else{
						$insert_jexp ="INSERT INTO tbl_applied SET JUser_Id='".$juserid."',emp_id='".$empid."',JobId='".$jobid."',status='yes',relavent='no'";
					}
				 
			         $insert_jexp1 ="INSERT INTO tbl_recent_views SET userid='".$juserid."',Action='Applied',Activity='Applied Job',Reference='".$jobid."',empid='".$_POST['empid']."',Ipaddress='".$_SERVER['REMOTE_ADDR']."'";
					 $jexp1= mysqli_query($con,$insert_jexp1);
					 $jexp= mysqli_query($con,$insert_jexp);
					 
					 
					 
			   $desi_name="select Desig_Name from tbl_desigination where Desig_Id='".$rr_data['Job_Name']."'";
				$desi= mysqli_query($con,$desi_name); 
				$desin=mysqli_fetch_array($desi);

                   $description="Job Applied for ".$desin['Desig_Name'];
             $insert_query = "INSERT into tbl_notifications SET job_id='".$jobid."',description='".$description."',job_owner_id='".$empid."',profile_id='".$juserid."',notification_to='".$empid."',notification_from='".$juserid."', mode='jobseeker'";
					$rr1 = mysqli_query($con,$insert_query); 
                   
                    $cj3="select JFullName,JEmail  from tbl_jobseeker where JUser_Id='".$juserid."'";  
					$resultcj3 = mysqli_query($con,$cj3);  
					$result_cj3=mysqli_fetch_array($resultcj3);

					 $cj4="select emp_email,contact_name from tbll_emplyer where emp_id='".$empid."'";  
		             $resultcj4 = mysqli_query($con,$cj4);  
					 $result_cj4=mysqli_fetch_array($resultcj4); 
                     $job_email=$result_cj4['emp_email']; 

                     $cj5="select Job_Name,Comp_Name from tbl_jobposted where Job_Id='".$jobid."'";  
		             $resultcj5 = mysqli_query($con,$cj5);  
					 $result_cj5=mysqli_fetch_array($resultcj5); 
					 $sql2 = "SELECT * FROM tbl_desigination where Desig_Id ='".$result_cj5['Job_Name']."'";
										$query2 = mysqli_query($con, $sql2);
										$row2s = mysqli_fetch_array($query2);
                    

                    $siteurl="http://needyin.com/"; 

					$subject="Job Application";

		             $message .= "Dear ".$result_cj4['contact_name']."<br/>";
				 	$message .= "You have received a new application against your open vacancy. Just click on the following link to view candidate details<br><br>";
	                 $message .= $result_cj3['JFullName']." has applied to your job !<br /><br />";
	                 $message .= "Job Details : <br />";
	                 $message .= "Job Title : ".$row2s['Desig_Name']."<br />";
	                 $message .= "Company Name : ".$result_cj5['Comp_Name']."<br /><br />";
	                 $message .= "Just click following link !<br /><br />";
	                 $message .= "<a href=".$siteurl.">NeedyIn </a><br /><br />";
	                 $message .= "Thanks,";
				 	$message .= "Team Needyin";
				 $message .= "<img src='./img/logo.png' width='200px' height='100px'";

                   
		                  if($ss_data['JuserStatus']=='A'){
                   
		                    $mm=$reg_user->send_mail2($job_email,$message,$subject);
							}{
							}

		             $message2 .= "Dear ".$result_cj3['JFullName']."<br/>";
	                 $message2 .= "Thank you for applying for".$row2s['Desig_Name']." position on Needyin.Com<br /><br />";
				 $message2 .= "We've shared the information with the concerned recruiter. In case your profile suits to the requirement, recruiters will be in touch with you directly or you will know the feedback/status of your application soon.<br><br>";
	                 $message2 .= "Job Details : <br />";
	                 $message2 .= "Job Title : ".$row2s['Desig_Name']."<br />";
	                 $message2 .= "Company Name : ".$result_cj5['Comp_Name']."<br /><br />";
	                 $message2 .= "Just click following link !<br /><br />";
	                 $message2 .= "<a href=".$siteurl.">NeedyIn </a><br /><br />";
	                 $message2 .= "Thanks,<br>";
				 $message2 .= "Team Needyin<br>";
				 $message2 .= "<img src='./img/logo.png' width='200px' height='100px'<br>";
                                $mm2=$reg_user->send_mail2($result_cj3['JEmail'],$message2,$subject);

						?><script>alert("Congratulations!! You have successfully Applied for this Job.");
						
                         window.location.href = "appliedjobs.php";
						</script>
					<?php  
				
				}
				else 
				{
					?><script>alert("You have Already Applied for this Job");
					window.location.href = "job-detail-postlogin.php?uid=<?php echo $_POST['empid'];?>&jid=<?php echo $_POST['jobid']; ?>";</script>
					<?php  
				}
		}
		else
		 {  ?>
          <script>
          alert("This job is not match with your details");
        window.location.href = "job-detail-postlogin.php?uid=<?php echo $_POST['empid'];?>&jid=<?php echo $_POST['jobid']; ?>";</script>
      <?php }

} 		   
 ?>


      