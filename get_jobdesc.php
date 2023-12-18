<?php 
//session_start();
require_once 'class.user.php';
$q=$_GET["q"];

$sql="SELECT * FROM tbl_jobdesc WHERE id ='".$q."' order by `Job_Role` ASC ";
// $sql = "SELECT id = '".$q."' FROM tbl_jobdesc INNER JOIN tbl_masterskills on tbl_jobdesc.id = tbl_masterskills.skill_Id ";
$rowCount = $sql->num_rows;
$result = mysqli_query($con,$sql);
// echo "<select class='form-control classic' name='PJobdesc'>";
while($row = mysqli_fetch_array($result))
{
    // echo "JobName: " . $row["Job_Role"]. " - Job Brief: " . $row["Job brief"]. " - Required Skills: " . $row["Required skills"]. " -Duties and Resposibilities: ".$row["Duties and responsibilities"]."<br>";
    // echo "<div class ='main'><span style='color:blue; text-align:center;background-color: white;'>".$row['Job_Role']."</span></div>";
    echo "Job Role : ".$row['Job_Role']."\n\n";
    echo "Job Brief : \n\n";
    echo "".$row['Job brief']."\n\n\n";
    echo "Required Skills : \n\n";
    echo "".$row['Required skills']."\n\n\n";
    echo "Duties and Responsibilities : \n\n";
    echo "".$row['Duties and responsibilities']."\n";
}
echo "";

?>
	
			

		