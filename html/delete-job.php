<?php
session_start();
require_once 'class.user.php';
$emp_login = new USER();

if($emp_login->is_logged_in())
{
	$emp_login->redirect('index-recruiter.php');
}
				  
$stmt = $emp_login->runQuery("SELECT * FROM tbll_emplyer WHERE emp_id=:rid");
$stmt->execute(array(":rid"=>$_SESSION['empSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if(isset($_REQUEST['jobId'])){

			$EditJob = "UPDATE tbl_jobposted jp SET jp.Job_Status=0 WHERE jp.job_Id = '".$_REQUEST['jobId']."'";
			$DeleteShortlisted="Delete FROM tbl_shortlisted WHERE JobId = '".$_REQUEST['jobId']."'";

			$EditJob= mysqli_query($con,$EditJob);	
			$DeleteShortlisted=mysqli_query($con,$DeleteShortlisted);	
			if($EditJob!=0)
			{?>
				<script>alert("Your job has been deleted");window.location.href = "rec-jobs.php";</script>
			<?php  
			}

}
else{echo "no delete job id";}
	
?>
			

      