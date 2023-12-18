<?php 
session_start();
require_once("config.php");
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
	$user_home->redirect('index.php');
}
$msg=array();
$stmt = $user_home->runQuery("SELECT JPwd FROM tbl_jobseeker u
							  WHERE u.JUser_Id=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$msg=array();
if(isset($_POST['Changepwd']))
{
	if(empty($_POST['password']) || empty($_POST['newpassword']) || empty($_POST['conpassword']))
	{
		$msg[]="One of the field is empty";
	}
	
	
		if($row['JPwd'] != md5($_POST['password']))
		{
			
			$msg[]="Old Password is incorrect";
		}
		if($_POST['newpassword'] != $_POST['conpassword'])
		{
			
			$msg[]="Passwords are not matching";
		}
		if(strlen($_POST['newpassword'])<6)
			{
				$msg[]="Password  length should be between 6 to 12";
			}
		if(!empty($msg))
		{echo "yes";
			echo "<script language='javascript'>alert('";
			foreach($msg  as $error)
				echo $error."\\n";
			echo "');history.go(-1);</script>";
		}
		else
		{
			$newpassword=md5($_POST['newpassword']);
			$update_pwd="UPDATE tbl_jobseeker SET JPwd = '$newpassword' WHERE JUser_Id= $_SESSION[userSession]";
			$pwd=mysqli_query($con,$update_pwd);
			if($pwd!=0)
			 {?>
				<script>alert("Password successfully Updated");window.location.href = "jobseeker-profile.php";</script>
			<?php  }
			else
				echo mysqli_error($con);
		}
		
	
}

?>