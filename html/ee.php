<?php
session_start();
require_once("config.php");
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
	$user_home->redirect('index.php');
}
$stmt = $user_home->runQuery("SELECT * FROM tbl_jobseeker u
							  JOIN tbl_currentexperience cexp on u.JUser_Id=cexp.JUser_Id
							  WHERE u.JUser_Id=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
    <!-- css includes-->
    <?php include"source.php" ?>
<script type="text/javascript">
            $(document).ready(function () {
                $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
                    localStorage.setItem('activeTab', $(e.target).attr('href'));
                });
                var activeTab = localStorage.getItem('activeTab');
                if (activeTab) {
                    $('#myTab a[href="' + activeTab + '"]').tab('show');
                }
            });
        </script>	
</head>

<body>
    <?php include"postlogin-header-jobseekar.php"?>
        <!-- main-->
        <main>
            <section class="jobseekar-profile">
                <div class="job-seekar-header">
                    <div class="container">
                        <!-- top right buttons -->
<div class="row">
                            <div class="col-md-12">
                                <ul class="header-top-btns pull-right">
                                    <li><a class="btn waves-effect waves-light" href="job-search-results-postlogin.php">Latest Jobs</a></li>
                                    <li><a class="btn waves-effect waves-light" href="appliedjobs.php">Applied Jobs</a></li>
                                    <li><a class="btn waves-effect waves-light" href="js-recruiter-view.php">Recruiter View</a></li>
                                    <li><a class="btn waves-effect waves-light" href="jobseeker-profile-update-resume.php">Update Resume</a></li>
                                </ul>
                            </div>
                        </div>
                        <!--/ top right buttons -->
                        <!-- profile primary details -->
                        <div class="row">
                            <!-- profile piccutre -->
                            <div class="col-md-3 piccol">
                                <figure class="profile-pic-js">
								 <?php 
																
																 $sql = "SELECT JPhoto FROM tbl_jobseeker WHERE JUser_Id=".$row['JUser_Id'];
																			$result = mysqli_query($con,$sql);
																			$row1 = mysqli_fetch_array($result);
																			$profileLogo=$row1['JPhoto']; if($profileLogo){?>
								<img src="<?php echo $profileLogo; ?>" class="img-responsive" >
																			<?php } else { ?> <img src="img/profile-pic.jpg" class="img-responsive" > <?php } ?>
                                    <div class="file-field input-field btn-block">
									<form name="logos" action="general-info.php" method="post" enctype="multipart/form-data">
									<div class="btn"> <span>Update Profile picture</span>
                                            <input type="file" id="logo" name="logo"> </span>
									</div>
									<input type="submit"  name="Savelogo" value="Save" class="btn waves-effect waves-light btn-blue-sm "/>
                                    </form>
									</div>
									 
                                </figure>
                            </div>
                            <!--/ profile picture -->
                            <!-- jobseekar basic details in header -->
                            <div class="col-md-9">
                                <div class="js-basicdetails">
                                    <h2 class="h2 fbold"><?php echo $row['JFullName']; ?></h2>
                                    <h5 class="flight"><?php echo $row['Des']; ?> at <?php echo $row['Company_Name']; ?>,  Hyderabad</h5>
                                    <article class="js-contact-det"> <span class="flight"> <i class="fa fa-phone" aria-hidden="true"></i> +91 <?php echo $row['JPhone']; ?></span> <span class="flight"><i class="fa fa-envelope" aria-hidden="true"></i>  <?php echo $row['JEmail']; ?></span> </article>
                                </div>
                            </div>
                            <!--/ jobseekar basic details in header -->
                        </div>
                        <!--/ profile primary details -->
                    </div>
                </div>
                <!-- job seekar header -->
                <!-- job seekar body -->
                <section class="job-seekar-body">
                    <div class="js-profile-nav">
                        <!-- job seekear profile navigation -->
                        <div class="container">
                            <ul class="nav nav-tabs responsive-tabs col-md-9 col-md-offset-3 nav-profile " id="myTab">
                                <li class="active"><a href="#geninfo" data-toggle="tab"><i class="fa fa-user-o" aria-hidden="true"></i> General Information</a></li>
                                <li><a href="#education" data-toggle="tab"><i class="fa fa-book" aria-hidden="true"></i> Education</a></li>
                                <li><a href="#proexp" data-toggle="tab"><i class="fa fa-black-tie" aria-hidden="true"></i> Professional Experience</a></li>
                                <li><a href="#skills" data-toggle="tab"><i class="fa fa-cog" aria-hidden="true"></i> Skills</a></li>
                            </ul>
                            <!-- profile discription content -->
                            <div class="tab-content profile-body-content">
                                <div class="tab-pane active" id="geninfo">
                                    <div class="tabjsinfo-content">
                                        <?php include'general-info-js.php'?>
                                    </div>
                                </div>
                                <div class="tab-pane" id="education">
                                    <div class="tabjsinfo-content">
                                        <?php include'education-info-js.php'?>
                                    </div>
                                </div>
                                <div class="tab-pane" id="proexp">
                                    <div class="tabjsinfo-content">
                                        <?php include'prof-exp-js.php'?>
                                    </div>
                                </div>
                                <div class="tab-pane" id="skills">
                                    <div class="tabjsinfo-content">
                                        <?php include'skills-info-js.php'?>
                                    </div>
                                </div>
                            </div>
                            <!-- /profile discription content -->
                        </div>
                    </div>
                    <!-- job seekar profile navigation -->
                </section>
                <!-- / job seekar body -->
        </main>
        <!--/main-->
        <!-- responsive tabs -->
        <script>
            $('.responsive-tabs').responsiveTabs({
                accordionOn: ['xs', 'sm']
            });
        </script>
        <!--/responsive tabs-->
        <!-- tool tip-->
        <script>
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
        <!-- tool tip -->
        <!-- updae text field -->
        <script>
            $(document).ready(function () {
                Materialize.updateTextFields();
            });
        </script>
        <!-- updtae text field -->
        <script>
            $('.datepicker').pickadate({
                selectMonths: true, // Creates a dropdown to control month
                selectYears: 100 // Creates a dropdown of 15 years to control year
            });           
        </script>
        <!-- alert examples -->
        <div class="container">
            <div class="alert alert-success alert-dismissible" id="myAlert"> <a href="#" class="close">&times;</a> <strong>Success!</strong> Profile Overview Updated successfully </div>
        </div>
        <!-- alert examples -->
        <!-- footer-->
        <?php include 'footer.php'?>
            <!--/footer-->
</body>

</html>