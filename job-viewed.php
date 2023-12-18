<?php
//session_start();
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
$sqlv1= "SELECT * FROM tbl_jobseekerview sJ
LEFT JOIN tbll_emplyer e ON sJ.emp_id = e.emp_id
LEFT JOIN tbl_jobseeker J ON sJ.JUser_Id = J.JUser_Id
JOIN tbl_currentexperience Jd ON J.JUser_Id = Jd.JUser_Id
JOIN tbl_location L on J.JpLoc_Id=L.Loc_Id
LEFT JOIN tbl_education Ed on J.JUser_Id= Ed.JUser_Id 
LEFT JOIN tbl_qualification qo on Ed.Qual_Id=qo.Qual_Id 
LEFT JOIN tbl_jobposted jobposted on sJ.emp_id= jobposted.emp_id
WHERE J.JuserStatus='A' AND J.jdndstatus='0' AND e.emp_id ='".$row['emp_id']."'  Group by J.JUser_Id DESC ORDER BY sJ.Date DESC "; 	
$resultv1 = mysqli_query($con,$sqlv1); 
$count=mysqli_num_rows($resultv1);	
if(isset($_POST['Subs'])){
$sql1.="";
}
else
{
	$sql1.="LIMIT 10";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with Needyin</title>
    <!-- css includes-->
    <?php include"source.php"; ?>
</head>

<body>
    <?php
include_once("analyticstracking.php");
include'includes-recruiter/db-recruiter-header.php' ?>
        <!-- main-->
        <main>
            <!--dashboard of profiles section -->
            <section class="db-recruiter">
                <div class="container">
                   <!--ad space -->
                <!--  <div class="row row2images">
                      <div class="col-md-6"><figure><a href="javascript:void(0)"><img class="img-responsive" src="img/ads-img/ad-home01.jpg"></a></figure></div>
                       <div class="col-md-6"><figure><a href="javascript:void(0)"><img class="img-responsive" src="img/ads-img/ad-home02.jpg"></a></figure></div>
                  </div>-->
                  <!-- / ad space-->
                    <!-- title row-->
                    <div class="row">
                        <div class="col-md-12">
                            <article class="dbpage-title">
                                <h4 class="h4"> <i class="fa fa-users" aria-hidden="true"></i> Profiles</h4> </article>
                        </div>
                    </div>
                    <!--/ title row-->
                    <!-- profiles navigation -->
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-profiles nav-default">
								<li><a href="dbrecruiter-latest.php"><i class="fa fa-address-book" aria-hidden="true"></i> Latest Profiles <span></span> </a></li>
                                <li><a href="dbrecruiter-profles.php"> <i class="fa fa-exchange" aria-hidden="true"></i> Matched Profiles <span></span> </a></li>
                                <li><a href="dbrecruiter-profles-shortlist.php"><i class="fa fa-heart" aria-hidden="true"></i> Shortlisted Profiles <span></span> </a></li>
								<li><a href="dbrecruiter-sche-int.php"><i class="fa fa-calendar" aria-hidden="true"></i> Scheduled Interview<span></span> </a></li>
								<li><a class="nav-select-db" href="job-viewed.php"><i class="fa fa-id-card-o" aria-hidden="true"></i> Jobs Viewed <span>(<?php echo $count; ?>)</span> </a></li>								
                            </ul>
                        </div>
                    </div>
                    <!-- profiles navigation -->
                    <?php include "includes-recruiter/job-views.php"; ?>
                        <!-- top profiles list -->
                        <!-- top profiles list -->
						<!-- <a class="load-more btn" href="#!">Load More</a> </div>-->
                </div>
            </section>
            <!--/ dtashboard of profiles section -->
        </main>
        <!--/main-->
        <?php //include "footer.php";  ?>
</body>

</html>