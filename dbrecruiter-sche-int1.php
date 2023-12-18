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
$sqlv1= "SELECT J.JFullName,J.JPhoto,sJ.scheduled_on,J.JUser_Id,e.emp_id,e.status,J.JFullName,J.JEmail,J.JTotalEy,J.JTotalEm,J.JuserStatus,J.JPLoc_Id,J.Job_Skills,Jd.NoticePeriod,Jd.CurrentSalL,Jd.CurrentSalT,Jd.ExpSalL,Jd.ExpMaxSalL,Jd.Company_Name,jobposted.Job_Name,qo.Qual_Name,L.Loc_Name,Jd.Des FROM interviewscheduled sJ
LEFT JOIN tbll_emplyer e ON sJ.emp_id = e.emp_id
LEFT JOIN tbl_jobseeker J ON sJ.juser_id= J.JUser_Id
JOIN tbl_currentexperience Jd ON J.JUser_Id = Jd.JUser_Id
JOIN tbl_location L on J.JpLoc_Id=L.Loc_Id
LEFT JOIN tbl_education Ed on J.JUser_Id= Ed.JUser_Id 
LEFT JOIN tbl_qualification qo on Ed.Qual_Id=qo.Qual_Id 
LEFT JOIN tbl_jobposted jobposted on sJ.job_id= jobposted.Job_Id WHERE J.JuserStatus='A' AND J.jdndstatus='0' AND e.emp_id ='".$row['emp_id']."' and jobposted.Job_Status=1 Group by J.Juser_Id DESC ORDER BY J.currentdate DESC "; 	
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
	<script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#loding1").hide();
                $(".education").change(function () {
                    $("#loding1").show();
                    var id = $(this).val();
					var empid= $("#empid").val();
					var juserid= $("#juserid").val();
					alert (juserid);
                    $("#PSpeca").find('option').remove();
                    $.ajax({
                        type: "POST",
                        url: "getScheduled.php",	
						data: 'id=' + id+'&empid='+ empid+'&juserid='+juserid,
                        cache: false,
                        success: function (e) {
                            $("#loding1").hide();
                            $("#PSpeca"+juserid).html(e);
                        }
                    });
                });
            });
        </script>
  
    <?php include"source.php" ?>
</head>

<body>
    <?php include'includes-recruiter/db-recruiter-header.php'; ?>
       
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
									<li><a href="dbrecruiter-profles.php"><i class="fa fa-exchange" aria-hidden="true"></i> MATCHED PROFILES </a></li>
									<li><a href="recently-viewed.php"><i class="fa fa-eye" aria-hidden="true"></i> PROFILES SCREENED <span></span> </a></li>
									<li><a href="dbrecruiter-profles-shortlist.php"><i class="fa fa-heart" aria-hidden="true"></i> SHORTLISTED PROFILES <span></span> </a></li>
									<li><a class="nav-select-db" href="dbrecruiter-sche-int.php"><i class="fa fa-calendar" aria-hidden="true"></i> SCHEDULED INTERVIEW<span>(<?php echo $count; ?>)</span> </a></li>									
									<li><a href="job-viewed.php"><i class="fa fa-id-card-o" aria-hidden="true"></i> JOBS VIEWED <span></span> </a></li>
									
                            </ul>
                        </div>
                    </div>
                 
                    <?php include "includes-recruiter/schedule-profiles.php"; ?>
                       
                </div>
            </section>
         
        </main>
      
</body>

</html>