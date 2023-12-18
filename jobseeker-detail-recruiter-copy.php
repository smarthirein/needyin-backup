<?php 
session_start();
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


 
$jc1= "SELECT * FROM tbl_jobseeker WHERE JUser_Id='".$JUser_Id."' and jdndstatus='0' ";
$jresult1 = mysqli_query($con,$jc1);
$jrow = mysqli_fetch_array($jresult1);

$c1= "SELECT * FROM tbl_currentexperience   WHERE JUser_Id=".$JUser_Id;
$result1 = mysqli_query($con,$c1);
$row1 = mysqli_fetch_array($result1);
$c3="Select Loc_Id,Loc_Name from tbl_location where Loc_Id=".$jrow['JPLoc_Id'];
$result3 = mysqli_query($con,$c3);
$row3= mysqli_fetch_array($result3); 

$c4="Select Loc_Id,Loc_Name from tbl_location where Loc_Id=".$row1['Loc_Id'];
$result4 = mysqli_query($con,$c4);
$row4= mysqli_fetch_array($result4); 
$jc2= "SELECT Job_Name,Comp_Name FROM tbl_jobposted WHERE emp_id='".$row['emp_id']."'";
$jresult2 = mysqli_query($con,$jc2);
$jrow2 = mysqli_fetch_array($jresult2);

function dateDiff($start, $end) {
  $start_ts = strtotime($start);
  $end_ts = strtotime($end);
  $diff = $end_ts - $start_ts;
  return round($diff / 86400);
}

  $cv="select emp_id,JUser_Id from tbl_employerview where JUser_Id='".$JUser_Id."' and emp_id='".$row['emp_id']."'";
