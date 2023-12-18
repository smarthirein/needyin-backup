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

$JUser_Id=$_REQUEST['uid'];
$profile_user_id = trim($JUser_Id);
    $visitor_user_id = trim($row['emp_id']); 
 $cv1="select empid,userid from tbl_recent_views where userid='".$JUser_Id."' and empid='".$row['emp_id']."'";
$resultv41 = mysqli_query($con,$cv1);
$rowv41= mysqli_fetch_array($resultv41); 

	if($rowv41['userid'] =="" && $rowv41['empid'] =="" && Action!="Viewed"){
		 if($profile_user_id != $visitor_user_id){
 $sql1 = "INSERT INTO tbl_recent_views (userid,empid,Activity,Action) VALUES ($profile_user_id, $visitor_user_id,'Profile is viewed ','Viewed')";
 mysqli_query($con,$sql1);
 
  }
}
$cv="select emp_id,JUser_Id from tbl_employerview where JUser_Id='".$JUser_Id."' and emp_id='".$row['emp_id']."'";
$resultv4 = mysqli_query($con,$cv);
$rowv4= mysqli_fetch_array($resultv4); 
if($rowv4['JUser_Id'] =="" && $rowv4['emp_id'] ==""){


    // this will store the data in tbl_employerview including date and time if id's are not equal.
    if($profile_user_id != $visitor_user_id){
        $sql = "INSERT INTO tbl_employerview (JUser_Id,emp_id, Date) VALUES ($profile_user_id, $visitor_user_id, NOW())";	   
       mysqli_query($con,$sql);
	
	   
    }
}

 $jc1= "SELECT * FROM tbl_jobseeker WHERE JUser_Id=".$JUser_Id;
$jresult1 = mysqli_query($con,$jc1);
$jrow = mysqli_fetch_array($jresult1);

 $c1= "SELECT * FROM tbl_currentexperience   WHERE JUser_Id=".$JUser_Id;
$result1 = mysqli_query($con,$c1);
$row1 = mysqli_fetch_array($result1);
//print_r($row1);



$c3="Select Loc_Id,Loc_Name from tbl_location where Loc_Id=".$jrow['JPLoc_Id'];
$result3 = mysqli_query($con,$c3);
$row3= mysqli_fetch_array($result3); 

$c4="Select Loc_Id,Loc_Name from tbl_location where Loc_Id=".$row1['Loc_Id'];
$result4 = mysqli_query($con,$c4);
$row4= mysqli_fetch_array($result4); 

