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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with Needyin</title>
  
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
include_once("../analyticstracking.php");
include'../includes-recruiter/admin_header.php'; ?>   
        <main>        
            <section class="db-recruiter">
                <div class="container">                  
                    <div class="row">
                        <div class="col-md-12">
                            <article class="dbpage-title">
                                <h4 class="h4"> <i class="fa fa-clipboard" aria-hidden="true"></i> Employers</h4>
							</article>
                        </div>
                    </div>                  
                </div>              
                <div class="container">
                    <div class="row">
                       <div class="col-md-9 col-sm-8">
						 <?php
							$sql3 = "SELECT Count(*) as Id FROM tbll_emplyer";
							$query3 = mysqli_query($con, $sql3);
						    $row3 = mysqli_fetch_array($query3);
						 ?>
                            <h5 class="h5  jobtitle pull-left">TOTAL Employers  <span><?php echo $row3['Id']; ?></span></h5></div>
							<div class="col-md-3 col-sm-4 actdrop">							
								<form name="" method="post" action="">
									<div class="form-group">
										<select name="activeinactive" onchange="this.form.submit();" class="form-control classic">	  										
										  <option value="1" <?php if($_POST['activeinactive'] ==1){echo "selected";} ?>>Active</option>
										  <option value="0" <?php if($_POST['activeinactive'] ==0){echo "selected";}?>>Inactive</option>
										  <option value="2" <?php if($_POST['activeinactive'] ==2){echo "selected";}?>>Sent to Admin</option>
										   <option value="3" <?php if($_POST['activeinactive'] ==3){echo "selected";}?>>Awaited Process</option>
										   <option value="6" <?php if($_POST['activeinactive'] ==6){echo "selected";}?>>In Process</option>
										   <option value="4" <?php if($_POST['activeinactive'] ==4){echo "selected";}?>>Approved</option>
										   <option value="7" <?php if($_POST['activeinactive'] ==7){echo "selected";}?>>Sent To Query</option>
										    <option value="5" <?php if($_POST['activeinactive'] ==5){echo "selected";}?>>Rejected</option>
											
										</select>
									</div>
								</form>							
							</div>
                      </div>
                   </div>
				    
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 postedjobs">
                            <!--table-->
                            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th width="10%">Company Name</th>
										<th width="8%">Company Type </th>
										<th width="75px" style="text-align:center;">Strength</th>
										 <th width="100px" style="text-align:center;"> Contact Name</th> 
										<th width="100px" class="text-center">Email ID</th>
										<th width="100px" style="text-align:center;"> Contact Number</th>
									    <th width="100px" class="text-center">Company URL</th> 
										<th width="10%">YOR </th>
										<th width="10%">ROC </th>										
										<th width="100px" class="text-center">Status</th>
                                    </tr>
                                </thead>
								<tbody>
								<?php 								
								if($_POST['activeinactive'] != "")
								{
									$sql4 = "SELECT * FROM tbll_emplyer where status='".$_POST['activeinactive']."'";
									$query4 = mysqli_query($con, $sql4);
								}
								else
								{
									$sql4 = "SELECT * FROM tbll_emplyer where  status=0";
									$query4 = mysqli_query($con, $sql4);
								}									
									while($row4 = mysqli_fetch_array($query4)){										
										?>	
										<tr>
											<td><a href="employer-detail-recruiter.php?uid=<?php echo $row4['emp_id'];?>"><?php echo $row4['companyname'];?></a></td>
											<td width="8%"><?php echo $row4['company_type'];?></td>
											<td width="65px" style="text-align:center;"><?php echo $row4['EmployerStrength'];?></td>
											<td width="65px" style="text-align:center;"><?php echo $row4['contact_name'];?></td>											
											<td><?php echo $row4['emp_email'];?></td>
											<td width="65px" style="text-align:center;"><?php echo $row4['contact_num'];?></td>
											<td style="text-align:center; width:77px;"><?php echo $row4['CompanyUrl'];?></td>	
											<td width="5%"><?php echo $row4['YoR'];?>  </td>	
											<td width="5%"><a href="https://www.needyin.com/dev/<?php echo $row4['roc'];?>" download> Download</a> </td>										
											<td style="text-align:center; width:77px;"> 
											<?php if($row4['status'] =='0'){ echo "Inactive";}else if($row4['status'] =='1'){ echo "Validated";}else if($row4['status'] =='2'){ echo "Sent to Admin";}else if($row4['status'] =='3'){ echo "Awaited Process";}else if($row4['status'] =='4'){ echo "Approved";} else if($row4['status'] =='5'){ echo "Rejected";}else if($row4['status'] =='6'){ echo "In Process";}else if($row4['status'] =='7'){ echo "Sent to Query";}else { echo "";}?>
											</td>											
										</tr>    
							    	<?php  }?>									
                                </tbody>											
                            </table>
                       
                        </div>
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