$resultv4 = mysqli_query($con,$cv);
$rowv4= mysqli_fetch_array($resultv4); 
//echo count($rowv4);
if(count($rowv4)==0){


    // this will store the data in tbl_employerview including date and time if id's are not equal.
    if(($profile_user_id !="") AND ($visitor_user_id !="")){
     $sql = "INSERT INTO tbl_employerview (JUser_Id,emp_id, Date) VALUES ($profile_user_id, $visitor_user_id, NOW())";	  
       mysqli_query($con,$sql);
	   
	  $jb_email=$jrow['JEmail'];
							                    $subject="Profile is viewed ";
//$message = "Hello ".$jb_data['JFullName']."\n Job matched with your Profile skills \n Just click following link !\n <a href=".$siteurl.">NeedyIn </a> \n Thanks,";
							                    $message .= "Hello ".$jb_data['JFullName']."";
 
						                          $message .= "Your Profile is viewed by by'".$row['companyname']."'!<br /><br />";
						                          $message .= "Just click following link !<br /><br />";
						                           $message .= "<a href=".$siteurl.">NeedyIn </a><br /><br />";
						                          $message .= "Thanks,";
												  $headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                                           // echo $message; 
							                  $user_home->send_mail2($jb_email,$message,$subject);
	   
    }
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
/*$('input.autocomplete').autocomplete({
            data: {
                "Apple": null
                , "Microsoft": null
                , "Google": 'http://placehold.it/250x250'
            }
            , limit: 20
        , });*/
    </script>
</head>

<body>
    <?php include 'includes-recruiter/db-recruiter-header.php'; ?>
        <!-- main-->
        <main>
            <!-- recruiter view -->
            <section class="rec-view">
                <!-- brudcrumb -->
                <div class="container">
                    <ul class="bcrumb-listjobs">
                        <li> <a href="index.php">HOME</a> </li>
                        <li><?php if($_GET['pgid'] ==1){  ?> <a href="dbrecruiter-latest.php">LATEST PROFILES</a> <?php } else if($_GET['pgid'] ==2){?><a href="dbrecruiter-profles.php">MATCHED PROFILES</a> <?php } else if($_GET['pgid'] ==3){?><a href="dbrecruiter-profles-shortlist.php">SHORTLISTED PROFILES</a> <?php } else if($_GET['pgid'] ==4){?><a href="recently-viewed.php">PROFILES VIEWED</a> <?php } else if($_GET['pgid'] ==5){?><a href="job-viewed.php"> PROFILES VIEWED</a> <?php }  else if($_GET['pgid'] ==5){?><a href="dbrecruiter-sche-int.php"> SCHEDULED INTERVIEWS</a> <?php } else {  ?> <a href="dbrecruiter-latest.php">LATEST PROFILES</a> <?php }?></li>
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
                            <div class="">
                               <div class="row">
                                   <div class="col-md-12">
                                        <div class="col-md-2 col-sm-3">
                                    <figure class="recview-img"> <img class="img-cover" data-object-fit="cover" src="<?php if($jrow['JPhoto']){ echo $jrow['JPhoto']; }else{ ?> img/profile-pic.jpg <?php }?>"> </figure>
                                </div>
                                <div class="col-md-10 col-sm-10">
                                    <div class="recview-basic-details">
                                        <article class="name-view">
                                            <h3 class="fbold"><?php echo $jrow['JFullName']; ?></h3>
                                            <h5 class="txt-white"><?php echo $row1['Des']; ?> at <?php echo $row1['Company_Name']; ?></h5> </article>
                                    </div>
                                    <div class="row rowcan">
                                        <div class="col-md-3 col-sm-4">
                                            <div class="features-main-candidate">
                                                <p>Current Location</p> <span><?php echo $row4['Loc_Name'] ?></span> </div>
                                        </div>
                                        <div class="col-md-3 col-sm-4">
                                            <div class="features-main-candidate">
                                                <p>Preferred Location</p> <span><?php echo $row3['Loc_Name'] ?></span> </div>
                                        </div>
                                        <div class="col-md-3 col-sm-4">
                                            <div class="features-main-candidate">
                                                <p>Experience</p> <span><?php echo $jrow['JTotalEy']; ?> Years - <?php echo $jrow['JTotalEm']; ?> Months</span> </div>
                                        </div>
                                        <div class="col-md-3 col-sm-4">
                                            <div class="features-main-candidate">
                                                <p>Expected Offer (Lacs)</p>
												<span>
												Mn: <?php echo $row1['ExpSalL'];  ?> - Mx: <?php echo $row1['ExpMaxSalL']; ?> 
												</span> 
												</div>
                                        </div>
                                         
                                    </div>
                                     <div class="row rowcan">
                                         <div class="col-md-3 col-sm-4">
                                            <div class="features-main-candidate">
                                                <p>Notice Period</p> <span><?php// echo $row1['NoticePeriod']; ?><?php if($row1['NoticePeriod']=='1'){echo "Immediate";}else {echo $row1['NoticePeriod']." days"; }?>  </span> </div>
                                        </div>
                                        <div class="col-md-9">
                                             <article class="details-contact">
                                        <p><span><i class="fa fa-phone" aria-hidden="true"></i> +91 - <?php echo $jrow['JPhone']; ?></span><span><i class="fa fa-envelope-o" aria-hidden="true"></i>
										<?php echo $jrow['JEmail']; ?></span> 
										<!--<span>
											<?php 
											$from=date('Y-m-d');
											$to=$jrow['currentdate'];
											echo dateDiff($to,$from).'days';
											?>
										</span> -->
										</p>
                                    </article>
                                      
                                        </div>
                                     </div>
                                      
                                    <div class="row">
                                             <div class="options-rec">
                                        <ul>
										
										<?php if(count($row1['PaySlip'])==0){?>
										<li> payslip</li>
										<?php }else { ?> 
										<li><a href="<?php echo $row1['PaySlip']; ?>" download target="_blank"><i class="fa fa-download" aria-hidden="true"></i> Payslip</a></li><?php } ?>
										
                                          <li><a href="<?php if($row1['UpdateCV']){ echo $row1['UpdateCV'];}else { ?> ./img/profile-ic.png <?php } ?>" download target="_blank"><i class="fa fa-download" aria-hidden="true"></i> Resume</a></li> 
										<?php 
											$cv="select * from tbl_shortlisted where JUser_Id='".$JUser_Id."' and emp_id='".$row['emp_id']."'";
											$resultv4 = mysqli_query($con,$cv);
											$rowv4= mysqli_fetch_array($resultv4);  
											 $rowcount=mysqli_num_rows($resultv4);
									if($rowcount){
										?><li><a href="#"><i class="fa fa-heart" aria-hidden="true"></i> Shortlist Profile</a></li>
                                            <li><a href="#msg-pop"><i class="fa fa-envelope-o" aria-hidden="true"></i> Message</a></li>
                                            <li><a href="#schedule-pop"><i class="fa fa-calendar" aria-hidden="true"></i> Schedule</a></li>
											<?php }else{ ?>
											  <?php 
						$cj21="SELECT Job_Skill,Loc_Id FROM tbl_jobposted WHERE emp_id = '".$row[emp_id]."' and Job_Status=1 "; 
			  $resultcj12 = mysqli_query($con,$cj21);  			
					while($result_cj12=mysqli_fetch_array($resultcj12))
                          {  
                             $jobskills[]=$result_cj12['Job_Skill'];
							  $loc[]=$result_cj12['Loc_Id'];
                           }
						  $rowcount=mysqli_num_rows($resultcj12);
						     $jobskills1=array_filter(array_unique($jobskills));
							   $loc1=array_filter(array_unique($loc));
				 $ids = join(",",$jobskills1);
				
				$ids2 =array_unique(explode(",",$ids));
				//print_r($ids2);

				 // $list3 = implode(",",array_unique(array_merge(explode(",",$ids),explode(",",$ids))));
	$loc_id = join(",",$loc1); 
 	$locids =explode(",",$loc_id);
	//print_r($locids);
	
foreach($ids2 as $idss)
{		
	$query11s="select JUser_Id FROM tbl_jobseeker where FIND_IN_SET('$idss',Job_Skills) and JuserStatus='Y' and JUser_Id='".$JUser_Id."'";
	$qu_ress=mysqli_query($con,$query11s);
			while ($qu_data = mysqli_fetch_array($qu_ress)) 
			{
			    $juser_ids[]=$qu_data['JUser_Id'];
				//print_r($juser_ids);
			}
}	
$suids=array_filter(array_unique($juser_ids));		
//print_r($suids);
foreach($locids as $loc)	
{	
 $query22="select JUser_Id FROM tbl_jobseeker where JuserStatus='Y' and  JPLoc_Id='".$loc."' and JUser_Id='".$JUser_Id."' ";
   $qu_res21=mysqli_query($con,$query22);

   while($qu_data2 = mysqli_fetch_array($qu_res21))
   {
      $luser_ids[]=$qu_data2['JUser_Id'];
   }
}
$luserids=array_filter(array_unique($luser_ids));		
//print_r($luserids); 
$c_ids=array_intersect($suids,$luserids);
 $d_cnt=count($c_ids);
                               		if($rowcount==0){
										?>
										 <li><a href="#" onclick="notmatched1();"><i class="fa fa-heart-o" aria-hidden="true"></i> Shortlist Profile</a></li>
									<?php }else{
									if($d_cnt==0){
											?>
                                            <li><a href="#" onclick="notmatched();"><i class="fa fa-heart-o" aria-hidden="true"></i> Shortlist Profile</a></li>
											<?php } else {?> <li><a href="#shortlist"><i class="fa fa-heart-o" aria-hidden="true"></i> Shortlist Profile</a></li>
											
									<?php }
									
									}
									}
											?>
                                        </ul>
                                    </div>
                                        </div>
                                   
                                </div>
                                 
                                   </div>
                                    
                               </div>
                               
                                
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
									 <li><a href="#reasons"><i class="fa fa-map-marker" aria-hidden="true"></i> Reasons to Relocate</a></li>
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
                                            <?php include 'skills-info-js-rec-view1.php' ;?>
                                        </div>
                                    </div>
									<div class="tab-pane" id="reasons">
                                        <div class="tabjsinfo-content">
                                           <?php include 'reasons-view-js-rec-view1.php'; ?>
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
                  <h4 class="h4 flight">ShortList <span class="fbold">Job Seeker</span></h4>
                      <form method="post" action="visit.php" id="visits"><div class="modal-content text-center">
							<h3 class="h3 flight">Job <span class="fbold">Name</span></h3>
							<div class="importjobs-in">
							<?php  
 $cjs="select Job_Id,Job_Name from tbl_jobposted where Job_Status=1 and emp_id=".$row['emp_id'];
							$resultcj = mysqli_query($con,$cjs);

							$rowcount=mysqli_num_rows($resultcj);
							while ($rowji1 = mysqli_fetch_array($resultcj))
							{
							
							?> 
							<input  name="jobid[]" value="<?php echo $rowji1['Job_Id'] ?>" type="checkbox" required="true" id="testcj<?php echo $rowji1['Job_Id'] ?>" onclick="addClass(this)"/>
							
							<?php  $sql2 = "SELECT * FROM tbl_desigination where Desig_Id ='".$rowji1['Job_Name']."'";
							$query2 = mysqli_query($con, $sql2);
							$row2 = mysqli_fetch_array($query2);?>
							<label for="testcj<?php echo $rowji1['Job_Id'] ?>"><?php echo $row2['Desig_Name'] ?></label>																		
							<?php }
							?>
							</div>
							</div>
							<div class="modal-footer"> 
							<input type="hidden" value="<?php echo $JUser_Id; ?>" name="juserids">
							<input type="hidden" value="<?php echo $row['emp_id']; ?>" name="empids">	
							<?php if($rowcount!=0){?>							
							<a class="modal-action waves-effect waves-green btn-flat">
							<input type="submit" name="Shortlist1" onclick="return Validated()" value="Shortlist"></a>
							<!--<a class="modal-action waves-effect waves-green btn-flat"><input type="submit" name="Shortlist1"  value="Shortlist"></a>-->
							<a href="jobseeker-detail-recruiter.php?uid=<?php echo $JUser_Id; ?>" class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</a>
							 </div>
							<?php } ?>
					 </form>
            </div>
			</div>
            <!-- shortlist profile popup -->
            <!-- message popup-->

            <div id="msg-pop" class="modal">
               <form method="post" action="visit.php">
                <div class="modal-content text-center">
                    <h3 class="h3 flight">Send <span class="fbold">Message</span></h3>
                    <p class="pb15 text-center">You can send message only selected Profiles </p>
                    <div class="importjobs-in">
                        <div class="input-field">
						<input  type="hidden" name="email" value="<?php echo $jrow['JEmail']?>,<?php echo $profile_user_id;?>">
					<label for="sub-sendmsg"></label>
                        </div>
                        <div class="input-field">
                            <input  type="hidden" name="comp_name" value="<?php echo $jrow2['Comp_Name']?>">
                             <label for="sub-sendmsg"></label>
                        </div>
                        <div class="input-field">
                           <input id="sub-sendmsg" type="text" name="subject"> 
                           <label for="sub-sendmsg">Subject</label>
                        </div>
                        <div class="input-field">
                            <textarea id="writemsg" class="materialize-textarea" name="message" ></textarea>
                            <label for="writemsg">Write a Message</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"> 
                    <a class=" modal-action waves-effect waves-green btn-flat"><input type="submit" name="sendmesg" value="Send Message" onclick="return validsendmessage()"></a>
                    
                    <a href="jobseeker-detail-recruiter.php?uid=<?php echo $rowv4['JUser_Id'];?>" class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</a></div>
           
             </form>
			</div>
            <!--/ message popup-->
            <!-- schedule popup-->
    <div id="schedule-pop" class="modal">
            <form method="post" action="visit.php">
                <div class="modal-content text-center">
                    <h3 class="h3 flight">Schedule the <span class="fbold">Interview</span></h3>
                    <p class="pb15">You can Schedule the interview to selected candidates </p>
                    <div class="importjobs-in">
                        <div class="input-field">
                            <input type="date" class="datepicker" name="dates" id="dates">
							
                            <label>Select Schedule Date</label>
                            <script>
                                $('.datepicker').pickadate({
                                    selectMonths: true, // Creates a dropdown to control month
                                    selectYears: 15, // Creates a dropdown of 15 years to control year
									min:new Date()									
                                });
                            </script>
                        </div>
						<div class="input-field">
						<input type="hidden" id="sub-sendmsg" type="hidden" name="email" value="<?php echo $jrow['JEmail']?>,<?php echo $profile_user_id;?>">
						<input type="hidden" id="sub-sendmsg" type="hidden" name="comp_name" value="<?php echo $jrow2['Comp_Name']?>">
							 <input type="hidden"  name="jobid"  value="<?php echo $rowv4['JobId'] ?>">
							  <input type="hidden" name="juserid"  value="<?php echo $rowv4['JUser_Id'] ?>">
							   <input type="hidden" name="empid"  value="<?php echo $rowv4['emp_id'] ?>">
							    <label for="sub-sendmsg"></label>
							   </div>
						<div class="input-field">
                            <textarea id="writemsg2" class="materialize-textarea" name="message"></textarea>
                            <label for="writemsg2">Write a Message</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer newfoot"> 
				<a class="modal-action waves-effect waves-green btn-flat"><input type="submit" name="sendschedule" value="Make Schedule" onclick="return validschedule()"> </a>
				<a href="jobseeker-detail-recruiter.php?uid=<?php echo $rowv4['JUser_Id'];?>" class="modal-action modal-close waves-effect waves-green btn-flat">cancel</a>
				 </div>
			</form>
            </div>
			<script lang="javascript">
			
							function addClass(obj) {
    obj.className ? obj.className = "" : obj.className = "checked";
}

		function Validated()
{
	if((($("[type=checkbox]:checked").length)!="") ||(($("[type=checkbox]:checked").length)!=0) ){		
   //document.getElementById("visits").submit();
   return true;
	}else{
		 alert("Plase Check Atleast one");
		 return false;
	}
}

			function validsendmessage()
			{
				var subject=document.getElementById('sub-sendmsg').value;
            	if( subject =="")
            	{
            		alert("Please Give Subject to Send Message");
            		document.getElementById('sub-sendmsg').focus();
            		return false;
            	}
				
				var message=document.getElementById('writemsg').value;
            	if( message.length <1)
            	{
            		alert("Please type Message");
            		document.getElementById('writemsg').focus();
            		return false;
            	}
					
			}
			
			function validschedule()
			{
				
				var dates=document.getElementById('dates').value;
            	if( dates =="")
            	{
            		alert("Please Give Date to Schedule Message");
            		document.getElementById('dates').focus();
            		return false;
            	}
				
				var message=document.getElementById('writemsg2').value;
            	if( message.length <1)
            	{
            		alert("Please type Message");
            		document.getElementById('writemsg2').focus();
            		return false;
            	}
				
			}
			function notmatched()
			{
				alert("Your Prefered Location and Skills are not matching for this profile");
			}
			function notmatched1()
			{
				alert("No jobs available");
			}
				</script>
			
			
			
			
            <!-- /schedule popup-->
</body>

</html>