function dateDiff($start, $end) {
  $start_ts = strtotime($start);
  $end_ts = strtotime($end);
  $diff = $end_ts - $start_ts;
  return round($diff / 86400);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
    <!-- css includes-->
	
	
    <?php include"source.php" ?>
	 <script type="text/javascript" src="js/jquery.bootstrap-responsive-tabs.min.js"></script>
	
	<script type="text/javascript">
	

    </script>
</head>

<body>
    <?php
	include_once("analyticstracking.php");
	include 'includes-recruiter/db-recruiter-header.php'; ?>
        <!-- main-->
        <main>
            <!-- recruiter view -->
            <section class="rec-view">
                <!-- brudcrumb -->
                <div class="container">
                    <ul class="bcrumb-listjobs">
                        <li> <a href="index.php">Home</a> </li>
                        <li> <a href="dbrecruiter-profles.php">Latest Profiles</a> </li>
                        <li> <a><?php echo $jrow['JFullName']; ?></a> </li>
                    </ul>
                </div>
                <!--/ brudcrumb -->
                <!-- recruiter view main -->
                <section class="rec-viewmain">
                    <!-- recruiter view header -->
                    <div class="rec-view-header">
                        <div class="container">
                            <!-- row-->
                            <div class="row">
                                <div class="col-md-2">
                                    <figure class="recview-img"> <img src="<?php if($jrow['JPhoto']){ echo $jrow['JPhoto']; }else{ ?> img/profile-pic.jpg <?php }?>" class="img-responsive"> </figure>
                                </div>
                                <div class="col-md-7">
                                    <div class="recview-basic-details">
                                        <article class="name-view">
                                            <h3 class="fbold"><?php echo $jrow['JFullName']; ?></h3>
                                            <h5 class="txt-white"><?php echo $row1['Des']; ?> at <?php echo $row1['Company_Name']; ?></h5> </article>
                                    </div>
                                    <div class="row rowcan">
                                        <div class="col-md-2">
                                            <div class="features-main-candidate">
                                                <p>Current location</p> <span><?php echo $row4['Loc_Name'] ?></span> </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="features-main-candidate">
                                                <p>Prefered location</p> <span><?php echo $row3['Loc_Name'] ?></span> </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="features-main-candidate">
                                                <p>Experience</p> <span><?php echo $jrow['JTotalEy']; ?>.<?php echo $jrow['JTotalEm']; ?> years</span> </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="features-main-candidate">
                                                <p>Expected offer</p> <span><?php echo $row1['ExpSalL'];  ?>lakhs</span> <span><?php echo $row1['ExpMaxSalL'];  ?>thousands</span> </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="features-main-candidate">
                                                <p>Notice Period</p> <span><?php  ?><?php if($row2['NoticePeriod']=='1'){echo "Immdidate";}else {echo $row1['NoticePeriod']; }?> days</span> </div>
                                        </div>
                                    </div>
                                    <article class="details-contact">
                                        <p><span><i class="fa fa-phone" aria-hidden="true"></i> +91 <?php echo $jrow['JPhone']; ?></span> <span><i class="fa fa-envelope-o" aria-hidden="true"></i>
										<?php echo $jrow['JEmail']; ?></span> 
										<span>
											<?php 
											$from=date('Y-m-d');
											$to=$jrow['currentdate'];
											echo dateDiff($to,$from).'days';
											?>
										</span>
										</p>
                                    </article>
                                </div>
                                <!-- recruiter options -->
                                <div class="col-md-3">
                                    <div class="options-rec">
                                        <ul>
										<li><a href="<?php echo $row1['PaySlip'] ?>" download target="_blank"><i class="fa fa-download" aria-hidden="true"></i> Download Payslip</a></li>
                                            <li><a href="<?php echo $row1['UpdateCV'] ?>" download target="_blank"><i class="fa fa-download" aria-hidden="true"></i> Download Resume</a></li>
                                            <li><a href="#shortlist"><i class="fa fa-heart-o" aria-hidden="true"></i> Shortlist Profile</a></li>
											<li><a href="#shortlist"><i class="fa fa-heart-o" aria-hidden="true"></i> Applied For Job:</a></li>
                                            <li><a href="#msg-pop"><i class="fa fa-envelope-o" aria-hidden="true"></i> Message</a></li>
                                            <li><a href="#schedule-pop"><i class="fa fa-calendar" aria-hidden="true"></i> Schedule</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- / recruiter options -->
                            </div>
                            <!-- / row -->
                        </div>
                    </div>
                    <!-- /recruiter view -->
                    <!-- recruiter view tab-->
                    <!-- job seekar body -->
                    <section class="job-seekar-body">
                        <div class="js-profile-nav recview">
                            <!-- job seekear profile navigation -->
                            <div class="container">
                                <ul class="nav nav-tabs responsive-tabs col-md-12 nav-profile">
                                    <li class="active"><a href="#geninfo"><i class="fa fa-user-o" aria-hidden="true"></i> General Information</a></li>
                                    <li><a href="#education"><i class="fa fa-book" aria-hidden="true"></i> Education</a></li>
                                    <li><a href="#proexp"><i class="fa fa-black-tie" aria-hidden="true"></i> Professional Experience</a></li>
                                    <li><a href="#skills"><i class="fa fa-cog" aria-hidden="true"></i> Skills</a></li>
                                </ul>
                                <!-- profile discription content -->
                                <div class="tab-content profile-body-content">
                                    <div class="tab-pane active" id="geninfo">
                                        <div class="tabjsinfo-content">
                                            <?php include'general-info-js-rec-view1.php'; ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="education">
                                        <div class="tabjsinfo-content">
                                            <?php include'education-info-js-rec-view1.php' ;?>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="proexp">
                                        <div class="tabjsinfo-content">
                                            <?php include'prof-exp-js-rec-view1.php' ;?>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="skills">
                                        <div class="tabjsinfo-content">
                                            <?php include'skills-info-js-rec-view1.php' ;?>
                                        </div>
                                    </div>
                                </div>
                                <!-- /profile discription content -->
                            </div>
                        </div>
                        <!-- job seekar profile navigation -->
                    </section>
                    <!-- / job seekar body -->
                    <!--/ recruiter view tab-->
                </section>
                <!--/ recruiter view main -->
            </section>
            <!-- recruiter view -->
        </main>
        <!--/main-->
        <div id="shortlist-candidate" class="snackbar"><span><i class="fa fa-check" aria-hidden="true"></i></span> You have successfully Shortlist this Jobseeker</div>
        <?php include 'footer.php'?>
            <!--/footer-->
            <script>
                $('.responsive-tabs').responsiveTabs({
                    accordionOn: ['xs', 'sm']
                });
            </script>
            <!-- shortlist profile popup -->

            <div id="shortlist" class="modal">
                <div class="modal-content">
                  <h4 class="h4 flight">ShortList <span class="fbold">Job Seekar</span></h4>
                      <form method="post" action="visit.php"><div class="modal-content text-center">
							<h3 class="h3 flight">JOB <span class="fbold">Name</span></h3>
							<div class="importjobs-in">
							<?php $cj="select Job_Id,Job_Name from tbl_jobposted where Job_Status=1 and emp_id=".$row['emp_id'];
							$resultcj = mysqli_query($con,$cj); while ($rowji1 = mysqli_fetch_array($resultcj))
							{
							?> 
							<?php $sql2 = "SELECT * FROM tbl_desigination where Desig_Id ='".$jrow['Job_Name']."'";
												$query2 = mysqli_query($con, $sql2);
												$row2 = mysqli_fetch_array($query2);

                                   ?>
							<input name="jobid" value="<?php echo $rowji1['Job_Id'] ?>" type="radio" required="true" id="testcj<?php echo $rowji1['Job_Id'] ?>" />
							<label for="testcj<?php echo $rowji1['Job_Id'] ?>"><?php echo $row2['Desig_Name'] ?></label>																		
							<?php }
							?>
							</div>
							</div>
							<div class="modal-footer"> 
							<input type="hidden" value="<?php echo $JUser_Id; ?>" name="juserids">
							<input type="hidden" value="<?php echo $row['emp_id']; ?>" name="empids">					
							<input type="submit" name="Shortlist1" value="Shortlist" class="modal-action waves-effect waves-green btn-flat">
							<a class=" modal-action modal-close waves-effect waves-green btn-flat">Cancel</a> </div>
						  </form>
            </div>
			</div>
            <!-- shortlist profile popup -->
            <!-- message popup-->
									<?php
 if(isset($_POST['sendmesg'])) {

 // EDIT THE 2 LINES BELOW AS REQUIRED
 $email_from='support@needyin.com';
    $email_to = $jrow['JEmail'];
 
    $email_subject = $_POST['subject'];
	 $message = $_POST['message'];
 
 
 
    $email_message .= "Messagage: ".clean_string($message)."\n";
 
	$mail = new PHPMailer;
                       
						$mail->IsSMTP();
						//$mail->SMTPDebug = 1;

						$mail->Host = 'mail.webmailcommunications.com';
						$mail->SMTPAuth = true;
						$mail->Username = 'support@needyin.com';
						$mail->Password = 'Support@123';
						$mail->SMTPSecure = 'tls';

						$mail->From = $email_from;
						$mail->FromName = 'Needyin';
						$mail->addAddress($email_to);

						$mail->isHTML(true);

						$mail->Subject = $email_subject;
						$mail->Body    = $email_message;
// create email headers
 

 if($mail->send())
 {
?>
 
<!-- include your own success html here -->
 
<script>alert('successfully send messages.');</script>

 
<?php

 }
 else {
	 ?>
	 <script>alert('sorry please try once again.');</script>
	 <?php
 
}
}
 
?>
            <div id="msg-pop" class="modal">
               <form method="post" action="">
                <div class="modal-content text-center">
                    <h3 class="h3 flight">Send <span class="fbold">Message</span></h3>
                    <p class="pb15">You can send message only selected Profiles </p>
                    <div class="importjobs-in">
                        <div class="input-field">
                            <input id="sub-sendmsg" type="text" name="subject">
                            <label for="sub-sendmsg">Subject</label>
                        </div>
                        <div class="input-field">
                            <textarea id="writemsg" class="materialize-textarea" name="message"></textarea>
                            <label for="writemsg">Write a Message</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"> <input type="submit" name="sendmesg" value="Send Message" class=" modal-action waves-effect waves-green btn-flat"> <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Cancel</a> </div>
           
             </form>
			</div>
            <!--/ message popup-->
            <!-- schedule popup-->
			<?php
 
if(isset($_POST['sendschedule'])) {

 // EDIT THE 2 LINES BELOW AS REQUIRED
 $email_from='support@needyin.com';
    $email_to = $jrow['JEmail'];
 $email_subject = "Inteview scheduled on";
$dates = $_POST['dates'];
	 $message = $_POST['message']; 
    $email_message .= "Messagage: ".clean_string($message)."\n";
	$email_message .= "interview Scheduled on: ".clean_string($dates )."\n";  
	$mail = new PHPMailer;
                       
	$mail->IsSMTP();
						

						$mail->Host = 'mail.webmailcommunications.com';
						$mail->SMTPAuth = true;
						$mail->Username = 'support@needyin.com';
						$mail->Password = 'Support@123';
						$mail->SMTPSecure = 'tls';

						$mail->From = $email_from;
						$mail->FromName = 'Needyin';
						$mail->addAddress($email_to);

						$mail->isHTML(true);

						$mail->Subject = $email_subject;
						$mail->Body    = $email_message;

 if($mail->send())
 {
?>
 
<!-- include your own success html here -->
 
<script>alert('successfully send messages.');;</script>

 
<?php

 }
 else {
	 ?>
	 <script>alert('sorry please try once again.');</script>
	 <?php
 
}
}
 
?>    <div id="schedule-pop" class="modal">
            <form method="post" action="">
                <div class="modal-content text-center">
                    <h3 class="h3 flight">Schedule the <span class="fbold">Interview</span></h3>
                    <p class="pb15">You can Schedule the interview to selected candidates </p>
                    <div class="importjobs-in">
                        <div class="input-field">
                            <input type="date" class="datepicker" name="dates">
                            <label>Select Schedule Date</label>
                            <script>
                                $('.datepicker').pickadate({
                                    selectMonths: true, // Creates a dropdown to control month
                                    selectYears: 15 // Creates a dropdown of 15 years to control year
                                });
                            </script>
                        </div>
						 <div class="input-field">
                            <textarea id="writemsg" class="materialize-textarea" name="message"></textarea>
                            <label for="writemsg">Write a Message</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"> 
				<input type="submit" name="sendschedule" value="Make Schedule" class=" modal-action waves-effect waves-green btn-flat"> 
				<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Cancel</a> </div>
			</form>
            </div>
            <!-- /schedule popup-->
</body>

</html>