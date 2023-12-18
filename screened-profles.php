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
$stmt = $user_home->runQuery("SELECT * FROM tbll_emplyer WHERE emp_id=:rid");
$stmt->execute(array(":rid"=>$_SESSION['empSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$em_id = $row['emp_id'];
if(empty($row['EmployerStrength']) || empty($row['CompanyUrl']) || empty($row['YoR']) || empty($row['NoOfBranch']) || empty($row['ToR']) || empty($row['designation']) )
	{
		$varres= "Complete your profile first to post jobs";
	
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
  
    <?php include "source.php"; ?>
	  <!-- <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script> -->
	  <!-- <link REL="STYLESHEET" TYPE="text/css" HREF="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"> -->
	  <script>
            $(document).ready(function () {
                $('#example').DataTable();
            });
        </script>
		<style>
		.t {
			width: 500px;
			height: 130px;
			resize:none;
		}
						</style>
       
</head>

<body>
    <?php
include_once("analyticstracking.php");
include'includes-recruiter/db-recruiter-header.php'; ?>
   
        <main>
        
            <section class="db-recruiter">
                <div class="container">
                  
                    <div class="row">
                        <div class="col-md-12">
                            <article class="dbpage-title">
                                <h4 class="h4"> <i class="fa fa-users" aria-hidden="true"></i> Screened Profiles</h4> </article>
                        </div>
                    </div>
                  
                </div>
              
                <div class="jobs-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <figure class="jobimg"><img src="images/screening.png"></figure>
                            </div>
                            <div class="col-md-6 text-center">
                                <div class="job-title-header">
                                    <p class="flight">Speed up Your Recruiting by Screening More Profiles</p>
                                    <!-- <?php if($row['status']==4){ ?> -->
									  <article class="btns-jobtitle"> <a href="javascript:void(0)" onclick="return validateprofile()">Post a Job</a> </article>
									<!-- <?php } ?> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
          
                <div class="container">
                    <div class="row">
                        <div class="col-md-9 col-sm-8">
						 <?php
							$sql3 = "SELECT Count(*) as Id FROM tbl_jobposted WHERE emp_id='".$row['emp_id']."'";
							$query3 = mysqli_query($con, $sql3);
							$row3 = mysqli_fetch_array($query3);
							$sql3 = "SELECT Count(*) as upload_emplr_Id FROM tbl_jobseeker WHERE upload_emplr_Id='".$row['emp_id']."'";
							$query3 = mysqli_query($con, $sql3);
						    $row3 = mysqli_fetch_array($query3);
						 ?>
                            <h5 class="h5  jobtitle pull-left">TOTAL UPLOADED PROFILES  <span><?php echo $row3['upload_emplr_Id']; ?></span></h5><?php if($row['status']==4){ ?><a class="addjobicon tooltipped waves-effect waves-light" data-position="top" data-delay="50" data-tooltip="Post a Job" href="javascript:void(0)" onclick="return validateprofile()"><i class="fa fa-plus" aria-hidden="true"></i></a><?php } ?> </div>
							<!-- <div class="col-md-3 col-sm-4 actdrop">							
								<form name="" method="post" action="">
									<div class="form-group">
										<select name="activeinactive" onchange="this.form.submit();" class="form-control classic">																 
										  <option value="1" <?php if($_POST['activeinactive'] ==1){echo "selected";} ?>>Active Jobs</option>
										  <option value="0" <?php if(($_POST['activeinactive'] ==0)&&($_POST['activeinactive']!="")){echo "selected";}?>>Inactive Jobs</option>
										  <option value="2" <?php if($_POST['activeinactive'] ==2){echo "selected";}?>>Closed Jobs</option>
										</select>
									</div>
								</form>
							</div> -->
                      </div>
                   
                    <div class="row">
                        <div class="col-md-12 postedjobs">
                            <!--table-->
                            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th  width="15%">Candidate Name</th>
                                        <th width="21%">Skills %</th>
                                        <th width="100px" style="text-align:center;">Experience<br>in Years %</th>
                                        <!-- <th width="100px" style="text-align:center;">Salary<br>in Lakhs</th> -->
                                        <th class="th-top" colspan="3" style="padding:0">
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                               <!-- <tr class="brdrow">
                                                   
                                               </tr> -->
                                                <!-- <tr> -->
                                                    <th class="text-center">  <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Relevant</th> 
                                                     <th class="text-center"> <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> Irrelevant</th>
													 <th class="text-center"> <i class="fa fa-question-circle" aria-hidden="true"></i> ? </th>
                                                </tr>
                                            </table>
                                        </th>
                                        <!-- <th width="100px" class="text-center">Shortlisted</th> -->
										<th width="100px" class="text-center">Selected</th>
                                        <th class="text-center rem-filter" width="120px">Actions</th>
                                        <th class="text-center rem-filter" width="120px">Status</th>
									
                                    </tr>
                                </thead>
								  <tbody>
								<?php 	
									$sql4 = "SELECT * FROM tbl_jobseeker  WHERE upload_emplr_Id='".$row['emp_id']."'";
									$query4 = mysqli_query($con, $sql4);
								$sqlLoc = "SELECT JUser_Id,JFullName,JLoc_Name,Job_Id,Job_Skills,JTotalEy,JTotalEm,JPhone,JEmail FROM tbl_jobseeker WHERE upload_emplr_Id ='".$row['emp_id']."'";
								$resultLoc = mysqli_query($con, $sqlLoc);	
																	
									while($row4 = mysqli_fetch_array($resultLoc)){
										$user_queryD = "SELECT Loc_Name from tbl_location where Loc_Name='".$row4['JLoc_Name']."'";
										$rrD = mysqli_query($con,$user_queryD);

										 $sql2 = "SELECT * FROM tbl_jobdesc where id ='".$row4['Job_Id']."'";
												$query2 = mysqli_query($con, $sql2);
												$row2 = mysqli_fetch_array($query2);
										?>	
										<tr>
								<?php
								$percent_query = "SELECT Job_Name, Loc_Id, Job_Skill, Min_Exp,Job_Id FROM tbl_jobposted WHERE emp_id='".$row['emp_id']."' AND Job_Name='".$row4['Job_Id']."'";
								$query_percent = mysqli_query($con, $percent_query);
								$exp_row = mysqli_fetch_array($query_percent);
								?>
								<?php
								$jskills="SELECT * FROM tbl_jobseeker WHERE Job_Id='".$exp_row['Job_Name']."' AND JFullName = '".$row4['JFullName']."'";
								$jobfitresult = mysqli_query($con,$jskills);   
								$jobfitmentrow = mysqli_fetch_array($jobfitresult);  
								$jobfitskills=explode(',',$jobfitmentrow['Job_Skills']);
								$empskills=explode(',',$exp_row['Job_Skill']);
								$common_skills=array_intersect($jobfitskills,$empskills);
								$skill_percent=(count($common_skills)/count($jobfitskills))*100;
								if($jobfitmentrow['JPLoc_Id']==$exp_row['Loc_Id'])
								{
									$loc_percent=100;
								}
								else
								{
									$loc_percent=0;
								}
								
								?>
<td width="13%"><a href = "shin-fitment.php?uid=<?php echo $row['emp_id'];?>&jid=<?php echo $row4['Job_Id'];?>&skill=<?php echo $jobfitmentrow['Job_Skills'];?>&jname=<?php echo $row4['JFullName'];?>&jsid=<?php echo $row4['JUser_Id'];?>"><?php echo $row4['JFullName'];?> <small>JobName: <?php echo $row2['Job_Role'];?></a> <!-- , <Posted on date:--></small> 
											</td>
											<td width="21%"><?php ?>
											
								<?php
								echo floor($skill_percent);
								?> </td>
											<td width="100px" style="text-align:center;">
											<?php
											//  echo $row4['JTotalEm'];
											$yExp = $jobfitmentrow['JTotalEm'];
											$fitmentRow = (int) filter_var($yExp, FILTER_SANITIZE_NUMBER_INT);
											// $skill_percent=(count($common_skills)/count($jobfitskills))*100;
											if($fitmentRow>=$exp_row['Min_Exp'])
												{
   											 $exp_percent=100;
												}
											else
												{
    										 $exp_percent=($fitmentRow/$exp_row['Min_Exp'])*100;
												}
											echo floor($exp_percent);
											$overall=($skill_percent+$exp_percent+$loc_percent)/3;
											/*SMA code*/
											if ($overall >= 75)
											{
												$smart = "S";
											}
											else if($overall == 75 || $overall = 60)
											{
												$medium = "M";
											}
											else if($overall<=60)
										    {
												$avg = "A";
											}
											/*SMA code End*/
											?> 
											</td>
											<!-- <td width="65px" style="text-align:center;"><?php echo $row4['Sal_Range'];?> - <?php echo $row4['MSal_Range'];?></td> -->
													<?php $sql3 = "SELECT Count(*) as ID FROM tbl_applied WHERE emp_id='".$row['emp_id']."' and JobId='".$row4['Job_Id']."' and relavent='yes' and user_status='A'";
													$query3 = mysqli_query($con,$sql3);
													$row3 = mysqli_fetch_array($query3);
													$sqlir3 = "SELECT Count(*) as ID FROM tbl_applied WHERE emp_id='".$row['emp_id']."' and JobId='".$row4['Job_Id']."' and relavent='no' and user_status='A'";
													$queryir3 = mysqli_query($con,$sqlir3);
													$rowir3 = mysqli_fetch_array($queryir3);
													$sql3 = "SELECT Count(*) as ID FROM tbl_shortlisted WHERE emp_id='".$row['emp_id']."' and JobId='".$row4['Job_Id']."'";
													$query3 = mysqli_query($con,$sql3);
													$row6 = mysqli_fetch_array($query3);
													$sqls = "SELECT Count( DISTINCT juser_id,job_id) as ID FROM interviewscheduled WHERE emp_id='".$row['emp_id']."' and job_id='".$row4['Job_Id']."' and selected='yes'";
													$querys = mysqli_query($con,$sqls);
													$rowsh = mysqli_fetch_array($querys);
													?>                               
											<td style="text-align:center; width:77px;"><a href="#"> <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>  <?php echo $row3['ID'];?></a>
											           
											</td>											       
											<td style="text-align:center; width:77px;"><a href="#" > <i class="fa fa-thumbs-o-down" aria-hidden="true"></i>  <?php echo $rowir3['ID'];?></a>
         
											</td>
											<td> ? </td>
											<!-- <td style="text-align:center;"><a href="short-listed-jobseekars.php?jobId=<?php echo $row4['Job_Id'];?>"><i class="fa fa-heart-o" aria-hidden="true"></i> <?php echo $row6['ID'];?></a></td> -->
											<td style="text-align:center;"><a href="#"><i class="fa fa-check" aria-hidden="true"></i> <?php echo $rowsh['ID'];?></a></td>
											<td width="100px" style="text-align:center;">
											<a class="dropdown-button" data-activates="more-dropdown<?php echo $row4['Job_Id'];?>" href="#!"> More <i class="fa fa-chevron-down" aria-hidden="true"></i></a>
											<ul id="more-dropdown<?php echo $row4['Job_Id'];?>" class="dropdown-content drop1">
													<li><a href="#chat-popup"><i class="fa fa-comments" aria-hidden="true"></i> Chat </a></li>

	<!-- <button type="submit" <i class="fa fa-comment" aria-hidden="true"></i> SMS</button></li> -->
	<li><a href="#msg-popup"><i class="fa fa-envelope-o" aria-hidden="true"></i> Message</a></li>
</form>
													
													<!-- <li><a href="#"><i class="fa fa-envelope-o" aria-hidden="true"></i> EMAIL </a></li> -->
													</ul>
													</td>
											<td width="65px" style="text-align:center;"><h6>pending..</h6></td>
										</tr>    
							    									
                                </tbody>	
<!-- message pop-up -->
<div id="msg-popup" class="modal">
               <form method="post" action="send-msg.php">
                <div class="modal-content text-center">
                    <h3 class="h3 flight">Send <span class="fbold">Message</span></h3>
                    <p class="pb15 text-center">send message</p>
                    <div class="importjobs-in">
                        <div class="input-field">
						<input  type="hidden" name="email" value="<?php echo $jobfitmentrow['JEmail'];?>">
					<label for="sub-sendmsg"></label>
                        </div>
                        <div class="input-field">
						<input  type="hidden" name="phone" value="<?php echo $row4['JPhone'];?>">
					<label for="sub-sendmsg"></label>
                        </div>
                        <div class="input-field">
						<input  type="hidden" name="jname" value="<?php echo $row4['Job_Id'];?>">
					<label for="sub-sendmsg"></label>
                        </div>
                             <input id="sub-sendmsg" type="text" name="subject"> 
                       <div class="input-field">
                            <input  type="hidden" name="comp_name" value="<?php echo $jrow2['Comp_Name']?>">
                             <label for="sub-sendmsg"></label>
                        </div>
                        <div class="input-field">
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
                    
                    <a href="screened-profles.php" class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</a></div>
           
             </form>
			</div>
			<?php 
			$chat_link = "https://safe-mesa-59524.herokuapp.com/";
			$encoded_link = base64_encode($chat_link);
			$chat_link = $encoded_link;
			?>
<div id="chat-popup" class="modal">
               <form method="post" name = "sendchaturl" action="send-chaturl.php">
                <div class="modal-content text-center">
                    <h3 class="h3 flight">Send <span class="fbold">ChatUrlLink to Jobseeker</span></h3>
                    <p class="pb15 text-center">send chaturl</p>
                    <div class="importjobs-in">
					<div class="input-field">
						<input  type="text" name="chaturl" value="<?php echo $chat_link?>">
					<label for="sub-sendmsg"></label>
                        </div>
                        <div class="input-field">
						<input  type="hidden" name="email" value="<?php echo $jobfitmentrow['JEmail'];?>">
					<label for="sub-sendmsg"></label>
                        </div>
                        <div class="input-field">
						<input  type="hidden" name="phone" value="<?php echo $row4['JPhone'];?>">
					<label for="sub-sendmsg"></label>
                        </div>
                        <div class="input-field">
						<input  type="hidden" name="jname" value="<?php echo $row4['Job_Id'];?>">
					<label for="sub-sendmsg"></label>
                        </div>
                             <!-- <input id="sub-sendmsg" type="text" name="subject"> 
                       <div class="input-field">
                            <input  type="hidden" name="comp_name" value="<?php echo $jrow2['Comp_Name']?>">
                             <label for="sub-sendmsg"></label>
                        </div> -->
                        <!-- <div class="input-field">
                          <label for="sub-sendmsg">Subject</label>
                        </div>
                        <div class="input-field">
                            <textarea id="writemsg" class="materialize-textarea" name="message" ></textarea>
                            <label for="writemsg">Write a Message</label>
                        </div> -->
                    </div>
                </div>
                <div class="modal-footer"> 
                    <a class=" modal-action waves-effect waves-green btn-flat"><input type="submit" name="sendchaturl" value="Send"></a>
                    
                    <a href="screened-profles.php" class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</a></div>
           
             </form>
			</div>

								<?php  }?>											
                            </table>
							
                        </div>
                    </div>
              
                </div>
			
            </section>
			<div id="resets-login" class="modal bottom-sheet text-center alertbx">
                <div class="modal-footer"> <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat"><i class="fa fa-times" aria-hidden="true"></i></a> </div>
                <div class="modal-content">
				<form method="post" action="jobsempaction.php">
                    <h4 class="h4 txt-blue">Reason to Close Job :</h4>
					<input type="hidden" name="jobempid" id="close">
                    <textarea class="t" required name="closejobtext" id="closejobtext"><?php echo $jobsid; ?></textarea>
                    <div class="col-md-12">
					 <input type="submit"  name="closejob" value="SUBMIT" onclick="return validclose()" class="btn btn-blue-sm waves-effect waves-light"/>	
                    </div>			
					</form>
                </div>
            </div>
			 <div id="activate-login" class="modal bottom-sheet text-center alertbx">
                <div class="modal-footer"> <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat"><i class="fa fa-times" aria-hidden="true"></i></a> </div>
                <div class="modal-content">
					<form method="post" action="jobsempaction.php">
						<h4 class="h4 txt-blue">Reason to Activate Job :</h4>
						<input type="hidden" name="jobempid" id="name">
						<textarea class="t" required name="reason" id="activate"></textarea>
						<div class="col-md-12">
						<input type="submit"  name="activate" value="SUBMIT" onclick="return validactivate()" class="btn btn-blue-sm waves-effect waves-light"/>	
						</div>			
					</form>
                </div>
            </div>		
			 <div id="inactivate-login" class="modal bottom-sheet text-center alertbx">
                <div class="modal-footer"> <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat"><i class="fa fa-times" aria-hidden="true"></i></a> </div>
                <div class="modal-content">
					<form method="post" action="jobsempaction.php">
						<h4 class="h4 txt-blue">Reason to Inactivate  Job :</h4>
						<input type="hidden" name="jobempid" id="name">
						<textarea class="t" required name="reason" id="inactivatejob"></textarea>
						<div class="col-md-12">
						    <input type="submit"  name="inactivate" value="SUBMIT" onclick="return validinactivate()" class="btn btn-blue-sm waves-effect waves-light"/>	
						</div>
									
					</form>
                </div>
            </div>
        
        </main>
  
	              
			         
			<div id="importjobs" class="modal importjob">
                <div class="modal-content text-center">
                    <h4>Import Your Jobs</h4>
                    <p>Quickly import your jobs via excel</p>
                    <div class="importjobs-in">
                        <div class="file-field input-field">
                            <div class="btn"> 
								<span>Browse</span>
                                <input type="file" multiple>
							</div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="Upload Excel Sheet">
							</div>
                        </div>
                    </div>
                    <p><a href="img/imported-jobs.xls" target="_blank"> Download sample excel template</a></p>
                </div>
                <div class="modal-footer"> <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Cancel</a> </div>
            </div>

			<script>
			function validsendmessage()
			{
				var subject=document.getElementById('sub-sendmsg').value;
            	if( subject =="")
            	{
            		alert("Please give subject to send message");
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

			</script>
			<!-- message pip-up -->
			<script lang="javascript">
			function validinactivate()
			{
			var reason=document.getElementById('inactivatejob').value;
            	if(inactivatejob.lengths<1 )
            	{
            		alert("Please Give Your Reason to inactivate Job");
            		document.getElementById('inactivatejob').focus();
            		return false;
            	}			
			}		
			function validclose()
			{
			var closejobtext=document.getElementById('closejobtext').value;
            	if(closejobtext.length<1 )
            	{
            		alert("Please Give Your Reason to Close Job");
            		document.getElementById('closejobtext').focus();
            		return false;
            	}			
			}			
			function validactivate()
			{
			var activate=document.getElementById('activate').value;
            	if(activate.length<1 )
            	{
            		alert("Please Give Your Reason to Activate Job");
            		document.getElementById('activate').focus();
            		return false;
            	}
			
			}	
			function validateprofile()
			{
				var messages=<?php echo json_encode($varres); ?>;	
				if(messages != null)
				{
					
				
					alert(messages);
					setTimeout("location.href='view-profile-recruiter.php';",2000);
					return false;
					
				}
				else
				{
				
					window.location='create-job.php';		
				}
			}
			</script>

            
		</body>

</html>
