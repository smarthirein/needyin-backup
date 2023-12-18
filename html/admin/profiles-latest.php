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
                                <h4 class="h4"> <i class="fa fa-clipboard" aria-hidden="true"></i> Profiles</h4> </article>
                        </div>
                    </div>
                  
                </div>
              
                <div class="container">
                    <div class="row">
                        <div class="col-md-9 col-sm-8">
						 <?php
							$sql3 = "SELECT Count(*) as Id FROM tbl_jobseeker";
							$query3 = mysqli_query($con, $sql3);
						    $row3 = mysqli_fetch_array($query3);
						 ?>
                            <h5 class="h5  jobtitle pull-left">TOTAL Job Seekers  <span><?php echo $row3['Id']; ?></span></h5> </div>
							<div class="col-md-3 col-sm-4 actdrop">							
								<form name="" method="post" action="">
									<div class="form-group">

										<select name="activeinactive" onchange="this.form.submit();" class="form-control classic">											
										 										  	
										  <option value="Y" <?php if($_POST['activeinactive'] =='Y'){echo "selected";} ?>>100% complete</option>										   										
										  <option value="V" <?php if($_POST['activeinactive'] =='V'){echo "selected";}?>>Vadlidation</option>
										  <option value="N" <?php if($_POST['activeinactive'] =='N'){echo "selected";}?>>No validation</option>
										  <option value="AW" <?php if($_POST['activeinactive'] =='AW'){echo "selected";}?>>Awaited Pocess</option>
										  <option value="IP" <?php if($_POST['activeinactive'] =='IP'){echo "selected";}?>>In Process</option>										  
										  <option value="A" <?php if($_POST['activeinactive'] =='A'){echo "selected";}?>>Approved</option>
										  <option value="SQ" <?php if($_POST['activeinactive'] =='SQ'){echo "selected";}?>>Sent to Query</option>										  
										  <option value="R" <?php if($_POST['activeinactive'] =='R'){echo "selected";}?>>Rejected</option>
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
                                        <th width="10%">Name</th>
										<th width="10%">Designation </th>
										<th width="100px" class="text-center">Email ID</th> 
<th width="100px" style="text-align:center;"> Resume</th> 										
                                        <th width="100px" style="text-align:center;">Experience</th>
										   
                                        <th width="100px" style="text-align:center;"> Exp Salary</th>                                        
									    <th width="100px" class="text-center">Preffered Loc</th>                                       
										<th width="100px" class="text-center">Status</th>
										
                                    </tr>
                                </thead>
								<tbody>
								<?php 								
								if($_POST['activeinactive'] != "")
								{
									$sql4 ="SELECT * FROM tbl_jobseeker tj INNER JOIN tbl_currentexperience ce ON tj.JUser_Id=ce.JUser_Id where  tj.JuserStatus='".$_POST['activeinactive']."' order by tj.currentdate desc";
									$query4 = mysqli_query($con, $sql4);
								}
								else
								{
									$sql4 ="SELECT * FROM tbl_jobseeker tj INNER JOIN tbl_currentexperience ce ON tj.JUser_Id=ce.JUser_Id where  tj.JuserStatus='Y'";
									$query4 = mysqli_query($con, $sql4);
								}
									
																	
									while($row4 = mysqli_fetch_array($query4)){
										
										$user_queryD = "SELECT Loc_Name from tbl_location  where Loc_Id='".$row4['JPLoc_Id']."'";
										$rrD = mysqli_query($con,$user_queryD);
										$rrsD = mysqli_fetch_array($rrD);
										
										$user_cloc = "SELECT Loc_Name from tbl_location  where Loc_Id='".$row4['Loc_Id']."'";
										$cloc = mysqli_query($con,$user_cloc);
										$clocs = mysqli_fetch_array($cloc);
										
										$sql2 = "SELECT * FROM tbl_desigination where Desig_Id ='".$row4['Job_Name']."'";
										$query2 = mysqli_query($con, $sql2);
										$row2 = mysqli_fetch_array($query2);
										?>	
										<tr>
										<td>
										<a href="jobseeker-detail-recruiter.php?uid=<?php echo $row4['JUser_Id'];?>"><?php echo $row4['JFullName'];?></a></td>
											<td width="25%"><?php echo $row4['Des'];?> </td>
											<td><?php echo $row4['JEmail'];?></td>		
<td width="65px" style="text-align:center;"><a href="<?php echo $row4['UpdateCV'];?>" download>Download</a></td>											
											<td width="65px" style="text-align:center;"><?php echo $row4['JTotalEy'];?> . <?php echo $row4['JTotalEm'];?></td>
											
											<td width="65px" style="text-align:center;"><?php echo $row4['ExpSalL'];?> - <?php echo $row4['ExpMaxSalL'];?></td>
													                            
											<td style="text-align:center; width:77px;"><?php echo $rrsD['Loc_Name'];?>
											           
											</td>											       
											<td style="text-align:center; width:77px;"> <?php //echo $row4['JuserStatus'];?>
											<?php if($row4['JuserStatus'] =='AW'){ echo "Awaited Process";}else if($row4['JuserStatus'] =='Y'){ echo "100% Complete";}else if($row4['JuserStatus'] =='N'){ echo "No Validation";}else if($row4['JuserStatus'] =='V'){ echo "Validation";}else if($row4['JuserStatus'] =='A'){ echo "Approved";} else if($row4['JuserStatus'] =='SQ'){ echo "Sent To Query";}else if($row4['JuserStatus'] =='IP'){ echo "In Process";}else if($row4['JuserStatus'] =='R'){ echo "Rejected";}else { echo "";}?>
											</td>
											<!--<td style="text-align:center; width:77px;"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Open Modal</button></td>-->
										</tr>    
							    	<?php  }?>									
                                </tbody>											
                            </table>
                       
                        </div>
                    </div>
              
                </div>
			<?php	//echo $jc1= "SELECT * FROM tbl_jobseeker WHERE JUser_Id='".$JUser_Id."' and jdndstatus='0' ";
