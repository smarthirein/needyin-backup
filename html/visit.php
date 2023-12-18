<?php 
session_start();
require_once 'class.user.php';
$user_home = new USER();
//echo $_SESSION['userSession'];
if($user_home->is_logged_in())
{
	$user_home->redirect('index.php');
}
$stmt = $user_home->runQuery("SELECT * FROM tbll_emplyer WHERE emp_id=:eid");
$stmt->execute(array(":eid"=>$_SESSION['empSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

 if(isset($_POST['Shortlist1']) || $_POST['jobid']!=""){				
				 $juserids=$_POST['juserids'];
				$empids=$_POST['empids'];
				$jobid1=$_POST['jobid'];
			
				foreach($_POST['jobid'] as $selected) {
				 $user_query2="select * from tbl_shortlisted where JUser_Id='".$juserids."' and emp_id='".$empids."' and JobId='".$selected."'";
				$rrlk2= mysqli_query($con,$user_query2); 
				$row3s = mysqli_fetch_array($rrlk2);
				$users[]=$row3s['JUser_Id'];
				}
				
				$count=count(array_filter($users));
			
				if($count ==0){
				$sql2 = "SELECT * FROM tbl_desigination where Desig_Id ='".$jrow2['Job_Name']."'";
												$query2 = mysqli_query($con, $sql2);
												$row3s = mysqli_fetch_array($query2);
												foreach($_POST['jobid'] as $selected) {
				$insert_jexp ="INSERT INTO tbl_shortlisted SET JUser_Id='".$juserids."',emp_id='".$empids."',JobId='".$selected."',status='yes'";
				
					$jexp= mysqli_query($con,$insert_jexp);
					$query1="select td.Desig_Name,tl.Loc_Name from tbl_jobposted tj INNER JOIN tbl_desigination td ON tj.Job_Name=td.Desig_Id  INNER JOIN tbl_location tl ON tl.Loc_Id=tj.Loc_Id where tj.Job_Id=".$selected;
					 $res=mysqli_query($con,$query1);
					 $result=mysqli_fetch_array($res);
					 $job_names[]=$result['Desig_Name'];
					 $jb_locations[]=$result['Loc_Name'];
}
				
					
					$jc1= "SELECT JFullName,JEmail FROM tbl_jobseeker WHERE JUser_Id='".$juserids."' and jdndstatus='0'";
						$jresult1 = mysqli_query($con,$jc1);
						$jrow = mysqli_fetch_array($jresult1);
						$jc2= "SELECT Job_Name,Comp_Name FROM tbl_jobposted WHERE emp_id=".$empids;
						$jresult2 = mysqli_query($con,$jc2);
						$jrow2 = mysqli_fetch_array($jresult2);
						
					if($jexp!=0)
					{
						$email_to = $jrow['JEmail'];
						$jname=base64_encode($jrow['JFullName']);
						$jbnames=implode(",",$job_names);
						$jobnames=base64_encode($jbnames);
						$jblocs=implode(",",$jb_locations);
						$joblocations=base64_encode($jblocs);
						$jcomp=base64_encode($jrow2['Comp_Name']);
					/*	$msg ="Dear ".$jrow['JFullName'].",<br><br>
Congratulations!!!<br>Your profile is short-listed for the below position and your current profile information as seen by recruiters:<br><br> Your Profile is shortlisted for ".$row3s['Desig_Name']." in ".$jrow2['Comp_Name']."<br>You can now login to your account using your e-mail id and password to view the recruiter details.<br>Thanks,<br>Team Needyin<br><img src='./img/logo.png' width='200px' height='100px'>";*/
						$msg="<table width='600' border='0' cellspacing='0' cellpadding='0' style='font-family:arial; margin:0 auto;'>
       
        <tr height='43px'>
                <td align='left' width='400px;' >
                        <a href='".$siteurl."' target='_blank'><img src='".$siteurl."/img/logo.png' width='198'></a>
                </td>
                <td align='right' width='300px;'>
                    <table>
                        <tr height='70'>
                            <td align='center' style='padding-right:10px;'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/about_us.php' target='_blank'>About Us</a> |</td>
                            <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/contact.php' target='_blank'>Contact</a> | </td>
							<td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/short_temp.php?jname=".$jname."&jobnames=".$jobnames."&jcomp=".$jcomp."&joblocations=".$joblocations."' target='_blank'>View In Web</a>
						     </td>
                           
                        </tr>
                    </table>
                </td>
        </tr>
         <tr>
                <td colspan='2' style='background:#90bd14;' align='center'>
                    <p style='font-size:15px; line-height:25px; color:#fff; padding:10px ; text-align: justify;'>Dear ".ucfirst($jrow['JFullName']).",<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Congratulations!!! Your profile is short-listed for the below position and your current profile information as seen by recruiters:
 </p>
                </td>
        </tr>
        <tr>
                <td style='height:15px;'>
                </td>
        </tr>
        <tr height='320px'>
                <td colspan='2'   style='background:url(".$siteurl."/img/schedule8.png) no-repeat center 0;'>
                
                        <div style='width:600px; margin-bottom: 224px;'>
                          <div style='color:white; float:left; font-size:14px; width:200px; margin-left: 111px;
    margin-top: 50px;height: 80px;'>
                                
                                 Your profile is short-listed.
                            </div>
                            <div style='color:white; float:left; font-size:14px; width:200px;margin-left: 0px;height: 80px;'>
                                ";
                        foreach($job_names as $jobname)
                                   { $msg.= " Job Name&nbsp;&nbsp;: ".$jobname."<br>";
                                   }
                                 $msg.= "<br>
                            </div>
                             <div style='color:white; float:left; font-size:14px; width:200px;float:left;height: 80px;margin-left: 25px;'>
                               Company Name&nbsp;: ".$jrow2['Comp_Name']." <br>";
                                foreach($jb_locations as $jobloc)
                                   { $msg.= " Job Location&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ".$jobloc."<br>"; }

							$msg.="                   
                            </div>

                  </div>
                
				</td>
		</tr>		
		
    <tr>
            <td colspan='2' style='background:#0274bb;' align='center'>
                <p style='font-size:13px; line-height:20px; color:#fff; '>You have received this mail because your e-mail ID is registered with Needyin.com. This is a system-generated e-mail regarding your Needyin account preferences, please don't reply to this message.</p>
            </td>
        </tr>
        
        </tr>
		</table>";
						$email_subject = "Profile is Shortlisted";
						$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$user_home->send_mail2($email_to, $msg, $email_subject); 
							
						?><script>alert("successfully shortlisted");window.location.href = "jobseeker-detail-recruiter.php?uid=<?php echo $juserids ?>&pgid=3";</script>
					<?php  
					}
				}else{
					?><script>alert("Already shortlisted");window.location.href = "jobseeker-detail-recruiter.php?uid=<?php echo $juserids ?>";</script>
				
					<?php  
				}
					}
					else if(isset($_POST['Shortlist1'])){
				
				$juserids=$_POST['juserids'];
				$empids=$_POST['empids'];
				$jobid1=$_POST['jobid'];
				$user_query2="select * from tbl_shortlisted where JUser_Id='".$juserids."' and emp_id='".$empids."' and JobId='".$jobid1."'";
				$rrlk2= mysqli_query($con,$user_query2); 
				 $count=mysqli_num_rows($rrlk2);
				if($count ==0){
			
			foreach($_POST['jobid'] as $selected) {
 $insert_jexp ="INSERT INTO tbl_shortlisted SET JUser_Id='".$juserids."',emp_id='".$empids."',JobId='".$selected."',status='yes'";
				  
				
					$jexp= mysqli_query($con,$insert_jexp);
				$query1="select td.Desig_Name,tl.Loc_Name from tbl_jobposted tj INNER JOIN tbl_desigination td ON tj.Job_Name=td.Desig_Id  INNER JOIN tbl_location tl ON tl.Loc_Id=tj.Loc_Id where tj.Job_Id=".$selected;
					 $res=mysqli_query($con,$query1);
					 $result=mysqli_fetch_array($res);
					 $job_names[]=$result['Desig_Name'];
					 $jb_locations[]=$result['Loc_Name'];
}
					 $jc1= "SELECT JFullName,JEmail FROM tbl_jobseeker WHERE JUser_Id='".$juserids."' and jdndstatus='0'";
						$jresult1 = mysqli_query($con,$jc1);
						$jrow = mysqli_fetch_array($jresult1);
						 $jc2= "SELECT Job_Name,Comp_Name FROM tbl_jobposted WHERE emp_id=".$empids;
						$jresult2 = mysqli_query($con,$jc2);
						$jrow2 = mysqli_fetch_array($jresult2);	
				
					
					if($jexp!=0)
					{
						$email_to = $jrow['JEmail'];
						$jname=base64_encode($jrow['JFullName']);
						$jbnames=implode(",",$job_names);
						$jobnames=base64_encode($jbnames);
						$jblocs=implode(",",$jb_locations);
						$joblocations=base64_encode($jblocs);
						$jcomp=base64_encode($jrow2['Comp_Name']);
					//	$msg = "Dear ".$jrow['JFullName'].", Your Profile is shortlisted for ".$row3s['Desig_Name']." in ".$jrow2['Comp_Name'];
						$msg="<table width='600' border='0' cellspacing='0' cellpadding='0' style='font-family:arial; margin:0 auto;'>
       
        <tr height='43px'>
                <td align='left' width='400px;' >
                        <a href='".$siteurl."' target='_blank'><img src='".$siteurl."/img/logo.png' width='198'></a>
                </td>
                <td align='right' width='300px;'>
                    <table>
                        <tr height='70'>
                            <td align='center' style='padding-right:10px;'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/about_us.php' target='_blank'>About Us</a> |</td>
                            <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/contact.php' target='_blank'>Contact</a> | </td>
							<td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/short_temp.php?jname=".$jname."&jobnames=".$jobnames."&jcomp=".$jcomp."&joblocations=".$joblocations."' target='_blank'>View In Web</a>
						     </td>
                           
                        </tr>
                    </table>
                </td>
        </tr>
         <tr>
                <td colspan='2' style='background:#90bd14;' align='center'>
                    <p style='font-size:15px; line-height:25px; color:#fff; padding:10px ; text-align: justify;'>Dear ".ucfirst($jrow['JFullName']).",<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Congratulations!!! Your profile is short-listed for the below position and your current profile information as seen by recruiters:
 </p>
                </td>
        </tr>
        <tr>
                <td style='height:15px;'>
                </td>
        </tr>
        <tr height='320px'>
                <td colspan='2'   style='background:url(".$siteurl."/img/schedule8.png) no-repeat center 0;'>
                
                        <div style='width:600px; margin-bottom: 224px;'>
                          <div style='color:white; float:left; font-size:14px; width:200px; margin-left: 111px;
    margin-top: 50px;height: 80px;'>
                                
                                 Your profile is short-listed.
                            </div>
                            <div style='color:white; float:left; font-size:14px; width:200px;margin-left: 0px;height: 80px;'>
                                ";
                        foreach($job_names as $jobname)
                                   { $msg.= " Job Name&nbsp;&nbsp;: ".$jobname."<br>";
                                   }
                                 $msg.= "<br>
                            </div>
                             <div style='color:white; float:left; font-size:14px; width:200px;float:left;height: 80px;margin-left: 25px;'>
                               Company Name&nbsp;: ".$jrow2['Comp_Name']." <br>";
                                foreach($jb_locations as $jobloc)
                                   { $msg.= " Job Location&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ".$jobloc."<br>"; }

							$msg.="                   
                            </div>

                  </div>
                
				</td>
		</tr>		
		
    <tr>
            <td colspan='2' style='background:#0274bb;' align='center'>
                <p style='font-size:13px; line-height:20px; color:#fff; '>You have received this mail because your e-mail ID is registered with Needyin.com. This is a system-generated e-mail regarding your Needyin account preferences, please don't reply to this message.</p>
            </td>
        </tr>
        
        </tr>
		</table>";
						$email_subject = "Profile is Shortlisted";
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$user_home->send_mail2($email_to, $msg, $email_subject);
						?>
						<script>alert("successfully shortlisted");window.location.href = "jobseeker-detail-recruiter.php?uid=<?php echo $juserids ?>&pgid=3";</script>
						
						<?php  
					}
				}
				else
				{           
					?>
					<script>alert("Already shortlisted");window.location.href = "jobseeker-detail-recruiter.php?uid=<?php echo $juserids ?>";</script>
					<?php  
				}
					}
					?>
					
<?php 
if(isset($_POST['inviteFriend'])) {
	
 if(empty($_POST['email']))
 {
	 ?>
	 <script lang="javascript">
	 alert("Email canot be empty");
	 
	 
	 
	 </script>
	 <?php
 }
 else
 {

$to      = $_POST['email'];
$name    = $_POST['name'];
$converted_name = str_replace(' ', '%20', $name);
$phone_number=$_POST['number'];
$from_name    = $_POST['fromname'];
$subject = 'Invitation to join Needyin';
$message = "<table width='600' border='0' cellspacing='0' cellpadding='0' style='font-family:arial; margin:0 auto;'>
                             <tr height='43px'>
						            <td align='left' width='400px;' >
						                    <a href='".$siteurl."' target='_blank'><img src='".$siteurl."/img/logo.png' width='198'></a>
						               
						            </td>
						            <td align='right' width='300px;'>
						                <table>
						                    <tr height='70'>
						                        <td align='center' style='padding-right:10px;'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/about_us.php' target='_blank'>About Us</a> |</td>
						                        <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/contact.php' target='_blank'>Contact</a>
						                        |</td>
												
												 <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/emp_msg.php?mess=".$mess."&name=".$name."&comname=".$comname."' target='_blank'>View In Web</a>
						                        </td>
						                    </tr>
						                </table>
						            </td>
       						 </tr>
        					 <tr>
								            <td colspan='2' style='background:url(https://www.needyin.com/img/thankyou1.png) no-repeat center 0; height:335px;' >
								              <div style='padding: 15px; text-align: justify; margin-left: 311px; margin-top: 16px; width: 175px;font-size: 11px; padding-left: 10px;'>
								                   Dear ".$name.",<br><br>
								             ".$from_name." Grabbing a dream job lands you on cloud nine, where you start planning to give wings to your dream. But you soon land up in reality when you get to know. 
											  
											<strong>  Regards<br>
											  Needyin
                                           </strong>
								              </div>
								              
								            </td>
       						 </tr>
					        <tr>
					            <td colspan='2' style='background:#90bd14;' align='center'>
					              
					                <p style='font-size:20px; font-weight:bold; color:#fff; margin:0; padding-bottom:31px;  margin:0;'>
									<br>
									<a href=".$siteurl."/dev/signup-jobseekar.php?email=$to&name=$converted_name&phone=$phone_number>Accept Invitation</a></p>
					            </td>
					        </tr>
					        <tr>
					            <td height='10' colspan='2' align='center'>
					                <!--<p style='font-size:15px; line-height:22px; color:#333; padding:0 10px; margin:0;'></p>-->
					            </td>
					        </tr>
					        <tr>
					            <td colspan='2' style='background:#0274bb;' align='center'>
					                <p style='font-size:13px; line-height:16px; color:#fff; '>You have received this mail because your e-mail ID is registered with Needyin.com. This is a system-generated e-mail regarding your Needyin account preferences, please don't reply to this message.</p>
					            </td>
					        </tr>
    
    </table>";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$user_home->send_mail($to, $message, $subject); 
						?>
<script>
alert("Invited successfully");
window.location.href = "jobseeker-profile.php";
</script>
						
<?php }
 ?>

<?php
}
					?>
					
														<?php
 if(isset($_POST['sendmesg'])) {

 // EDIT THE 2 LINES BELOW AS REQUIRED

    $email_to = $_POST['email'];
	$email_to1=explode(",",$email_to);
	$comp_names = $_POST['comp_name'];
 if(empty($_POST['subject'])||empty($_POST['message']))
 {
	 ?>
	 <script lang="javascript">
	 alert("Subject or message canot be empty");
	 
	 
	 
	 </script>
	 <?php
 }
 else
 {
    $email_subject = $_POST['subject'];
	 $message = $_POST['message'];
	 $name_sql="SELECT JFullName from tbl_jobseeker WHERE JUser_Id='".$email_to1[1]."'";
	 $name_js=mysqli_query($con,$name_sql);
	 $jsname=mysqli_fetch_array($name_js);
	  $mess=base64_encode( $message);
	 $name=base64_encode($jsname['JFullName']);
	 $comname=base64_encode($comp_names);
 
					 $msg  = "<table width='600' border='0' cellspacing='0' cellpadding='0' style='font-family:arial; margin:0 auto;'>
                             <tr height='43px'>
						            <td align='left' width='400px;' >
						                    <a href='".$siteurl."' target='_blank'><img src='".$siteurl."/img/logo.png' width='198'></a>
						               
						            </td>
						            <td align='right' width='300px;'>
						                <table>
						                    <tr height='70'>
						                        <td align='center' style='padding-right:10px;'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/about_us.php' target='_blank'>About Us</a> |</td>
						                        <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/contact.php' target='_blank'>Contact</a>
						                        |</td>
												
												 <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/emp_msg.php?mess=".$mess."&name=".$name."&comname=".$comname."' target='_blank'>View In Web</a>
						                        </td>
						                    </tr>
						                </table>
						            </td>
       						 </tr>
        					 <tr>
								            <td colspan='2' style='background:url(https://www.needyin.com/img/thankyou1.png) no-repeat center 0; height:335px;' >
								              <div style='padding: 15px; text-align: justify; margin-left: 311px; margin-top: 16px; width: 175px;font-size: 13px; padding-left: 10px;'>
								                   Dear ".ucfirst($jsname['JFullName']).",<br><br>
								             Following message for you:<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$message."<br><br>
											  
											<strong>  Thanks<br>
											  ".$comp_names."
                                           </strong>
								              </div>
								              
								            </td>
       						 </tr>
					        <tr>
					            <td colspan='2' style='background:#90bd14;' align='center'>
					              
					                <p style='font-size:20px; font-weight:bold; color:#fff; margin:0; padding-bottom:31px;  margin:0;'>
									<br>
									<a href=".$siteurl.">Needyin.com </a></p>
					            </td>
					        </tr>
					        <tr>
					            <td height='10' colspan='2' align='center'>
					                <!--<p style='font-size:15px; line-height:22px; color:#333; padding:0 10px; margin:0;'></p>-->
					            </td>
					        </tr>
					        <tr>
					            <td colspan='2' style='background:#0274bb;' align='center'>
					                <p style='font-size:13px; line-height:16px; color:#fff; '>You have received this mail because your e-mail ID is registered with Needyin.com. This is a system-generated e-mail regarding your Needyin account preferences, please don't reply to this message.</p>
					            </td>
					        </tr>
    
    </table>";
	 
	 									//$email_subject = "You have received Message";
						$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$user_home->send_mail($email_to1[0], $msg, $email_subject); 

 ?>
<!-- include your own success html here -->
 <script>
	 alert("Message sent successfully");
window.location.href = "jobseeker-detail-recruiter.php?uid=<?php echo $email_to1[1] ?>";</script>
<?php
}
 }
 
?>
			<?php
 
if(isset($_POST['sendschedule'])) {
 // EDIT THE 2 LINES BELOW AS REQUIRED
$email_from ="support@needyin.com";

     $email_to = $_POST['email'];
 	 $email_to1=explode(",",$email_to);
	 $email_subject = "Inteview scheduled on";
	 $jobid = $_POST['jobid'];
	
	 $juserid = $_POST['juserid'];
	 $empid = $_POST['empid'];
	 $hours = $_POST['hours'];
 $mins = $_POST['min'];
	 $dat = $_POST['dates'];
     $dates=date('Y-m-d', strtotime($dat));
	 $message = $_POST['message']; 

if(empty($dates)||empty($message))
{
	?>
	 <script lang="javascript">	 
	 alert("One of the Fields is Empty Please Check"); 
	 </script>
	 <?php
	
}
else
{ 
	$comp_nme = "select companyname from tbll_emplyer where emp_id='$empid'";
	
    $comp_res=mysqli_query($con,$comp_nme);
	$comp_row=mysqli_fetch_array($comp_res);
	
	$loc_nme= "select tbl_location.loc_name
	from tbl_location
	inner join tbl_jobposted on tbl_location.Loc_id=tbl_jobposted.Loc_id
	where tbl_jobposted.Job_Id=$jobid";
	$loc_res=mysqli_query($con,$loc_nme);
	$loc_row=mysqli_fetch_array($loc_res);
	
	$job_nme= "select tbl_desigination.Desig_Name
	from tbl_desigination
	inner join tbl_jobposted on tbl_desigination.Desig_Id=tbl_jobposted.Job_Name
	where tbl_jobposted.Job_Id=$jobid";
	$job_res=mysqli_query($con,$job_nme);
	$job_row=mysqli_fetch_array($job_res);
	$msg=base64_encode($message);
	$cmp=base64_encode($comp_row['companyname']);
	$des=base64_encode($job_row['Desig_Name']);
	$loc=base64_encode($loc_row['loc_name']);
	$int_date=base64_encode($dates);
	$int_hours=base64_encode($hours);
	$int_mins=base64_encode($mins);
	$name_sql="SELECT JFullName from tbl_jobseeker WHERE JUser_Id='".$email_to1[1]."'";
	 $name_js=mysqli_query($con,$name_sql);
	 $jsname=mysqli_fetch_array($name_js);
	// $email_message = "hi,\n Message: ".$message." interview Scheduled on: ".$dates;
	$email_message ="<table width='600' border='0' cellspacing='0' cellpadding='0' style='font-family:arial; margin:0 auto;'>
       
        <tr height='43px'>
                <td align='left' width='400px;' >
                        <a href='http:".$siteurl."' target='_blank'><img src='".$siteurl."/img/logo.png' width='198'></a>
                </td>
                <td align='right' width='300px;'>
                    <table>
                        <tr height='70'>
                            <td align='center' style='padding-right:10px;'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/about_us.php' target='_blank'>About Us</a> |</td>
                            <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/contact.php' target='_blank'>Contact</a>|</td>
                            <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href=".$siteurl."/inter_temp.php?message=$msg&companyname=$cmp&Desig_Name=$des&loc_name=$loc&dates=$int_date&hours=$int_hours&mins=$int_mins target='_blank'>View In Web</a></td>
                           
                        </tr>
                    </table>
                </td>
        </tr>
         <tr>
                <td colspan='2' style='background:#90bd14;' align='center'>
                    <p style='font-size:15px; line-height:25px; color:#fff; padding:10px ; text-align: justify;'>Dear  ".ucfirst($jsname['JFullName']).",<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Your profile is schedled for the interview with the recuiter/ client/ Company in this week. You are hereby required to be avaiable for the interview. Following are the interview schedule details for your ready reference.  </p>
                </td>
        </tr>
        <tr>
                <td style='height:15px;'>
                </td>
        </tr>
        <tr height='320px'>
                <td colspan='2'   style='background:url(".$siteurl."/img/schedule8.png) no-repeat center 0;'>
                
                        <div style='color:white; float:left;margin-bottom: 150px;margin-left: 60px; padding-top: 15px; font-size:14px; width:200px;'>
                        $message
						
                        </div>
                        <div style='color:white; float:right; margin-right: 130px; margin-bottom: 40px;   font-size:14px;'>
						Inteview Date: $dates <br>
						Interview Time: $hours:$mins <br>
						Inteview Venue : ".$loc_row['loc_name']."
                         
                        </div>
                         <div style='color:white; float:right; margin-right: 85px; margin-bottom: 20px;   font-size:14px;'>
							Company Name:".$comp_row['companyname']."<br>
							  Job Name:".$job_row['Desig_Name']."
							

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
                <p style='font-size:13px; line-height:30px; color:#fff; '>You have received this mail because your e-mail ID is registered with Needyin.com. This is a system-generated e-mail regarding your Needyin account preferences, please don't reply to this message.</p>
            </td>
        </tr>
        
        </tr>
    </table>";
	
	$insert_query = "INSERT into interviewscheduled SET job_id='".$jobid."',scheduled_on='".$dates."',message='".$message."',juser_id='".$juserid."',emp_id='".$empid."',subject='".$email_subject."',hours='".$hours."',minutes='".$mins."'";
$rr1 = mysqli_query($con,$insert_query);
					$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$user_home->send_mail2($email_to1[0],  $email_message, $email_subject);
 
?> 
<!-- include your own success html here --> 
<script>
	alert("Interview scheduled successfully");
	window.location.href = "jobseeker-detail-recruiter.php?uid=<?php echo $juserid ?>";</script>
	 <?php
 
}
}
  if(isset($_POST['Selected'])){
	 // print_r($_POST);
	  $noofusers=$_POST['noofusers'];
	  $jobids=$_POST['jobids'];
	  $selects=$_POST['selects'];
	   $empid=$_POST['empid'];
	  $sche_s = mysqli_query($con,$sche);
	$row1_sche = mysqli_fetch_array($sche_s);
	 $row1_sche['latest_sche'];
	 $reason=$_POST['reason'];
	foreach($noofusers as $selected_users) {
				 $user_query2="select juser_id,max(scheduled_on) as latest_sche from interviewscheduled where emp_id='".$_SESSION['empSession']."' and  job_id='".$jobids."' and juser_id='".$selected_users."'";
				$rrlk2= mysqli_query($con,$user_query2); 
				$row3s = mysqli_fetch_array($rrlk2);
				$ss="update interviewscheduled SET selected='".$selects."',reason='".$reason."',updated=NOW() where emp_id='".$empid."' and  job_id='".$jobids."' and juser_id='".$selected_users."' ";
				$ss_res=mysqli_query($con,$ss);	
				}
				?>
				<script>alert("Successfully updated selected candidates");
				window.location.href = "view-job.php?jobId=<?php echo $jobids  ?>";</script>
				<?php
  }
 
?>

					

		