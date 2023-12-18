<?php 
session_start();
require_once("../config.php");
require_once '../class.user.php';
$user_home = new USER();
 
if(!isset($_SESSION['adminSession']))
{
	$user_home->redirect('index-recruiter.php');
   
} 	
$stmt = $user_home->runQuery("SELECT * FROM tbl_admin WHERE id=:eid");
$stmt->execute(array(":eid"=>$_SESSION['adminSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$empid=$_GET['uid'];
$jc1= "SELECT * FROM tbll_emplyer te INNER JOIN tbl_industry ti ON te.industry_type=ti.Indus_Id INNER JOIN tbl_location tl  ON tl.Loc_Id=te.loc_id INNER JOIN tbl_country tc  ON te.country_id=tc.Cntry_Id INNER JOIN tbl_states ts  ON te.state_id=ts.id WHERE te.emp_id='".$empid."'";
$jresult1 = mysqli_query($con,$jc1);
$jrow = mysqli_fetch_array($jresult1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
    <!-- css includes-->
    <?php include "source.php"; ?>	
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
                    <!-- recruiter view header -->
                   <!-- <div class="rec-view-header">
                        <div class="container">
                            <!-- row-->
                           <!--  <div class="">
                               <div class="row">
                                   <div class="col-md-12">
                                        <div class="col-md-2 col-sm-3 detail-imgnew">
                                  <figure class="recview-img"> <img class="img-cover" data-object-fit="cover" src="../<?php //if($jrow['eLogo']){ echo $jrow['eLogo']; }else{ ?> ../img/js-profile-list-pic.jpg <?php// }?>"> </figure>
                                </div>
                               
                                 
                                   </div>
                                    
                               </div>
                               
                                
                            </div>
                            <!-- / row -->
                      <!--   </div>
                    </div>-->
                    <!-- /recruiter view -->
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
										<!-- display details edit and title -->
										
											
										<!--/ display details edit and title -->
										<!-- display details show-->
										<!--show details -->
									<div class="container-fluid">
   <div class="row">
    <div class="col-md-6" ><article class="sub-title"><h4 class="pull-left">Company <span class="fbold">Details</span></h4> </article>
      <div class="row">
        <div class="col-md-4" ><span class="fbold">Company Name:</span> <input type="text" name="name" value="<?php echo $jrow['companyname']; ?>" disabled>	</div>
        <div class="col-md-4" >	<span class="fbold">Approved(yes/no):</span> <select name="cname" onChange="comanyname(this);" style="display:block"><option value="yes">yes</option><option value="no">no</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span> <div id="company" style="display:none;">
																<label><input id="other-inputs" name="comreason"  placeholder="Add Reason" ></input>
																</label>
																</div>
																<script>
																function comanyname(elem) {																			
																	 if (elem.value == "no") {
																		document.getElementById("company").style.display = 'block';
																	} else {
																		document.getElementById("company").style.display = 'none';
																	}
																}
																
								</script></div>
      </div>
	   <div class="row">
        <div class="col-md-4" ><span class="fbold">Company Url: </span><input type="text" name="email" value="<?php echo $jrow['CompanyUrl']; ?>" disabled>	</div>
        <div class="col-md-4" >	<span class="fbold">Approved(yes/no):</span> <select name="curl" onChange="comanyurl(this);" style="display:block"><option value="yes">yes</option><option value="no">no</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span>  <div id="curl" style="display:none;">
																<label><input id="other-inputs" name="comurl"  placeholder="Add url description" ></input>
																</label>
																</div>
																<script>
																function comanyurl(elem) {																			
																	 if (elem.value == "no") {
																		document.getElementById("curl").style.display = 'block';
																	} else {
																		document.getElementById("curl").style.display = 'none';
																	}
																}
																													
																</script>	</div>
      </div>
	   <div class="row">
        <div class="col-md-4" ><span class="fbold">Roc: </span><?php if(count($jrow['roc'])==0){?>
										<li> Roc</li>
										<?php }//else { ?> 
										<a href="<?php echo $jrow['roc']; ?>" download target="_blank"><i class="fa fa-download" aria-hidden="true"></i> Roc</a></li><?php //} ?>	</div>
        <div class="col-md-4" >	<span class="fbold">Approved(yes/no):</span> <select name="roc" onChange="comanyroc(this);" style="display:block"><option value="yes">yes</option><option value="no">no</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span>  <div id="roc" style="display:none;">
																<label><input id="other-inputs" name="comroc"  placeholder="Add Roc Reason" ></input>
																</label>
																</div>
																<script>
																function comanyroc(elem) {																			
																	 if (elem.value == "no") {
																		document.getElementById("roc").style.display = 'block';
																	} else {
																		document.getElementById("roc").style.display = 'none';
																	}
																}
																													
																</script>	</div>
      </div>
	  
	    <div class="row">
			 <div class="col-md-4" ><span class="fbold">Employer Strength: </span><input type="text" name="email" value="<?php echo $jrow['EmployerStrength']; ?>" disabled></div>
			 <div class="col-md-4" ></div>
			 <div class="col-md-4"></div>
        </div>
		<div class="row">
			 <div class="col-md-4" ><span class="fbold">No of Branches: </span><input type="text" name="email" value="<?php echo $jrow['NoOfBranch']; ?>" disabled></div>
			 <div class="col-md-4" ></div>
			 <div class="col-md-4"></div>
        </div>
		<div class="row">
			 <div class="col-md-4" ><span class="fbold">Company Type: </span><input type="text" name="company_type" value="<?php echo $jrow['company_type']; ?>" disabled></div>
			 <div class="col-md-4" ><span class="fbold">Approved(yes/no):</span><select name="ctype" onChange="comanytype(this);" style="display:block"><option value="yes">yes</option><option value="no">no</option></select></div>
			 <div class="col-md-4">
			 <span class="fbold">Write Reason:</span>  <div id="ctype" style="display:none;">
																<label><input id="other-inputs" name="comtype"  placeholder="Write Reason" ></input>
																</label>
																</div>
																<script>
																function comanytype(elem) {																			
																	 if (elem.value == "no") {
																		document.getElementById("ctype").style.display = 'block';
																	} else {
																		document.getElementById("ctype").style.display = 'none';
																	}
																}
																</script>
			 </div>
        </div>
	  <div class="row">
			 <div class="col-md-4" ><span class="fbold">Industry Type: </span><input type="text" name="email" value="<?php echo $jrow['Indus_Name']; ?>" disabled></div>
			 <div class="col-md-4" ><span class="fbold">Approved(yes/no):</span><select name="indtype" onChange="indtype(this);" style="display:block"><option value="yes">yes</option><option value="no">no</option></select></div>
			 <div class="col-md-4">
			 <span class="fbold">Write Reason:</span>  <div id="indtype" style="display:none;">
																<label><input id="other-inputs" name="comtype"  placeholder="Write Reason" ></input>
																</label>
																</div>
																<script>
																function indtype(elem) {																			
																	 if (elem.value == "no") {
																		document.getElementById("indtype").style.display = 'block';
																	} else {
																		document.getElementById("indtype").style.display = 'none';
																	}
																}
																</script>
			 </div>
        </div>
		<div class="row">
			 <div class="col-md-4" ><span class="fbold">YOR: </span><input type="text" name="name" value="<?php echo $jrow['YoR']; ?>" disabled></div>
			 <div class="col-md-4" ><span class="fbold">Approved(yes/no):</span><select name="cyor" onChange="cyor(this);" style="display:block"><option value="yes">yes</option><option value="no">no</option></select></div>
			 <div class="col-md-4">
			 <span class="fbold">Write Reason:</span>  <div id="cyor" style="display:none;">
																<label><input id="other-inputs" name="comtype"  placeholder="Write Reason" ></input>
																</label>
																</div>
																<script>
																function cyor(elem) {																			
																	 if (elem.value == "no") {
																		document.getElementById("cyor").style.display = 'block';
																	} else {
																		document.getElementById("cyor").style.display = 'none';
																	}
																}
																</script>
			 </div>
        </div>
		<div class="row">
			 <div class="col-md-4" ><span class="fbold">TOR: </span><input type="text" name="name" value="<?php echo $jrow['ToR']; ?>" disabled></div>
			 <div class="col-md-4" ></div>
			 <div class="col-md-4"></div>
        </div>
			  <div class="row">
			 <div class="col-md-4" ><span class="fbold">Designation: </span><input type="text" name="designation" value="<?php echo $jrow['Indus_Name']; ?>" disabled></div>
			 <div class="col-md-4" ><span class="fbold">Approved(yes/no):</span><select name="desig" onChange="condesig(this);" style="display:block"><option value="yes">yes</option><option value="no">no</option></select></div>
			 <div class="col-md-4">
			 <span class="fbold">Write Reason:</span>  <div id="desig" style="display:none;">
																<label><input id="other-inputs" name="comtype"  placeholder="Write Reason" ></input>
																</label>
																</div>
																<script>
																function condesig(elem) {																			
																	 if (elem.value == "no") {
																		document.getElementById("desig").style.display = 'block';
																	} else {
																		document.getElementById("desig").style.display = 'none';
																	}
																}
																</script>
			 </div>
        </div>
	  
	  
	  
    </div>
    <div class="col-md-6" >.col-sm-4</div>
  </div>
</div>
										<div id="show-profile-overview">
											<div class="row showdetails "><div class="col-md-6 col-sm-6">
												<div class="col-md-4 col-sm-6">												
													<div class="block-show ">	
													<article class="sub-title"><h4 class="pull-left">Company <span class="fbold">Details</span></h4> </article>													
														<!--<span class="fbold">Industry Type: </span><input type="text" name="email" value="<?php echo $jrow['Indus_Name']; ?>" disabled>														
														<span class="fbold">YOR: </span><input type="text" name="name" value="<?php echo $jrow['YoR']; ?>" disabled>
														<span class="fbold">TOR: </span><input type="text" name="name" value="<?php echo $jrow['ToR']; ?>" disabled>
														<ul>
										
										<?php if(count($jrow['roc'])==0){?>
										<li> Roc</li>
										<?php }else { ?> 
										<a href="<?php echo $jrow['roc']; ?>" download target="_blank"><i class="fa fa-download" aria-hidden="true"></i> Roc</a></li><?php } ?>
										
                                       
										                           </ul>-->
													</div>
												</div>
												<div class="col-md-4 col-sm-6">
												
												 <div class="block-show ">	
												 <article class="sub-title"> <h4 class="pull-left"><span class="fbold"> Approved (Yes/No)</span></h4> </article>
												  		
														
														
														<select name="curl" onChange="comanyurl(this);" style="display:block"><option value="yes">yes</option><option value="no">no</option></select>
											<!--	<article class="sub-title"> <h4 class="pull-left">Contact<span class="fbold"> Person Details</span></h4> </article>
																 <span class="fbold">  Contact Name: </span><input type="text" name="name" value="<?php echo $jrow['contact_name']; ?>" disabled>														
														<span class="fbold">E-mail: </span><input type="text" name="email" value="<?php echo $jrow['emp_email']; ?>" disabled>
														<span class="fbold">Contact Number: </span><input type="text" name="website" value="<?php echo $jrow['contact_num']; ?>" disabled>
														
																<span class="fbold">   Contact person Designation: </span><input type="text" name="name" value="<?php echo $jrow['designation']; ?>" disabled>	
																   
												-->
												</div></div>
												<div class="col-md-4 col-sm-6">
												
												 <div class="block-show ">
												 <article class="sub-title"> <h4 class="pull-left">Add<span class="fbold"> Reason</span></h4> </article>
														 <div id="curl" style="display:none;">
																<label><input id="other-inputs" name="comurl"  placeholder="Add url description" ></input>
																</label>
																</div>
																<script>
																function comanyurl(elem) {																			
																	 if (elem.value == "no") {
																		document.getElementById("curl").style.display = 'block';
																	} else {
																		document.getElementById("curl").style.display = 'none';
																	}
																}
																function myindus(){															
																	document.getElementById("curl").style.color="blue";																	 

																}</script>												 
												 <!--<article class="sub-title"> <h4 class="pull-left">Company<span class="fbold"> Address</span></h4> </article>
												<span class="fbold"> Company Address: </span><input type="text" name="email" value="<?php echo $jrow['address1']; ?>" disabled>
												 <span class="fbold"> Location: </span><input type="text" name="email" value="<?php echo $jrow['Loc_Name']; ?>" disabled>
												 <span class="fbold">  State: </span><input type="text" name="email" value="<?php echo $jrow['states']; ?>" disabled>
												  <span class="fbold">  Country: </span><input type="text" name="email" value="<?php echo $jrow['Cntry_Name']; ?>" disabled>
													<span class="fbold">Pincode: </span><input type="text" name="email" value="<?php echo $jrow['pincode']; ?>" disabled>
													<form name="" method="post" action="changestatus.php">
									<label>Change Status</label>
									
										<select name="activeinactive"  class="form-control classic">	
										<option value="W" <?php if( $jrow['JuserStatus'] =='W') {echo "selected";}?>>W</option>										
										<option value="Y" <?php if($jrow['JuserStatus'] =='Y'){echo "selected";} ?>>Y</option>
										<option value="N" <?php if($jrow['JuserStatus'] =='N'){echo "selected";}?>>N</option>
										<option value="V" <?php if($jrow['JuserStatus'] =='V'){echo "selected";}?>>V</option>
										</select>							
										<input type="hidden" value="<?php echo $JUser_Id; ?>" name="empid">
										<input class="btn btn-blue-sm" type="submit" value="submit" name="statusc">		
								</form>-->
												 </div></div>
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
    

          
            <!--/ message popup-->
            <!-- schedule popup-->

			
			
			
			
            <!-- /schedule popup-->
</body>

</html>