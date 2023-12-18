<!-- Get skills fro Database using AJAX call -->
<?php 
//session_start();
require_once 'class.user.php';
$q=$_GET["q"];

$sql = "SELECT skill_Name,skill_Id FROM tbl_masterskills WHERE skill_Status=1 order by skill_Name";
$rowCount = $sql->num_rows;
$result = mysqli_query($con,$sql);
// echo "<select class='form-control classic' name='PJobdesc'>";
while($row = mysqli_fetch_array($result))
{
    // echo "JobName: " . $row["Job_Role"]. " - Job Brief: " . $row["Job brief"]. " - Required Skills: " . $row["Required skills"]. " -Duties and Resposibilities: ".$row["Duties and responsibilities"]."<br>";
    // echo "<div class ='main'><span style='color:blue; text-align:center;background-color: white;'>".$row['Job_Role']."</span></div>";
    echo "NewSkills from Skills Table : \n\n";
    echo "".$row['skill_Name']."\n\n\n";
}
echo "";

?>
	
			

		