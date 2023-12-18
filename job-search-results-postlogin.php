<?php 
require_once 'class.user.php';
header('Cache-Control: no cache'); //no cache
 session_cache_limiter('private_no_expire');
session_start();
//require_once("config.php");


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
			{
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
		 $sjss="SELECT  count(profile_id)  as idcs FROM `tbl_notifications` WHERE `profile_id`='$userid' and `description`='Profile 100% completed'";	
		$ssjsres=mysqli_query($con,$sjss);
		$re_cj4=mysqli_fetch_array($ssjsres); 
		
	  if(($sqlressow['JuserStatus']=='Y')&&($re_cj4['idcs']==''))
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
	$admin_email="prashant@needyin.com";

							             $mm=$user_home->send_mail2($admin_email,$nt_message,$subject);
	  }
    }
		
		
	}


$actual_link = "$_SERVER[REQUEST_URI]";                     
$stmt = $user_home->runQuery("SELECT * FROM tbl_jobseeker u                         
                              WHERE u.JUser_Id=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
//print_r($row);
 $sqlj2= "SELECT * FROM tbl_currentexperience where JUser_Id='".$row['JUser_Id']."'";
//print_r($sqlj2);  
$resultj2 = mysqli_query($con,$sqlj2);
$jobrow=mysqli_fetch_array($resultj2);

$jskills=explode(",",$row['Job_Skills']);
$Ploc=$row['JPLoc_Id'];
$sal=$jobrow['ExpSalL'];


if($row['nri_status']=='Y')
{
       foreach($jskills as $skill)
        {
           
            
            $cj2="select * from tbl_jobposted where FIND_IN_SET('".$skill."', Job_Skill) and Job_Status='1' and adm_status='A' ORDER BY created DESC";                    
                $resultcj2 = mysqli_query($con,$cj2);  
                while($result_cj2=mysqli_fetch_array($resultcj2))
                {
                    $jobids[]=$result_cj2['Job_Id'];           
                 } 
                   $job_ids=array_filter(array_unique($jobids));     
                  $cc=count($job_ids); 
              
        } 
  }
  else
  {
    foreach($jskills as $skill)
        {
           
            
            $cj2="select * from tbl_jobposted where Loc_Id='$Ploc' and  FIND_IN_SET('".$skill."', Job_Skill) and Job_Status='1' and adm_status='A' ORDER BY created DESC";                    
                $resultcj2 = mysqli_query($con,$cj2);  
                while($result_cj2=mysqli_fetch_array($resultcj2))
                {
                    $jobids[]=$result_cj2['Job_Id'];           
                 } 
                   $job_ids=array_filter(array_unique($jobids));     
                  $cc=count($job_ids); 
              
        } 
  }
        foreach($jskills as $lang_id)
            {
                $cf="select flag from tbl_masterskills where skill_Id='".$lang_id."'"; 
                    $resultcf = mysqli_query($con,$cf);  
                    $result_cf=mysqli_fetch_array($resultcf); 
                    $flags[]=$result_cf['flag'];

              } 
           
              $flag_ids=array_filter(array_unique($flags));
              foreach($flag_ids as $flag_id)
            {
                $cf1="select skill_Id from tbl_masterskills where flag='".$flag_id."'"; 
                 $resultcf1 = mysqli_query($con,$cf1);  
                   while($result_cf1=mysqli_fetch_array($resultcf1))
                   {
                    $skills[]=$result_cf1['skill_Id'];
                   }
            }
			
              $skill_ids=array_filter(array_unique($skills));
                

              $new_skills=array_diff_assoc($skill_ids,$jskills);   
                                 
                  
             foreach ($new_skills as $skill_id)
              {
             $cjs="select Job_Skill from tbl_jobposted where Loc_Id='".$Ploc."' and Job_Status='1' and FIND_IN_SET('".$skill_id."', Job_Skill) and adm_status='A'"; 
			
                   $resultcjs = mysqli_query($con,$cjs);  
                   $result_count=mysqli_num_rows($resultcjs);
               
                   if($result_count>0)
                   {
                     
                 
                      $t_skillids[]=$skill_id;
                   }
                   
               }  
          $skillids=array_filter(array_unique($t_skillids));  
	  
          $sc=count(array_filter($skillids));
          $sks=implode(",",$skillids) ;

		
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
<script>
function GetJobs_skill(loc_id,skill_id)
{
 
    var xmlhttp;
    if (window.XMLHttpRequest)
      {
      xmlhttp=new XMLHttpRequest();
      }
    else
      {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
       
        document.getElementById("job-list").innerHTML=xmlhttp.responseText;
     
       
        }
      }
    xmlhttp.open("GET","similarskill_jobs.php?loc_id="+loc_id+"&skill_id="+skill_id,true);
    xmlhttp.send();
}

