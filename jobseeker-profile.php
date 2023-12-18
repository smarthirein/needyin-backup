<?php 
session_start();
require_once("config.php");
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
	$user_home->redirect('index.php');
}
$stmt = $user_home->runQuery("SELECT * FROM tbl_jobseeker u
							  JOIN tbl_currentexperience cexp on u.JUser_Id=cexp.JUser_Id
							  WHERE u.JUser_Id=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$c1= "SELECT * FROM tbl_currentexperience   WHERE JUser_Id=".$row['JUser_Id'];
$c1_result = mysqli_query($con,$c1);
$c1_row = mysqli_fetch_array($c1_result);

$c4="select Loc_Id,Loc_Name from tbl_location where Loc_Id=".$c1_row['Loc_Id'];
$result4 = mysqli_query($con,$c4);
$row4= mysqli_fetch_array($result4); 


$valres=array();

if(isset($_SESSION['userSession']))
{
	$userid=$_SESSION['userSession'];

$sqljs="SELECT `JFullName`, `JEmail`, `JPhone`,`JTotalEy`, `JTotalEm`, `DoB`, `Gender`,  `JPLoc_Id`, `Job_Skills`, `Indus_Id`, `Func_Id`,'JCauthorised', 'JPhoto','Jcitizen','JuserStatus',`nri_status`,`jReasonSummary` FROM `tbl_jobseeker` WHERE `JUser_Id`='$userid'";
//echo $sqljs;
		$sqljs2="SELECT `CurrentExp_Id`, `Loc_Id`, `Company_Name`, `CurrentSalL`, `CurrentSalT`, `ExpSalL`, `ExpMaxSalL`, `doJ`, `JDesc`, `Des`,  `alter_no`,`PaySlip` FROM `tbl_currentexperience` WHERE `JUser_Id`='$userid'";
		//echo $sqljs2;
		$count=0;
		$sqljs3="SELECT * FROM `tbl_education` WHERE `JUser_Id`='$userid'";
		//echo $sqljs3;
		$sqljsres=mysqli_query($con,$sqljs);
		$sqljsres2=mysqli_query($con,$sqljs2);
		$sqljsres3=mysqli_query($con,$sqljs3);
		$edu_details=0;
		$prof_details=0;
		$gen_details=0;
		$reason_details=0;
		//echo mysqli_num_rows($sqljsres3);
		if(mysqli_num_rows($sqljsres3)==0)
		{
			$valres[]="Please provide the Eduational Background";
			$edu_details=1;
		}
		else
		$count=$count+1;
		$sqlressow=mysqli_fetch_array($sqljsres);
		$sqlressow2=mysqli_fetch_array($sqljsres2);
		if(!empty($sqlressow['jReasonSummary']))
		{
			$count=$count+1;		
		}
	    else
			$reason_details=1;
		for($i=0;$i<14;$i++)
		{
			if(!empty($sqlressow[$i]))
				 $count=$count+1;
			if($i==4 && $sqlressow[$i]==0)
				 $count=$count+1;
			
		}
		for($i=1;$i<=11;$i++)
		{
			if(!empty($sqlressow2[$i]))
				$count=$count+1;
		}
		for($i=0;$i<11;$i++)
		{
			if($i==3||$i==4)
			{
				if(empty($sqlressow[3])&&empty($sqlressow[4]))
				{
				
				$valres[]="Please provide the General Information details , ";
					$gen_details=1;
				
				}
			}
			else if(empty($sqlressow[$i]))
			{// echo $i;
				
				
				$valres[]="Please provide the General Information details , ";
				$gen_details=1;
				break;
			}
				
	
		}
		
		for($j=0;$j<12;$j++)
		{
			if($j==3||$j==4||$j==5||$j==6)
			{
				if(empty($sqlressow2[3])&&empty($sqlressow2[4]))
				{
				
				$valres[]="Please provide the General Information details , ";
					$gen_details=1;
				break;
				
				}
				else if(empty($sqlressow2[5])&&empty($sqlressow2[6]))
				{
				
				$valres[]="Please provide the General Information details , ";
				$gen_details=1;
				break;
				
				}
			}
			else if(empty($sqlressow2[$j]))
			{
				
				$valres[]="Please provide the Professional Experience details , ";
				$prof_details=1;
				break;
			}
				
	
		}
	if($gen_details==1 && $prof_details==1 && $edu_details==1)
		$msg="Please update your General, Professional and Education details";
	else if($gen_details==1 && $prof_details==1)
		$msg="Please update your General and Professional details";
	else if($prof_details==1 && $edu_details==1)
		$msg="Please update your Professional and Education details";
	else if($gen_details==1 && $edu_details==1)
		$msg="Please update your General and Education details";
	else if($gen_details==1)
		$msg="Please update your General Details";
	else if($prof_details==1)
		$msg="Please update your Professional Details";
	else if($edu_details==1)
		$msg="Please update your Education Details";
	else if($reason_details==1)
		$msg="Please give a Reason Description";
	else if($sqlressow['nri_status']=='Y')
		{
			$passport_sql="SELECT * FROM tbl_passport where JUser_Id=".$userid;
			$passport_res=mysqli_query($con,$passport_sql);
			if(mysqli_num_rows($passport_res)==0)
				$msg="Please fill your Passport Details";
			else
				$msg="";
		}
	
	else
		$msg="";
		
	
	/*				
		
		if(empty($valres))
    {
     
	  if($sqlressow['JuserStatus']=='V')
	  {
	  $qq="update  tbl_jobseeker set JuserStatus='AW' where JUser_Id=".$_SESSION['userSession'];
		  $res=mysqli_query($con,$qq);
		  $description="Profile 100% completed";
           $insert_query = "INSERT into tbl_notifications SET description='".$description."',profile_id='".$_SESSION['userSession']."',notification_to='1',notification_from='".$_SESSION['userSession']."',mode='admin'"; 
			$rr1 = mysqli_query($con,$insert_query);
			
				$subject="Profile Completed 100%";
				
										$nt_message="<table width='600' border='0' cellspacing='0' cellpadding='0' style='font-family:arial; margin:0 auto;'>
       
        <tr height='43px'>
                <td align='left' width='400px;' >
                        <a href=".$siteurl." target='_blank'><img src='".$siteurl."img/logo.png' width='198'></a>
                </td>
                <td align='right' width='300'>
                    <table>
                        <tr height='70'>
                            <td align='center' style='padding-right:10px;'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."about-us.php' target='_blank'>About Us</a> |</td>
                            <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."contact.php.php' target='_blank'>Contact</a> |</td>
                           
                           
                        </tr>
                    </table>
                </td>
        </tr>
         <tr>
                <td colspan='2' style='background:#90bd14;' align='center'>
                    <p style='font-size:15px; line-height:20px; color:#fff; padding:5px ; text-align: justify;'>Dear ".$result_cj4['contact_name'].",<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A new profile is identified matching with your job details which are close to your skills,location and / or other criteria. </p>
                </td>
        </tr>
        <tr>
                <td style='height:15px;'>
                </td>
        </tr>
        <tr height='320'>
                <td colspan='2'   style='background:url(".$siteurl."img/notif.png) no-repeat center 0;background-size: 560px 310px; height:320px;'>
             
                        <table style='margin-bottom: 185px; width: 400px; margin-left: 60px;'>
                        <tr >
                            <td align='center'>
                            <p style='padding-right:10px;font-size:14px; color:white; text-decoration:none;width:120px; '>I heard about needyin from my friend and registered in the portal two weeks back. </p></td>


                            <td align='center'>
                            <p style='font-size:14px; margin-left: 45px; color:white;;width:120px; text-decoration:none;'> I joined the portal a few days back and I could reach the recruiters as per by preferred location anad skills.</p></td>

                            <td   align='center' ><p style='font-size:14px; color:white; ;width:120px;text-decoration:none;margin-left: 50px;'>I joined this portal recently. To get my details please click on the link below</br><a href=".$siteurl.">NeedyIn </a></p></td>
                           
                        </tr>
                    </table>
</div>						
				</td>
		</tr>		
				
     
            
        <tr>
            <td height='10' colspan='2' align='center'>
               <p style='font-size:15px; line-height:22px; color:#333; padding:0 10px; margin:0;'></p>
            </td>
        </tr>
    <tr>
            <td colspan='2' style='background:#0274bb;' align='center'>
                <p style='font-size:13px; line-height:30px; color:#fff; '>You have received this mail because your e-mail ID is registered with Needyin.com. This is a system-generated e-mail regarding your Needyin account preferences, please dont reply to this message.</p>
            </td>
        </tr>
        
        </tr>
    </table>";
	$admin_email="shashikalakoppu@gmail.com";

							             $mm=$reg_user->send_mail2($admin_email,$nt_message,$subject);
	  }
    }
	*/
	
		//echo "HII";
	//echo $count;
	$percent= floor((($count/26)*100));
		 $per=$percent*1.5;
		 $percent;

	 if($percent==100 && $sqlressow2[11] != "")
		 {
 $qq="update  tbl_jobseeker set JuserStatus='Y' where JuserStatus='V' and JUser_Id=$userid";
      $res=mysqli_query($con,$qq);
	  
	  //for adding updated date in 'tbl_user_admin_curationdts' for 100% completed date start date
	 $ac="update  tbl_user_admin_curationdts set Y_updt='NOW()' where JUser_Id=$userid";
      $resac=mysqli_query($con,$ac);
				
		
	$sjs="SELECT  `JFullName`, `JEmail`, `JuserStatus` FROM `tbl_jobseeker` WHERE `JUser_Id`='$userid'";	
		$sjsres=mysqli_query($con,$sjs);
		$result_cj4=mysqli_fetch_array($sjsres); 
		 
	 $sjss="SELECT  count(profile_id)  as idcs FROM `tbl_notifications` WHERE `profile_id`='$userid' and `description`='Profile 100% completed'";	
		$ssjsres=mysqli_query($con,$sjss);
		$re_cj4=mysqli_fetch_array($ssjsres); 
		 
	 $result_cj4['JuserStatus'];
	  if(($result_cj4['JuserStatus']=='Y')&&($re_cj4['idcs']==''))
	  {
	  /*$qq="update  tbl_jobseeker set JuserStatus='AW' where JUser_Id=".$_SESSION['userSession'];
		  $res=mysqli_query($con,$qq);*/
		  $description="Profile 100% completed";
           $insert_query = "INSERT into tbl_notifications SET description='".$description."',profile_id='".$_SESSION['userSession']."',notification_to='1',notification_from='".$_SESSION['userSession']."',mode='admin'"; 
			$rr1 = mysqli_query($con,$insert_query);
			
				$subject="Profile Completed 100%";
				
										$nt_message="<table width='600' border='0' cellspacing='0' cellpadding='0' style='font-family:arial; margin:0 auto;'>
       
        <tr height='43px'>
                <td align='left' width='400px;' >
                        <a href=".$siteurl." target='_blank'><img src='".$siteurl."img/logo.png' width='198'></a>
                </td>
                <td align='right' width='300'>
                    <table>
                        <tr height='70'>
                            <td align='center' style='padding-right:10px;'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."about-us.php' target='_blank'>About Us</a> |</td>
                            <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."contact.php.php' target='_blank'>Contact</a> |</td>
                           
                           
                        </tr>
                    </table>
                </td>
        </tr>
         <tr>
                <td colspan='2' style='background:#90bd14;' align='center'>
                    <p style='font-size:15px; line-height:20px; color:#fff; padding:5px ; text-align: justify;'>Dear Admin ,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A new profile is identified with name called ".$result_cj4['JFullName']." and Email id is ".$result_cj4['JEmail'].". </p>
                </td>
        </tr>
        <tr>
                <td style='height:15px;'>
                </td>
        </tr>
        <tr height='320'>
                <td colspan='2'   style='background:url(".$siteurl."img/notif.png) no-repeat center 0;background-size: 560px 310px; height:320px;'>
             
                        <table style='margin-bottom: 185px; width: 400px; margin-left: 60px;'>
                        <tr >
                            <td align='center'>
                            <p style='padding-right:10px;font-size:14px; color:white; text-decoration:none;width:120px; '>I heard about needyin from my friend and registered in the portal two weeks back. </p></td>
                        </tr>
                    </table>
</div>						
				</td>
		</tr>		
				
     
            
        <tr>
            <td height='10' colspan='2' align='center'>
               <p style='font-size:15px; line-height:22px; color:#333; padding:0 10px; margin:0;'></p>
            </td>
        </tr>
  
        
        </tr>
    </table>";
	$admin_email="prashant@needyin.com";

							             $mm=$user_home->send_mail2($admin_email,$nt_message,$subject);
	  }
		 }
}

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
include_once("analyticstracking.php");
include "postlogin-header-jobseekar.php";?>
            <!-- main-->
            <main>
                <section class="jobseekar-profile">
                    <div class="job-seekar-header">
                        <div class="container">
                            <!-- top right buttons -->
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="header-top-btns pull-right">
                                        <li><a class="btn waves-effect waves-light" href="javascript:void(0)" onclick="return forwardinglatestjob()">Latest Jobs</a></li>
                                        <li><a class="btn waves-effect waves-light" href="javascript:void(0)" onclick="return forwardingappliedjob()">Applied Jobs</a></li>
                                        <li><a class="btn waves-effect waves-light" href="javascript:void(0)" onclick="return forwardingrecruiterview()">Recruiter's View</a></li>
                                        <li><a class="btn waves-effect waves-light" href="javascript:void(0)" onclick="return forwardingupdateresume()">Update Resume</a></li>
										  <li><a class="btn waves-effect waves-light" href="./job-search-results-postlogin_jobseeker.php">Search</a></li>			
                                    </ul>
                                </div>
                            </div>
                            <!--/ top right buttons -->
                            <!-- profile primary details -->
                            <div class="row">
                                <!-- profile piccutre -->
                                <div class="col-md-2 col-xs-12 col-sm-4 piccol">
                                    <figure class="profile-pic-js">
                                        <?php 			
												 $sql = "SELECT JPhoto,Gender FROM tbl_jobseeker WHERE JUser_Id=".$row['JUser_Id'];
																			$result = mysqli_query($con,$sql);
																			$row1 = mysqli_fetch_array($result);
																			$profileLogo=$row1['JPhoto']; if($profileLogo){?>
																			<img src="<?php echo $profileLogo; ?>" class="img-cover" data-object-fit="cover">
                                            <?php } else if($row1['Gender']=="Male") { ?> <img src="img/js-profile-list-pic.jpg" class="img-cover" data-object-fit="cover">
                                                <?php } else {?> <img src="img/female.png" class="img-cover" data-object-fit="cover">
												<?php } ?>
                                                    <div class="file-field input-field btn-block">
                                                        <form name="logos" action="general-info.php" method="post" enctype="multipart/form-data">
                                                           <div class="savepbtn" >
                                                                <input type="submit" name="Savelogo" value="Save & Update " class="btn waves-effect waves-light btn-blue-sm " onclick="return logofile()" /> </div>
                                                            <div class="btn proupload"> <span class="text-font"> Update Profile picture [60 KB]</span>
                                                                <input type="file" style="cursor: pointer;" id="logo" name="logo" onchange="ValidateSingleInput(this)"> </div>
                                                        </form>
														 <form name="logos1" action="general-info.php" method="post" enctype="multipart/form-data">
												
													<input type="submit" name="removelogo" class="Waves-effect waves-light btn-blue-sm " value="&#128465;" style="float:right;position:relative;bottom:170px;right:0px;padding:0 1px !important;">													
												</form>
                                                    </div> 
                                                 </figure>
                                			</div>
                                <!--/ profile picture -->
                                <!-- jobseekar basic details in header -->
								<?php if($row['nri_status']=='Y')
                                {
                                    $cnt= "SELECT * FROM  tbl_country   WHERE Cntry_Id=".$c1_row['Loc_Id'];
                                    $cnt_res = mysqli_query($con,$cnt);
                                    $cnt_data = mysqli_fetch_array($cnt_res);
                                    $cloc_name=$cnt_data['Cntry_Name'];
                                } else
                                {
                                    $cloc_name=$row4['Loc_Name'];
                                } ?>
                                <div class="col-md-10 col-xs-12 col-sm-8">
                                    <div class="js-basicdetails">
                                        <h2 class="h2 fbold"><?php echo $row['JFullName']; ?></h2>
                                        <h5 class="flight"><?php echo $row['Des']; ?> at <?php echo $row['Company_Name']; ?>, <?php echo $cloc_name ?></h5>
                                        <article class="js-contact-det"> <span class="flight"> <i class="fa fa-phone" aria-hidden="true"></i> +91 <?php echo $row['JPhone']; ?></span> <span class="flight"><i class="fa fa-envelope" aria-hidden="true"></i>  <?php echo $row['JEmail']; ?></span> </article>
                                    </div>
                                </div>
                                <!--/ jobseekar basic details in header -->
                                
                            </div>
                            <!--/ profile primary details -->
                        </div>
                    </div>
                    <!-- job seekar header -->
                    <!-- job seekar body -->
                    <section class="job-seekar-body">
                        <div class="js-profile-nav">
                            <!-- job seekear profile navigation -->
                            <div class="container">
                                <script type="text/javascript">
                                  /*  $(document).ready(function () {
                                        $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
                                            localStorage.setItem('activeTab', $(e.target).attr('href'));
                                        });
                                        var activeTab = localStorage.getItem('activeTab');
                                        if (activeTab) {
                                            $('#myTab a[href="' + activeTab + '"]').tab('show');
                                        }
                                    });*/
                                </script>								
                                <ul class="nav nav-tabs responsive-tabs nav-profile nofullwidth profilenew-nav" id="myTab">
                                    <li class="active"><a href="#geninfo" data-toggle="tab"><i class="fa fa-user-o" aria-hidden="true"></i> General Information</a></li>
                                    <li><a href="#education" data-toggle="tab"><i class="fa fa-book" aria-hidden="true"></i> Education</a></li>
                                    <li><a href="#proexp" data-toggle="tab"><i class="fa fa-black-tie" aria-hidden="true"></i> Professional Experience</a></li>
                                    <li><a href="#skills" data-toggle="tab"><i class="fa fa-cog" aria-hidden="true"></i> Skills</a></li>
									<li><a href="#address" data-toggle="tab"><i class="fa fa-map-marker" aria-hidden="true"></i> Address/Reasons</a></li> 
                                   <!-- <li><a href="#address" data-toggle="tab"><i class="fa fa-map-marker" aria-hidden="true"></i> Address</a></li> -->
                            		<div style="text-align: right;float:right !important;">	
										<label style="font-size: 90%; color: #000000;">Profile Completeness XXXXX</label>
											<div class="progress" style="height:20px" >
												<div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $per; ?>px">
	  											<p><?php echo $percent; ?>%</p>
  												</div>
											</div>
									</div>
								</ul>
                                <!-- profile discription content -->
                                <div class="tab-content profile-body-content">
                                    <div class="tab-pane active" id="geninfo">
                                        <div class="tabjsinfo-content">
                                            <?php include 'general-info-js.php'; ?>
                                        </div>
                                    </div>
								 </div>
                                    <div class="tab-pane" id="education">
                                        <div class="tabjsinfo-content">
                                            <?php include'education-info-js.php'; ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="proexp">
                                        <div class="tabjsinfo-content">
                                            <?php include'prof-exp-js.php'; ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="skills">
                                        <div class="tabjsinfo-content">
                                            <?php include'skills-info-js.php'; ?>
                                        </div>
                                    </div>
                                   <div class="tab-pane" id="address">
                                        <div class="tabjsinfo-content">
                                            <?php include'address-info-js.php'; ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- /profile discription content -->
                            </div>
                        </div>
					
                        <!-- job seekar profile navigation -->
                    </section>
                    <!-- / job seekar body -->
                </section>
		
            </main>
            <!--/main-->
            <!-- responsive tabs -->
            <script>
                $('.responsive-tabs').responsiveTabs({
                    accordionOn: ['xs', 'sm']
                });
            </script>
            <!--/responsive tabs-->
            <!-- tool tip-->
            <script>
                $(document).ready(function () {
                    $('[data-toggle="tooltip"]').tooltip();
                });
            </script>
            <!-- tool tip -->
            <!-- updae text field -->
            <script>
                $(document).ready(function () {
                    Materialize.updateTextFields();
                });
            </script>
		 
            <script>
                $('.datepicker').pickadate({
                    selectMonths: true, // Creates a dropdown to control month
                    selectYears: 100 // Creates a dropdown of 15 years to control year
                });
               
            </script>
			 
            <!-- alert examples -->
            <div class="container">
                <div class="alert alert-success alert-dismissible" id="myAlert"> <a href="#" class="close">&times;</a> <strong>Success!</strong> Profile Overview Updated successfully </div>
            </div>
            <!-- alert examples -->
            <!-- footer-->
            <?php //include 'footer.php'; ?>
                <!--/footer-->
    	</body>
<script lang="javascript">
function ValidateSingleInput(oInput) {
	var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png"];    
	//alert("DDDD");
    if (oInput.type == "file") {
        var sFileName = oInput.value;
         if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                }
            }           
            if (!blnValid) {
                alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
                oInput.value = "";
                return false;
            }
			else
			{				
				alert("Please Click on Save and Update Button ");
			}
        }
    }
}
function logofile()
{ 
    //var logo=document.getElementById('logo').files[0].size;
	var logo=document.getElementById('logo').value;
	if(logo=="") {
  alert("Please Upload Image");
		document.getElementById('logo').focus();
		return false;
}
	if(logo>60000)
	{		
		alert("Please Check Profile Picture Size is more than 60KB");
		document.getElementById('logo').focus();
		return false;
	}	
}
function forwardinglatestjob()
{
	var messages=<?php echo json_encode($msg); ?>;	
	if(messages.length>0)
	{       	

	alert(messages);	
	return false;
	}	
	else
	{		
		window.location='job-search-results-postlogin.php';		
	}		
}
function forwardingappliedjob()
{
	var messages=<?php echo json_encode($msg); ?>;	
	if(messages.length>0)
	{
	
	alert(messages);	
	return false;
	}	
	else
	{		
		window.location='appliedjobs.php';		
	}		
}
function forwardingrecruiterview()
{
	var messages=<?php echo json_encode($msg); ?>;	
	if(messages.length>0)
		{
			
			alert(messages);	
	return false;
		}
	else
	{		
		window.location='js-recruiter-view.php';		
	}		
}
function forwardingupdateresume()
{
	var messages=<?php echo json_encode($msg); ?>;	
	if(messages.length>0)
	{
	
	alert(messages);	
	return false;
	}	
	else
	{		
		window.location='jobseeker-profile-update-resume.php';		
	}		
}
</script>
    </html>