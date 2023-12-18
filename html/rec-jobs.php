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
                                <h4 class="h4"> <i class="fa fa-clipboard" aria-hidden="true"></i> Posted Jobs</h4> </article>
                        </div>
                    </div>
                  
                </div>
              
                <div class="jobs-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <figure class="jobimg"><img src="img/jobs-ban-img.png"></figure>
                            </div>
                            <div class="col-md-6 text-center">
                                <div class="job-title-header">
                                    <p class="flight">Speed up Your Hiring by Creating More Jobs</p>
                                    <?php if($row['status']==4){ ?>
									  <article class="btns-jobtitle"> <a href="javascript:void(0)" onclick="return validateprofile()">POST A JOB</a> </article>
									<?php } ?>
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
						 ?>
                            <h5 class="h5  jobtitle pull-left">TOTAL POSTED JOBS  <span><?php echo $row3['Id']; ?></span></h5><?php if($row['status']==4){ ?><a class="addjobicon tooltipped waves-effect waves-light" data-position="top" data-delay="50" data-tooltip="Post a Job" href="javascript:void(0)" onclick="return validateprofile()"><i class="fa fa-plus" aria-hidden="true"></i></a><?php } ?> </div>
							<div class="col-md-3 col-sm-4 actdrop">							
								<form name="" method="post" action="">
									<div class="form-group">
										<select name="activeinactive" onchange="this.form.submit();" class="form-control classic">																 
										  <option value="1" <?php if($_POST['activeinactive'] ==1){echo "selected";} ?>>Active Jobs</option>
										  <option value="0" <?php if(($_POST['activeinactive'] ==0)&&($_POST['activeinactive']!="")){echo "selected";}?>>Inactive Jobs</option>
										  <option value="2" <?php if($_POST['activeinactive'] ==2){echo "selected";}?>>Closed Jobs</option>
										</select>
									</div>
								</form>
							</div>
                      </div>
                   
                    <div class="row">
                        <div class="col-md-12 postedjobs">
                            <!--table-->
                            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th  width="15%">Position Name</th>
                                        <th width="21%">Skills / Titles</th>
                                        <th width="100px" style="text-align:center;">Experience<br>in Years</th>
                                        <th width="100px" style="text-align:center;">Salary<br>in Lakhs</th>
                                        <th class="th-top" colspan="2" style="padding:0">
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                               <tr class="brdrow">
                                                   <th class="text-center" colspan="2">Applied</th>
                                               </tr>
                                                <tr>
                                                    <th class="text-center">  <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Relevant</th> 
                                                     <th class="text-center"> <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> Irrelevant</th>
                                                </tr>
                                            </table>
                                        </th>
                                        <th width="100px" class="text-center">Shortlisted</th>
										<th width="100px" class="text-center">Selected</th>
                                        <th class="text-center rem-filter" width="120px">Actions</th>
                                        <th class="text-center rem-filter" width="120px">Status</th>
									
                                    </tr>
                                </thead>
								  <tbody>
								<?php 								
								if($_POST['activeinactive'] != "")
								{
									$sql4 = "SELECT * FROM tbl_jobposted  WHERE emp_id='".$row['emp_id']."' AND Job_Status='".$_POST['activeinactive']."' order by created desc
";
									$query4 = mysqli_query($con, $sql4);
								}
								else
								{
									$sql4 = "SELECT * FROM tbl_jobposted  WHERE emp_id='".$row['emp_id']."' AND Job_Status=1";
									$query4 = mysqli_query($con, $sql4);
								}
									
																	
									while($row4 = mysqli_fetch_array($query4)){
										
										$user_queryD = "SELECT Loc_Name from tbl_location  where Loc_Id='".$row4['Loc_Id']."'";
										$rrD = mysqli_query($con,$user_queryD);
										$rrsD = mysqli_fetch_array($rrD);
										 $sql2 = "SELECT * FROM tbl_desigination where Desig_Id ='".$row4['Job_Name']."'";
												$query2 = mysqli_query($con, $sql2);
												$row2 = mysqli_fetch_array($query2);

										?>	
										<tr>
											<td width="13%"><?php echo $row2['Desig_Name'];?> <small>Location: <?php echo $rrsD['Loc_Name'];?> <!-- , <Posted on date:--></small> </td>
											<td width="21%"><?php 
												$x = explode(',',$row4['Job_Skill']);
												foreach($x as $i){
													$q ="SELECT skill_Name FROM  tbl_masterskills WHERE skill_Id='".$i."'";
													$r = mysqli_query($con,$q); 
													$r1 = mysqli_fetch_array($r);
													
													if($r1['skill_Name']==''){
														echo $r1['skill_Name'];
														}
													else{ echo $r1['skill_Name'].",";}
												}?>
											</td>
											<td width="65px" style="text-align:center;"><?php echo $row4['Min_Exp'];?> - <?php echo $row4['Max_Exp'];?></td>
											<td width="65px" style="text-align:center;"><?php echo $row4['Sal_Range'];?> - <?php echo $row4['MSal_Range'];?></td>
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
											<td style="text-align:center; width:77px;"><a title="This profile is matched with your skills,sal,exp and location" href="applied-jobseekars.php?jobId=<?php echo $row4['Job_Id'];?>"> <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>  <?php echo $row3['ID'];?></a>
											           
											</td>											       
											<td style="text-align:center; width:77px;"><a href="applied-jobseekars-irr.php?jobId=<?php echo $row4['Job_Id'];?>" title="This profile is not matched with experience"> <i class="fa fa-thumbs-o-down" aria-hidden="true"></i>  <?php echo $rowir3['ID'];?></a>
											             
											</td>
											<td style="text-align:center;"><a href="short-listed-jobseekars.php?jobId=<?php echo $row4['Job_Id'];?>"><i class="fa fa-heart-o" aria-hidden="true"></i> <?php echo $row6['ID'];?></a></td>
											<td style="text-align:center;"><a href="selected-jobseekars.php?jobId=<?php echo $row4['Job_Id'];?>"><i class="fa fa-check" aria-hidden="true"></i> <?php echo $rowsh['ID'];?></a></td>
											<td class="text-center" width="100px" style="position:relative;">
												<a class="dropdown-button" data-activates="more-dropdown<?php echo $row4['Job_Id'];?>" href="#!"> More <i class="fa fa-chevron-down" aria-hidden="true"></i></a>
												<ul id="more-dropdown<?php echo $row4['Job_Id'];?>" class="dropdown-content drop1">
													<li><a href="view-job.php?jobId=<?php echo $row4['Job_Id'];?>"><i class="fa fa-eye" aria-hidden="true"></i> View </a></li>
													<?php if(trim($row4['Job_Status'])==1) {?>
													<li><a href="edit-job.php?jobId=<?php echo $row4['Job_Id'];?>"><i class="fa fa-pencil" aria-hidden="true"></i> Edit </a></li>
													<?php }else {?>
													<li><a href="#" class="disabled" style="color:#ddd;"><i class="fa fa-pencil" aria-hidden="true"></i> Edit </a></li>
													<?php }?>
													
												
													<?php 
													if(trim($row4['Job_Status'])==1){ 
													$sqls = "SELECT * FROM jobsaction where jobid='".$row4['Job_Id']."' and empid='".$row['emp_id']."'";
													$querys = mysqli_query($con, $sqls);
													$rows11 = mysqli_fetch_array($querys);
													$rows11['status'];?>
														 <li><a href="#" data-serie-name="<?php echo $row4['Job_Id'];?>,<?php echo $row['emp_id'] ?>,0" onclick="serieName=this.dataset.serieName;document.querySelector('#inactivate-login input#name').value = serieName;return true;" data-target="inactivate-login"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> Inactivate</a></li>
														 <?php if($rows11['status']!=0) {?>
														 <li><a href="#"  data-serie-name="<?php echo $row4['Job_Id'];?>,<?php echo $row['emp_id'] ?>,2" onclick="serieName=this.dataset.serieName;document.querySelector('#resets-login input#close').value = serieName;return true;" data-target="resets-login"><i class="fa fa-eye" aria-hidden="true"></i> Close </a></li>    
														 <?php }}
													else if(trim($row4['Job_Status'])==0){
													?>	
													 <li><a href="#" data-serie-name="<?php echo $row4['Job_Id'];?>,<?php echo $row['emp_id'] ?>,1" onclick="serieName=this.dataset.serieName;document.querySelector('#activate-login input#name').value = serieName;return true;" data-target="activate-login"><i class="fa fa-check-square-o" aria-hidden="true"></i>    Activate</a></li>
													  <li><a href="#"  data-serie-name="<?php echo $row4['Job_Id'];?>,<?php echo $row['emp_id'] ?>,2" onclick="serieName=this.dataset.serieName;document.querySelector('#resets-login input#close').value = serieName;return true;" data-target="resets-login"><i class="fa fa-eye" aria-hidden="true"></i> Close </a></li>    
													<?php }													
													else if(trim($row4['Job_Status'])==2){ ?>
													
												<?php	} ?>				
												</ul>																							
											</td>
											<td width="65px" style="text-align:center;"><?php

											if(($row4['adm_status'])=='N'||($row4['adm_status'])=='V'||($row4['adm_status'])=='SA'||($row4['adm_status'])=='SQ'||($row4['adm_status']=='UQ'))
											echo "In curation";
										if(($row4['adm_status'])=='R')
											echo "Rejected";
										if(($row4['adm_status'])=='A')
											echo "Approved";
										
											?></td>
										</tr>    
							    	<?php  }?>									
                                </tbody>											
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