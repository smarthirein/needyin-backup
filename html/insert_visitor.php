<?php
require_once 'class.user.php';
$email=$_GET['email'];
$mobile=$_GET['mobile'];
$name=$_GET['name'];
 $check="SELECT * from tbl_jobseeker WHERE JEmail='$email'";
$check_res=mysqli_query($con,$check);
if(mysqli_num_rows($check_res)==1)
{
	$sql="INSERT into tbl_visits (email,mobile,status,name) VALUES ('$email','$mobile','Already Registered','$name')";
	$res=mysqli_query($con,$sql);
}
else
{
	$sql="INSERT into tbl_visits (email,mobile,status,name) VALUES ('$email','$mobile','Attempted','$name')";
	$res=mysqli_query($con,$sql);
}
?>