<?php 
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{ ?>
<script>alert("Please Login");
window.location.href="index.php";
</script>
<?php 
	
}
if(isset($_SESSION['userSession']))
{
	$userid=$_SESSION['userSession'];
$sqljs="SELECT  `JFullName`, `JEmail`, `JPhone`,`JTotalEy`, `JTotalEm`, `DoB`, `Gender`,  `JPLoc_Id`, `Job_Skills`, `Indus_Id`, `Func_Id`,`nri_status` FROM `tbl_jobseeker` WHERE `JUser_Id`='$userid'";

		$sqljs2="SELECT `CurrentExp_Id`, `Loc_Id`, `Company_Name`, `CurrentSalL`, `CurrentSalT`, `ExpSalL`, `ExpMaxSalL`, `doJ`, `JDesc`, `Des`,  `alter_no` FROM `tbl_currentexperience` WHERE `JUser_Id`='$userid'";		
		$sqljs3="SELECT * FROM `tbl_education` WHERE `JUser_Id`='$userid'";	
		$sqljsres=mysqli_query($con,$sqljs);
		$sqljsres2=mysqli_query($con,$sqljs2);
		$sqljsres3=mysqli_query($con,$sqljs3);		
		if(mysqli_num_rows($sqljsres3)<1)
		{
			$valres[]="Please Give at least one Education(Degree) Details";
		}
		$sqlressow=mysqli_fetch_array($sqljsres);
		$sqlressow2=mysqli_fetch_array($sqljsres2);
		if($sqlressow['nri_status']=='Y')
		{
			$passport_sql="SELECT * FROM tbl_passport where JUser_Id=".$userid;
			$passport_res=mysqli_query($con,$passport_sql);
			if(mysqli_num_rows($passport_res)==0)
				$valres[]="Please fill your Passport Details";
		}
		for($i=0;$i<11;$i++)
		{
			if($i==3||$i==4)
			{
				if(empty($sqlressow[3])&&empty($sqlressow[4]))
				{
				
				$valres[]="Please fill General Information ";
				
				}
			}
			else if(empty($sqlressow[$i]))
			{// echo $i;
				$valres[]="Please fill General Information ";
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
				break;
				
				}
				else if(empty($sqlressow2[5])&&empty($sqlressow2[6]))
				{
				
				$valres[]="Please fill General Information Information ";
				break;
				
				}
			}
			else if(empty($sqlressow2[$j]))
			{
				//echo $j;
				
				$valres[]="Please fill Professional Experince";
				
				break;
			}
		}
		if(!empty($valres))
		{?>
			<script language="javascript">alert("<?php  foreach($valres as $k) {echo $k.'\\n'; }?>");
		window.location='jobseeker-profile.php';
		</script>
	
	<?php		
		} else
    {
      $qq="update  tbl_jobseeker set JuserStatus='A' where JUser_Id=$userid";
      $res=mysqli_query($con,$qq);
    }
		//echo "HII";
	}
					  