//$jresult1 = mysqli_query($con,$jc1);
//$jrow = mysqli_fetch_array($jresult1);?>
              		<!-- Modal -->
								<div id="myModal" class="modal fade" role="dialog">
								  <div class="modal-dialog">

									<!-- Modal content-->
									<div class="modal-content"  style="width: 800px;padding:0">
									  <div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Modal Header</h4>
									  </div>
									  <div class="modal-body">
										<div class="container-fluid">
   <div class="col-md-12">
   <form method="post" action="empadmin.php">
    <div class="col-md-6" >
	
      <div class="row">
        <div class="col-md-4" ><span class="fbold">User Name:</span> <input style="font-size:12px" type="text" name="name" value="<?php echo $jrow['JFullName']; ?>" disabled>	</div>
        <div class="col-md-4" >	<span class="fbold">Approved (yes/no):</span> <select name="unameapp"  style="display:block"><option value="yes" <?php if ($output1[1]=='yes'){ echo 'selected';} ?>>yes</option><option value="no" <?php if ($output1[1]=='no'){ echo 'selected';} ?>>no</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span> <?php echo $output1[2];?>
		 <div id="company" >
			<label><input id="other-inputs" name="cnamere"  placeholder="Add Reason" value="<?php echo $output1[2];?>"></input>
			</label>
		</div>
		
								</div>
      </div>
	  
	   <div class="row">
        <div class="col-md-4" ><span class="fbold">User Phone:</span> <input style="font-size:12px" type="text" name="name" value="<?php echo $jrow['JPhone']; ?>" disabled>	</div>
        <div class="col-md-4" >	<span class="fbold">Approved (yes/no):</span> <select name="unameapp"  style="display:block"><option value="yes" <?php if ($output1[1]=='yes'){ echo 'selected';} ?>>yes</option><option value="no" <?php if ($output1[1]=='no'){ echo 'selected';} ?>>no</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span> <?php echo $output1[2];?>
		 <div id="company" >
			<label><input id="other-inputs" name="cnamere"  placeholder="Add Reason" value="<?php echo $output1[2];?>"></input>
			</label>
		</div>
		
								</div>
      </div>
	   <div class="row">
        <div class="col-md-4" ><span class="fbold">User Exp:</span> <input style="font-size:12px" type="text" name="name" value="<?php echo $jrow['JTotalEy'].'.'.$jrow['JTotalEm']; ?>" disabled>	</div>
        <div class="col-md-4" >	<span class="fbold">Approved (yes/no):</span> <select name="unameapp"  style="display:block"><option value="yes" <?php if ($output1[1]=='yes'){ echo 'selected';} ?>>yes</option><option value="no" <?php if ($output1[1]=='no'){ echo 'selected';} ?>>no</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span> <?php echo $output1[2];?>
		 <div id="company" >
			<label><input id="other-inputs" name="cnamere"  placeholder="Add Reason" value="<?php echo $output1[2];?>"></input>
			</label>
		</div>
		</div>
      </div>
	  <div class="row">
        <div class="col-md-4" ><span class="fbold">User DOB:</span> <input style="font-size:12px" type="text" name="name" value="<?php echo $jrow['DoB'] ?>" disabled>	</div>
        <div class="col-md-4" >	<span class="fbold">Approved (yes/no):</span> <select name="unameapp"  style="display:block"><option value="yes" <?php if ($output1[1]=='yes'){ echo 'selected';} ?>>yes</option><option value="no" <?php if ($output1[1]=='no'){ echo 'selected';} ?>>no</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span> <?php echo $output1[2];?>
		 <div id="company" >
			<label><input id="other-inputs" name="cnamere"  placeholder="Add Reason" value="<?php echo $output1[2];?>"></input>
			</label>
		</div>
		
								</div>
      </div>
	    <div class="row">
        <div class="col-md-4" ><span class="fbold">User Gender:</span> <input style="font-size:12px" type="text" name="name" value="<?php echo $jrow['Gender'] ?>" disabled>	</div>
        <div class="col-md-4" >	<span class="fbold">Approved (yes/no):</span> <select name="unameapp"  style="display:block"><option value="yes" <?php if ($output1[1]=='yes'){ echo 'selected';} ?>>yes</option><option value="no" <?php if ($output1[1]=='no'){ echo 'selected';} ?>>no</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span> <?php echo $output1[2];?>
		 <div id="company" >
			<label><input id="other-inputs" name="cnamere"  placeholder="Add Reason" value="<?php echo $output1[2];?>"></input>
			</label>
		</div>
		
								</div>
      </div>
	   
	  
	  </div>
	  <div class="col-md-6" >
	   <div class="row">
        <div class="col-md-4" ><span class="fbold">User Email:</span> <input type="text" name="email" value="<?php echo $jrow['JEmail']; ?>" disabled>	</div>
        <div class="col-md-4" >	<span class="fbold">Approved (yes/no):</span> <select name="uemailapp"  style="display:block"><option value="yes" <?php if ($output1[1]=='yes'){ echo 'selected';} ?>>yes</option><option value="no" <?php if ($output1[1]=='no'){ echo 'selected';} ?>>no</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span> <?php echo $output1[2];?>
		 <div id="company" >
			<label><input id="other-inputs" name="cnamere"  placeholder="Add Reason" value="<?php echo $output1[2];?>"></input>
			</label>
		</div>
		
								</div>
      </div>
	  <div class="row">
        <div class="col-md-4" ><span class="fbold">Reason attachment:</span> <a href="./<?php echo $jrow['JReasonAttach'] ?>" download> download</a>	</div>
        <div class="col-md-4" >	<span class="fbold">Approved (yes/no):</span> <select name="unameapp"  style="display:block"><option value="yes" <?php if ($output1[1]=='yes'){ echo 'selected';} ?>>yes</option><option value="no" <?php if ($output1[1]=='no'){ echo 'selected';} ?>>no</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span> <?php echo $output1[2];?>
		 <div id="company" >
			<label><input id="other-inputs" name="cnamere"  placeholder="Add Reason" value="<?php echo $output1[2];?>"></input>
			</label>
		</div>
		
								</div>
      </div>
	   <div class="row">
        <div class="col-md-4" ><span class="fbold">Pref Location:</span> <input type="text" name="loca" value="<?php echo $jrow['JPLoc_name']; ?>" disabled>	</div>
        <div class="col-md-4" >	<span class="fbold">Approved (yes/no):</span> <select name="uemailapp"  style="display:block"><option value="yes" <?php if ($output1[1]=='yes'){ echo 'selected';} ?>>yes</option><option value="no" <?php if ($output1[1]=='no'){ echo 'selected';} ?>>no</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span> <?php echo $output1[2];?>
		 <div id="company" >
			<label><input id="other-inputs" name="cnamere"  placeholder="Add Reason" value="<?php echo $output1[2];?>"></input>
			</label>
		</div>
		
								</div>
      </div>
	    <div class="row">
        <div class="col-md-4" ><span class="fbold">Pref Location:</span> <input type="text" name="loca" value="<?php echo $jrow['JPLoc_name']; ?>" disabled>	</div>
        <div class="col-md-4" >	<span class="fbold">Approved (yes/no):</span> <select name="uemailapp"  style="display:block"><option value="yes" <?php if ($output1[1]=='yes'){ echo 'selected';} ?>>yes</option><option value="no" <?php if ($output1[1]=='no'){ echo 'selected';} ?>>no</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span> <?php echo $output1[2];?>
		 <div id="company" >
			<label><input id="other-inputs" name="cnamere"  placeholder="Add Reason" value="<?php echo $output1[2];?>"></input>
			</label>
		</div>
		
								</div>
      </div>
	    <div class="row">
        <div class="col-md-4" ><span class="fbold">Pref Location:</span> <input type="text" name="loca" value="<?php echo $jrow['JPLoc_name']; ?>" disabled>	</div>
        <div class="col-md-4" >	<span class="fbold">Approved (yes/no):</span> <select name="uemailapp"  style="display:block"><option value="yes" <?php if ($output1[1]=='yes'){ echo 'selected';} ?>>yes</option><option value="no" <?php if ($output1[1]=='no'){ echo 'selected';} ?>>no</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span> <?php echo $output1[2];?>
		 <div id="company" >
			<label><input id="other-inputs" name="cnamere"  placeholder="Add Reason" value="<?php echo $output1[2];?>"></input>
			</label>
		</div>
		
								</div>
      </div>
	  </div>
	  </form>
	  </div>
	  </div>
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