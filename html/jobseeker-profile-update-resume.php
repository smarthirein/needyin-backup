<?php
session_start();
require_once("config.php");
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
	$user_home->redirect('index.php');
}
if(isset($_SESSION['userSession']))
{
	$userid=$_SESSION['userSession'];

$sqljs="SELECT  `JFullName`, `JEmail`, `JPhone`,`JTotalEy`, `JTotalEm`, `DoB`, `Gender`,  `JPLoc_Id`, `Job_Skills`, `Indus_Id`, `Func_Id`, `JuserStatus` FROM `tbl_jobseeker` WHERE `JUser_Id`='$userid'";

		$sqljs2="SELECT `CurrentExp_Id`, `Loc_Id`, `Company_Name`, `CurrentSalL`, `CurrentSalT`, `ExpSalL`, `ExpMaxSalL`, `doJ`, `JDesc`, `Des`,  `alter_no` FROM `tbl_currentexperience` WHERE `JUser_Id`='$userid'";
	
		$sqljs3="SELECT * FROM `tbl_education` WHERE `JUser_Id`='$userid'";
		
		$sqljsres=mysqli_query($con,$sqljs);
		$sqljsres2=mysqli_query($con,$sqljs2);
		$sqljsres3=mysqli_query($con,$sqljs3);
		$edu_details=0;
		$prof_details=0;
		$gen_details=0;		
		if(mysqli_num_rows($sqljsres3)<1)
		{
			$valres[]="Please Give at least one Education(Degree) Details";
			$edu_details=1;
		}
		
		
		$sqlressow=mysqli_fetch_array($sqljsres);
		$sqlressow2=mysqli_fetch_array($sqljsres2);
		for($i=0;$i<11;$i++)
		{
			if($i==3||$i==4)
			{
				if(empty($sqlressow[3])&&empty($sqlressow[4]))
				{
				
				$valres[]="Please fill General Information ";
					$gen_details=1;
				
				}
			}
			else if(empty($sqlressow[$i]))
			{// echo $i;
				
				
				$valres[]="Please fill General Information ";
				$gen_details=1;
				break;
			}
				
	
		}
		
		for($j=0;$j<11;$j++)
		{
			if($j==3||$j==4||$j==5||$j==6)
			{
				if(empty($sqlressow2[3])&&empty($sqlressow2[4]))
				{
				
				$valres[]="Please fill General Information Information ";
					$gen_details=1;
				break;
				
				}
				else if(empty($sqlressow2[5])&&empty($sqlressow2[6]))
				{
				
				$valres[]="Please fill General Information Information ";
					$gen_details=1;
				break;
				
				}
			}
			else if(empty($sqlressow2[$j]))
			{				
				$valres[]="Please fill Professional Experince";
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
	else
		$msg="";
		
		if(!empty($valres))
		{?>
	
	
			<script language="javascript">alert("<?php echo $msg; ?>");
		window.location='jobseeker-profile.php';
		</script>
			
			
			
	<?php		
		}else
    {
   $qq="update tbl_jobseeker set JuserStatus='Y' where JuserStatus='V' and JUser_Id=$userid";
      $res=mysqli_query($con,$qq);
		
		
		//for adding updated date in 'tbl_user_admin_curationdts' for 100% completed date start date
	  $ac="update  tbl_user_admin_curationdts set Y_updt='NOW()' where JUser_Id=$userid";
      $resac=mysqli_query($con,$ac);
	  
			$sqljs="SELECT  `JFullName`, `JEmail`, `JuserStatus` FROM `tbl_jobseeker` WHERE `JUser_Id`='$userid'";	
			$sqljsres=mysqli_query($con,$sqljs);
			$result_cj4=mysqli_fetch_array($resultcj4); 
	 $sjss="SELECT  count(profile_id)  as idcs FROM `tbl_notifications` WHERE `profile_id`='$userid' and `description`='Profile 100% completed'";	
		$ssjsres=mysqli_query($con,$sjss);
		$re_cj4=mysqli_fetch_array($ssjsres); 
		
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
		
		//echo "HII";
		
		
		
		
		
		
}
$stmt = $user_home->runQuery("SELECT * FROM tbl_jobseeker u
							  JOIN tbl_currentexperience cexp on u.JUser_Id=cexp.JUser_Id
							  WHERE u.JUser_Id=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
    <!-- css includes-->
    <?php include"source.php" ?>
</head>

<body>
    <?php 
	include_once("analyticstracking.php");
	include"postlogin-header-jobseekar.php"; ?>
        <!-- main-->
        <main>
            <section class="jobseekar-profile">
                <?php include "inner-menu.php" ;?>
                <!-- job seekar header -->
                <div class="container">
                    <ul class="bcrumb-listjobs">
                        <li> <a href="index.php">Home</a> </li>
                        <li> <a href="jobseeker-profile.php"><?php echo $row['JFullName']; ?></a> </li>
                        <li> <a>Update Resume</a> </li>
                    </ul>
                </div>
                <!-- job seekar body -->
                <section class="job-seekar-body">
                    <div class="js-profile-nav">
                        <!-- job seekear profile navigation -->
                        <div class="container">
                            <!-- update resume block -->
                            <div class="update-cv">
                                <div class="title-block-tab">
                                    <h4 class="flight">Update <span class="fbold">Resume</span></h4><br><br><br> <a href="#cvnewupload">Upload New Resume</a> </div>
                                    <script>
            $(document).ready(function () {
                $('.modal').modal();
            });
        </script>
                                <div class="cv-div">
								<?php	$sql1= "SELECT UpdateCV,currentdate FROM tbl_currentexperience WHERE JUser_Id=".$row['JUser_Id'];
																			$result1 = mysqli_query($con,$sql1);
																			$row1 = mysqli_fetch_array($result1);?>
                                    <p class="atresume">Attached Resume: (Uploaded on <?php $date=date_create($row1['currentdate']);echo date_format($date,"M d,Y");?>) 
									<a href="<?php echo $row1['UpdateCV']; ?>" target="blank"><i class="fa fa-download" aria-hidden="true"></i> Download</a> 
									</p>
                                    <div class="resume-preview mCustomScrollbar">
										<p>Your Latest Resume</p><div class="resume-message" style="display:none;"><p>Your mobile doesn't support </div>
                                        <div class="resume" >
									
										
                                            <p><?php  $cv=explode('.',$row1['UpdateCV']);;if($cv[1]=="pdf" || $cv[1]=="PDF"){?>
												
											<embed src="<?php echo $row1['UpdateCV']?>" width="600" height="475" type='application/pdf'>

											<?php } else{ $upcv=explode("/",$row1['UpdateCV']); //print_r($upcv[2]); ?>
												
											
<?php
echo "<iframe src=https://view.officeapps.live.com/op/embed.aspx?src=https://needyin.com/".$row1['UpdateCV']." width=600 height=475></iframe>";

											}?>
											</p>
									
                                        </div>
									                         </div>
                                </div>
                            </div>
                            <!--/ update resume block -->
                        </div>
                    </div>
                    <!-- job seekar profile navigation -->
                </section>
                <!-- / job seekar body -->
            </section>
        </main>
        <!--/main-->
       
       
        <!-- updae text field -->
        <script>
            $(document).ready(function () {
                Materialize.updateTextFields();
            });
			function Validateresume(oInput) {
	var _validFileExtensions = [".doc",".docx",".pdf"];    
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
        }
    }
}
function resumefile()
{
	
	var resume=document.getElementById('resume').files[0].size;
	//resumesize=resume.size;
	//alert(resume);
	//return false;
	if(resume>250000)
	{
		
		alert("Resume size is more than 250KB ,please check");
		document.getElementById('resume').focus();
		return false;
		
	}
	
	
}
    </script>
        <!-- footer-->
        <?php //include 'footer.php' ?>
            <!--/footer-->
</body>
<!-- upload new resume -->
        <div id="cvnewupload" class="modal">
           
                     <form name="resume" action="general-info.php" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <h4 class="text-center">Upload New Resume</h4>
                <!-- modal body -->
                <div class="profile-pic-edit text-center">                   
                        <div class="file-field input-field">
                            <div class="btn"> <span>Resume</span>
                                <input type="file" id="resume" name="resume"> </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text"> </div>
                        </div>
                        <br>
                        <p>Supported Formats: doc, docx, rtf, pdf. Max file size:250KB Please note that this resume document will be uploaded to your Needyin profile</p>
                </div>
                <!--/modal body-->
            </div>
            <div class="modal-footer text-center"> <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Cancel</a> 	<a class="waves-effect waves-green btn-flat" href="javascript:void(0)"><input type="submit"  name="Saveresume" value="Save"/></a> </div>
  </form>     
             
        </div>
        <!--/ upload new resume-->
        <script>
            $(document).ready(function () {
                $('.modal').modal();
            });
        </script>

</html>