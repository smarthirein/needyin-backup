<?php 
session_start();
require_once 'class.user.php';
$emp_login = new USER();

if(!$emp_login->is_logged_in())
{
    $emp_login->redirect('index.php');
} 
$stmt = $emp_login->runQuery("SELECT * FROM tbll_emplyer WHERE emp_id=:rid");
$stmt->execute(array(":rid"=>$_SESSION['empSession']));
$rows = $stmt->fetch(PDO::FETCH_ASSOC);
$nt_query="select * from tbl_notifications where notification_to='".$_SESSION['empSession']."' and mode='jobseeker'";
$nt_res=mysqli_query($con,$nt_query);
  $jb_qq="select * from tbl_jobseeker where JUser_Id='".$_GET['uid']."' ";
     $jb_res=mysqli_query($con,$jb_qq);
   $data=mysqli_fetch_array($jb_res);
   print_r($data);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
   
    <?php include "source.php" ?>
        <script>
            $(document).ready(function () {
                $("#txtEditor").Editor();
            });
        </script>
</head>

<body>
    <?php 
	   include_once("analyticstracking.php");
	   include "includes-recruiter/db-recruiter-header.php";?>
     
        <main>
            <section class="jobseekar-profile">
                <div class="job-seekar-header">
                    <div class="container">
                      
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="header-top-btns pull-right" style="padding-bottom:0;">
                                    <li><a class="btn waves-effect waves-light" href="job-search-results-postlogin.php">Latest Jobs</a></li>
                                    <li><a class="btn waves-effect waves-light" href="appliedjobs.php">Applied Jobs</a></li>
                                    <li><a class="btn waves-effect waves-light" href="js-recruiter-view.php">Recruiter View</a></li>
                                    <li><a class="btn waves-effect waves-light" href="jobseeker-profile-update-resume.php">Update Resume</a></li>
                                </ul>
                            </div>
                        </div>
                      
                    </div>
                </div>
              
                <div class="container">
                    <ul class="bcrumb-listjobs">
                        <li> <a href="index.php">Home</a> </li>
                        <li> <a href="jobseeker-profile.php"><?php echo $data['JFullName'];?></a> </li>
                        <li> <a href="notifications.php">Notifications</a> </li>                       
                    </ul>
                </div>
               
                <section class="job-seekar-body">
                    
                    <div class="container">
                       
                        <div class="notifications-block">
                           
                            <div class="notification-detail">
                                <p class="msg-detail-del"><a href="notifications.php"><i class="fa fa-bell-o" aria-hidden="true"></i> Back to Inbox</a> <a href="#!"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a></p>
                                <article class="sub-from">
                                    <p>Subject: <b>Job | Job opportunity with Affluent Global Services</b></p>
                                    <p>From: <b>Affluent Global Services Pvt. Ltd. </b> <span class="flight">on 28-02-2017</span></p>
                                    <p>Experience required for the Job: <b>4 - 6 years</b></p>
                                    <p>Job Location: <b>Hyderabad, Hyderabad / Secunderabad</b></p>
                                </article>
                                <article class="msg-rec">
                                    <p><b>Dear Candidate,</b></p>
                                    <p class="text-justify">Job opportunity with Affluent Global Services.</p>
                                    <p>Affluent Global Services in the capacity of HR Executive. AGS (ISO 9001-2015) is a 4 year old company headed by individuals with a total experience of 45 years in this IT industry. We pride ourselves to be the Microsoft Gold Certified Development partner of Microsoft and focus on Microsoft Technologies Development and testing. With a development centre in Madhapur and Ahmedabad in India and presence in China and Mexico, we have plans to initiate our office in Dubai, Singapore and North America this year. Please visit www.affluentgs.com for our brief profile. </p>
                                    <p>Work location: <span class="fbold">Hyderabad</span></p>
                                    <p>Interview Date <span class="fbold">24-12-2016</span></p>
                                    <p>JAVA,Database - SQL Server, Oracle,Hibernate, Struts</p>
                                    <p>Good vocal and written communication skills</p> <address class="add">
                                    <p>Regards,</p>
                                    <p>Shiva Ranjani | Human Resource</p>
                                    <p>M: +91- 8019022445</p>
                                </address> </article>
                            </div>
                            
                        </div>
                       
                    </div>
                </section>
               
            </section>
        </main>
       
        <script>
            $(document).ready(function () {
                Materialize.updateTextFields();
            });
        </script>
      
        <?php include 'footer.php'?>
        
</body>

</html>