function validateemail()
{
 
  if(!emailverify(document.getElementById('email-yours').value))
  {
    
    document.getElementById('email-yours').focus();
    return false;
 
  }
}</script>
    <?php
			  include_once("analyticstracking.php");
			  include "postlogin-header-jobseekar.php" ;?>
        <!-- main-->
        <main>
           <?php include "inner-menu.php";?>
            <!-- search results, job list -->
            <section class="job-list">
                <div class="container">
                    <ul class="bcrumb-listjobs">
                        <li> <a href="index.php">Home</a> </li>
                        <li> <a href="jobseeker-profile.php"><?php echo $row['JFullName'] ?></a> </li>
                        <li> <a>All Latest Jobs</a> </li>
                    </ul>
                </div>
               
                <!-- row-->
                <div class="container">
                    <div class="row">
                      <!-- right block -->
                        <div class="col-md-3 col-sm-4 col-xs-12 moveright">
                            <!-- right block page -->
                            <div class="right-block-list" id="right-list">
                                <!-- email letter-->
                                <div class="email-news brdbg-white">
                                    <h5 class="txt-blue h5">Get Email Alert for Matching jobs</h5>
                                    <form  name="" method="post" action="subscriberinfo.php">
                                    <div class="mail-input brdbg-white">
                                        <div class="input-field ">
                                            <input name="subcribe-email" id="email-yours" type="email" class="validate" required>
                                            <label for="email-yours">Enter your email</label>
                                        </div>  <input type="hidden" name="current_page" value="<?php echo $actual_link?>">
                                        <input type="submit" name="Subs" class="waves-effect waves-light btn btn-blue-sm btn-block" value="Subscribe" onclick="return validateemail()">
                                        
                                        </div>
                                    </form>
                                </div>
                                <!--/ email letter-->
                                <!-- jobs with similar skills -->
                                    <div class="email-news brdbg-white">
                                        <h5 class="txt-blue h5">Jobs With Similar Skills</h5>
                                        <h6 class="h6"><?php if($sc!='0') { ?>Click below here <?php } else { ?>No skills <?php } ?> </h6>
                                        <ul class="similar-links-list noheight-list">
                                       <?php   if($sc!='0')
                                        {
                                      foreach ($skillids as $skill_id) {

                                                     $s_query="select skill_Name,skill_Id from tbl_masterskills where skill_Id=".$skill_id;
                                                     $s_res=mysqli_query($con,$s_query);
                                                     $skill_name=mysqli_fetch_array($s_res);
                                                     ?>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="GetJobs_skill('<?php echo $Ploc;?>','<?php echo $skill_name['skill_Id']; ?>');">
                                                            <?php echo $skill_name['skill_Name']; ?>
                                                        </a>
                                                    </li>
                                                    <?php
                                                     
                                                   } ?>
                                            <?php  }  ?>
                                           
                                        </ul>
                                    </div>
                                    <!-- jobs with similar skills -->
                            </div>
                            <!-- / right block page -->
                        </div>
                        <!--/ right block -->
                       
                        <!-- middle list jobs -->
                        <div class="col-md-9 col-sm-8 col-xs-12 ">
                            <!-- middle list jobs -->
                             <div class="job-list" id="job-list">
                                <div class="noofjobs brdbg-white">
                                    <p><span class="fbold txt-blue"><?php echo $cc;?></span> Jobs found </p>
                                </div>
                                <!-- job list block -->
                            
                                <?php  
                                if($cc!='0')
                                { 
                                  $x=1;
                                foreach($job_ids as $job_id)
                                    {  
                                          $j_query="select * from tbl_jobposted where Job_Id=".$job_id;  
                                          $j_res=mysqli_query($con,$j_query);
                                          $j_data=mysqli_fetch_array($j_res);

                                           $j_query1="select * from tbll_emplyer where emp_id='".$j_data['emp_id']."' ";  
                                          $j_res1=mysqli_query($con,$j_query1);
                                          $j_data1=mysqli_fetch_array($j_res1);
                                        ?> 
                                <div class="brdbg-white list-block">
                                    <div class="row job-title-list">
									<?php $sql2 = "SELECT * FROM tbl_desigination where Desig_Id ='".$j_data['Job_Name']."'";
									   $query2 = mysqli_query($con, $sql2);
									   $row2 = mysqli_fetch_array($query2);?>
                                        <div class="col-md-9 col-sm-8 col-xs-8"> <a class="txt-blue" href="latest_jobdetail.php?uid=<?php echo $j_data['emp_id'];?>&jid=<?php echo $j_data['Job_Id'];?>&skill=<?php echo $sks;?>"><?php echo $row2['Desig_Name'];?>
                                          <?php
                                              $sche_id="select count(JUser_Id) as appliedId FROM tbl_applied where JUser_Id='".$userid."' and  JobId='".$job_id."'";
                                              $sc_id=mysqli_query($con,$sche_id);
                                              $sche_res = mysqli_fetch_array($sc_id);
                                              if($sche_res['appliedId'] !=0){?>
                                                 <span class="green-tag"> Applied</span>
                                              <?php } 
                                              else {
                                                     $jobViewed="select count(JUser_Id) as viewJob FROM tbl_jobseekerview where JUser_Id='".$userid."' and  job_id='".$job_id."'";
                                                      $viewedId=mysqli_query($con,$jobViewed);
                                                      $viewedCount = mysqli_fetch_array($viewedId);
                                                      if($viewedCount['viewJob'] !=0){?>
                                                       <span class="viewed-rec">Viewed</span>
                                                    <?php }
                                               } ?>  
                                           </a> 
                                           <div>
                   
                                           </div>
                                        <span><?php echo $j_data['Comp_Name'];?></span> 

                                        <div class="usermain-features">
                                        <ul>
                                            <li><i class="fa fa-suitcase" aria-hidden="true"></i> <?php echo $j_data['Min_Exp'];?>-<?php echo $j_data['Max_Exp'];?> Years</li>
                                         <?php    $loc_query="select * from tbl_location where Loc_Id=".$j_data['Loc_Id'];  
                                          $loc_res=mysqli_query($con,$loc_query);
                                          $loc_data=mysqli_fetch_array($loc_res); ?>
                                            <li><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $loc_data['Loc_Name'];?></li>
                                            <li><i class="fa fa-calendar" aria-hidden="true"></i> 
                                            <?php $dateb=date_create($j_data['created']); echo $dob= date_format($dateb,"M d,Y");?>											
											</li>
                                        </ul>
                                    </div>
                                        </div>
                                        <div class="col-md-3 col-sm-4 col-xs-4 text-right">
                                            <figure class="prelogo image-container">
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
									<!--Mouli Implement -->
									<div>									
									</div>		
							<!--Mouli Implement -->									
                                    <div class="sal-list-details">
                                    <?php   
										$emp_query="select * from tbll_emplyer where emp_id=".$j_data['emp_id'];  
                                        $emp_res=mysqli_query($con,$emp_query);
                                        $emp_data=mysqli_fetch_array($emp_res); 
									?>
                                        <p><b>CTC (Lacs) : </b>Min: <?php echo $j_data['Sal_Range']; ?> - Max: <?php echo $j_data['MSal_Range']; ?>
                                          
									   
                                     <?php   if($j_data['notshow_jobseeker']==0) { ?>
                                          <span class="pull-right" title="Email:<?php echo $emp_data['emp_email']."&nbsp; Contact No:".$emp_data['contact_num'];  ?>"><b>Posted by : </b> <?php echo ucfirst($emp_data['contact_name']);?>  </span>
                                           <?php } else { ?>
                                           <span class="pull-right">
                                               <b>Posted by : </b> Confidential
                                           </span>

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
										
                                <!--/ job list block -->
                            <?php 
                              if(isset($_POST['Subs'])=="" && $x=="10") {
								  	if($cc>=10){ 
							?>
							<form method="post" action="">
								<input type="submit" name="Subs" class="btn waves-effect waves-light fbold text-center waves-input-wrapper" value="Load More">
							</form>
							<?php } 
								 exit();
							  }else{  
							  
							   }

                            $x++; 
							?>			
						<?php
                          }		  
                            } else { ?>
                                            <center>No Jobs found matching with your Skills and Location</center>
                                            <?php   }?>

                         <!-- middle list jobs -->
                        </div>
					
                        <!--/ middle list jobs -->
                    </div>
                </div>
                <!--/ row-->
                </div>
            </section>
            <!--/search results, job list -->
        </main>
        <!--/main-->
<script>
function GetJobs_skill(loc_id,skill_id)
{
 
    var xmlhttp;
    if (window.XMLHttpRequest)
      {
      xmlhttp=new XMLHttpRequest();
      }
    else
      {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
      
        document.getElementById("job-list").innerHTML=xmlhttp.responseText;
   
       
        }
      }
    xmlhttp.open("GET","similarskill_jobs.php?loc_id="+loc_id+"&skill_id="+skill_id,true);
    xmlhttp.send();
}

function validateemail()
{
	
	if(!emailverify(document.getElementById('email-yours').value))
	{
		
		document.getElementById('email-yours').focus();
		return false;
		
		
	}
}
 </script>
</body>
</html>