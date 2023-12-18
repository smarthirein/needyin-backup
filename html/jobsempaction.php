<?php
header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire');
session_cache_limiter('public'); 
session_start();
require_once 'class.user.php';
$emp_login = new USER();

if($emp_login->is_logged_in())
{
	$emp_login->redirect('dashboard-recruiter.php');
}		  
$stmt = $emp_login->runQuery("SELECT * FROM tbll_emplyer WHERE emp_id=:rid");
$stmt->execute(array(":rid"=>$_SESSION['empSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

 if(isset($_POST['closejob'])){
	$jobs=$_POST['jobempid'];
	$jobs1=explode(",",$jobs);
	 $reason=$_POST['closejobtext'];
	 if(empty($reason))
	 {
		 ?>
	 <script lang="javascript">
	 alert("Please Give Your Reason to Close Job");
	 history.go(-1);
	 
	 	 </script>
	<?php	 
		 
	 }
	 else
	 {
 $sqls = "SELECT * FROM jobsaction where jobid='".$jobs1[0]."' AND empid='".$jobs1[1]."' AND status==0";
													$querys = mysqli_query($con, $sqls);
													$rows11 = mysqli_fetch_array($querys);
												 $count=mysqli_num_rows($querys);
													if($count==0){
	$insert_jexp1 ="UPDATE jobsaction SET jobid='$jobs1[0]',empid='$jobs1[1]',reason='$reason',status='$jobs1[2]'";
	$DeleteShortlisted="Delete FROM tbl_shortlisted WHERE JobId = '".$jobs1[0]."'";
	$deletescheduled="Delete FROM interviewscheduled WHERE job_id = '".$jobs1[0]."'";
	$rr= mysqli_query($con,$insert_jexp1);	
	$DeleteShortlisted=mysqli_query($con,$DeleteShortlisted);
	$deletescheduled=mysqli_query($con,$deletescheduled);
															$change_aw = "INSERT INTO tbl_Job_details_updts SET emp_Id='".$jobs1[1]."',Job_Id='".$jobs1[0]."',closed_updts='NOW()'";
				$eduz= mysqli_query($con,$change_aw);
	$insert_jexp2 ="UPDATE tbl_jobposted SET Job_Status='$jobs1[2]' where Job_Id='$jobs1[0]' and emp_id='$jobs1[1]'";	
	$rrs= mysqli_query($con,$insert_jexp2);			
				if($rrs!=0)
					{?>		<script>alert("Successfully Closed Job");window.location.href = "rec-jobs.php";</script>
					<?php  }
					
	}
	else{
						?>		<script>alert("Job Already Closed");window.location.href = "rec-jobs.php";</script>
					<?php 
					}
 }
 }
 if(isset($_POST['activate'])){
	$jobs=$_POST['jobempid'];
	$jobs1=explode(",",$jobs);
	$reason=$_POST['reason'];
	 if(empty($reason))
	 {
	?>
	 <script lang="javascript">
		 alert("Please Give Your Reason to Close Job");
		 history.go(-1);	 
	 </script>
	<?php	 		 
	 }
	 else
	 {
		$sqls = "SELECT * FROM jobsaction where jobid='".$jobs1[0]."',empid='".$jobs1[1]."' AND status==0";
													$querys = mysqli_query($con, $sqls);
													$rows11 = mysqli_fetch_array($querys);
													 $count=mysqli_num_rows($querys);
													if($count==0){
  $insert_jexp1 ="INSERT INTO jobsaction SET jobid='$jobs1[0]',empid='$jobs1[1]',reason='$reason',status='$jobs1[2]'";
    $rr= mysqli_query($con,$insert_jexp1);	
    $insert_jexp2 ="UPDATE tbl_jobposted SET Job_Status='$jobs1[2]' where Job_Id='$jobs1[0]' and emp_id='$jobs1[1]'";	
    $rrs= mysqli_query($con,$insert_jexp2);			
				if($rrs!=0)
					{?>
				<script>alert("Successfully Activated Job");
				window.location.href = "rec-jobs.php";</script>
					<?php  }
													}
 }
 }
 if(isset($_POST['inactivate'])){
	$jobs=$_POST['jobempid'];
	$jobs1=explode(",",$jobs);
	$reason=$_POST['reason'];
	 if(empty($reason))
	 {
		 ?>
	 <script lang="javascript">
	 
	 
	 
	 alert("Please Give Your Reason to Close Job");
	 history.go(-1);
	 
	 	 </script>
	<?php	 
		 
	 }
	 else
	 {
		$sqls = "SELECT * FROM jobsaction where jobid='".$jobs1[0]."',empid='".$jobs1[1]."' ";
													$querys = mysqli_query($con, $sqls);
													$rows11 = mysqli_fetch_array($querys);
													 $count=mysqli_num_rows($querys);
													if($count==0){
	$insert_jexp1 ="INSERT INTO jobsaction SET jobid='$jobs1[0]',empid='$jobs1[1]',reason='$reason',status='$jobs1[2]'";
	$DeleteShortlisted="Delete FROM tbl_shortlisted WHERE JobId = '".$jobs1[0]."'";
	$deletescheduled="Delete FROM interviewscheduled WHERE job_id = '".$jobs1[0]."'";
    $rr= mysqli_query($con,$insert_jexp1);	
	$DeleteShortlisted=mysqli_query($con,$DeleteShortlisted);
	$deletescheduled=mysqli_query($con,$deletescheduled);
														$change_aw1 = "INSERT INTO tbl_Job_details_updts SET emp_Id='".$jobs1[1]."',Job_Id='".$jobs1[0]."',inac_updts='NOW()'";
				$eduz= mysqli_query($con,$change_aw1);
    $insert_jexp2 ="UPDATE tbl_jobposted SET Job_Status='$jobs1[2]' where Job_Id='$jobs1[0]' and emp_id='$jobs1[1]'";	
    $rrs= mysqli_query($con,$insert_jexp2);			
				if($rrs!=0)
					{?>
				<script>alert("Succesfully Inactivated  Job");
				window.location.href = "rec-jobs.php";</script>
					<?php  }
													}
 }
 }
?>
