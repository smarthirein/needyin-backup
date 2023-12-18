<?php 
session_start();
require_once '../class.user.php';

$user_home = new USER();
if(!isset($_SESSION['adminSession']))
{
		 $user_home->redirect('admin.php');
   
} 	  
$stmt = $user_home->runQuery("SELECT * FROM tbl_admin WHERE id=:rid");
$stmt->execute(array(":rid"=>$_SESSION['adminSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$msg=array();

if(isset($_POST['Changepwd']))
{
	if(empty($_POST['password']) || empty($_POST['newpassword']) || empty($_POST['conpassword']))
	{
		$msg[]="One of the field is empty";
	}
	
		
		if($row['password'] != md5($_POST['password']))
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
		{
			echo "<script language='javascript'>alert('";
			foreach($msg  as $error)
				echo $error."\\n";
			echo "');history.go(-1);</script>";
		}
		else
		{
			$newpassword=md5($_POST['newpassword']);
			$update_pwd="UPDATE tbl_admin SET password = '$newpassword' WHERE id= '".$_SESSION['adminSession']."'";
			$pwd=mysqli_query($con,$update_pwd);
			if($pwd!=0)
			 {?>
				<script>alert("Password successfully Updated");
				window.location.href = "admin-update-password.php";
				</script>
			<?php  }
			else
				echo mysqli_error($con);
		}
		
}

?>