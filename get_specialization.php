<?php
require_once("config.php");
require_once 'class.user.php';
$reg_user = new USER();
if($_POST['id'])
{
	   $id=$_POST['id'];
	   $sql2 = "SELECT Speca_Id,Speca_Name FROM tbl_specialization WHERE Qual_Id='".$id."'ORDER By Speca_Name ";
	    $query2 = mysqli_query($con, $sql2);
 ?>
 <option value="0" selected="selected" disabled>Select Specialization</option>
<option value="Others">Others</option>
 <?php
	while($row1 = mysqli_fetch_array($query2))
	{
	extract($row1);
    ?>	
	<option value="<?php echo $row1['Speca_Id']; ?>"><?php echo $row1['Speca_Name'];?></option>
	<?php 
	}
}
?>		