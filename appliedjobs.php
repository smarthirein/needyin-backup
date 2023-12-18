<?php 
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
	$user_home->redirect('index.php');
}
					  
$stmt = $user_home->runQuery("SELECT * FROM tbl_jobseeker u							
                              WHERE u.JUser_Id=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);


	if(isset($_SESSION['userSession']))
	{
		$userid=$_SESSION['userSession'];
		$sqljs="SELECT  `JFullName`, `JEmail`, `JPhone`,`JTotalEy`, `JTotalEm`, `DoB`, `Gender`,  `JPLoc_Id`, `Job_Skills`, `Indus_Id`, `Func_Id`, `JuserStatus` FROM `tbl_jobseeker` WHERE `JUser_Id`='$userid'";
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
				
				
				$valres[]="Please fill General Information ".$i;
				
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
				break;
				
				}
				else if(empty($sqlressow2[5])&&empty($sqlressow2[6]))
				{
				
				$valres[]="Please fill General Information  ";
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
		
		echo $valres;
		if(!empty($valres))
		{?>
	
	
			<script language="javascript">alert("<?php  foreach($valres as $k) {echo $k.'\\n'; }?>");
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
		
	  if(($result_cj4[' ']=='Y')&&($re_cj4['idcs']==''))		
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

 if($_GET['day']=='today'){
	 $today=date("Y-m-d");
			 $sql1= "SELECT ap.JUser_Id,ap.emp_id,Jp.Job_Id,Jp.Job_Name,L.Loc_Id,Jp.Job_Skill,Jp.PEduc_Id,qo.Qual_Id,E.emp_id,Jp.Job_Status,ap.created,Jp.Min_Exp,Jp.Max_Exp,Jp.Sal_Range,Jp.MSal_Range FROM tbl_applied ap LEFT JOIN tbl_jobposted Jp ON ap.JobId=Jp.Job_Id
 LEFT JOIN tbl_jobseeker J ON ap.JUser_Id = J.JUser_Id
 LEFT JOIN tbl_location L on Jp.Loc_Id=L.Loc_Id
 LEFT JOIN tbl_industry I on Jp.PIndus_Id=I.Indus_Id
 LEFT JOIN tbl_functionalarea F on Jp.PFunc_Id=F.Func_Id         
 LEFT JOIN tbl_qualification qo on Jp.PEduc_Id=qo.Qual_Id
 LEFT JOIN tbll_emplyer E ON ap.emp_id = E.emp_id
 WHERE ap.JUser_Id ='".$row['JUser_Id']."' and DATE(ap.created)='".$today."' and Jp.Job_Status='1'";		

		} else if($_GET['day']=='15'){
		$day15=date('Y-m-d', strtotime("-15 days"));
		 $sql1= "SELECT ap.JUser_Id,ap.emp_id,Jp.Job_Id,Jp.Job_Name,L.Loc_Id,Jp.Job_Skill,Jp.PEduc_Id,qo.Qual_Id,E.emp_id,Jp.Job_Status,ap.created,Jp.Min_Exp,Jp.Max_Exp,Jp.Sal_Range,Jp.MSal_Range FROM tbl_applied ap LEFT JOIN tbl_jobposted Jp ON ap.JobId=Jp.Job_Id
 LEFT JOIN tbl_jobseeker J ON ap.JUser_Id = J.JUser_Id
 LEFT JOIN tbl_location L on Jp.Loc_Id=L.Loc_Id
 LEFT JOIN tbl_industry I on Jp.PIndus_Id=I.Indus_Id
 LEFT JOIN tbl_functionalarea F on Jp.PFunc_Id=F.Func_Id         
 LEFT JOIN tbl_qualification qo on Jp.PEduc_Id=qo.Qual_Id
 LEFT JOIN tbll_emplyer E ON ap.emp_id = E.emp_id
 WHERE ap.JUser_Id ='".$row['JUser_Id']."' and DATE(ap.created)>='".$day15."' and Jp.Job_Status='1'";	
		}
		else if($_GET['day']=='30'){
		$day30=date('Y-m-d', strtotime("-30 days"));
		$sql1= "SELECT ap.JUser_Id,ap.emp_id,Jp.Job_Id,Jp.Job_Name,L.Loc_Id,Jp.Job_Skill,Jp.PEduc_Id,qo.Qual_Id,E.emp_id,Jp.Job_Status,ap.created,Jp.Min_Exp,Jp.Max_Exp,Jp.Sal_Range,Jp.MSal_Range FROM tbl_applied ap LEFT JOIN tbl_jobposted Jp ON ap.JobId=Jp.Job_Id
 LEFT JOIN tbl_jobseeker J ON ap.JUser_Id = J.JUser_Id
 LEFT JOIN tbl_location L on Jp.Loc_Id=L.Loc_Id
 LEFT JOIN tbl_industry I on Jp.PIndus_Id=I.Indus_Id
 LEFT JOIN tbl_functionalarea F on Jp.PFunc_Id=F.Func_Id         
 LEFT JOIN tbl_qualification qo on Jp.PEduc_Id=qo.Qual_Id
 LEFT JOIN tbll_emplyer E ON ap.emp_id = E.emp_id
 WHERE ap.JUser_Id ='".$row['JUser_Id']."' and DATE(ap.created)>='".$day30."' and Jp.Job_Status='1'";	

		}else{
			


   $sql1= "SELECT ap.JUser_Id,ap.emp_id,Jp.Job_Id,Jp.Job_Name,L.Loc_Id,Jp.Job_Skill,Jp.PEduc_Id,qo.Qual_Id,E.emp_id,Jp.Job_Status,ap.created,Jp.Min_Exp,Jp.Max_Exp,Jp.Sal_Range,Jp.MSal_Range FROM tbl_applied ap LEFT JOIN tbl_jobposted Jp ON ap.JobId=Jp.Job_Id
 LEFT JOIN tbl_jobseeker J ON ap.JUser_Id = J.JUser_Id
 LEFT JOIN tbl_location L on Jp.Loc_Id=L.Loc_Id        
 LEFT JOIN tbl_qualification qo on Jp.PEduc_Id=qo.Qual_Id
 LEFT JOIN tbll_emplyer E ON ap.emp_id = E.emp_id
 WHERE ap.JUser_Id ='".$row['JUser_Id']."' and Jp.Job_Status='1' order by  ap.created DESC";	

		}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
   
    <?php include "source.php";?>
</head>
<body>
    <?php
include_once("analyticstracking.php");
include "postlogin-header-jobseekar.php"; ?>
       
        <main>
           <?php include "inner-menu.php" ;?>
           
            <section class="job-list">
               
                <div class="container">
                    <ul class="bcrumb-listjobs">
                        <li> <a href="index.php">Home</a> </li>
                        <li> <a href="jobseeker-profile.php"><?php echo $row["JFullName"]?></a> </li>
                        <li> <a>Applied Jobs</a> </li>
                    </ul>
                </div>
               
                
                <div class="container">
                    <div class="row">
                
                        <div class="col-md-9 col-sm-8">
                        
                            <div class="job-list">
                                <div class="noofjobs brdbg-white">
                                   <?php  $r1 = mysqli_query($con,$sql1);
											$count_applied=mysqli_num_rows($r1);
										if($count_applied > 0) { ?>
                                   <p><span class="fbold txt-blue"><?php echo $count_applied;?></span> Jobs applied </p>
									 </div>
									<?php } else { ?>
									<p><span class="fbold txt-blue"><?php echo $count_applied;?></span> Jobs applied </p>
									</div>
							 		<center>You have not applied for jobs.</center>
									<?php } ?>
                               
					
						<?php	
                                 while($j_data = mysqli_fetch_array($r1)){ 
								  $shortlist_query="SELECT COUNT(JUser_Id) as num_shortlist, DATE_FORMAT(created, '%M %d %Y') as shortlist_date from tbl_shortlisted WHERE JUser_Id='".$row['JUser_Id']."' AND JobId='".$j_data['Job_Id']."'";
								 $is_shortlisted=false;
								 $shortlist_query_res=mysqli_query($con, $shortlist_query);
								 if(mysqli_num_rows($shortlist_query_res)!=0)
								 {
									$shortlist_result=mysqli_fetch_array($shortlist_query_res);
									 if($shortlist_result['num_shortlist'])
									{
										$is_shortlisted=true;
										$shortlist_date=$shortlist_result['shortlist_date'];
									}	 
								 }
								 $scheduled_query="SELECT DATE_FORMAT(scheduled_on,'%M %d %Y') as scheduled_date from interviewscheduled WHERE juser_id='".$row['JUser_Id']."' AND job_id='".$j_data['Job_Id']."' ORDER BY scheduled_on DESC";
								 $scheduled_query_res=mysqli_query($con,$scheduled_query);
								 $is_scheduled=false;
								 if(mysqli_num_rows($scheduled_query_res)!=0)
								 {
									 $is_scheduled=true;
									 $scheduled_res=mysqli_fetch_array($scheduled_query_res);
									 $scheduled_date=$scheduled_res['scheduled_date'];
								 }
								 $employerid=$j_data['emp_id'];
                                 $j_query1="select * from tbll_emplyer where emp_id='$employerid' ";  
								 $j_res1=mysqli_query($con,$j_query1);
                                 $j_data1=mysqli_fetch_array($j_res1);													?>
                                <div class="brdbg-white list-block">
                                    <div class="row job-title-list">
									<?php $sql2 = "SELECT Desig_Name FROM tbl_desigination where Desig_Id ='".$j_data['Job_Name']."'";
									$query2 = mysqli_query($con, $sql2);
									$row2 = mysqli_fetch_array($query2);?>
                                        <div class="col-md-9 col-sm-8 col-xs-8"> <a class="txt-blue" href="applied_jobdetail.php?uid=<?php echo $employerid;?>&jid=<?php echo $j_data['Job_Id'];?>"><?php echo $row2['Desig_Name']; ?> </a> <span><?php echo $j_data['Comp_Name'];?></span> 
                                        <div class="usermain-features">
                                        <ul>
                                            <li><i class="fa fa-suitcase" aria-hidden="true"></i> <?php echo $j_data['Min_Exp'];?>-<?php echo $j_data['Max_Exp'];?> Years</li>
                                         <?php    $loc_query="select Loc_Name from tbl_location where Loc_Id=".$j_data['Loc_Id'];  
                                          $loc_res=mysqli_query($con,$loc_query);
                                          $loc_data=mysqli_fetch_array($loc_res); ?>
                                            <li><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $loc_data['Loc_Name'];?></li>
                                            <li><i class="fa fa-calendar" aria-hidden="true"></i> 
                                            <?php $dateb=date_create($j_data['created']); echo $dob= date_format($dateb,"M d, Y");?></li>
											
											<li><a href="#addpayslip"><i class="fa fa-check" aria-hidden="true"></i>Job Status</a></li>
											
                                        </ul>
                                    </div>
                                        </div>
                                        <div class="col-md-3 col-sm-4 col-xs-4 text-right">
                                            <figure class="employer-logo">
                                                <?php if($j_data1['eLogo']!="") { ?> 
                                                    <img class="img-contain" data-object-fit="contain" src="<?php echo $j_data1['eLogo'];?>"> <?php } else { ?>
                                                     <img class="img-contain" data-object-fit="contain" src="img/your-logo.png">
                                                    <?php } ?>
                                            </figure>
                                        </div>
                                    </div>
                                    
                                    <div class=" list-emp-keyskills">
                                        <h6 class="h6">Key Skills</h6>
                                        <?php  $skill_ids=explode(",",$j_data['Job_Skill']); ?>

                                        <p> <?php foreach ($skill_ids as $skill_id) {

                                                     $s_query="select skill_Name from tbl_masterskills where skill_Id=".$skill_id;
                                                     $s_res=mysqli_query($con,$s_query);
                                                     $skill_name=mysqli_fetch_array($s_res);
                                                     ?> <span><?php echo $skill_name['skill_Name']; ?> </span><?php
                                                     
                                                   } ?></p>
                                    </div>
                                    <div class="sal-list-details">
                                    <?php   $emp_query="select * from tbll_emplyer where emp_id=".$employerid;  
                                          $emp_res=mysqli_query($con,$emp_query);
                                          $emp_data=mysqli_fetch_array($emp_res); ?>

                                        <p><b>CTC (Lacs) : </b>Min: <?php echo $j_data['Sal_Range']; ?> - Max: <?php echo $j_data['MSal_Range']; ?>
                                        <?php if($j_data['notshow_jobseeker']==0) { ?>
                                                        <span class="pull-right" title="Email:<?php echo $emp_data['emp_email']."&nbsp; Contact No:".$emp_data['contact_num'];  ?>"><b>Posted by : </b> <?php echo ucfirst($emp_data['contact_name']);?> 
                                                        </span>
                                                        <?php } else { ?>
                                                        <span class="pull-right" ><b>Posted by : </b> Confidential  </span>
                                                        <?php } ?> 
                                               <span class="pull-right" >
                                                <span class="ic-new">
                                                 <?php if($j_data['category_id']=='2'){ 
                                                  ?>
                                                  <img title="Hot Job" src="img/hotjobs-icon.png"> 
                                                   <?php  } else if($j_data['category_id']=='3'){ ?>
                                                 <img title="Premium Job" src="img/premium-jobs-icon.png"> 
                                                  <?php } else {?>
                                                 <img title="Featured Job" src="img/featured-jobs-icon.png">  
                                                 <?php } ?>
                                               </span>
                                           </span>
                                        </p>
                                    </div>
                                </div>
													<?php } ?>
                             
                            </div>
                        
                        </div>
                
                        <div class="col-md-3 col-sm-4">
                            
                            <div class="right-block-list" id="right-list">
                              
                                <div class="email-news brdbg-white">
                                    <h5 class="txt-blue h5">Application Summary</h5>
                                    <ul class="similar-links-list appliedlist noheight-list">
                                       
                                        <li><a href="appliedjobs.php?day=30">Applied jobs in last 30 days </a></li>
									 <li><a href="appliedjobs.php?day=15">Applied jobs in last 15 days </a></li>                            
									   <li><a href="appliedjobs.php?day=today">Applied jobs today </a></li>
                                    </ul>
                                </div>
                          
                            </div>
                          
                        </div>
                       
                    </div>
                </div>
            
            </section>
          
        </main>
 <div id="addpayslip" class="modal">
    <div class="modal-content">
        <h4 class="text-center">Job Status</h4>
        <div class="profile-pic-edit text-center">                   
            <table class="table skillstable table-bordered">
				<thead>
				<tr>
					<th>
					Status
					</th>
					<th>
					Date
					</th>
				</tr>
				</thead>
				<tbody>
				<tr>
				<?php if($is_shortlisted && $is_scheduled){ ?>
											<th>Scheduled</th>
											<?php } else if($is_shortlisted==true && $is_scheduled==false){ ?>
											<th>Shortlisted </th>
											<?php } ?>
											
				<?php if($is_shortlisted && $is_scheduled){ ?>
											<th><?php echo $scheduled_date; ?></th>
											<?php } else if($is_shortlisted==true && $is_scheduled==false){ ?>
											<th><?php echo $shortlist_date; ?> </th>
											<?php } ?>
				</tr>
				</tbody>
			</table>
        </div>
    </div>     
</div>
  
</body>

</html>