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
                                <h4 class="h4"> <i class="fa fa-clipboard" aria-hidden="true"></i> Jobs</h4> </article>
                        </div>
                    </div>
                  
                </div>
              
                <div class="container">
                    <div class="row">
                       <div class="col-md-9 col-sm-8">
						 <?php
							$sql3 = "SELECT Count(*) as Id FROM tbl_jobposted";
							$query3 = mysqli_query($con, $sql3);
						    $row3 = mysqli_fetch_array($query3);
							
							
						 ?>
                            <h5 class="h5  jobtitle pull-left">TOTAL Jobs  <span><?php echo $row3['Id']; ?></span></h5></div>
							<div class="col-md-3 col-sm-4 actdrop ">							
								<form name="" method="post" action="#">
									<div class="form-group">
										<select name="activeinactive" onchange="this.form.submit();" class="form-control classic">
<option>select</option>										
										 <?php 
											$q1 = "SELECT Comp_Name,Job_Id,emp_id FROM tbl_jobposted group by emp_id";
											$r1 = mysqli_query($con,$q1);
											while($res1 = mysqli_fetch_array($r1))
											{
												$compName = $res1['Comp_Name'];
												$empId = $res1['emp_id'];
												$jobId = $res1['Job_Id'];
												?>
												<option value="<?php echo $empId;?>" <?php if ($empId==$_POST['activeinactive']){ echo 'selected';}?> ><?php echo $compName;?></option>;
										<?php 
											} ?>
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
										<th>Company Name</th>
                                        <th>Job Title</th>
                                        <th>Position Type</th>
                                        <th style="text-align:center;">Experience</th>
                                        <th>Location</th>
									    <th>Job Status</th>
									    <th>Doc</th>
                                    </tr>
                                </thead>
								<tbody>								
								
										<?php 								
								if($_POST['activeinactive'] != "")
								{
									$sql4 = "SELECT * FROM 	tbl_jobposted where  Job_Status=1 and emp_id='".$_POST['activeinactive']."'";
									$query4 = mysqli_query($con, $sql4);
								}
								else
								{
									 $sql4 = "SELECT * FROM tbl_jobposted where  Job_Status=1 ";
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
										<td ><?php echo $row4['Comp_Name'];?></td>
											<td ><a href="view-job-admin.php?jobId=<?php echo $row4['Job_Id'];?>"><?php echo $row2['Desig_Name'];?></a> </td>
										
											<td  style="text-align:center;"><?php echo $row4['Min_Exp'];?> - <?php echo $row4['Max_Exp'];?></td>
											<td  style="text-align:center;"><?php echo $row4['Sal_Range'];?> - <?php echo $row4['MSal_Range'];?></td>
											<td><?php echo $rrsD['Loc_Name'];?></td>
											<td><?php if($row4['Job_Status']==0){ echo "Inactive";}else if($row4['Job_Status']==2){echo "Closed";}else { echo "Active";}?> </td>
											<td><?php echo $row4['created'];?></td>
										</tr>    
							    	<?php  }?>										
                                </tbody>											
                            </table>
                       
                        </div>
                    </div>
              
                </div>
              </div>
            </section>
			
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