$stmt = $user_home->runQuery("SELECT * FROM tbl_jobseeker  WHERE JUser_Id=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
 $uid=$_GET['uid'];
$jid=$_GET['jid'];
$cdate=$_GET['cd'];
//echo $_GET['act'];
if($_GET['act']=="noti"){
   $notifi="UPDATE tbl_notifications SET notification_read=1 WHERE job_id =".$jid." and job_owner_id=".$uid." and created_on='".$cdate."'  and notification_to =".$_SESSION['userSession'];
 mysqli_query($con, $notifi);
}else if($_GET['act']=="ins"){
  $tbl_is="UPDATE interviewscheduled SET notification_read=1 WHERE job_id =".$jid." and emp_id=".$uid." and created='".$cdate."' and juser_id =".$_SESSION['userSession'];
 mysqli_query($con, $tbl_is);
}
else if($_GET['act']=="sh"){
 $tbl_ap="UPDATE tbl_shortlisted SET notification_read=1 WHERE JobId =".$jid." and emp_id=".$uid." and created='".$cdate."' and JUser_Id =".$_SESSION['userSession'];
 mysqli_query($con, $tbl_ap);
}
else{
	
}
 
 
 $sql1= "SELECT J.*,qo.Qual_Name,Ed.contact_name,L.Loc_Name,I.Indus_Name,F.Func_Name,Ed.companyname,Ed.eLogo,Ed.company_type,Ed.address1,Ed.contact_num,Ed.emp_email
									FROM tbl_jobposted J		
									LEFT JOIN tbl_location L on J.Loc_Id=L.Loc_Id
									LEFT JOIN tbl_industry I on J.PIndus_Id=I.Indus_Id
									LEFT JOIN tbl_functionalarea F on J.PFunc_Id=F.Func_Id									
									LEFT JOIN tbll_emplyer Ed on J.emp_id= Ed.emp_id 
									LEFT JOIN tbl_qualification qo on J.PEduc_Id=qo.Qual_Id
									where J.emp_id='".$uid."' AND J.Job_Id='".$jid."'";		


if(isset($_SESSION['userSession']))
{
$jobseekerid=$_SESSION['userSession'];
$sqlinsert="INSERT INTO `tbl_jobseekerview` (`emp_id`, `JUser_Id`, `job_id`) VALUES ('$uid','$jobseekerid','$jid')";
mysqli_query($con,$sqlinsert);


}								
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
 
    <?php include"source.php" ?>
</head>

<body>
    <?php
	include_once("analyticstracking.php");
	include "postlogin-header-jobseekar.php"; ?>
       
        <main>
            
            <section class="job-detail">
                
                <div class="job-list-header">
                    <div class="container">
                        
                        <div class="row search-home nomrg">
                            <div class="search-home-in">
                                <div class="row">
								<?php require_once "search.php";?>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
               
         <?php   $result1 = mysqli_query($con,$sql1); 
				  $cc=mysqli_num_rows($result1);
				$rowview2 = mysqli_fetch_array($result1);
                             ?>
			   <div class="container">
                    <ul class="bcrumb-listjobs">
                        <li> <a href="index.php">Home</a> </li>
                        <li> <a href="job-search-results-postlogin_jobseeker.php?skills=<?php echo $_GET['skills'];?>&loc=<?php echo $_GET['loc']?>">Search Results</a> </li>
						<?php $sql2 = "SELECT * FROM tbl_desigination where Desig_Id ='".$rowview2['Job_Name']."'";
												$query2 = mysqli_query($con, $sql2);
												$row3 = mysqli_fetch_array($query2);?>
                        <li> <a><?php echo $row3['Desig_Name']; ?></a> </li>
                    </ul>
                </div>
                
                <div class="container">
                    <div class="row">
                       
                        <div class="col-md-9">
                            <div class="job-detail-block brdbg-white">
                                
                                <div class="job-detail-header row">
                                    <div class="col-md-9 col-xs-12 col-xs-9">
                                        <div class="jobheader-title">
										
                                            <h4 class="txt-blue h4"><?php echo $row3['Desig_Name']; ?></h4>
                                            <h5 class="h5 comp-name"><?php echo $rowview2['Comp_Name']; ?> <span> <?php echo $rowview2['Comp_Url']; ?></span></h5>
                                            <div class="usermain-features">
                                                <ul>
                                                    <li><i class="fa fa-suitcase" aria-hidden="true"></i> <?php echo $rowview2['Min_Exp']; ?>-<?php echo $rowview2['Max_Exp']; ?> Years</li>
                                                    <li><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $rowview2['Loc_Name']; ?>	</li>
                                                    <li><i class="fa fa-calendar" aria-hidden="true"></i> 
													
													<?php $dateb=date_create($rowview2['created']); echo $dob= date_format($dateb,"M d, Y"); ?> Created </li>
                                                </ul>
                                            </div>
                                          <form name="applyedJob" method="post" action="applied.php">
											<input type="hidden" name="juserid" value="<?php echo $row['JUser_Id']; ?>">
											<input type="hidden" name="empid" value="<?php echo $uid; ?>">
											<input type="hidden" name="jobid" value="<?php echo $jid; ?>">
                                            <?php  $qq="select aId from tbl_applied where JUser_Id='".$row['JUser_Id']."' and emp_id='".$uid."' and JobId='".$jid."'";
                           $qq_res=mysqli_query($con,$qq);
                           $qq_data=mysqli_fetch_array($qq_res);
                           $a_id=$qq_data['aId'];
                           if($a_id==""){ ?>
											<input type="submit" name="apply" value="Apply Now" data-position="bottom" class="btn"  id="applybtn">
                                            <?php } else { ?>
                      <input type=""  value="Already Applied" data-position="bottom" class="btn tooltipped btn disabled" disabled >
                            <?php } ?>
										</form>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-xs-12 col-xs-3">
                                        <figure class="prelogo-detail">
                                        <?php if($rowview2['eLogo']!="") { ?> 
                                       <img class="img-contain" data-object-fit="contain" src="<?php echo $rowview2['eLogo'];?>" >
                                        <?php } else {?>
                                        <img class="img-contain" data-object-fit="contain" src="img/your-logo.png" >
                                        <?php } ?>
                                         </figure>
                                    </div>
                                </div>
                                
                                <div class="basic-detailstab">
                                   <ul>
                                       <li><span class="txt-blue">Job Title</span> <span><?php echo $row3['Desig_Name'];; ?></span></li>
                                       
                                       <li><span class="txt-blue">Position Type</span> <?php echo $rowview2['PJobtype']; ?></li>
                                       
                                        <li><span class="txt-blue">Experience</span> <?php echo $rowview2['Min_Exp']; ?>-<?php echo $rowview2['Max_Exp']; ?></li>
                                       
                                       <li><span class="txt-blue">Location</span> <?php echo $rowview2['Loc_Name']; ?></li>
                                   </ul>
                                </div>
                                
                                <div class="list-description">
                                    <h4 class="h4 txt-blue">Job Description: </h4>
                                   <p>
                                       <?php echo htmlspecialchars_decode($rowview2['Job_Desc']); ?>
                                    </p>    
                                    
                                </div>
                                
                              
                                <div class="list-description">
                                    <h4 class="h4 txt-blue">Qualification</h4>
                                    <ul>
										<?php
											$sql2 = "SELECT * FROM tbl_university where University_Id ='".$rowview2['PUniver_Id']."'";
													$query2 = mysqli_query($con, $sql2);
													$row2 = mysqli_fetch_array($query2);
											$sql3 = "SELECT * FROM tbl_specialization where Speca_Id ='".$rowview2['PSpeci_Id']."'";
													$query3 = mysqli_query($con, $sql3);
													$row3 = mysqli_fetch_array($query3);
										

                                            if($rowview2['Qual_Name'] && $row3['Speca_Name']){ ?>
                                            <li><?php echo $rowview2['Qual_Name']; ?> - <?php echo $row3['Speca_Name']; ?></li>
                                      <?php  }
                                        else{?>
                                            <li>Not Available</li>
                                            <?php  }
                                       

                                        if($row2['University_Name']){?>
                                            <li><?php echo $row2['University_Name']; ?></li>
                                   <?php     }
                                        else{?>
                                            <li>Not Available</li>
                                    <?php    }
                                        ?>	
										 <!-- <li><?php echo $rowview2['Qual_Name']; ?> - <?php echo $row3['Speca_Name']; ?></li>										
										 <li><?php echo $row2['University_Name']; ?></li> -->
                                    </ul>
                                    <table class="subtable">
                                        <tr>
                                            <td>CTC Range(Lacs)</td>
                                            <?php if( $rowview2['Sal_Range'] || $rowview2['MSal_Range']){?>
                                            <td>: Min: <?php echo $rowview2['Sal_Range']; ?> - Max: <?php echo $rowview2['MSal_Range']; ?></td>
                                       <?php     } else{ ?>
                                        <td>: Not Available</td>
                                      <?php } ?>
                                            <!-- <td>: Min: <?php echo $rowview2['Sal_Range']; ?> - Max: <?php echo $rowview2['MSal_Range']; ?></td> -->
                                        </tr>
                                        <tr>
                                            <td>Industry</td>
                                            <?php if($rowview2['Indus_Name'] != ""){?>
                                                <td>: <?php echo $rowview2['Indus_Name']; ?></td>
                                       <?php     } else{ ?>
                                        <td>: Not Available</td>
                                      <?php } ?>
                                            <!-- <td>: <?php echo $rowview2['Indus_Name']; ?></td> -->
                                        </tr>
                                        <tr>
                                            <td>Functional Area</td>
                                            <?php if($rowview2['Func_Name'] != ""){?>
                                                <td>: <?php echo $rowview2['Func_Name']; ?></td>
                                       <?php     } else{ ?>
                                        <td>: Not Available</td>
                                      <?php } ?>
                                            <!-- <td>: <?php echo $rowview2['Func_Name']; ?></td> -->
                                        </tr>
                                      
                                    </table>
                                </div>
                                
                                <div class="keyskills-detail">
                                    <h4 class="h4 txt-blue">Keyskills</h4>
                                    <div class=" list-emp-keyskills">
                                    <?php  $skill_ids=explode(",",$rowview2['Job_Skill']); ?>
                                        <p><?php foreach ($skill_ids as $skill_id) {

                                                     $s_query="select skill_Name from tbl_masterskills where skill_Id=".$skill_id;
                                                     $s_res=mysqli_query($con,$s_query);
                                                     $skill_name=mysqli_fetch_array($s_res);
                                                     ?> <span><?php echo $skill_name['skill_Name']; ?> </span><?php
                                                     
                                                   } ?></p>
                                    </div>
                                </div>
                                
								<?php if($rowview2['notshow_jobseeker']==0) {?> 
                                <div class="keyskills-detail">
                                    <h5 class="h5 txt-blue" id="rec-cont-det" style="text-decoration: underline;">Recruiter Contact Details</h5>
									
                                    <div class="Recruiter-contact-details">
                                        <table class="table" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td>Recruiter Name:</td>
                                                <td><?php echo $rowview2['contact_name']; ?> </td>
                                            </tr>
                                           
                                            <tr>
                                                <td>Contact No.</td>
                                                <td><?php echo $rowview2['contact_num']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Email ID</td>
                                                <td><?php echo $rowview2['emp_email']; ?></td>
                                            </tr>
                                        </table>
                                    </div>
									
                                </div>
								<?php } ?>
                               
							   <form name="" method="post" action="applied.php">
							   <input type="hidden" name="juserid" value="<?php echo $row['JUser_Id']; ?>">
							   <input type="hidden" name="empid" value="<?php echo $uid; ?>">
							   <input type="hidden" name="jobid" value="<?php echo $jid; ?>">
								<?php if($a_id==""){ ?>
                                            <input type="submit" name="apply" value="Apply Now" data-position="bottom" class="btn"  id="applybtn">
                                            <?php } else { ?>
                      <input type=""  value="Already Applied" data-position="bottom" class="btn tooltipped btn disabled" disabled >
                            <?php } ?>
								</form>
                                
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                           
                           
                            <div class="right-adspace-list">
                                <figure>
                                    <a href="javascript:void(0)"><img class="img-responsive" src="img/adv.jpg"></a>
                                </figure>
                               
                            </div>
                           
                            
                            
                            <div class="similar-jobs brdbg-white">
                                <h4 class="h4 search-filter-title">Similar Jobs</h4>
                                <ul class="similar-list">
							<?php
                             $languages=$rowview2['Job_Skill'];  
                            
							         $location=$rowview2['Loc_Id'];  
							        $lang_ids=explode(",",$languages);
						
						foreach($lang_ids as $lang_id)
						 {
							 $cj2="select * from tbl_jobposted where Loc_Id='".$location."' and Job_Status='1' and Job_Id!='".$_GET['jid']."' and  FIND_IN_SET('".$lang_id."', Job_Skill) "; 
							  $resultcj2 = mysqli_query($con,$cj2);  
							  while($result_cj2=mysqli_fetch_array($resultcj2))
							  {								  
							  $job_ids[]=$result_cj2['Job_Id'];
							  }
							  
						} 
						$jobs=array_filter(array_unique($job_ids));
						$cc=count(array_filter($jobs));
                      
						 if($cc!='0')
                                {
                                foreach($jobs as $job_id)
			                     	{  
                                         $j_query="select * from tbl_jobposted where Job_Id='$job_id' and Job_Status='1'";  
                                          $j_res=mysqli_query($con,$j_query);
                                          $j_data=mysqli_fetch_array($j_res);

                                         $sql22 = "SELECT * FROM tbl_desigination where Desig_Id ='".$j_data['Job_Name']."'";
                                                $query22 = mysqli_query($con, $sql22);
                                                $row22 = mysqli_fetch_array($query22);
										 
                                        ?> 
                                    <li> <a class="txt-blue" href="job-detail-postlogin.php?uid=<?php echo $j_data['emp_id'] ?>&jid=<?php echo $j_data['Job_Id'] ?>"><b><?php echo $row22['Desig_Name'];?></b> <span><?php echo $j_data['Min_Exp'];?>-<?php echo $j_data['Max_Exp'];?> Years | <?php  $j_query1="select Loc_Name from tbl_location where Loc_Id=".$j_data['Loc_Id'];  
                                          $j_res1=mysqli_query($con,$j_query1);
                                          $j_data1=mysqli_fetch_array($j_res1);echo $j_data1['Loc_Name'];?> </span></a>
                                        <p class="company-name-similar"><?php echo $j_data['Comp_Name'];?></p>
                                        <p>Keyskills : 
										
										 <?php  $skill_ids=explode(",",$j_data['Job_Skill']); ?>

                                         <?php foreach ($skill_ids as $skill_id) {

                                                     $s_query="select skill_Name from tbl_masterskills where skill_Id=".$skill_id;
                                                     $s_res=mysqli_query($con,$s_query);
                                                     $skill_name=mysqli_fetch_array($s_res);
                                                     ?> <span><?php echo $skill_name['skill_Name']; ?> </span><?php
                                                     
                                                   } ?>
										</p>
                                    </li>
								<?php } 
                                } else { ?>
                                   <li> <center><h5 class="h5 nosimjobs">No Similar Jobs</h5></center> </li>
                                <?php } ?>
                                </ul>
                            </div>
                        </div>
                       
                    </div>
                </div>

            </section>

        </main>
      
</body>

</html>