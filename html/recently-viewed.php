<?php
require_once("config.php");
require_once 'class.user.php';
$user_home = new USER();
if(!isset($_SESSION['empSession']))
{
		 $user_home->redirect('index-recruiter.php');
   
} 
$stmt = $user_home->runQuery("SELECT * FROM tbll_emplyer WHERE emp_id=:eid");
$stmt->execute(array(":eid"=>$_SESSION['empSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$sqlv1= "SELECT *,J.JUser_Id ,J.currentdate FROM tbl_employerview sJ
LEFT JOIN tbll_emplyer e ON sJ.emp_id = e.emp_id
LEFT JOIN tbl_jobseeker J ON sJ.JUser_Id = J.JUser_Id
JOIN tbl_currentexperience Jd ON J.JUser_Id = Jd.JUser_Id
JOIN tbl_location L on J.JpLoc_Id=L.Loc_Id
LEFT JOIN tbl_education Ed on J.JUser_Id= Ed.JUser_Id 
LEFT JOIN tbl_qualification qo on Ed.Qual_Id=qo.Qual_Id 
WHERE J.JuserStatus='A' AND J.jdndstatus='0' AND e.emp_id ='".$row['emp_id']."' Group by J.currentdate DESC ORDER BY sJ.Date DESC "; 	

$resultv1 = mysqli_query($con,$sqlv1); 
$count=mysqli_num_rows($resultv1);	
if(isset($_POST['Subs'])){
$sql1.="";
}
else{
	$sql1.="LIMIT 10";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with Needyin</title>
  
    <?php include"source.php"; ?>
</head>

<body>
    <?php 
include_once("analyticstracking.php");
include'includes-recruiter/db-recruiter-header.php' ?>
     
        <main>
         
            <section class="db-recruiter">
                <div class="container">
              
                    <div class="row">
                        <div class="col-md-12">
                            <article class="dbpage-title">
                                <h4 class="h4"> <i class="fa fa-users" aria-hidden="true"></i> Profiles</h4> </article>
                        </div>
                    </div>
                
                  
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-profiles nav-default">
								<li><a href="dbrecruiter-latest.php"><i class="fa fa-address-book" aria-hidden="true"></i> LATEST PROFILES <span></span> </a></li>
                                <li><a href="dbrecruiter-profles.php"><i class="fa fa-exchange" aria-hidden="true"></i> MATCHED PROFILES <span></span> </a></li>
								<li><a class="nav-select-db" href="recently-viewed.php"><i class="fa fa-eye" aria-hidden="true"></i> PROFILES SCREENED <span>(<?php echo $count; ?>)</span> </a></li>
                                <li><a href="dbrecruiter-profles-shortlist.php"><i class="fa fa-heart" aria-hidden="true"></i> SHORTLISTED PROFILES <span></span> </a></li>
                                <li><a href="dbrecruiter-sche-int.php"><i class="fa fa-calendar" aria-hidden="true"></i> SCHEDULED INTERVIEW<span></span> </a></li>
								<li><a href="job-viewed.php"><i class="fa fa-id-card-o" aria-hidden="true"></i> JOBS VIEWED <span></span> </a></li>								
                            </ul>
                        </div>
                    </div>
                  
                    <?php include "includes-recruiter/recent-views.php"; ?>
                
                       
                </div>
            </section>
    
        </main>
     
        <?php include"footer.php";  ?>
</body>

</html>