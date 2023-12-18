<?php
require_once("config.php");
require_once 'class.user.php';
$reg_user = new USER();
if(isset($_POST['save']))
{
	$juserid=$_POST['juserid'];
			$empid=$_POST['empid'];
			$jobid=$_POST['jobid'];
			 $current_page=$_POST['current_page']; 
              $ss="select JPLoc_Id,Job_Skills,nri_status,JTotalEy,JuserStatus from tbl_jobseeker where JUser_Id=".$juserid;
                 $ss_res=mysqli_query($con,$ss);
                 $ss_data=mysqli_fetch_array($ss_res);
                  $loc=$ss_data['JPLoc_Id']; 
                  $prof_skills=$ss_data['Job_Skills'];
				  $js_exp=$ss_data['JTotalEy'];
                 $jobseeker_skills=explode(",",$prof_skills);










?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
    <!-- css includes-->
    <?php include"source.php" ?>
        <script>
            $(document).ready(function () {
                $('.modal').modal();
            });
        </script>
</head>

<body>
    <?php 
	include_once("analyticstracking.php");
	include "postlogin-header-jobseekar.php" ?>
        <!-- main-->
        <main>
            <section class="jobseekar-profile">
                <?php include "inner-menu.php" ;?>
                
                <!-- job seekar header -->
                <!-- job seekar body -->
                <section class="job-seekar-body">
                    <div class="js-profile-nav">
                        <!-- job seekear profile navigation -->
                        <div class="container">
                            <!-- update resume block -->
                            <div class="update-cv">
                                <div class="title-block-tab">
                                    <h4 class="flight">SAVED <span class="fbold">JOBS</span></h4> </div>
                                <!--change password -->
                                <div class="JOBS">
                                  
                                            </div>
                                        
                                    
                                  
                                <!--/ change password -->
                            </div>
                            <!--/ update resume block -->
                        </div>
                    </div>
                    <!-- job seekar profile navigation -->
                </section>
                <!-- / job seekar body -->
            </section>
        </main>
        <!--/main-->
        <!-- footer-->
        <?php //include 'footer.php'; ?>
            <!--/footer-->
</body>

</html>