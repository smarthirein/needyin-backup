<?php 
session_start();
require_once("config.php");
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
	$user_home->redirect('index.php');
}
$stmt = $user_home->runQuery("SELECT * FROM tbl_jobseeker u
							  JOIN tbl_currentexperience cexp on u.JUser_Id=cexp.JUser_Id
							  WHERE u.JUser_Id=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if(isset($_POST['Skillsinfo'])){
			
			for($i=1;$i<=$_POST['noofSkills'];$i++){
				
				if(isset($_POST['Skill_Id'.$i]) && !empty($_POST['Skill_Id'.$i])){
					
					$skills_id=$_POST['Skill_Id'.$i];
					$skills = $_POST['skills'.$i];
					$exp = $_POST['experience'.$i];
					$ver = $_POST['version'.$i];
					$used = $_POST['last_used'.$i];					
					$user_update_query = "UPDATE tbl_skills SET Skill_Name='".$skills."',version='".$ver."',experience='"$exp."',last_used='".$used."' where JUser_Id='".$row['JUser_Id']."' and Skill_Id='".$skills_id."'";
					$rr = mysqli_query($con,$user_update_query);
					
				}
				else
				{ 
					
					echo "<br>No Skill Id - New Record<br>";
					$skills = $_POST['skills'.$i];
					$exp = $_POST['experience'.$i];
					$ver = $_POST['version'.$i];
					$used = $_POST['last_used'.$i];
					$user_update_query1 = "INSERT into tbl_skills SET  Skill_Name='".$skills."',version='".$ver."',experience='".$exp."',last_used='".$used."',JUser_Id='".$row['JUser_Id']."'";
					$rr1 = mysqli_query($con,$user_update_query1);
				}
			}
		}  
exit;
				
 ?>
      