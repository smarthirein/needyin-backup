<?php 
session_start();
require_once("config.php");
require_once 'class.user.php';
$user_home = new USER();
if(!$user_home->is_logged_in())
{
	$user_home->redirect('index-recruiter.php');
}
$stmt = $user_home->runQuery("SELECT * FROM tbll_emplyer WHERE emp_id=:eid");
$stmt->execute(array(":eid"=>$_SESSION['empSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$sql1= "SELECT * FROM tbl_shortlisted sJ
LEFT JOIN tbll_emplyer e ON sJ.emp_id = e.emp_id
LEFT JOIN tbl_jobseeker J ON sJ.JUser_Id = J.JUser_Id
JOIN tbl_currentexperience Jd ON J.JUser_Id = Jd.JUser_Id
JOIN tbl_location L on J.JpLoc_Id=L.Loc_Id
LEFT JOIN tbl_education Ed on J.JUser_Id= Ed.JUser_Id 
LEFT JOIN tbl_qualification qo on Ed.Qual_Id=qo.Qual_Id 
WHERE J.JuserStatus='A' AND e.emp_id ='".$row['emp_id']."' Group by J.JUser_Id ORDER BY sJ.screated DESC";		
$result1 = mysqli_query($con,$sql1); 
$count=mysqli_num_rows($result1);	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with Needyin</title>
    <!-- css includes-->
    <?php include"source.php" ?>
</head>
<body>
    <?php 
	include_once("analyticstracking.php");
	include'includes-recruiter/db-recruiter-header.php'; ?>
      
        <main>
           
            <section class="db-recruiter">
                <div class="container">
                    <!-- title row-->
                    <div class="row">
                        <div class="col-md-12">
                            <article class="dbpage-title">
                                <h4 class="txt-blue h4"> <i class="fa fa-users" aria-hidden="true"></i> PROFILES</h4> 
							</article>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-profiles nav-default">
								<li><a href="dbrecruiter-latest.php">LATEST PROFILES <span></span> </a></li>
                                <li><a class="nav-select-db" href="#!">MATCHED PROFILES <span>(<?php echo $count; ?>)</span> </a></li>
                                <li><a href="dbrecruiter-profles-shortlist.php">SHORTLISTED PROFILE <span>(</span> </a></li>
                                <li><a href="recently-viewed.php">RECENTLY VIEWED <span></span> </a></li>
                            </ul>
                        </div>
                    </div>
                   
                    <?php include "includes-recruiter/top-profiles.php"; ?>
                    
            </div>
             </section>
        </main>
       
        <?php include "footer.php"; ?>
</body>

</html>