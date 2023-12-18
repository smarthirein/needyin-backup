<?php 
session_start();
require_once("../config.php");
require_once '../class.user.php';
$user_home = new USER();
 
if(!isset($_SESSION['adminSession']))
{
	$user_home->redirect('index-recruiter.php');
   
} 	
$uid=$_GET['uid'];
$cdate=$_GET['cd'];
if($_GET['act']=="notis"){
	echo $notifi="UPDATE tbl_notifications SET notification_read=1 WHERE  job_owner_id=".$uid." and created_on='".$cdate."'  and notification_to =".$_SESSION['adminSession'];
		 mysqli_query($con, $notifi);
		
		}else{}
$stmt = $user_home->runQuery("SELECT * FROM tbl_admin WHERE id=:eid");
$stmt->execute(array(":eid"=>$_SESSION['adminSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$empid=$_GET['uid'];
$jc1= "SELECT * FROM tbll_emplyer te INNER JOIN tbl_industry ti ON te.industry_type=ti.Indus_Id INNER JOIN tbl_location tl  ON tl.Loc_Id=te.loc_id INNER JOIN tbl_country tc  ON te.country_id=tc.Cntry_Id INNER JOIN tbl_states ts  ON te.state_id=ts.id WHERE te.emp_id='".$empid."'";
$jresult1 = mysqli_query($con,$jc1);
$jrow = mysqli_fetch_array($jresult1);


 $change_aw="UPDATE tbll_emplyer SET status='3' WHERE emp_id='".$empid."' and status='2'";
	mysqli_query($con,$change_aw);
	
	
	// to add the SA status date to the table tbl_emp_admin_updts
	$eau="update tbl_emp_admin_updts SET 3_updts='NOW()' where emp_id=".$empid;
	$eau_res=mysqli_query($con,$eau);


//exploding data from the tbll_emplyer  for admin status
 $cnamea=explode("#",$jrow['adminstatus']);

$output1 = preg_split( "/(^|@|#)/", $cnamea[0]);
$output2 = preg_split( "/(^|@|#)/", $cnamea[1]);
$output3 = preg_split( "/(^|@|#)/", $cnamea[2]);
$output4 = preg_split( "/(^|@|#)/", $cnamea[3]);
$output5 = preg_split( "/(^|@|#)/", $cnamea[4]);
$output6 = preg_split( "/(^|@|#)/", $cnamea[5]);
$output7 = preg_split( "/(^|@|#)/", $cnamea[6]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
    <!-- css includes-->
    <?php include "source.php"; ?>	
	<style>
.col-md-12{
	font-size:12px;
}
.col-md-12 row{
	font-size:12px;
}
.modal-dialog{
	   width: 80% !important; padding:0 !important;
}
.modal-header{
	padding:0 !important;
	border-bottom:none !important;
	background:none !important;
}
input[disabled]{
	font-size:11px !important;
	color:#000 !important;
	
}
.other-inputs{
	font-size:10px !important;
	
}
.alice{ background:#F0F8FF !important;
border-bottom:2px solid #fff;
}
.azure{
	background:	#F5F5DC !important;border-bottom:2px solid #fff;
}
.fbold{
	font-size:10px !important;color:#5F9EA0;
}
form p{
	font-size:10px !important;
}
.modal .modal-content{
	padding:0px !important;
}
.col-md-4{height:40px !important;
}
.row{
	margin:0 !important;
}
fieldset {
border: #ddd 1px solid;
padding:15px;
}
legend{
	width:auto !important;
}
select{
background:none !important;
font-size:11px !important;
background:url(../img/arrow-new.png)no-repeat right center!important;

}
.btn-blue-sm{font-size:10px !important;
}

</style>
</head>
<body>
    <?php 
	include_once("../analyticstracking.php");
	include '../includes-recruiter/admin_header.php'; ?>
        <!-- main-->
        <main>
            <!-- recruiter view -->
            <section class="rec-view">
                <!-- brudcrumb -->
                <div class="container">
                    <ul class="bcrumb-listjobs">
                        <li> <a href="index.php">HOME</a> </li>
                        <li>  <a href="employers-latest.php">LATEST EMPLOYERS</a> 
						</li>
                        <li> <a><?php echo $jrow['companyname']; ?></a> </li>
                    </ul>
                </div>
                <!--/ brudcrumb -->
                <!-- recruiter view main -->
                <section class="rec-viewmain">
                  
                    <!-- recruiter view tab-->
                    <!-- job seekar body -->
                    <section class="job-seekar-body">					
                        <div class="js-profile-nav recview">						
                            <!-- job seekear profile navigation -->
                            <div class="container">							
                                <ul class="nav nav-tabs responsive-tabs nav-profile">
                                     <li class="active"></li>
                                </ul>
								 <div class="tab-content profile-body-content">
                                    <div class="tab-pane active" id="geninfo">
                                        <div class="tabjsinfo-content">
										<div class="display-features">
									<!-- profile over view -->
									<div class="display-details">
										<!-- display details show-->
										<!--show details -->
									<div class="container-fluid">
   <div class="row">
  
   <div class="col-md-12">	
   <span style="float:right;font-size:12px !important;background:#ddd;padding:5px">Current Status:<?php if($jrow['status'] =='0'){ echo "Not Validated";}else if($jrow['status'] =='1'){ echo "Validated";}else if($jrow['status'] =='2'){ echo "Sent to Admin";}else if($jrow['status'] =='3'){ echo "Awaited Process";}else if($jrow['status'] =='4'){ echo "Approved";} else if($jrow['status'] =='5'){ echo "Rejected";}else if($jrow['status'] =='6'){ echo "In process";}else { echo "";}?></span>
   </div>
    <div class="col-md-6" >
	<fieldset>
  <legend>Company Details:</legend>
	<form method="post" action="empadmin.php">
	 
      <div class="row">
        <div class="col-md-4" ><span class="fbold">Company Name:</span> <input type="text" name="name" value="<?php echo $jrow['companyname']; ?>" disabled>	</div>
        <div class="col-md-4" >	<span class="fbold">Status:</span>
		<select id="cnameapp" name="cnameapp" onChange="comanyname(this);" style="display:block">
		<option value="0">select</option>
		<option value="yes" <?php if ($output1[1]=='cname^yes'){ echo 'selected';} ?>>Approved</option>
		<option value="no" <?php if ($output1[1]=='cname^no'){ echo 'selected';} ?>>Not Approved</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span> 
		 <div id="company" >
			<label><input class="other-inputs" id="cnamere" name="cnamere"  placeholder="Add Reason" value="<?php echo $output1[2];?>"></input>
			</label>
		</div>
		
								</div>
      </div>
	  
	   <div class="row">
        <div class="col-md-4" ><span class="fbold">Company Url: </span><input type="text" name="email" value="<?php echo $jrow['CompanyUrl']; ?>" disabled>	</div>
        <div class="col-md-4" >	<span class="fbold">Status:</span> 
		<select id="curlapp" name="curlapp" onChange="comanyurl(this);" style="display:block">
		<option value="0">select</option>
		<option value="yes" <?php if ($output2[1]=='curl^yes'){ echo 'selected';} ?>>Approved</option>
		<option value="no" <?php if ($output2[1]=='curl^no'){ echo 'selected';} ?>>Not Approved</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span>  <div id="curl" >
		<label><input class="other-inputs" id="comurlre" name="comurlre"  placeholder="Add url description" value="<?php echo $output2[2];?>"></input>
		</label>
																</div>
																	</div>
      </div>
	   <div class="row">
        <div class="col-md-4" ><span class="fbold">Roc: </span><?php if(count($jrow['roc'])==0){?>
										<li> Roc</li>
										<?php }//else { ?> 
										<a href="https://www.needyin.com/dev/<?php echo $jrow['roc']; ?>" download target="_blank"><i class="fa fa-download" aria-hidden="true"></i> Roc</a></li><?php //} ?>	</div>
        <div class="col-md-4" >	<span class="fbold">Status:</span>
		<select id="rocapp" name="rocapp" onChange="comanyroc(this);" style="display:block">
		<option value="0">select</option>
		<option value="yes" <?php if ($output3[1]=='croc^yes'){ echo 'selected';} ?>>Approved</option>
		<option value="no" <?php if ($output3[1]=='croc^no'){ echo 'selected';} ?>>
		Not Approved</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span>   <div id="roc" >
																<label><input class="other-inputs" id="rocre" name="comrocre"  placeholder="Add Roc Reason" value="<?php echo $output3[2];?>"></input>
																</label>
																</div>
																</div>
      </div>
	  
	    <!--<div class="row">
			 <div class="col-md-4" ><span class="fbold">Employer Strength: </span><input type="text" name="email" value="<?php echo $jrow['EmployerStrength']; ?>" disabled></div>
			 <div class="col-md-4" ></div>
			 <div class="col-md-4"></div>
        </div>
		<div class="row">
			 <div class="col-md-4" ><span class="fbold">No of Branches: </span><input type="text" name="email" value="<?php echo $jrow['NoOfBranch']; ?>" disabled></div>
			 <div class="col-md-4" ></div>
			 <div class="col-md-4"></div>
        </div>-->
		<div class="row">
			 <div class="col-md-4" ><span class="fbold">Company Type: </span><input type="text" name="company_type" value="<?php echo $jrow['company_type']; ?>" disabled></div>
			 <div class="col-md-4" ><span class="fbold">Status:</span> 
			 <select id="ctypeapp" name="ctypeapp" onChange="comanytype(this);" style="display:block">
			 <option value="0">select</option>
			 <option value="yes" <?php if ($output4[1]=='ctype^yes'){ echo 'selected';} ?>>Approved</option>
			 <option value="no" <?php if ($output4[1]=='ctype^no'){ echo 'selected';} ?>>Not Approved</option></select></div>
			 <div class="col-md-4">
			 <span class="fbold">Write Reason:</span> <div id="ctype">
																<label><input class="other-inputs" id="comtypere" name="comtypere"  placeholder="Write Reason" value="<?php echo $output4[2];?>"></input>
																</label>
																</div>
																
			 </div>
        </div>
	  <div class="row">
			 <div class="col-md-4" ><span class="fbold">Industry Type: </span><input type="text" name="indtype"  value="<?php echo $jrow['Indus_Name']; ?>" disabled></div>
			 <div class="col-md-4" ><span class="fbold">Status:</span>
			 <select id="indtypeapp" name="indtypeapp" onChange="indtype(this);" style="display:block">
			 <option value="0">select</option>
			 <option value="yes" <?php if ($output5[1]=='indtype^yes'){ echo 'selected';} ?>>Approved</option>
			 <option value="no" <?php if ($output5[1]=='indtype^no'){ echo 'selected';} ?>>Not Approved</option></select></div>
			 <div class="col-md-4">
			 <span class="fbold">Write Reason:</span>  <div id="indtype">
																<label><input class="other-inputs" id="indtypere" name="indtypere"  placeholder="Write Reason" value="<?php echo $output5[2];?>"></input>
																</label>
																</div>
																
			 </div>
        </div>
		<div class="row">
			 <div class="col-md-4" ><span class="fbold">YOR: </span><input type="text" name="name" value="<?php echo $jrow['YoR']; ?>" disabled></div>
			 <div class="col-md-4" ><span class="fbold">Status:</span>
			 <select id="cyorapp" name="cyorapp" onChange="cyor(this);" style="display:block">
			 <option value="0">select</option>
			 <option value="yes" <?php if ($output6[1]=='cyor^yes'){ echo 'selected';} ?>>Approved</option>
			 <option value="no" <?php if ($output5[1]=='cyor^no'){ echo 'selected';} ?>>Not Approved</option></select></div>
			 <div class="col-md-4">
			 <span class="fbold">Write Reason:</span>  <div id="cyor">
																<label><input class="other-inputs" id="cyorre" name="cyorre"  placeholder="Write Reason" value="<?php echo $output6[2];?>"></input>
																</label>
																</div>
																
			 </div>
        </div>
		<!--<div class="row">
			 <div class="col-md-4" ><span class="fbold">TOR: </span><input type="text" name="name" value="<?php echo $jrow['ToR']; ?>" disabled></div>
			 <div class="col-md-4" ></div>
			 <div class="col-md-4"></div>
        </div>-->
			  <div class="row">
			<div class="col-md-4" ><span class="fbold">Designation: </span><input type="text" name="designation" value="<?php echo $jrow['designation']; ?>" disabled></div>
			 <div class="col-md-4" ><span class="fbold">Status:</span>
			 <select id="desigapp" name="desigapp" onChange="condesig(this);" style="display:block">
			 <option value="0">select</option>
			 <option value="yes" <?php if ($output7[1]=='desig^yes'){ echo 'selected';} ?>>Approved</option>
			 <option value="no" <?php if ($output6[1]=='desig^no'){ echo 'selected';} ?>>Not Approved</option></select></div>
			 <div class="col-md-4">
			 <span class="fbold">Write Reason:</span>  
			 <div id="desig">
				<label><input class="other-inputs" id="desingre" name="desingre"  placeholder="Write Reason" value="<?php echo $output7[2];?>"></input>
				</label>
			</div>
			
			 </div>
        </div>
		<br/><br/>
		<br/>
		<input type="hidden" value="<?php echo $empid; ?>" name="empid">
		<?php if(($jrow['status'] !=0) ||($jrow['status'] !=1)) {?>
		<input class="btn btn-blue-sm" type="submit" value="Save & Submit" name="comapprovals" onclick="return validate()">	
		<?php }else {?>
		<input class="btn btn-blue-sm" type="submit"  onclick="return validate()" disabled>
		<?php }?>		
		<br/>
		<br/>
		<br/>
	  
	</form>
	  </fieldset>
    </div>
    <div class="col-md-6" >
	
	 <fieldset>
  <legend>Contact Details:</legend>
	<span class="fbold">  Contact Name: </span><input type="text" name="name" value="<?php echo $jrow['contact_name']; ?>" disabled>														
	<span class="fbold">E-mail: </span><input type="text" name="email" value="<?php echo $jrow['emp_email']; ?>" disabled>
	<span class="fbold">Contact Number: </span><input type="text" name="website" value="<?php echo $jrow['contact_num']; ?>" disabled>
	</fieldset>
	<fieldset>
  <legend>Company Address:</legend>
	
	<span class="fbold"> Company Address: </span><input type="text" name="email" value="<?php echo $jrow['address1']; ?>" disabled>
	<span class="fbold"> Location: </span><input type="text" name="email" value="<?php echo $jrow['Loc_Name']; ?>" disabled>
	<span class="fbold">  State: </span><input type="text" name="email" value="<?php echo $jrow['states']; ?>" disabled>
	<span class="fbold">  Country: </span><input type="text" name="email" value="<?php echo $jrow['Cntry_Name']; ?>" disabled>
	<span class="fbold">Pincode: </span><input type="text" name="email" value="<?php echo $jrow['pincode']; ?>" disabled>
	</fieldset>
	
	</div>
	<div class="col-md-12 row">
	
	 <fieldset>
  <legend><h2>Change Status</h2></legend>
	
	<form name="" method="post" action="changestatus.php">
			<label>Change Status</label>
			<select name="activeinactive"  class="form-control classic" required>	
			<!--<option value="0" <?php if( $jrow['status'] =='0') {echo "selected";}?>>Not Validated</option>										
			<option value="1" <?php if($jrow['status'] =='1'){echo "selected";} ?>>Validated</option>				
			<option value="2" <?php if($jrow['status'] =='2'){echo "selected";}?>>Sent to Admin</option>-->
		
		    
				<?php if (($output1[1]=='cname^yes')&&($output2[1]=='curl^yes')&&($output3[1]=='croc^yes')&&($output4[1]=='ctype^yes') &&($output5[1]=='indtype^yes') &&($output6[1]=='cyor^yes')&&($output7[1]=='desig^yes')&&(($jrow['status']==3)||($jrow['status']==5)||($jrow['status']==6))) { ?>
			<option value="3" <?php if($jrow['status'] =='3'){echo "selected";}?>>Awaited Process</option>
	<option value="6" <?php if($jrow['status'] =='6'){echo "selected";}?>>In Process</option>			
		   <option value="4" <?php if($jrow['status'] =='4'){echo "selected";}?>>Approved</option>
			<?php }else {?>	
			<option value="3" <?php if($jrow['status'] =='3'){echo "selected";}?> disabled>Awaited Process</option>
			 <option value="4" <?php if($jrow['status'] =='4'){echo "selected";}?> disabled>Approved</option>
			 <option value="6" <?php if($jrow['status'] =='6'){echo "selected";}?>>In Process</option>
			<option value="7" <?php if($jrow['status'] =='7'){echo "selected";}?>>Sent To Query</option>			 
			<?php } ?>			
			<option value="5" <?php if($jrow['status'] =='5'){echo "selected";}?>>Rejected</option>	
	
			</select>							
			<input type="hidden" value="<?php echo $empid; ?>" name="empid">
			<?php if(($jrow['status'] !=0) ||($jrow['status'] !=1)) {?>
			<input class="btn btn-blue-sm" type="submit" value="submit" name="statusemp">	
<?php } else {?>	
<input class="btn btn-blue-sm" type="submit" value="submit" disabled>
<?php }?>		
	</form>
	
	</fieldset>
	
	</div>
  </div>
</div>
										
									</div> 								
								
                                <!-- profile discription content -->
                               
                                <!-- /profile discription content -->
                            </div>
							<section>
			
					</section>
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
    <script>
			function validate()
			{
				//alert("dsfd");
				var cnameapp=document.getElementById('cnameapp').value;
				var cnameres=document.getElementById('cnamere').value;
            	if(((cnameapp =="yes")||(cnameapp=="no"))&&(cnameres == ""))				
            	{
					if(cnameapp =="yes"){
						document.getElementById('cnamere').value="ok";
					}else{
            		alert("Please Write Reason for  Company Name");
            		document.getElementById('cnamere').focus();
            		return false;
					}
            	}
				var curlapp=document.getElementById('curlapp').value;
				var curlres=document.getElementById('comurlre').value;
            	if(((curlapp =="yes")||(curlapp=="no"))&&(curlres == ""))				
            	{
					if(curlapp =="yes"){
						document.getElementById('comurlre').value="ok";
					}else{
            		alert("Please Write Reason for  Company URL");
            		document.getElementById('comurlre').focus();
            		return false;
					}
            	}
				var rocapp=document.getElementById('rocapp').value;
				var rocres=document.getElementById('rocre').value;
            	if(((rocapp =="yes")||(rocapp=="no"))&&(rocres == ""))				
            	{
					if(rocapp =="yes"){
						document.getElementById('rocre').value="ok";
					}else{
            		alert("Please Write Reason for  Company URL");
            		document.getElementById('rocre').focus();
            		return false;
					}
            	}
				var ctypeapp=document.getElementById('ctypeapp').value;
				var comtyperes=document.getElementById('comtypere').value;
            	if(((ctypeapp =="yes")||(ctypeapp=="no"))&&(comtyperes == ""))				
            	{
					if(ctypeapp =="yes"){
						document.getElementById('comtypere').value="ok";
					}else{
            		alert("Please Write Reason for  Company Type");
            		document.getElementById('comtypere').focus();
            		return false;
					}
            	}
				var indtypeapp=document.getElementById('indtypeapp').value;
				var indtyperes=document.getElementById('indtypere').value;
            	if(((indtypeapp =="yes")||(indtypeapp=="no"))&&(indtyperes == ""))				
            	{
					if(indtypeapp =="yes"){
						document.getElementById('indtypere').value="ok";
					}else{
            		alert("Please Write Reason for Industry Type");
            		document.getElementById('indtypere').focus();
            		return false;
					}
            	}
				var cyorapp=document.getElementById('cyorapp').value;
				var cyorres=document.getElementById('cyorre').value;
            	if(((cyorapp =="yes")||(cyorapp=="no"))&&(cyorres == ""))				
            	{
					if(cyorapp =="yes"){
						document.getElementById('cyorre').value="ok";
					}else{
            		alert("Please Write Reason for YOR");
            		document.getElementById('cyorre').focus();
            		return false;
					}
            	}
				
				var desigapp=document.getElementById('desigapp').value;
				var desingres=document.getElementById('desingre').value;
            	if(((desigapp =="yes")||(desigapp=="no"))&&(desingres == ""))				
            	{
					if(desigapp =="yes"){
						document.getElementById('desingre').value="ok";
					}else{
            		alert("Please Write Reason for Designation");
            		document.getElementById('desingre').focus();
            		return false;
					}
            	}
			}
</script>
          
            <!--/ message popup-->
            <!-- schedule popup-->

			
			
			
			
            <!-- /schedule popup-->
</body>

</html>