<?php
require_once 'class.user.php';
require_once 'source.php';
$user = new USER();

if(empty($_POST['id']) && empty($_POST['code']))
{
	$user->redirect('index.php');
}

if(isset($_POST['ids']) && isset($_POST['code']))
{
	$id = base64_decode($_POST['ids']); 
	$code = $_POST['code'];
	
	  $sqlver="SELECT JEmail FROM tbl_jobseeker WHERE JEmail='$id' AND JtokenCode='$code'"; 
	

	$sqlverres=mysqli_query($con ,$sqlver );
	$sqlverrow = mysqli_fetch_array($sqlverres);
	$dd=mysqli_num_rows($sqlverres);

	if(mysqli_num_rows($sqlverres) == 1)
	{
		if(isset($_POST['btn-jobseeker-reset-pass']))
		{
			 $pass = $_POST['password1'];
			 $cpass = $_POST['password'];
			
			if($cpass!==$pass)
			{ ?>
				<script lang='javascript' >alert("Given Passwords doesn't match");</script>
			<?php }
			
			else if(strlen($cpass)<'6')
			{ ?>
				<script lang='javascript' >alert("Password must Contain at leasr 8 letters");</script>
			<?php }
			else
			{
				$password = md5($cpass);
				  $sqlupdate = "UPDATE `tbl_jobseeker` SET `JPwd`='$password' WHERE JEmail='$id'";			
				$s_res=mysqli_query($con,$sqlupdate);
				echo ".";
				if($s_res)
				{ ?>
				
			 <script>
				alert("Your Password is changed , Relogin to continue")
				window.location.href = "login.php"; </script>
				<?php exit;
				}		
				
			}
		}	
	}
	else
	{  ?>
		<script lang='javascript' >alert("No Account Found, Try again");window.location.href = 'login.php';</script>
				
				
	<?php  }
	
	
}

?>
