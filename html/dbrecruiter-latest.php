<?php 
session_start();
 header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire');
session_cache_limiter('public'); 
require_once 'class.user.php';
$user_home = new USER();
if(!isset($_SESSION['empSession']))
{
$user_home->redirect('index-recruiter.php');   
} 
$stmt = $user_home->runQuery("SELECT * FROM tbll_emplyer WHERE emp_id=:eid");
$stmt->execute(array(":eid"=>$_SESSION['empSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$sql1= "SELECT J.JFullName,J.jReasonType,J.JUser_Id,J.Gender,J.currentdate,J.jdndstatus,J.JPhoto,J.currentdate,J.JTotalEy,J.JTotalEm,J.JPLoc_Id,Jd.Company_Name,Jd.NoticePeriod,Jd.Des,Jd.NoticePeriod,L.Loc_Name,Jd.CurrentSalL,Jd.CurrentSalT,
Jd.ExpSalL,Jd.ExpMaxSalL,qo.Qual_Name
FROM tbl_jobseeker J
JOIN tbl_currentexperience Jd ON J.JUser_Id = Jd.JUser_Id
LEFT JOIN tbl_location L on J.JpLoc_Id=L.Loc_Id
LEFT JOIN tbl_education Ed on J.JUser_Id= Ed.JUser_Id 
LEFT JOIN tbl_qualification qo on Ed.Qual_Id=qo.Qual_Id  
WHERE J.JuserStatus='A' and J.jdndstatus='0' Group by J.JUser_Id 
ORDER BY J.currentdate DESC ";	 
if(isset($_POST['Subs'])){

$sql1.=" ";
}
else{
	$sql1.="LIMIT 10";
}
$result1 = mysqli_query($con,$sql1); 
$count=mysqli_num_rows($result1);      
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
   
    <?php include"source.php" ?>
</head>

<body>
    <?php 
	include_once("analyticstracking.php");
	include 'includes-recruiter/db-recruiter-header.php'; ?>
       
        <main>
         
            <section class="db-recruiter">
                <div class="container">
                
                   <div class="row"></div>
                   
                    <div class="">
                            <article class="dbpage-title">
                                <h4 class="h4"> <i class="fa fa-users" aria-hidden="true"></i> Profiles</h4> </article>
                    </div>
                   
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-profiles nav-default">
								<li><a class="nav-select-db" href=""> <i class="fa fa-address-book" aria-hidden="true"></i> Latest Profiles <span>(<?php echo $count; ?>)</span> </a></li>
								<li><a href="dbrecruiter-profles.php"><i class="fa fa-exchange" aria-hidden="true"></i> Matched Profiles </a></li>
								<li><a href="dbrecruiter-profles-shortlist.php"><i class="fa fa-heart" aria-hidden="true"></i> Shortlisted Profiles <span></span> </a></li>
								<li><a href="dbrecruiter-sche-int.php"><i class="fa fa-calendar" aria-hidden="true"></i> Scheduled Interview<span></span> </a></li>
								<li><a href="job-viewed.php"><i class="fa fa-id-card-o" aria-hidden="true"></i> Jobs Viewed <span></span> </a></li>
                                <!-- <li><a href="resumeupload.php"><i class="fas fa-file-upload" aria-hidden="true"></i> Upload Resumes <span></span> </a></li>									 -->
							</ul>
                        </div>
                    </div>
                   
                    <?php include "includes-recruiter/latest-profiles.php"; ?>
                       
                        
                </div>
            </section>
          
        </main>
        
       
</body>

</html>