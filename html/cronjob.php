<?php 
session_start();
require_once 'class.user.php';
$user_home = new USER();
if($user_home->is_logged_in())
{
	$user_home->redirect('index.php');
}
				$stmt = $user_home->runQuery("SELECT * FROM tbll_emplyer WHERE emp_id=:eid");
				$stmt->execute(array(":eid"=>$_SESSION['empSession']));
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$juserids=$_POST['juserids'];
				$empids=$_POST['empids'];
				$jobid1=$_POST['jobid'];
				$user_query2="select * from tbl_shortlisted where JUser_Id='".$juserids."' and emp_id='".$empids."'";
				$rrlk2= mysqli_query($con,$user_query2); 
				$count=mysqli_num_rows($rrlk2);
				if($count ==0){
				$sql2 = "SELECT * FROM tbl_desigination where Desig_Id ='".$jrow2['Job_Name']."'";
												$query2 = mysqli_query($con, $sql2);
												$row3s = mysqli_fetch_array($query2);
				 $insert_jexp ="INSERT INTO tbl_shortlisted SET JUser_Id='".$juserids."',emp_id='".$empids."',JobId='".$jobid1."',status='yes'";
				  $insert_jexp1 ="INSERT INTO tbl_recent_views SET userid='".$juserids."',Action='Shortlisted',Activity='Shortlisted Profile',Reference='".$jobid."',empid='".$_POST['empid']."',Ipaddress='".$_SERVER['REMOTE_ADDR']."'";
					$jexp1= mysqli_query($con,$insert_jexp1);
					$jexp= mysqli_query($con,$insert_jexp);
					$jc1= "SELECT JFullName,JEmail FROM tbl_jobseeker WHERE JUser_Id=".$juserids;
						$jresult1 = mysqli_query($con,$jc1);
						$jrow = mysqli_fetch_array($jresult1);
						$jc2= "SELECT Job_Name,Comp_Name FROM tbl_jobposted WHERE emp_id=".$empids;
						$jresult2 = mysqli_query($con,$jc2);
						$jrow2 = mysqli_fetch_array($jresult2);						
					if($jexp!=0)
					{
						$email_to = $jrow['JEmail'];
						$msg ="Hi ".$jrow['JFullName'].", Your Profile is shortlisted for ".$row3s['Desig_Name']." in ".$jrow2['Comp_Name'];
						$email_subject = "Profile is Shortlisted";
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$user_home->send_mail2($email_to, $msg, $email_subject); 
							
						?><script>alert("successfully shortlisted");window.location.href = "jobseeker-detail-recruiter.php?uid=<?php echo $juserids ?>";</script>
					<?php  
					}
				}else{
					?><script>alert("Already shortlisted");window.location.href = "jobseeker-detail-recruiter.php?uid=<?php echo $juserids ?>";</script>
				
					<?php  
				}
				
					?>

			<?php
 
if(isset($_POST['sendschedule'])) {

 
$email_from ="support@needyin.com";

   $email_to = $_POST['email'];
	$email_to1=explode(",",$email_to);
	$email_subject = "Inteview scheduled on";
	 $jobid = $_POST['jobid'];
	 $juserid = $_POST['juserid'];
	$empid = $_POST['empid'];
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
	 $email_message = "hi,\n Message: ".$message." interview Scheduled on: ".$dates;
	 $insert_query = "INSERT into interviewscheduled SET job_id='".$jobid."',message='".$email_message."',juser_id='".$juserid."',emp_id='".$empid."',subject='".$email_subject."'";
$rr1 = mysqli_query($con,$insert_query);
					$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$user_home->send_mail2($email_to1[0],  $email_message, $email_subject);
 
?> 

<script>window.location.href = "jobseeker-detail-recruiter.php?uid=<?php echo $email_to1[1] ?>";</script>
	 <?php
 
}
}
 
?>
					

		