<?php 
//session_start();
require_once 'class.user.php';
$q=$_GET["q"];

$sql="SELECT * FROM tbl_area WHERE Loc_Id ='".$q."' order by `Area_Name` ASC ";
$rowCount = $sql->num_rows;
$result = mysqli_query($con,$sql);

echo "<select class='form-control classic' name='area'>";
while($row = mysqli_fetch_array($result))
{
echo "<option value='".$row['Area_Id']."'>  ".$row['Area_Name']."  </option>";
}
echo "</select>";

?>
	
			

		