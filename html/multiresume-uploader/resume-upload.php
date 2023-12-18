<?php
// header('Content-Type: application/json');
session_start();
require_once 'dbconfig.php';
require_once '/var/www/dev.needyin.com/html/class.user.php';
$user_home = new USER();
if(!isset($_SESSION['empSession']))
{
$user_home->redirect('/var/www/dev.needyin.com/html/index-recruiter.php');   
}    
//calling employer set
$stmt = $user_home->runQuery("SELECT * FROM tbll_emplyer Re WHERE Re.emp_id=:rid");
$stmt->execute(array(":rid"=>$_SESSION['empSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$uploaded = [];
$allowed = ['pdf', 'docx', 'doc'];

$succeeded = [];
$failed = [];

if(!empty($_FILES['file'])){
	foreach($_FILES['file']['name'] as $key => $name){
		if($_FILES['file']['error'][$key] === 0){
			$temp = $_FILES['file']['tmp_name'][$key];

			$ext = explode('.', $name);
			$ext = strtolower(end($ext));
			
			$file = md5_file($temp) . time() . '.' . $ext;
			$new_name_cv="Upload/CV_".$jid.".".$ext;
			rename($file,$new_name_cv);
			if(in_array($ext, $allowed) === true && move_uploaded_file($temp, "uploads/{$new_name_cv}") === true){
				$sqlfiles=" UPDATE `tbl_currentexperience` SET `UpdateCV`='$new_name_cv' WHERE `JUser_Id`='$jid'";
				$sqlres=mysqli_query($con,$sqlfiles);
				$succeeded[] = array(
					'name' => $name,
					'file' => $file
				);
				
				// $insert = $db->query("INSERT into resumes (resume_name,dir_location,uploaded_on) VALUES ('".$file."', NOW())");
			}else{
				$failed[] = array(
					'name' => $name
				);
			}
		}
	}

	if(!empty($_POST['ajax'])){
		echo json_encode(array(
			'succeeded' => $succeeded,
			'failed' => $failed
		));
	}


}
?>