<?php 
	session_start();
	require_once("../config.php");
	require_once '../class.user.php';
	$user_home = new USER();	 
	if(!isset($_SESSION['adminSession']))
	{
		$user_home->redirect('admin/admin.php');	   
	} 		
	$stmt = $user_home->runQuery("SELECT * FROM tbl_admin WHERE id=:eid");
	$stmt->execute(array(":eid"=>$_SESSION['adminSession']));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$JUser_Id=$_REQUEST['uid'];
	$profile_user_id = trim($JUser_Id);
	$visitor_user_id = trim($row['emp_id']);
	$cv1="select empid,userid from tbl_recent_views where userid='".$JUser_Id."' and empid='".$row['emp_id']."'";
	$resultv41 = mysqli_query($con,$cv1);
	$rowv41= mysqli_fetch_array($resultv41);
    if($rowv41['userid'] =="" && $rowv41['empid'] =="" && Action!="Viewed"){
	if($profile_user_id != $visitor_user_id){
	 $sql1 = "INSERT INTO tbl_recent_views (userid,empid,Activity,Action) VALUES ($profile_user_id, $visitor_user_id,'Profile is viewed ','Viewed')";
	 mysqli_query($con,$sql1);	
	  }
	}
    
 $jc1= "SELECT * FROM tbl_jobseeker WHERE JUser_Id='".$JUser_Id."'";
	$jresult1 = mysqli_query($con,$jc1);
	$jrow = mysqli_fetch_array($jresult1);
	$c1= "SELECT * FROM tbl_currentexperience WHERE JUser_Id=".$JUser_Id;
	$result1 = mysqli_query($con,$c1);
	$row1 = mysqli_fetch_array($result1);
	$c3="Select Loc_Id,Loc_Name from tbl_location where Loc_Id=".$jrow['JPLoc_Id'];
	$result3 = mysqli_query($con,$c3);
	$row3= mysqli_fetch_array($result3);
	$c4="Select Loc_Id,Loc_Name from tbl_location where Loc_Id=".$row1['Loc_Id'];
	$result4 = mysqli_query($con,$c4);
	$row4= mysqli_fetch_array($result4);
	$jc2= "SELECT Job_Name,Comp_Name FROM tbl_jobposted WHERE emp_id='".$row['emp_id']."'";
	$jresult2 = mysqli_query($con,$jc2);
	$jrow2 = mysqli_fetch_array($jresult2); 
	function dateDiff($start, $end) 
	{
	  $start_ts = strtotime($start);
	  $end_ts = strtotime($end);
	  $diff = $end_ts - $start_ts;
	  return round($diff / 86400);
	}
	$cv="select emp_id,JUser_Id from tbl_employerview where JUser_Id='".$JUser_Id."' and emp_id='".$row['emp_id']."'";
	$resultv4 = mysqli_query($con,$cv);
	$rowv4= mysqli_fetch_array($resultv4);
	$JUser_Id=$_REQUEST['uid'];
	$notification_id=$_REQUEST['noti_id'];
    if($row['id']!=4)
    {
	    $read_noti="UPDATE tbl_notifications SET notification_read=1 WHERE id='".$notification_id."' and mode='admin'";
	    mysqli_query($con,$read_noti);
    }
	if($row['id']!=4)
	{
		$change_aw="UPDATE tbl_jobseeker SET JuserStatus='AW' WHERE JUser_Id='".$JUser_Id."' and JuserStatus='Y'";
		mysqli_query($con,$change_aw);
	
		$change_ac="UPDATE tbl_user_admin_curationdts SET Aw_updt='NOW()' WHERE JUser_Id='".$JUser_Id."' ";
		mysqli_query($con,$change_ac);
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
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
	    box-shadow: 1px 2px 3px 1px #ddd inset !important;
		border:none !important;
}
.other-inputs{
	font-size:10px !important;
	    box-shadow: 1px 2px 3px 1px #ddd inset !important;
		border:none !important;
}
.alice{ background:#F0F8FF !important;
    border: 1px solid #fff;
}
.azure{
	background:	#F0FFFF !important;    border: 1px solid #fff;
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
.col-md-6 {
    width: 50%;
   <!-- border: 1px solid #ddd;-->
}
select{
background:none !important;
font-size:11px !important;
background:url(../img/arrow-new.png)no-repeat right center!important;
    box-shadow: 1px 2px 3px 1px #ddd inset !important;
	border:none !important;
}
.btn-blue-sm{font-size:10px !important;
}
fieldset {
border: #ddd 1px solid !important;
padding:15px !important;
}
legend{
	width:auto !important;
}

</style>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
    <!-- css includes-->
    <?php include "source.php" ?>	
	 <script type="text/javascript" src="../js/jquery.bootstrap-responsive-tabs.min.js"></script>
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
                        <li> <a href="admin.php">HOME</a> </li>
                        <li> <a href="profiles-latest.php">LATEST PROFILES</a></li>
                        <li> <a><?php echo $jrow['JFullName']; ?></a> </li>
                    </ul>
                </div>
                <!--/ brudcrumb -->
                <!-- recruiter view main -->
                <section class="rec-viewmain">
                    <!-- recruiter view header -->
                    <div class="rec-view-header">
                        <div class="container">
                            <!-- row-->
                            <div class="">
                               <div class="row">
                                   <div class="col-md-12">
                                        <!--<div class="col-md-2 col-sm-3 detail-imgnew">
                                    <figure class="recview-img"> <img class="img-cover" data-object-fit="cover" src="<?php if($jrow['JPhoto']){ echo $jrow['JPhoto']; }else{ ?> img/js-profile-list-pic.jpg <?php }?>"> </figure>
                                </div>-->
                                <div class="col-md-10 col-sm-10 details-js-view">
                                    <div class="recview-basic-details">
                                        <article class="name-view">
                                            <h3 class="txt-white"><?php echo $jrow['JFullName']; ?></h3>
                                            <h5 class="txt-white"><?php echo $row1['Des']; ?> at <?php echo $row1['Company_Name']; ?></h5> </article>
                                    </div>
                                    <div class="row rowcan">
                                        <div class="col-md-2 col-sm-4">
                                            <div class="features-main-candidate">
                                                <p>Current Location</p> <span>
												<?php 
													if($jrow['nri_status']=='Y')
													{
														$cnt= "SELECT * FROM  tbl_country  WHERE Cntry_Id=".$row1['Loc_Id'];
														$cnt_res = mysqli_query($con,$cnt);
														$cnt_data = mysqli_fetch_array($cnt_res);
														$cloc_name=$cnt_data['Cntry_Name'];
													} else
													{
														$cloc_name=$row4['Loc_Name'];
													}
													echo $cloc_name;
												?></span>
											</div>
                                        </div>
                                        <div class="col-md-2 col-sm-4">
                                            <div class="features-main-candidate">
                                                <p>Preferred Location</p> <span><?php echo $row3['Loc_Name'] ?></span> </div>
                                        </div>
                                        <div class="col-md-2 col-sm-4">
                                            <div class="features-main-candidate">
                                                <p>Experience</p> <span><?php echo $jrow['JTotalEy']; ?> Years - <?php echo $jrow['JTotalEm']; ?> Months</span> </div>
                                        </div>
                                        <div class="col-md-2 col-sm-4">
                                            <div class="features-main-candidate">
                                                <p>Exp CTC (Lacs)</p>
												<span>
												Min: <?php echo $row1['ExpSalL'];  ?> - Max: <?php echo $row1['ExpMaxSalL']; ?> 
												</span> 
											</div>
                                        </div>
                                        <div class="col-md-2 col-sm-4">
                                            <div class="features-main-candidate">
                                                <p>Notice Period</p> <span><?php // echo $row1['NoticePeriod']; ?><?php if($row1['NoticePeriod']=='1'){echo "Immediate";}else {echo $row1['NoticePeriod']." days"; }?>  </span> </div>
                                        </div>
                                         
                                    </div>
                                     <div class="row rowcan">
                                        <div class="col-md-12">
                                             <article class="details-contact">
                                        <p><span><i class="fa fa-phone" aria-hidden="true"></i> +91 - <?php echo $jrow['JPhone']; ?></span><span><i class="fa fa-envelope-o" aria-hidden="true"></i>
										<?php echo $jrow['JEmail']; ?></span> 
										<!--<span>
											<?php 
											$from=date('Y-m-d');
											$to=$jrow['currentdate'];
											echo dateDiff($to,$from).'days';
											?>
										</span> -->
										</p>
                                    </article>
                                      
                                        </div>
                                     </div>
                                      
                                    <div class="row">
                                             <div class="options-rec">
                                        <ul>
										
										<?php if($row1['PaySlip']==''){ ?>
										
										<?php }else { ?> 
										<li><a href="<?php echo "https://needyin.com/".$row1['PaySlip']; ?>" download target="_blank"><i class="fa fa-download" aria-hidden="true"></i> Payslip</a></li><?php } ?>
										
                                        <li><a href="<?php if($row1['UpdateCV']){ echo "view-profile.php?JUser_Id=".$JUser_Id;}else { ?> ./img/profile-ic.png <?php } ?>"><i class="fa fa-list-alt" aria-hidden="true"></i> Resume Preview</a></li> 
										                           </ul>
                                    </div>
                                        </div>
                                   
                                </div>
                                 
                                   </div>
                                    
                               </div>
                               
                                
                            </div>
                            <!-- / row -->
                        </div>
                    </div>
                    <!-- /recruiter view -->
                    <!-- recruiter view tab-->
                    <!-- job seekar body -->
                    <section class="job-seekar-body">
					
                        <div class="js-profile-nav recview">
						
                            <!-- job seekear profile navigation -->
                            <div class="container">
							<?php if(($jrow['JuserStatus'] =='N') ||($jrow['JuserStatus'] =='V') ||($jrow['JuserStatus'] =='A') ) {?>
								<button style="height:40px !important;" type="button" class="btn btn-info btn-sm" data-toggle="modal" disabled>Verify Details</button>
							<?php } else {?>
							<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Verify Details</button>
							<?php }?>
								
								<span style="float:right;font-size:12px !important;background:#ddd;padding:5px">Current Status:<?php if($jrow['JuserStatus'] =='AW'){ echo "Awaited Process";}else if($jrow['JuserStatus'] =='Y'){ echo "100% Complete";}else if($jrow['JuserStatus'] =='N'){ echo "No Validation";}else if($jrow['JuserStatus'] =='V'){ echo "Validation";}else if($jrow['JuserStatus'] =='A'){ echo "Approved";} else if($jrow['JuserStatus'] =='R'){ echo "Rejected";}else if($jrow['JuserStatus'] =='SQ'){ echo "Sent To Query";}else if($jrow['JuserStatus'] =='IP'){ echo "In Process";}else { echo "Query Updated";}?></span>
								<!-- Modal -->
								<div id="myModal" class="modal fade" role="dialog" >
								  <div class="modal-dialog">

									<!-- Modal content-->
									<div class="modal-content">
									  <div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>										
									 </div>
									  <div class="modal-body">
										<div class="container-fluid">
   <div class="col-md-12" >
	  <?php 
	//exploding data from the tbll_emplyer  for admin status
	 $cnamea=explode("#",$jrow['adm_status']);
	 // SPLITING DATA INTO ARRAY
	$output1 = preg_split( "/(^|@|#)/", $cnamea[0]);//uname
	
	$output2 = preg_split( "/(^|@|#)/", $cnamea[1]);//uphone
	$output3 = preg_split( "/(^|@|#)/", $cnamea[2]);//uexp
	$output4 = preg_split( "/(^|@|#)/", $cnamea[3]);//udob
	$output5 = preg_split( "/(^|@|#)/", $cnamea[4]);//ugen
	$output6 = preg_split( "/(^|@|#)/", $cnamea[5]);//ucsal
	$output7 = preg_split( "/(^|@|#)/", $cnamea[6]);//udoj
	$output8 = preg_split( "/(^|@|#)/", $cnamea[7]);//upayslip
	$output9 = preg_split( "/(^|@|#)/", $cnamea[8]);//updatedcv
	$output10 = preg_split( "/(^|@|#)/", $cnamea[9]);//uemail
	$output11 = preg_split( "/(^|@|#)/", $cnamea[10]);//reattach
	$output12 = preg_split( "/(^|@|#)/", $cnamea[11]);//ploc
	$output13 = preg_split( "/(^|@|#)/", $cnamea[12]);//cauth
	$output14 = preg_split( "/(^|@|#)/", $cnamea[13]);//fname
	$output15 = preg_split( "/(^|@|#)/", $cnamea[14]);//psum
	$output16 = preg_split( "/(^|@|#)/", $cnamea[15]);//rtype
	$output17 = preg_split("/(^|@|#)/", $cnamea[16]);//comname
	$output18 = preg_split( "/(^|@|#)/", $cnamea[17]);//comname

	?>
	 <fieldset>
  <legend><h2>Change Status</h2></legend>
   <form method="post" action="empadmin.php">
  
   <div class="col-md-6" >
	
      <div class="row alice">
        <div class="col-md-4" ><span class="fbold">User Name:</span> <input style="font-size:12px" type="text" name="uname" value="<?php echo $jrow['JFullName']; ?>" disabled>	</div>
        <div class="col-md-4" >	<span class="fbold">Status:</span> <select name="unameapp" id="unameapp"  style="display:block">
		<option value="0">select</option>
		<option value="yes" <?php if ($output1[1]=='uname^yes'){ echo 'selected';} ?>>Approved</option>
		<option value="no" <?php if ($output1[1]=='uname^no'){ echo 'selected';} ?>>Not Approved</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span> 
		 <div id="company" >
			<label><input  class="other-inputs" id="unamere" name="unamere"  placeholder="Add Reason" value="<?php echo $output1[2];?>"></input>
			</label>
		</div>
		
								</div>
      </div>
	   <div class="row azure">
        <div class="col-md-4" ><span class="fbold">User Gender:</span> <input style="font-size:12px" type="text" name="ugen" value="<?php echo $jrow['Gender'] ?>" disabled>	</div>
        <div class="col-md-4" >	<span class="fbold">Status:</span> <select name="ugenapp" id="ugenapp"  style="display:block">
		<option value="0">select</option>
		<option value="yes" <?php if ($output5[1]=='ugen^yes'){ echo 'selected';} ?>>Approved</option>
		<option value="no" <?php if ($output5[1]=='ugen^no'){ echo 'selected';} ?>>Not Approved</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span> 
		 <div id="company" >
			<label><input class="other-inputs" id="ugenre" name="ugenre"  placeholder="Add Reason" value="<?php echo $output5[2];?>"></input>
			</label>
		</div>
		
								</div>
      </div>
	  	  <div class="row alice" >
        <div class="col-md-4" ><span class="fbold">User DOB:</span> <input style="font-size:12px" type="text" name="udob" id="udob" value="<?php echo $jrow['DoB'] ?>" disabled>	</div>
        <div class="col-md-4" >	<span class="fbold">Status:</span> <select name="udobapp" id="udobapp"  style="display:block">
		<option value="0">select</option>
		<option value="yes" <?php if ($output4[1]=='udob^yes'){ echo 'selected';} ?>>Approved</option>
		<option value="no" <?php if ($output4[1]=='udob^no'){ echo 'selected';} ?>>Not Approved</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span> 
		 <div id="company" >
			<label><input class="other-inputs" id="udobre" name="udobre"  placeholder="Add Reason" value="<?php echo $output4[2];?>"></input>
			</label>
		</div>
		
								</div>
      </div>
	    <div class="row azure">
        <div class="col-md-4" ><span class="fbold">User Email:</span> <input type="text" name="email" value="<?php echo $jrow['JEmail']; ?>" disabled>	</div>
        <div class="col-md-4" >	<span class="fbold">Status:</span> <select name="uemailapp" id="uemailapp"  style="display:block">
		<option value="0">select</option>
		<option value="yes" <?php if ($output10[1]=='uemail^yes'){ echo 'selected';} ?>>Approved</option>
		<option value="no" <?php if ($output10[1]=='uemail^no'){ echo 'selected';} ?>>Not Approved</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span> 
		 <div id="company" >
			<label><input class="other-inputs" id="uemailre" name="uemailre"  placeholder="Add Reason" value="<?php echo $output10[2];?>"></input>
			</label>
		</div>
		
								</div>
      </div>
	  
	   <div class="row alice">
        <div class="col-md-4" ><span class="fbold">User Phone:</span> <input style="font-size:12px" type="text" name="uphone" value="<?php echo $jrow['JPhone']; ?>" disabled>	</div>
        <div class="col-md-4" >	<span class="fbold">Status:</span> <select name="uphoneapp" id="uphoneapp"  style="display:block">
		<!--<option value="0">select</option>-->
		<option value="yes" selected >Approved</option>
		<option value="no" disabled>Not Approved</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span> 
		 <div id="company" >
			<label><input class="other-inputs" id="uphonere" name="uphonere"  placeholder="Add Reason" value="<?php echo $output2[2];?>"></input>
			</label>
		</div>
		
								</div>
      </div>
	  
 <div class="row azure">
        <div class="col-md-4" ><span class="fbold">Profile Summary:</span> <p id="other-inputs" style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;"> <?php echo $jrow['profile_summary']; ?>" </p>	</div>
        <div class="col-md-4" >	<span class="fbold">Status:</span> <select id="psumapp" name="psumapp"  style="display:block">
		<option value="0">select</option>
		<option value="yes" <?php if ($output14[1]=='psum^yes'){ echo 'selected';} ?>>Approved</option>
		<option value="no" <?php if ($output14[1]=='psum^no'){ echo 'selected';} ?>>Not Approved</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span>
		 <div id="company" >
			<label><input class="other-inputs" id="psumre" name="psumre"  placeholder="Add Reason" value="<?php echo $output14[2];?>"></input>
			</label>
		</div>
		
								</div>
      </div>
									
	   <div class="row alice">
        <div class="col-md-4" ><span class="fbold">Pref Location:</span> <input type="text" name="ploca" value="<?php echo $row3['Loc_Name']; ?>" disabled>	</div>
        <div class="col-md-4" >	<span class="fbold">Status:</span> <select id="plocapp" name="plocapp"  style="display:block">
		<option value="0">select</option>
		<option value="yes" <?php if ($output11[1]=='ploc^yes'){ echo 'selected';} ?>>Approved</option>
		<option value="no" <?php if ($output11[1]=='ploc^no'){ echo 'selected';} ?>>Not Approved</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span> 
		 <div id="company" >
			<label><input class="other-inputs" id="plocre" name="plocre"  placeholder="Add Reason" value="<?php echo $output11[2];?>"></input>
			</label>
		</div>
		
								</div>
      </div>
	   
	  
	  
	  
	   <div class="row azure">
        <div class="col-md-4" ><span class="fbold">UpdateCV:</span> <a href="https://www.needyin.com/<?php echo $row1['UpdateCV'] ?>" download> download</a>	</div>
        <div class="col-md-4" >	<span class="fbold">Status:</span> <select id="updatecvapp" name="updatecvapp"  style="display:block">
		<option value="0">select</option>
		<option value="yes" <?php if ($output9[1]=='updatedcv^yes'){ echo 'selected';} ?>>Approved</option>
		<option value="no" <?php if ($output9[1]=='updatedcv^no'){ echo 'selected';} ?>>Not Approved</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span> 
		 <div id="company" >
			<label><input class="other-inputs" id="updatecvre" name="updatecvre"  placeholder="Add Reason" value="<?php echo $output9[2];?>"></input>
			</label>
		</div>
		
								</div>
      </div>
	   
	   <div class="row alice">
        <div class="col-md-4" ><span class="fbold">Reason Summary:</span> <input type="text" name="rsum" value="<?php echo $jrow['jReasonSummary']; ?>" disabled>	</div>
        <div class="col-md-4" >	<span class="fbold">Status:</span> <select id="rsumapp" name="rsumapp"  style="display:block">
		<option value="0">select</option>
		<option value="yes" <?php if ($output16[1]=='rsum^yes'){ echo 'selected';} ?>>Approved</option>
		<option value="no" <?php if ($output16[1]=='rsum^no'){ echo 'selected';} ?>>Not Approved</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span>
		 <div id="company" >
			<label><input class="other-inputs" id="rsumre" name="rsumre"  placeholder="Add Reason" value="<?php echo $output16[2];?>"></input>
			</label>
		</div>
		
								</div>
      </div>
	  </div>
	  <div class="col-md-6" >
	  <div class="row azure">
        <div class="col-md-4" ><span class="fbold">Company Name:</span> <input type="text" id="comname" name="comname" value="<?php echo $row1['Company_Name']; ?>" disabled>	</div>
        <div class="col-md-4" >	<span class="fbold">Status:</span> <select id="comnameapp" name="comnameapp"  style="display:block">
		<option value="0">select</option>
		<option value="yes" <?php if ($output18[1]=='comname^yes'){ echo 'selected';} ?>>Approved</option>
		<option value="no" <?php if ($output18[1]=='comname^no'){ echo 'selected';} ?>>Not Approved</option></select></div>
		<div class="col-md-4" > <span class="fbold">Write Reason:</span> 
		 <div id="company" >
			<label><input class="other-inputs" id="comnamere" name="comnamere" placeholder="Add Reason" value="<?php echo $output18[2];?>"></input>
			</label>
		</div>
		</div>
      </div>
	   <div class="row alice">
        <div class="col-md-4"><span class="fbold">Date of Join:</span> <input type="text" name="udoj" value="<?php echo $row1['doJ']; ?>" disabled>	</div>
        <div class="col-md-4">	<span class="fbold">Status:</span> <select id="udojapp" name="udojapp"  style="display:block">
		<option value="0">select</option>
		<option value="yes" <?php if ($output7[1]=='udoj^yes'){ echo 'selected';} ?>>Approved</option>
		<option value="no" <?php if ($output7[1]=='udoj^no'){ echo 'selected';} ?>>Not Approved</option></select></div>
		<div class="col-md-4"> <span class="fbold">Write Reason:</span> 
			<div id="company">
			<label><input class="other-inputs" id="udojre" name="udojre"  placeholder="Add Reason" value="<?php echo $output7[2];?>"></input></label>
			</div>
		</div>
      </div>
	  	<?php 
	 $fa= "SELECT * FROM tbl_functionalarea WHERE Func_Id=".$jrow['Func_Id'];
	$resultfa = mysqli_query($con,$fa);
	$rowfa = mysqli_fetch_array($resultfa);
	 ?>
	 <div class="row azure">
        <div class="col-md-4" ><span class="fbold">Functional Area:</span> <input type="text" name="fname" value="<?php echo $rowfa['Func_Name']; ?>" disabled>	</div>
        <div class="col-md-4" >	<span class="fbold">Status:</span> <select id="fnameapp" name="fnameapp"  style="display:block">
		<option value="0">select</option>
		<option value="yes" <?php if ($output13[1]=='fname^yes'){ echo 'selected';} ?>>Approved</option>
		<option value="no" <?php if ($output13[1]=='fname^no'){ echo 'selected';} ?>>Not Approved</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span> 
		 <div id="company" >
			<label><input class="other-inputs" id="fnamere" name="fnamere"  placeholder="Add Reason" value="<?php echo $output13[2];?>"></input>
			</label>
		</div>
		
								</div>
      </div>
	
	  
	   <div class="row alice">
        <div class="col-md-4" ><span class="fbold">User Exp:</span> <input style="font-size:12px" type="text" name="uexp" value="<?php echo $jrow['JTotalEy'].'.'.$jrow['JTotalEm']; ?>" disabled>	</div>
        <div class="col-md-4" >	<span class="fbold">Status:</span> <select id="uexpapp" name="uexpapp"  style="display:block">
		<option value="0">select</option>
		<option value="yes" <?php if ($output3[1]=='uexp^yes'){ echo 'selected';} ?>>Approved</option>
		<option value="no" <?php if ($output3[1]=='uexp^no'){ echo 'selected';} ?>>Not Approved</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span> 
		 <div id="company" >
			<label><input class="other-inputs" id="uexpre" name="uexpre"  placeholder="Add Reason" value="<?php echo $output3[2];?>"></input>
			</label>
		</div>
		
								</div>
      </div>
	   <div class="row azure">
        <div class="col-md-4" ><span class="fbold">Expected Sal:</span> <input type="text" name="ucsal" value="<?php echo $row1['ExpSalL'].'-'.$row1['ExpMaxSalL']; ?>" disabled>	</div>
        <div class="col-md-4" >	<span class="fbold">Status:</span> <select id="ucsalapp" name="ucsalapp"  style="display:block">
		<option value="0">select</option>
		<option value="yes" <?php if ($output6[1]=='ucsal^yes'){ echo 'selected';} ?>>Approved</option>
		<option value="no" <?php if ($output6[1]=='ucsal^no'){ echo 'selected';} ?>>Not Approved</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span>
		 <div id="company" >
			<label><input class="other-inputs" id="ucsalre" name="ucsalre"  placeholder="Add Reason" value="<?php echo $output6[2];?>"></input>
			</label>
		</div>
		
								</div>
      </div>
	   <div class="row alice">
        <div class="col-md-4" ><span class="fbold">PaySlip:</span> <a href="https://www.needyin.com/<?php echo $row1['PaySlip'] ?>" download> download</a>	</div>
        <div class="col-md-4" >	<span class="fbold">Status:</span> <select id="payslipapp" name="payslipapp"  style="display:block">
		<option value="0">select</option>
		<option value="yes" <?php if ($output8[1]=='upayslip^yes'){ echo 'selected';} ?>>Approved</option>
		<option value="no" <?php if ($output8[1]=='upayslip^no'){ echo 'selected';} ?>>Not Approved</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span>
		 <div id="company" >
			<label><input class="other-inputs" id="payslipre" name="payslipre"  placeholder="Add Reason" value="<?php echo $output8[2];?>"></input>
			</label>
		</div>
		
								</div>
      </div>
	  
	    <div class="row azure">
        <div class="col-md-4" ><span class="fbold">Country Authorised:</span> <input type="text" name="caut" value="<?php echo $jrow['JCauthorised']; ?>" disabled>	</div>
        <div class="col-md-4" >	<span class="fbold">Status:</span> <select id="cautapp" name="cautapp"  style="display:block">
		<option value="0">select</option>
		<option value="yes" <?php if ($output12[1]=='cauth^yes'){ echo 'selected';} ?>>Approved</option>
		<option value="no" <?php if ($output12[1]=='cauth^no'){ echo 'selected';} ?>>Not Approved</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span>
		 <div id="company">
			<label><input class="other-inputs" id="cautre" name="cautre"  placeholder="Add Reason" value="<?php echo $output12[2];?>"></input>
			</label>
		</div>
		
								</div>
      </div>
	    
	  
	   <div class="row alice">
        <div class="col-md-4" ><span class="fbold">Reason Type:</span> <input type="text" name="rtype" value="<?php echo $jrow['jReasonType']; ?>" disabled>	</div>
        <div class="col-md-4" >	<span class="fbold">Status:</span> <select id="rtypeapp" name="rtypeapp"  style="display:block">
		<option value="0">select</option>
		<option value="yes" <?php if ($output15[1]=='rtype^yes'){ echo 'selected';} ?>>Approved</option>
		<option value="no" <?php if ($output15[1]=='rtype^no'){ echo 'selected';} ?>>Not Approved</option></select></div>
		<div class="col-md-4" > <span class="fbold">Write Reason:</span>
			<div id="company" >
				<label><input class="other-inputs" id="rtypere" name="rtypere"  placeholder="Add Reason" value="<?php echo $output15[2];?>"></input></label>
			</div>
		</div>
      </div>
	  
	    <div class="row azure">
        <div class="col-md-4" ><span class="fbold">Reason attachment:</span><?php if($row['JReasonAttach']!=''){ ?> <a href="https://www.needyin.com/<?php echo $row1['JReasonAttach'] ?>" download> download</a>	<?php } ?></div>
        <div class="col-md-4" >	<span class="fbold">Status:</span> <select id="reasonattapp" name="reasonattapp"  style="display:block">
		<option value="0">select</option>
		<option value="yes" <?php if ($output17[1]=='reattach^yes'){ echo 'selected';} ?>> Approved</option>
		<option value="no" <?php if ($output17[1]=='reattach^no'){ echo 'selected';} ?>>Not Approved</option></select></div>
		 <div class="col-md-4" > <span class="fbold">Write Reason:</span> 
		 <div id="company" >
			<label><input class="other-inputs" id="reasonattre" name="reasonattre"  placeholder="Add Reason" value="<?php echo $output17[2];?>"></input>
			</label>
		</div>
		
								</div>
      </div>
	   <input type="hidden" value="<?php echo $JUser_Id; ?>" name="juserid">
		
		<?php  if($row['id']!=4) {  ?>
			
	  <input class="btn btn-blue-sm" type="submit" value="Save & Close" name="jseekerapprovals" onclick="return validate()">
	  <input class="btn btn-blue-sm" type="submit" value="Save & Submit" name="jseekerapprovals" onclick="return validate()">
		<?php } ?>
	  </div>
	 
	  </form>
	   </fieldset>
 
	  </div>
	  </div>
									  </div>
									  
									</div>

								  </div>
								</div>
<?php if($row['id']!=4) { ?>
								<div class="row">
								<div  class="col-md-12 " style="margin-top:10px;">
								 <fieldset>
  <legend><h2>Change Jobseeker Status</h2></legend>
								
								<form name="" method="post" action="changestatus.php">
									<div  class="col-md-6" style="margin-top:10px;">
									<label style="margin-bottom:10px;">Change Status</label>
									<select name="activeinactive"  class="form-control classic">	
									
									<?php 	
echo $jrow['JuserStatus'];									
								if (($output1[1]=='uname^yes')&&($output2[1]=='uphone^yes')&&($output3[1]=='uexp^yes')&&($output4[1]=='udob^yes') &&($output5[1]=='ugen^yes') &&($output6[1]=='ucsal^yes')&&($output7[1]=='udoj^yes')&&($output8[1]=='upayslip^yes')&&($output9[1]=='updatedcv^yes')&&($output10[1]=='uemail^yes')&&($output11[1]=='ploc^yes')&&($output12[1]=='cauth^yes')&&($output13[1]=='fname^yes')&&($output14[1]=='psum^yes')&&($output15[1]=='rtype^yes')&&($output16[1]=='rsum^yes')&&($output17[1]=='reattach^yes')&&($output18[1]=='comname^yes')&&(($jrow['JuserStatus'] =='AW')||($jrow['JuserStatus'] =='SQ') ||($jrow['JuserStatus'] =='IP'))) { ?>
										<!--  <option value="AW" <?php if($jrow['JuserStatus'] =='AW'){echo "selected";}?>>Awaited Pocess</option>
										   <option value="IP" <?php if($jrow['JuserStatus'] =='IP'){echo "selected";}?>>In Process</option> -->
										 <option value="" >Select Change Status</option>
										 <option value="A" <?php if($jrow['JuserStatus'] =='A'){echo "selected";}?>>Approved</option>								 
<option value="R" <?php if($jrow['JuserStatus'] =='R'){echo "selected";}?>>Rejected</option>										  
<?php }else {?>										 
										<!--   <option value="AW" <?php if($jrow['JuserStatus'] =='AW'){echo "selected";}?> disabled>Awaited Pocess</option>
											<option value="IP" <?php if($jrow['JuserStatus'] =='IP'){echo "selected";}?>>In Process</option> -->
										<option value="" >Select Change Status</option>
<option value="SQ" <?php if($jrow['JuserStatus'] =='SQ'){echo "selected";}?>>Sent to Query</option>											
										  <option value="A" <?php if($jrow['JuserStatus'] =='A'){echo "selected";}?> disabled>Approved</option>
										  
										  <option value="R" <?php if($jrow['JuserStatus'] =='A'){echo "disabled";}?>  else if($jrow['JuserStatus'] =='R'){echo "selected";}?> Rejected</option>
<?php } ?>	
									</select>
									</div>
									<div  class="col-md-6" >
									<input type="hidden" value="<?php echo $JUser_Id; ?>" name="juserids">
									<?php if(($jrow['JuserStatus'] =='N') ||($jrow['JuserStatus'] =='V') ||($jrow['JuserStatus'] =='AW') ||($jrow['JuserStatus'] =='Y') ||($jrow['JuserStatus'] =='A' || $row['id']==4)) {?>
									<input class="btn btn-blue-sm" type="submit" value="Save & Submit" disabled>
									<?php }else { ?>
									<input class="btn btn-blue-sm" type="submit" value="Save & Submit" name="statusc" >
									<?php } ?>
									</div>
									
								</form>
								
								 </fieldset>
								</div>
								</div>
<?php } ?>
                                <ul class="nav nav-tabs responsive-tabs nav-profile">
                                    <li class="active"><a href="#geninfo"><i class="fa fa-user-o" aria-hidden="true"></i> General Information</a></li>
                                    <li><a href="#education"><i class="fa fa-book" aria-hidden="true"></i> Education</a></li>
                                    <li><a href="#proexp"><i class="fa fa-black-tie" aria-hidden="true"></i> Professional Experience</a></li>
                                    <li><a href="#skills"><i class="fa fa-cog" aria-hidden="true"></i> Skills</a></li>
									 <li><a href="#reasons"><i class="fa fa-map-marker" aria-hidden="true"></i> Reasons to Relocate</a></li>
                                </ul>
                                <!-- profile discription content -->
                                <div class="tab-content profile-body-content">
                                    <div class="tab-pane active" id="geninfo">
                                        <div class="tabjsinfo-content">
                                            <?php include '../general-info-js-rec-view1.php'; ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="education">
                                        <div class="tabjsinfo-content">
                                            <?php include '../education-info-js-rec-view1.php' ;?>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="proexp">
                                        <div class="tabjsinfo-content">
                                            <?php include '../prof-exp-js-rec-view1.php' ;?>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="skills">
                                        <div class="tabjsinfo-content">
                                            <?php include 'skills-info-js-rec-view1.php' ;?>
                                        </div>
                                    </div>
									<div class="tab-pane" id="reasons">
                                        <div class="tabjsinfo-content">
                                           <?php include 'reasons-view-js-rec-view1.php'; ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- /profile discription content -->
                            </div>
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
        <!--/main-->
   
       
            <!--/footer-->
            <script>
                $('.responsive-tabs').responsiveTabs({
                    accordionOn: ['xs', 'sm']
                });
				function addClass(obj) {
					obj.className ? obj.className = "" : obj.className = "checked";
				}
           
			function validate()
			{
				
				var unameapp=document.getElementById('unameapp').value;
				var unameres=document.getElementById('unamere').value;
            	if(((unameapp =="yes")||(unameapp=="no"))&&(unameres == ""))				
            	{
					if(unameapp =="yes"){
						document.getElementById('unamere').value="ok";
					}else 
					{
            		alert("Please Write Reason for  User Name");
            		document.getElementById('unamere').focus();
            		return false;
					}
            	}			
				
				var ugenapp=document.getElementById('ugenapp').value;				
				var ugenres=document.getElementById('ugenre').value;
            	if(((ugenapp =="yes")||(ugenapp=="no"))&&(ugenres == ""))			
            	{
            		if(ugenapp =="yes"){
						document.getElementById('ugenre').value="ok";
					}else 
					{
						alert("Please Write Reason for Gender ");
            		document.getElementById('ugenre').focus();
            		return false;
					}
            	}
				
				var udobapp=document.getElementById('udobapp').value;
				var udobres=document.getElementById('udobre').value;
            	if(((udobapp =="yes")||(udobapp=="no"))&&(udobres == ""))					
            	{
					if(udobapp =="yes"){
						document.getElementById('udobre').value="ok";
					}else 
					{
					
            		alert("Please Write Reason for Dob");
            		document.getElementById('udobre').focus();
            		return false;
					}
            	}
				var uemailapp=document.getElementById('uemailapp').value;
				var uemailres=document.getElementById('uemailre').value;
            	if(((uemailapp =="yes")||(uemailapp=="no"))&&(uemailres == ""))	
            	{
					if(uemailapp =="yes"){
						document.getElementById('uemailre').value="ok";
					}else 
					{
            		alert("Please Write Reason for Email");
            		document.getElementById('uemailre').focus();
            		return false;
					}
            	}
				var uphoneapp=document.getElementById('uphoneapp').value;
				var uphoneres=document.getElementById('uphonere').value;
            	if(((uphoneapp =="yes")||(uphoneapp=="no"))&&(uphoneres == ""))	
            	{
					if(uphoneapp =="yes"){
						document.getElementById('uphonere').value="ok";
					}else 
					{
            		alert("Please Write Reason for phone");
            		document.getElementById('uphonere').focus();
            		return false;
					}
            	}
				var psumapp=document.getElementById('psumapp').value;
				var psumres=document.getElementById('psumre').value;
            	if(((psumapp =="yes")||(psumapp=="no"))&&(psumres == ""))	
            	{
					if(psumapp =="yes"){
						document.getElementById('psumre').value="ok";
					}else 
					{
            		alert("Please Write Reason for profile summary");
            		document.getElementById('psumre').focus();
            		return false;
					}
            	}
				
				var plocapp=document.getElementById('plocapp').value;
				var plocres=document.getElementById('plocre').value;
            	if(((plocapp =="yes")||(plocapp=="no"))&&(plocres == ""))
            	{
					if(plocapp =="yes"){
						document.getElementById('plocre').value="ok";
					}else 
					{
            		alert("Please Write Reason for preferred Location");
            		document.getElementById('plocre').focus();
            		return false;
					}
            	}
				var updatecvapp=document.getElementById('updatecvapp').value;
				var updatecvres=document.getElementById('updatecvre').value;
            	if(((updatecvapp =="yes")||(updatecvapp=="no"))&&(updatecvres == ""))
            	{
					if(updatecvapp =="yes"){
						document.getElementById('updatecvre').value="ok";
					}else 
					{
            		alert("Please Write Reason for CV");
            		document.getElementById('updatecvre').focus();
            		return false;
					}
            	}
				var comnameapp=document.getElementById('comnameapp').value;
				var comnameres=document.getElementById('comnamere').value;
            	if(((comnameapp =="yes")||(comnameapp=="no"))&&(comnameres == ""))
            	{
					if(comnameapp =="yes"){
						document.getElementById('comnamere').value="ok";
					}else 
					{
            		alert("Please Write Reason for Company Name");
            		document.getElementById('comnamere').focus();
            		return false;
					}
            	}
				var udojapp=document.getElementById('udojapp').value;
				var udojres=document.getElementById('udojre').value;
            	if(((udojapp =="yes")||(udojapp=="no"))&&(udojres == ""))
            	{
					if(udojapp =="yes"){
						document.getElementById('udojre').value="ok";
					}else 
					{
            		alert("Please Write Reason for DOJ");
            		document.getElementById('udojre').focus();
            		return false;
					}
            	}
				
				
				var fnameapp=document.getElementById('fnameapp').value;
				var fnameres=document.getElementById('fnamere').value;
            	if(((fnameapp =="yes")||(fnameapp=="no"))&&(fnameres == ""))
            	{
					if(fnameapp =="yes"){
						document.getElementById('fnamere').value="ok";
					}else 
					{
            		alert("Please Write Reason for Functional Area");
            		document.getElementById('fnamere').focus();
            		return false;
					}
            	}
				var uexpapp=document.getElementById('uexpapp').value;
				var uexpres=document.getElementById('uexpre').value;
            	if(((uexpapp =="yes")||(uexpapp=="no"))&&(uexpres == ""))
            	{
					if(uexpapp =="yes"){
						document.getElementById('uexpre').value="ok";
					}else 
					{
            		alert("Please Write Reason for Experience");
            		document.getElementById('uexpre').focus();
            		return false;
					}
            	}
				var ucsalapp=document.getElementById('ucsalapp').value;
				var ucsalres=document.getElementById('ucsalre').value;
            	if(((ucsalapp =="yes")||(ucsalapp=="no"))&&(ucsalres == ""))
            	{
					if(ucsalapp =="yes"){
						document.getElementById('ucsalre').value="ok";
					}else 
					{
            		alert("Please Write Reason for Exp Sal");
            		document.getElementById('ucsalre').focus();
            		return false;
					}
            	}
			
				var payslipapp=document.getElementById('payslipapp').value;
				var payslipres=document.getElementById('payslipre').value;
            	if(((payslipapp =="yes")||(payslipapp=="no"))&&(payslipres == ""))
            	{
					if(payslipapp =="yes"){
						document.getElementById('payslipre').value="ok";
					}else 
					{
            		alert("Please Write Reason for Payslip");
            		document.getElementById('payslipre').focus();
            		return false;
					}
            	}
					var cautapp=document.getElementById('cautapp').value;
				var cautres=document.getElementById('cautre').value;
            	if(((cautapp =="yes")||(cautapp=="no"))&&(cautres == ""))
            	{
            		if(cautapp =="yes"){
						document.getElementById('cautre').value="ok";
					}else 
					{
					alert("Please Write Reason for Country authorised");
            		document.getElementById('cautre').focus();
            		return false;
					}
            	}
			/*	var cautapp=document.getElementById('cautapp').value;
				var cautres=document.getElementById('cautre').value;
            	if(((cautapp =="yes")||(cautapp=="no"))&&(cautres == ""))
            	{
            		if(cautapp =="yes"){
						document.getElementById('cautre').value="ok";
					}else 
					{
					alert("Please Write Reason for Country authorised");
            		document.getElementById('cautre').focus();
            		return false;
					}
            	}*/
				var rtypeapp=document.getElementById('rtypeapp').value;
				var rtyperes=document.getElementById('rtypere').value;
            	if(((rtypeapp =="yes")||(rtypeapp=="no"))&&(rtyperes == ""))
            	{
					if(rtypeapp =="yes"){
						document.getElementById('rtypere').value="ok";
					}else 
					{
            		alert("Please Write Reason for Reason Type");
            		document.getElementById('rtypere').focus();
            		return false;
					}
            	}
				var rsumapp=document.getElementById('rsumapp').value;
				var rsumres=document.getElementById('rsumre').value;
            	if(((rsumapp =="yes")||(rsumapp=="no"))&&(rsumres == ""))
            	{
            		if(rsumapp =="yes"){
						document.getElementById('rsumre').value="ok";
					}else 
					{
					alert("Please Write Reason for Reason Summary");
            		document.getElementById('rsumre').focus();
            		return false;
					}
            	}
				var reasonattapp=document.getElementById('reasonattapp').value;
				var reasonattres=document.getElementById('reasonattre').value;
            	if(((reasonattapp =="yes")||(reasonattapp=="no"))&&(reasonattres == ""))
            	{
					if(reasonattapp =="yes"){
						document.getElementById('reasonattre').value="ok";
					}else 
					{
            		alert("Please Write Reason for Reason Attachment");
            		document.getElementById('reasonattre').focus();
            		return false;
					}
            	}				
			}
</script>
			
			
			
			
            <!-- /schedule popup-->
</body>

</html>