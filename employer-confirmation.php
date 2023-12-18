<?Php require_once("config.php");
require_once 'class.user.php';
echo $email=$_GET['email'];
				echo $status=$_GET['status'];exit;
			  if($_REQUEST['status']==1){
			
				echo $email=$_REQUEST['email'];
				echo $status=$_REQUEST['status'];
				
				
				 $update_emp_stat = "UPDATE tbll_emplyer SET status='".$status."' where emp_email='".$email."' ";
					$edu= mysqli_query($con,$update_emp_stat);
					
					if($edu!=0)
					{ 	?><script>alert("successfully activated your account.Please login");window.location.href = "index-recruiter.php";</script>
					<?php  }
					
					else{?><script>alert("something went wrong.Please Try again");window.location.href = "index-recruiter.php";</script>
					<?php 					
					}
}