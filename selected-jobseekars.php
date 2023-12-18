<?php 
session_start();

require_once 'class.user.php';
$user_home = new USER();
 
if(!isset($_SESSION['empSession']))
{
		 $user_home->redirect('index-recruiter.php');
   
} 
$stmt = $user_home->runQuery("SELECT * FROM tbll_emplyer WHERE emp_id=:eid");
$stmt->execute(array(":eid"=>$_SESSION['empSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);


$sql1= "SELECT * FROM interviewscheduled ins
LEFT JOIN tbll_emplyer e ON ins.emp_id = e.emp_id
LEFT JOIN tbl_jobseeker J ON ins.JUser_Id = J.JUser_Id
LEFT JOIN tbl_jobposted jp ON ins.emp_id = jp.emp_id
JOIN tbl_currentexperience Jd ON J.JUser_Id = Jd.JUser_Id
JOIN tbl_location L on J.JpLoc_Id=L.Loc_Id
LEFT JOIN tbl_education Ed on J.JUser_Id= Ed.JUser_Id 
LEFT JOIN tbl_qualification qo on Ed.Qual_Id=qo.Qual_Id 
WHERE ins.emp_id='".$row['emp_id']."' AND ins.job_id='".$_GET['jobId']."' and selected='yes' Group by J.JUser_Id"; 																		
																			//$row1 = mysqli_fetch_array($result);
$result1 = mysqli_query($con,$sql1); 
$count=mysqli_num_rows($result1);
$q = "SELECT * FROM tbl_jobposted WHERE Job_Id ='".$_GET['jobId']."'";
	$r = mysqli_query($con,$q);
	$res = mysqli_fetch_array($r);
	$skills = explode(',',$res['Job_Skill']);	

	
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with Needyin</title>
   
    <?php include"source.php" ?>
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
                                <h4 class="txt-blue h4 pull-left"> <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Selected (<?php echo $count; ?>)</h4> <span class="pull-right"><a href="rec-jobs.php"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Back to Posted Jobs list</a></span></article>
                        </div>
                    </div>
                  
                </div>
              
			
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="job-list appliedjs">
                                <div class="noofjobs brdbg-white">
                                 <p>Total <span class="fbold txt-blue"><?php echo $count; ?></span>
								 Profiles Selected For 
								 <span class="fbold txt-blue">
								<?php $sql2 = "SELECT * FROM tbl_desigination where Desig_Id ='".$res['Job_Name']."'";
								$query2 = mysqli_query($con, $sql2);
								$row2 = mysqli_fetch_array($query2);?>
								 <?php echo $row2['Desig_Name'];?> 
								 </span>							 
								 </p>
                                </div>
								
                               
							<?php	while ($row2 = mysqli_fetch_array($result1)) { ?>
                                <div class="brdbg-white list-block">
                                   
                                    <div class="">
                                       <div class="row">
                                           <div class="col-md-5">
                                               <div class="">
                                                       <div class="col-md-3 col-sm-3 col-xs-12">
                                            <figure class="js-list-pic">
                                               <img class="img-cover" data-object-fit="cover" src="<?php if($row2['JPhoto']){  echo $row2['JPhoto']; }else if($row2['Gender']=="Male") {?>img/js-profile-list-pic.jpg <?php } else {?>img/female.png <?php }?>" >
                                            </figure>
                                       
                                        </div>
										<script>
												function myFunctionId(id) {
												var myValue = $( "#sel<?php echo $row2['JUser_Id'] ?>" ).val();alert(myValue);
												 $("#example").append(myValue);
												}
												</script>										
                                        <div class="col-md-9 col-sm-9 col-xs-12 mobcenter">
                                            <a href="jobseeker-detail-recruiter.php?uid=<?php echo $row2['JUser_Id'] ?>" class="name">
                                                <h4 class="h4 txt-blue"><?php echo $row2['JFullName']; ?></h4>
                                                <h5><?php echo $row2['Des']; ?></h5>
                                                <p><?php echo $row2['Company_Name']; ?></p>
                                            </a> <span class="notice-list"><?php echo $row2['NoticePeriod']; ?> days Notice</span>
                                            <p style="padding-top:10px;">
										
											<a href="<?php if($row2['UpdateCV']){ echo $row2['UpdateCV'];}else { ?> ./img/profile-ic.png <?php } ?>" download target="_blank"><i class="fa fa-download" aria-hidden="true"></i> Download Resume</a>
											</p>
                                        </div>
                                               </div>
                                           </div>
                                           <div class="col-md-5 col-md-offset-2 col-sm-9">
                                            <table width="100%" cellpadding="0" cellspacing="0" class="list-table">
                                                <tr>
                                                    <td width="5%"><i class="fa fa-graduation-cap" aria-hidden="true"></i></td>
                                                    <td width="35%"> Education</td>
                                                    <td width="65%"><?php echo $row2['Qual_Name']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-user-o" aria-hidden="true"></i></td>
                                                    <td> Experience</td>
                                                    <td><?php echo $row2['JTotalEy']; ?> Years - <?php echo $row2['JTotalEm']; ?> Months </td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-inr" aria-hidden="true"></i></td>
                                                    <td> Exp CTC (Lacs)</td>
                                                    <td>Min: <?php echo $row2['ExpSalL']; ?> - Max: <?php echo $row2['ExpMaxSalL']; ?></td>
                                                </tr>
                                            </table>
                                           
                                    <div class="skills-tab">
                                        <div class="col-md-12 col-sm-12">
                                            <?php
                                                                            $skills=$row2['Job_Skills'];
                                                                            $skill_ids=explode(",",$skills);?>
                                                                            <h6 class="h6">Skills</h6>
											<p class="skills-js-list"><?php foreach($skill_ids as $skillid)  { 
												$ms_sql1="select * from tbl_masterskills where skill_Id=".$skillid;
                                           $ms_result1 = mysqli_query($con,$ms_sql1);
                                           $ms_data1 = mysqli_fetch_array($ms_result1);?>      
											<span><?php echo $ms_data1['skill_Name']; ?></span> <?php } ?> </p>
                                        </div>
                                    </div>
                                   
                                        </div>
                                       </div>
                                    
                                        
                                    </div>
                                   
                                   
                                </div>
							<?php } ?>
								
                                
                            </div>
                        </div>
                    </div>
                </div>

				
				
               
            </section>
           
        </main>
		
       
        <?php include"footer.php"?>
           
            <div id="shortlist-js" class="modal importjob">
                <div class="modal-content text-center">
                    <h3 class="h3 flight">Schedule the <span class="fbold">Interview</span></h3>
                    <p class="pb15">You can Schedule the interview to selected candidates </p>
                    <div class="importjobs-in">
                        <div class="input-field">
                            <input type="date" class="datepicker">
                            <label>Select Schedule Date</label>
                            <script>
                                $('.datepicker').pickadate({
                                    selectMonths: true, 
                                    selectYears: 15 
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"> <a href="#!" class=" modal-action waves-effect waves-green btn-flat">Make Schedule</a> <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Cancel</a> </div>
            </div>
          
            <div id="send-sel-msg" class="modal importjob">
                <div class="modal-content text-center">
                    <h3 class="h3 flight">Send <span class="fbold">Message</span></h3>
                    <p class="pb15">You can send message only selected Profiles </p>
                    <div class="importjobs-in">
                        <div class="input-field">
                            <input id="sub-sendmsg" type="text">
                            <label for="sub-sendmsg">Subject</label>
                        </div>
                        <div class="input-field">
                            <textarea id="writemsg" class="materialize-textarea"></textarea>
                            <label for="writemsg">Write a Message</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"> <a href="#!" class=" modal-action waves-effect waves-green btn-flat">Send Message</a> <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Cancel</a> </div>
            </div>
           
</body>

</html>