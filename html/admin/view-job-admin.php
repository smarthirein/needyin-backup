<?php
session_start();
header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire');
session_cache_limiter('public'); 
require_once '../class.user.php';
$user_home = new USER();	
if(!isset($_SESSION['adminSession']))
{
	$user_home->redirect('admin.php');   
} 	  
$stmt = $user_home->runQuery("SELECT * FROM tbl_admin WHERE id=:rid");
$stmt->execute(array(":rid"=>$_SESSION['adminSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$jid=$_GET['jobId'];
$uid=$_GET['jid'];
$cdate=$_GET['cd'];
if($_GET['act']=="noti"){
		 $notifi="UPDATE tbl_notifications SET notification_read=1 WHERE job_id =".$jid." and job_owner_id=".$uid." and created_on='".$cdate."'  and notification_to =".$_SESSION['adminSession'];
		 mysqli_query($con, $notifi);
		}
		$change_aw="UPDATE tbl_jobposted SET adm_status='AW' WHERE Job_Id='".$_GET['jobId']."' and adm_status='SA' and Job_Status='1'";
		mysqli_query($con,$change_aw);
		
		$change_aws = "INSERT INTO tbl_Job_details_updts SET emp_Id='".$uid."',Job_Id='".$_GET['jobId']."',aw_updts='NOW()'";
				$eduz= mysqli_query($con,$change_aws);

if(isset($_GET['jobId']))
{
	
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
			<style>
			#other-skills{
				height:25px;
				
			}
			select{
				
			}
			fieldset {
border: #ddd 1px solid;
padding:15px;
}
legend{
	width:auto !important;
}
			</style>
</head>

<body>
     <?php 
	include_once("../analyticstracking.php");
	include '../includes-recruiter/admin_header.php'; ?>
      
        <main>
          
            <section class="db-recruiter">
                <div class="container">
                
                    <div class="row">
                        <div class="col-md-12">
                            <article class="dbpage-title">
                                <h4 class="h4 pull-left"> <i class="fa fa-file-text-o" aria-hidden="true"></i> View JOB</h4><span class="pull-right"><a href="rec-jobs-admin.php"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Back to Jobs list</a></span>								
							</article>
                        </div>
                    </div>
                    
                </div>
               
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                          
                            <div class="job-detail-block viewjob brdbg-white">                              
                                <div class="job-detail-header row">		
<div class="col-md-12">									
								<span style="float:right;font-size:12px !important;background:#ddd;padding:5px">Current Status:<?php if($res['adm_status'] =='SA'){ echo "Sent To Admin";}else if($res['adm_status'] =='AW'){ echo "Awaited Process";}else if($res['adm_status'] =='A'){ echo "Approved";} else if($res['adm_status'] =='R'){ echo "Rejected";} else if($res['adm_status'] =='IP'){ echo "In Process";}else if($res['adm_status'] =='SQ'){ echo "Sent To Query";}else { echo "";}?></span>
								</div>
 <fieldset>
  <legend><h2>Change Status</h2></legend>                                   
								   <form name="selecteds" method="post" action="changestatus.php">
                                    <div class="">
                                            <div class="col-md-3 custom-btn">
											
                                                <div class="form-group mt5">
                                                    <label>Select Status </label>
													
                                                   <select name="activeinactive"  class="form-control classic">	
										<!--<option value="SA" <?php if($res['adm_status'] =='SA') {echo "selected";}?>>Sent to Admin</option>	-->									
										<option value="AW" <?php if($res['adm_status'] =='AW'){echo "selected";} ?>>Awaited Process</option>
										<option value="IP" <?php if($res['adm_status'] =='IP'){echo "selected";} ?>>In Process</option>
										<option value="A" <?php if($res['adm_status'] =='A'){echo "selected";}?>>Approved</option>
										<option value="SQ" <?php if($res['adm_status'] =='SQ'){echo "selected";}?>>Sent to Query</option>
										<option value="R" <?php if($res['adm_status'] =='R'){echo "selected";}?>>Rejected</option>										
										</select>
										<input type="hidden" value="<?php echo $_GET['jobId']; ?>" name="jobid">
										<input type="hidden" value="<?php echo $res['emp_id']; ?>" name="empid">
										
                                                </div>
                                            </div>                                          
											<div class="col-md-3">
											<div class="form-group" id="other-skill">	
												<label>Write Reason </label>											
												<input id="other-skills" name="reason" value="<?php echo $res['adm_reason'] ?>" placeholder="Add Feedback" required></input>											
											</div>

                                            </div>
                                            <div class="col-md-2">
                                               
                                                <input class="btn btn-blue-sm" type="submit" value="submit" name="statusjob" onclick="return validate()">
                                            </div>
                                    </div>
									</form>
									</fieldset>
                                    	
                                    <div class="col-md-10 col-sm-8">
                                     
                                        <div class="jobheader-title">
		                                  <h4 class="txt-blue h4"><?php $sql2 = "SELECT * FROM tbl_desigination where Desig_Id ='".$res['Job_Name']."'";
												$query2 = mysqli_query($con, $sql2);
												$row2 = mysqli_fetch_array($query2);?>
												<?php echo $row2['Desig_Name']; ?>
										   </h4>
                                           <h5 class="h5 comp-name"><?php echo $res['Comp_Name']; ?> <span> <?php echo $res['Comp_Url']; ?></span>
										   </h5>
                                            <div class="usermain-features">
                                                <ul>
                                                    <li><i class="fa fa-suitcase" aria-hidden="true"></i> <?php echo $res['Min_Exp']; ?>-<?php echo $res['Max_Exp']; ?> Years</li>
                                                    <?php	$sql1 = "SELECT * FROM tbl_location where Loc_Id ='".$res['Loc_Id']."'";
															$query1 = mysqli_query($con, $sql1);
															$row3 = mysqli_fetch_array($query1);?>
                                                    <li><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $row3["Loc_Name"] ?></li>
                                                    <li><i class="fa fa-calendar" aria-hidden="true"></i> <?php //echo $res['created']=date('d-m-y') ?><?php $date=date_create($res['created']);echo date_format($date,"M d,Y H:i:s"); //echo $row2['currentdate'];?></li>
                                                </ul>
                                            </div>
                                           
                                        </div>
                                    </div>                                   
                                    <!--<div class="col-md-2 col-sm-4">
                                          <figure class="logo-company"> 
											<?php //echo $profileLogo1=$res['eLogo']; if($profileLogo1){?>
											<img class="img-contain" data-object-fit="contain" src="<?php// echo $profileLogo1; ?>"><?php// } else {?><img class="img-contain" data-object-fit="contain"  src="img/logo.svg"><?php// } ?>
										  </figure>
                                    </div>-->
                                </div>
                              
                                <div class="basic-detailstab">                                   
                                   <ul>
                                       <li>
									   <span class="txt-blue">Job Title</span>
									   <?php $sql2 = "SELECT * FROM tbl_desigination where Desig_Id ='".$res['Job_Name']."'";
												$query2 = mysqli_query($con, $sql2);
												$row2 = mysqli_fetch_array($query2);?>
									   <span><?php echo $row2['Desig_Name']; ?></span>
									   </li>
                                       <li>
                                          <span class="txt-blue">Position Type</span>
                                          <span><?php echo $res['PJobtype']; ?></span> 
                                       </li>
                                       <li>
                                           <span class="txt-blue">Experience</span>
                                           <span><?php echo $res['Min_Exp']; ?> - <?php echo $res['Max_Exp']; ?> Years</span>
                                       </li>
                                       <li>
                                      <span class="txt-blue">Location</span>
                                           <?php $sql1 = "SELECT * FROM tbl_location where Loc_Id ='".$res['Loc_Id']."'";
												$query1 = mysqli_query($con, $sql1);
												$row1 = mysqli_fetch_array($query1);?>
                                      <span><?php echo $row1['Loc_Name']; ?></span>
                                       </li>
                                       <li>
                                           <span class="txt-blue">Job Status</span>
                                           <span class="mand"> <?php if($res['Job_Status']==0){ echo "Inactive";}else if($res['Job_Status']==2){echo "Closed";}else { echo "Active";}?> </span>
                                       </li>
                                   </ul>                                  
								  </div>
                              
                                <div class="list-description">
                                    <h4 class="h4 txt-blue">Job Description: </h4>
                                
								<p><?php echo htmlspecialchars_decode($res['Job_Desc']);?></p>
                                </div>
                              
                                <div class="list-description">
                                    <h4 class="h4 txt-blue">Qualification</h4>
                                    <ul>
										<?php $sqlq = "SELECT * FROM tbl_qualification where Qual_Id ='".$res['PEduc_Id']."'";
										$queryq = mysqli_query($con, $sqlq);
										$rowq = mysqli_fetch_array($queryq);?>
										<?php $sqls = "SELECT * FROM tbl_specialization where Speca_Id ='".$res['PSpeci_Id']."'";
										$querys = mysqli_query($con, $sqls);
										$rows = mysqli_fetch_array($querys);?>
										<?php $sqlu = "SELECT * FROM tbl_university where University_Id ='".$res['PUniver_Id']."'";
										$queryu = mysqli_query($con, $sqlu);
										$rowu = mysqli_fetch_array($queryu);?>
                                        <li> Course :   <?php if($rowq['Qual_Name'] =="") { echo "xxxxx";}else{echo $rowq['Qual_Name'];} ?> - Specialization :  <?php if($rows['Speca_Name'] =="") { echo "xxxxx";}else{ echo $rows['Speca_Name'];} ?></li> 
										<li>University :   <?php if($rowu['University_Name'] =="") { echo "xxxxx";}else{echo $rowu['University_Name'];} ?></li>
                                    </ul>
                                    <table class="subtable">
                                        <tr>
                                            <td width="18%">Salary Range (Lacs) </td>
                                            <td>:  Min: <?php echo $res['Sal_Range']; ?> - Max: <?php echo $res['MSal_Range']; ?> </td>
                                        </tr>
                                        <tr>
												<?php  $sqlI = "SELECT * FROM tbl_industry where Indus_Id ='".$res['PIndus_Id']."'";
												$queryI = mysqli_query($con, $sqlI);
												$rowI = mysqli_fetch_array($queryI);?>
                                            <td width="18%">Industry</td>
                                            <td>: <?php echo $rowI['Indus_Name']; ?></td>
                                        </tr>
                                        <tr>
												<?php  $sqlF = "SELECT * FROM tbl_functionalarea where Func_Id ='".$res['PFunc_Id']."'";
												$queryF = mysqli_query($con, $sqlF);
												$rowF = mysqli_fetch_array($queryF);?>
                                            <td width="18%">Functional Area</td>
                                            <td>: <?php echo $rowF['Func_Name']; ?></td>
                                        </tr>
                                      
                                    </table>
                                </div>
                               
                                <div class="keyskills-detail">
                                    <h4 class="h4 txt-blue">Keyskills</h4>
                                    <div class=" list-emp-keyskills">
                                        <p>
											<?php 
												foreach($skills as $i){
													$q1 = "SELECT * FROM tbl_masterskills WHERE skill_Id ='".$i."'";
													$r1 = mysqli_query($con,$q1);
													$res1 = mysqli_fetch_array($r1);
													echo '<span>'.$skillName = $res1['skill_Name'].'</span>';
												}
											?>
										</p>
                                    </div>
                                </div>
                           
                               
								
                            
                               
                            </div>
                            
                        </div>
                    </div>
                </div>
                
            </section>
           
        </main>
		<script>
      function validate()
			{				
				var cnameapp=document.getElementById('cnameapp').value;
				var cnameres=document.getElementById('cnamere').value;
            	if(((cnameapp =="yes")||(cnameapp=="no"))&&(cnameres == ""))				
            	{
            		alert("Please Write Reason for  Company Name");
            		document.getElementById('cnamere').focus();
            		return false;
            	}
			}
			</script>
</body>

</html>

<?php }
else echo 'No job exists';
?>