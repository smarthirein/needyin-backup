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
							  LEFT JOIN tbl_currentexperience cexp on u.JUser_Id=cexp.JUser_Id
							  WHERE u.JUser_Id=:uid");

							  
if(isset($_SESSION['userSession']))
{
	$userid=$_SESSION['userSession'];

$sqljs="SELECT  `JFullName`, `JEmail`, `JPhone`,`JTotalEy`, `JTotalEm`, `DoB`, `Gender`,  `JPLoc_Id`, `Job_Skills`, `Indus_Id`, `Func_Id` FROM `tbl_jobseeker` WHERE `JUser_Id`='$userid'";
//echo $sqljs;
		$sqljs2="SELECT `CurrentExp_Id`, `Loc_Id`, `Company_Name`, `CurrentSalL`, `CurrentSalT`, `ExpSalL`, `ExpMaxSalL`, `doJ`, `JDesc`, `Des`,  `alter_no` FROM `tbl_currentexperience` WHERE `JUser_Id`='$userid'";
		//echo $sqljs2;
		
		$sqljs3="SELECT * FROM `tbl_education` WHERE `JUser_Id`='$userid'";
		//echo $sqljs3;
		$sqljsres=mysqli_query($con,$sqljs);
		$sqljsres2=mysqli_query($con,$sqljs2);
		$sqljsres3=mysqli_query($con,$sqljs3);
		//echo mysqli_num_rows($sqljsres3);
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
				
				
				$valres[]="Please fill General Information ".$i;
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
				
				$valres[]="Please fill General Information  ";
					$gen_details=1;
				break;
				
				}
				else if(empty($sqlressow2[5])&&empty($sqlressow2[6]))
				{
				
				$valres[]="Please fill General Information  ";
					$gen_details=1;
				break;
				
				}
			}
			else if(empty($sqlressow2[$j]))
			{
				//echo $j;
				
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
	
	
			<script language="javascript">alert("<?php  echo $msg; ?>");
		window.location='jobseeker-profile.php';
		</script>
			
			
			
<?php		
		}else
    {
     $qq="update  tbl_jobseeker set JuserStatus='Y' where JuserStatus='V' and JUser_Id=$userid";
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
	$admin_email="shashikalakoppu@gmail.com";

							             $mm=$user_home->send_mail2($admin_email,$nt_message,$subject);
	  }
    }
		
		//echo "HII";
		
}							  
							  
							  
							  
							  
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
 $c1= "SELECT * FROM tbl_currentexperience   WHERE JUser_Id=".$row['JUser_Id'];
$result1 = mysqli_query($con,$c1);
$row1 = mysqli_fetch_array($result1);
//print_r($row1);

 $c2= "SELECT * FROM  tbl_jobseeker WHERE JUser_Id=".$row['JUser_Id'];
$result2 = mysqli_query($con,$c2);
$row2= mysqli_fetch_array($result2); 

$c3="select Loc_Id,Loc_Name from tbl_location where Loc_Id=".$row2['JPLoc_Id'];
$result3 = mysqli_query($con,$c3);
$row3= mysqli_fetch_array($result3); 

$c4="select Loc_Id,Loc_Name from tbl_location where Loc_Id=".$row1['Loc_Id'];
$result4 = mysqli_query($con,$c4);
$row4= mysqli_fetch_array($result4); 

