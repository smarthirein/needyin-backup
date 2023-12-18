<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();
//echo $_SESSION['userSession'];
$user_home = new USER();

if(!$user_home->is_logged_in())
{
	$user_home->redirect('index.php');
}
if(isset($_POST['SavedReason']))
{
	
	$reason_summary=$_POST['reasonSummary'];
	if($reason_summary == '')
	{
		?><script>alert("Reason Summary cannot be empty");window.location.href = "jobseeker-profile.php";</script> <?php
		exit;
	}
	$jid=$_POST['user_id'];
	$sql_reason="SELECT JReasonAttach from tbl_jobseeker WHERE `JUser_Id`='$jid'";
	$sql_query=mysqli_query($con,$sql_reason);
	$reason_row=mysqli_fetch_array($sql_query);


	$allowedrr =  array('DOCX','DOC' ,'PDF','JPG','PNG','JPEG','GIF');
	$_FILES['txtFileReason']['name'];
	if(count($_FILES['txtFileReason']['name']) > 0)
	{
    //Loop through each file
	for($i=0; $i<count($_FILES['txtFileReason']['name']); $i++) {
					          //Get the temp file path
	$tmpFilePath = $_FILES['txtFileReason']['tmp_name'][$i];						
	//Make sure we have a filepath
	if($tmpFilePath != ""){
    //save the filename
    $shortname = "Upload/Reason/reason_" . $jid.'-'.$_FILES['txtFileReason']['name'][$i];
	//save the url and the file
	$filePath = "Upload/Reason/reason_" . $jid.'-'.$_FILES['txtFileReason']['name'][$i];
	//Upload the file into the temp dir
	if(move_uploaded_file($tmpFilePath, $filePath))
	{
		$files[] = $shortname;
	}
    }
	}
	}
	$reasonList = implode(',', $files);	
	$sqlreason="UPDATE `tbl_jobseeker` SET `JReasonAttach`='$reasonList', jReasonSummary='$reason_summary' WHERE `JUser_Id`='$jid'";
					$sqlreasonres=mysqli_query($con,$sqlreason);
					if($sqlreasonres)
						?><script>alert("Successfully updated Reasons");window.location.href = "jobseeker-profile.php";</script> <?php
}
?>