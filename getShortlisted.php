<?php
require_once("config.php");
require_once 'class.user.php';
$reg_user = new USER();
if($_GET['JobId'])
{
	   $id=$_GET['JobId'];
	   $empId=$_GET['EmpId'];
	   $juserId=$_GET['JuserId'];   	  
	   $sql2 = "SELECT * FROM tbl_shortlisted WHERE emp_id='".$empId."' and (JUser_Id='".$juserId."' and JobId='".$id."') ORDER By JobId "; 
	   $query2 = mysqli_query($con, $sql2);
 ?>
 
 <?php
	while($row1 = mysqli_fetch_array($query2))
	{
	extract($row1);
    ?>	
	<option value="<?php echo $row1['JobId']; ?>"><?php $date=date_create($row1['created']);echo date_format($date,"M d,Y");?></option>
	<?php 
	}
}

?>		