function dateDiff($start, $end) {
  $start_ts = strtotime($start);
  $end_ts = strtotime($end);
  $diff = $end_ts - $start_ts;
  return round($diff / 86400);
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
    <!-- css includes-->
    <?php include "source.php" ?>
	<script type="text/javascript" src="js/jquery.bootstrap-responsive-tabs.min.js"></script>
</head>

<body>
    <?php 
	include_once("analyticstracking.php");
	include"postlogin-header-jobseekar.php"; ?>
        <!-- main-->
        <main>
           <?php include "inner-menu.php" ;?>
            <!-- recruiter view -->
            <section class="rec-view">
                <!-- brudcrumb -->
                <div class="container">
                    <ul class="bcrumb-listjobs">
                        <li> <a href="index.php">Home</a> </li>
                        <li> <a href="jobseeker-profile.php"><?php echo $row['JFullName']; ?> </a> </li>
                        <li> <a>Recruiter View</a> </li>
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
                                <div class="col-md-2 col-sm-3 col-xs-12">
                                    <figure class="recview-img">
                                     <?php if($row2['JPhoto']!=""){ ?>
                                     <img class="img-cover" data-object-fit="cover" src="<?php echo $row2['JPhoto']; ?>">
                                     <?php } else if($row2['Gender']=="Male") { ?>
                                     <img class="img-cover" data-object-fit="cover" src="img/js-profile-list-pic.jpg">
                                     <?php }  else {?>
									  <img class="img-cover" data-object-fit="cover" src="img/female.png">
									  <?php } ?>
                                     </figure>
                                </div>
                                <div class="col-md-10 col-sm-9 col-xs-12 details-js-view">
                                    <div class="recview-basic-details">
                                        <article class="name-view">
                                            <h3 class="fbold"><?php echo $row['JFullName']; ?></h3>
                                            <h5 class="txt-white"><?php echo $row1['Des']; ?> at <?php echo $row1['Company_Name']; ?></h5> </article>
                                    </div>
                                    <div class="row rowcan">
                                        <div class="col-md-2 col-sm-4 col-xs-12">
                                            <div class="features-main-candidate">
                                                <p>Current Location</p> <span><?php 
                                                        if($row['nri_status']=='Y')
                                                        {
                                                            $cnt= "SELECT * FROM  tbl_country   WHERE Cntry_Id=".$row1['Loc_Id'];
                                                            $cnt_res = mysqli_query($con,$cnt);
                                                            $cnt_data = mysqli_fetch_array($cnt_res);
                                                            $cloc_name=$cnt_data['Cntry_Name'];
                                                        } else
                                                        {
                                                            $cloc_name=$row4['Loc_Name'];
                                                        }
                                                echo $cloc_name; ?></span> </div>
                                        </div>
                                        <div class="col-md-2 col-sm-4 col-xs-12">
                                            <div class="features-main-candidate">
                                                <p>Preferred Location</p> <span><?php echo $row3['Loc_Name'] ?></span> </div>
                                        </div>
                                        <div class="col-md-2 col-sm-4 col-xs-12">
                                            <div class="features-main-candidate">
                                                <p>Experience</p> <span><?php echo $row['JTotalEy']; ?> Years - <?php echo $row['JTotalEm']; ?> Months </span> </div>
                                        </div>
                                        <div class="col-md-2 col-sm-4 col-xs-12">
                                            <div class="features-main-candidate">
                                                <p>Exp CTC (Lacs)</p> 
												<span>
                                                Min: <?php echo $row1['ExpSalL'];  ?> - Max: <?php echo $row1['ExpMaxSalL']; ?> 
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-4 col-xs-12">
                                            <div class="features-main-candidate">
                                                <p>Notice Period</p> <span><?php if($row1['NoticePeriod']=='1'){ echo "Immediate"; } else { echo $row1['NoticePeriod']; ?> days<?php } ?>
                                                </span> </div>
                                        </div>
                                        
                                    </div>
                                   
                                   		
										<article class="details-contact">
											<p><span><i class="fa fa-phone" aria-hidden="true"></i> +91 <?php echo $row['JPhone']; ?></span> <span><i class="fa fa-envelope-o" aria-hidden="true"></i> <?php echo $row['JEmail']; ?></span> 
											 <!--<span>Last Activity&nbsp;:&nbsp;<?php $from=date('Y-m-d'); $to=$row2['currentdate'];//echo dateDiff($to,$from). 'days';?></span> -->
											</p>
										</article>
                                 
                                   
                                   
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
                                <ul class="nav nav-tabs responsive-tabs nav-profile" id="myTabnew">
                                    <li class="active"><a href="#geninfo" data-toggle="tab"><i class="fa fa-user-o" aria-hidden="true"></i> General  Information</a></li>
                                    <li><a href="#education" data-toggle="tab"><i class="fa fa-book" aria-hidden="true"></i> Education</a></li>
                                    <li><a href="#proexp" data-toggle="tab"><i class="fa fa-black-tie" aria-hidden="true"></i> Professional Experience</a></li>
                                    <li><a href="#skills" data-toggle="tab"><i class="fa fa-cog" aria-hidden="true"></i> Skills</a></li>
                                    <li><a href="#reasons" data-toggle="tab"><i class="fa fa-map-marker" aria-hidden="true"></i> Reasons to Relocate</a></li>
                                </ul>
                               
                                <!-- profile discription content -->
                                <div class="tab-content profile-body-content">
                                    <div class="tab-pane active" id="geninfo">
                                        <div class="tabjsinfo-content">
                                            <?php include'general-info-js-rec-view.php'; ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="education">
                                        <div class="tabjsinfo-content">
                                            <?php include'education-info-js-rec-view.php'; ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="proexp">
                                        <div class="tabjsinfo-content">
                                            <?php include'prof-exp-js-rec-view.php'; ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="skills">
                                        <div class="tabjsinfo-content">
                                            <?php include'skills-info-js-rec-view.php'; ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="reasons">
                                        <div class="tabjsinfo-content">
                                           <?php include'reasons-view-js-rec-view.php'; ?>
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
        <?php// include 'footer.php'; ?>
            <!--/footer-->
            <script>
                $('.responsive-tabs').responsiveTabs({
                    accordionOn: ['xs', 'sm']
                });
            </script>
</body>

</html>