<?php 
header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire');
session_cache_limiter('public'); 
require_once('class.user.php');
if(isset($_GET['jobId'])){
	
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
                                <h4 class="h4 pull-left"> <i class="fa fa-file-text-o" aria-hidden="true"></i> View JOB</h4><span class="pull-right"><a href="rec-jobs.php"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Back to Jobs list</a></span>								
							</article>
                        </div>
                    </div>
                    
                </div>
               
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                          
                            <div class="job-detail-block viewjob brdbg-white">
                              
                                <div class="job-detail-header row">
                                    <form name="selecteds" method="post" action="visit.php">
                                    <div class="">
                                            <div class="col-md-3 custom-btn">
                                                <div class="form-group mt5">
                                                    <label>Select Candidate </label>
													<?php  $sql1_s="select juser_id from interviewscheduled where emp_id='".$_SESSION['empSession']."' and  job_id='".$_GET['jobId']."' group by juser_id" ;
													$result1_s = mysqli_query($con,$sql1_s); ?>
                                                    <select class="selectpicker" name="noofusers[]" data-live-search="true" data-live-search-placeholder="Search">
													<?php while ($row_s = mysqli_fetch_array($result1_s)) {
														 $ss1="SELECT JUser_Id,JFullName FROM tbl_jobseeker where JUser_Id=".$row_s['juser_id'];
														$ss_s = mysqli_query($con,$ss1);
														$row1s = mysqli_fetch_array($ss_s);
													?>
                                                        <option value="<?php echo $row1s['JUser_Id']; ?>"><?php echo $row1s['JFullName']; ?></option>
                                                      
													<?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Selected/Not selected </label>
                                                    <select class="form-control classic" name="selects" onChange="can_select(this);">
														<option value="" disabled >Select option</option>
                                                        <option value="yes">Selected</option>
                                                         <option value="no">Not Selected</option>                                                        
                                                    </select>
													<input type="hidden" value="<?php echo $_GET['jobId']; ?>" name="jobids">
													<input type="hidden" value="<?php echo $_SESSION['empSession']; ?>" name="empid">
                                                </div>
                                            </div>
											<div class="col-md-3">
											<div class="form-group" id="other-skill">	
												<label>Write Feedback </label>											
												<input id="other-skills" name="reason"  placeholder="Add Feedback" required></input>											
											</div>

                                            </div>
                                            <div class="col-md-2">
                                               
                                                <input class="btn btn-blue-sm" type="submit" value="submit" name="Selected">
                                            </div>
                                    </div>
									</form>
                                    	<script>
												function can_select(elem) 
												{	
													if ((elem.value =='no') ||(elem.value =='yes')){
													document.getElementById("other-skill").style.display = 'block';
													} else {
													document.getElementById("other-skill").style.display = 'none';
													}
												}
																			
																		</script>
                                    <div class="col-md-10 col-sm-8">
                                       <p style="padding-left:5px;"> 
										   <span><b>Note: This is how your job appears to candidates</b></span>
									   </p>
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
                                            <div class="dropdown-buttons"> <a class='dropdown-button btn' href='#' data-activates='dropdown1'>Options <i class="fa fa-caret-down" aria-hidden="true"></i> </a>
                                                <ul id='dropdown1' class='dropdown-content'>
                                         
                                                    <li>
														<?php if($res['Job_Status']==2){?>
														<a href="javascript:void(0);'" class="btn-flat disabled"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> 
															Edit JOb</a>
														<?php } else { ?>
															<a href="edit-job.php?jobId=<?php echo $_GET['jobId'];?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> 
															Edit Job</a>
														<?php } ?>
													</li>
                                                    <li class="divider"></li>
                                                    <li><a href="applied-jobseekars.php?jobId=<?php echo $_GET['jobId'];?>"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> View Applied (Relevant)</a></li>
                                                     <li><a href="applied-jobseekars-irr.php?jobId=<?php echo $_GET['jobId'];?>"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> View Applied (Irrelevant)</a></li>
													<li><a href="short-listed-jobseekars.php?jobId=<?php echo $_GET['jobId'];?>"><i class="fa fa-heart-o" aria-hidden="true"></i> View Shortlisted</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>                                   
                                    <div class="col-md-2 col-sm-4">
                                          <figure class="logo-company"> 
											<?php $profileLogo1=$row['eLogo']; if($profileLogo1){?>
											<img class="img-contain" data-object-fit="contain" src="<?php echo $profileLogo1; ?>"><?php } else {?><img class="img-contain" data-object-fit="contain"  src="img/logo.svg"><?php } ?>
										  </figure>
                                    </div>
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
												

                                        <li> Course :   <?php if($rowq['Qual_Name'] =="") { echo "Not Available";}else{echo $rowq['Qual_Name'];} ?> - Specialization :  <?php if($rows['Speca_Name'] =="") { echo "Not Available";}else{ echo $rows['Speca_Name'];} ?></li> 
										<li>University :   <?php if($rowu['University_Name'] =="") { echo "Not Available";}else{echo $rowu['University_Name'];} ?></li>
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
                                                 <td>Industry</td>
                                            <?php if($rowI['Indus_Name'] != ""){?>
                                                <td>: <?php echo $rowI['Indus_Name']; ?></td>
                                       <?php     } else{ ?>
                                        <td>: Not Available</td>
                                      <?php } ?>
                                        </tr>
                                        <tr>
												<?php  $sqlF = "SELECT * FROM tbl_functionalarea where Func_Id ='".$res['PFunc_Id']."'";
												$queryF = mysqli_query($con, $sqlF);
												$rowF = mysqli_fetch_array($queryF);?>
                                           <td>Functional Area</td>
                                            <?php if($rowF['Func_Name'] != ""){?>
                                                <td>: <?php echo $rowF['Func_Name']; ?></td>
                                       <?php     } else{ ?>
                                        <td>: Not Available</td>
                                      <?php } ?>
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
                           
                               
								<?php if($res['Job_Status']==2){?>
								<button class="btn waves-effect waves-light" type="submit" name="action" disabled>Edit JOb </button>
								<?php } else{ ?>
                                <button class="btn waves-effect waves-light" type="submit" name="action" onclick="Javascript:window.location.href='edit-job.php?jobId=<?php echo $_GET['jobId'];?>';">Edit JOb </button>
								<?php } ?>
                            
                               
                            </div>
                            
                        </div>
                    </div>
                </div>
                
            </section>
           
        </main>
      
</body>

</html>

<?php }
else echo 'No job exists';
?>