<?php 
header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire');
session_cache_limiter('public'); 
require_once("config.php");
require_once 'class.user.php';
$user_home = new USER();

$stmt = $user_home->runQuery("SELECT * FROM tbl_jobseeker u                         
                              WHERE u.JUser_Id=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
 $uid=$_GET['uid'];
  $jid=$_GET['jid'];
 $sql1= "SELECT J.*,qo.Qual_Name,Ed.contact_name,L.Loc_Name,I.Indus_Name,F.Func_Name,Ed.companyname,Ed.company_type,Ed.address1,Ed.contact_num,Ed.emp_email
                                    FROM tbl_jobposted J        
                                    LEFT JOIN tbl_location L on J.Loc_Id=L.Loc_Id
                                    LEFT JOIN tbl_industry I on J.PIndus_Id=I.Indus_Id
                                    LEFT JOIN tbl_functionalarea F on J.PFunc_Id=F.Func_Id                                  
                                    LEFT JOIN tbll_emplyer Ed on J.emp_id= Ed.emp_id 
                                    LEFT JOIN tbl_qualification qo on J.PEduc_Id=qo.Qual_Id
                                    where J.emp_id='".$uid."' AND J.Job_Id='".$jid."'";                             
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
  if(isset($_SESSION['userSession']))
        {
             include "postlogin-header-jobseekar.php"; 
        } else {
    include "prelogin-header.php"; 
    } ?>
        <div id="apply-thisjob" class="snackbar"><span><i class="fa fa-check" aria-hidden="true"></i></span> You have successfully applied this job</div>
        <!-- main-->
        <main>
            <!-- Job Detail -->
            <section class="job-detail">
                <!-- job list header -->
                <div class="job-list-header">
                    <div class="container">
                        <!-- search -->
                        <div class="row search-home nomrg">
                            <div class="search-home-in">
                                <div class="row">
                                <?php require_once "search.php";?>
                                </div>
                            </div>
                        </div>
                        <!-- / search -->
                    </div>
                </div>
                <!-- / job list header -->
                <!-- bread crumb-->
         <?php   $result1 = mysqli_query($con,$sql1); 
                                        
                                    while ($rowview2 = mysqli_fetch_array($result1)) {?>
               <div class="container">
                    <ul class="bcrumb-listjobs">
					<?php $sql2 = "SELECT * FROM tbl_desigination where Desig_Id ='".$rowview2['Job_Name']."'";
										$query2 = mysqli_query($con, $sql2);
										$row2 = mysqli_fetch_array($query2);?>
                        <li> <a href="index.php">Home</a> </li>
                        <li> <a href="job-search-results-prelogin.php">Search Results</a> </li>
                        <li> <a><?php echo $row2['Desig_Name']; ?></a> </li>
                    </ul>
                </div>
                <!--/bread crumb-->
                <!-- row-->
                <div class="container">
                    <div class="row">
                        <!-- job detail block -->
                        <div class="col-md-9">
                            <div class="job-detail-block brdbg-white">
                                <!-- detial header -->
                                <div class="job-detail-header row">
                                    <div class="col-md-10">
                                        <div class="jobheader-title">
										
                                            <h4 class="txt-blue h4"><?php echo $row2['Desig_Name']; ?></h4>
                                            <h5 class="h5 comp-name"><?php echo $rowview2['Comp_Name']; ?> <span> <?php echo $rowview2['Comp_Url']; ?></span></h5>
                                            <div class="usermain-features">
                                                <ul>
                                                    <li><i class="fa fa-suitcase" aria-hidden="true"></i> <?php echo $rowview2['Min_Exp']; ?>-<?php echo $rowview2['Max_Exp']; ?> Years</li>
                                                    <li><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $rowview2['Loc_Name']; ?>    </li>
                                                    <li><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo $rowview2['created']; ?> created on</li>
                                                </ul>
                                            </div>
                                          <!-- <form name="" method="post" action="applied.php">-->
                                          <form name="" method="post" >
                               <input type="hidden" name="juserid" value="<?php echo $row['JUser_Id']; ?>">
                               <input type="hidden" name="empid" value="<?php echo $uid; ?>">
                               <input type="hidden" name="jobid" value="<?php echo $jid; ?>">
                                <input type="submit" name="apply" value="Apply Now" data-position="bottom" class="btn tooltipped"  
                                onclick="window.location.href='login.php'" data-tooltip="Apply Now" id="applybtn">
                                </form>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <figure><img src="img/google-logo.png"> </figure>
                                    </div>
                                </div>
                                <!--/detail header -->
                                <!-- detail body -->
                                <!-- basic detail -->
                                <div class="basic-detailstab">
                                    <table cellpadding="0" ; cellspacing="0">
                                        <tr>
                                            <td><span class="txt-blue">Job title</span></td>
                                            <td>:<?php echo $row2['Desig_Name']; ?></td>
                                            <td><span class="txt-blue">Position type</span></td>
                                            <td>:<?php echo $rowview2['PJobtype']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><span class="txt-blue">Experience</span></td>
                                            <td>:<?php echo $rowview2['Min_Exp']; ?>-<?php echo $rowview2['Max_Exp']; ?> years</td>
                                            <td><span class="txt-blue">Location</span></td>
                                            <td>:<?php echo $rowview2['Loc_Name']; ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <!--/ basic details -->
                                <!-- list description -->
                                <div class="list-description">
                                    <h4 class="h4 txt-blue">Job Description: </h4>
                                    <p>
                                     <?php echo $rowview2['Job_Desc']; ?>
									</p>                                    
                                </div>
                                <!--/ list description -->
                                <!-- list description -->
                                <div class="list-description">
                                    <h4 class="h4 txt-blue">Qualification</h4>
                                    <ul>
                                        <li><?php echo $rowview2['Qual_Name']; ?></li>
                                        
                                    </ul>
                                    <table class="subtable">
                                        <tr>
                                            <td>Salary </td>
                                            <td>: <?php echo $rowview2['Sal_Range']; ?> LAKHS</td>
                                        </tr>
                                        <tr>
                                            <td>Industry</td>
                                            <td>: <?php echo $rowview2['Indus_Name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Functional Area</td>
                                            <td>: <?php echo $rowview2['Func_Name']; ?></td>
                                        </tr>
                                     
                                    </table>
                                </div>
                                <!--/ list description -->
                                <!-- key skills -->
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
                                <!--/ key skills -->
                                <!-- view contact details -->
                                <div class="keyskills-detail">
                                    <h5 class="h5 txt-blue" id="rec-cont-det">Recruiter Contact Details</h5>
									<?php if($rowview2['notshow_jobseeker']==0) {?> 
                                    <div class="Recruiter-contact-details">
                                        <table class="table" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td>Recruiter Name:</td>
                                                <td><?php echo $rowview2['contact_name']; ?> </td>
                                            </tr>
                                            <tr>
                                                <td>Website</td>
                                                <td><a href="<?php echo $rowview2['Comp_Url']; ?>" target="_blank"><?php echo $rowview2['Comp_Url']; ?></a></td>
                                            </tr>
                                            <tr>
                                                <td>Address</td>
                                                <td><?php echo $rowview2['address1']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Contact Details</td>
                                                <td><?php echo $rowview2['contact_num']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Email ID</td>
                                                <td><?php echo $rowview2['emp_email']; ?></td>
                                            </tr>
                                        </table>
                                    </div>
									<?php } ?>
                                </div>
                                <!--/ view contact details -->
                               <!-- <button  type="submit"  data-delay="50"  > </button>-->
                               <form name="" method="post" >
                               <input type="hidden" name="juserid" value="<?php echo $row['JUser_Id']; ?>">
                               <input type="hidden" name="empid" value="<?php echo $uid; ?>">
                               <input type="hidden" name="jobid" value="<?php echo $jid; ?>">
                                <input type="button" name="apply" value="Apply Now" data-position="bottom" class="btn tooltipped" data-tooltip="Apply Now" id="applybtn" onclick="window.location.href='login.php'">
                                </form>
                                <!-- / detail body -->
                            </div>
                        </div>
                        <!--/ job detail block -->
                        <!-- similar jobs -->
                        <div class="col-md-3">
                            <div class="similar-jobs brdbg-white">
                                <h4 class="h4 search-filter-title">Similar Jobs</h4>
                                <ul class="similar-list">
                                    <?php	 $languages=$rowview2['Job_Skill'];   
							        $lang_ids=explode(",",$languages);
						
						foreach($lang_ids as $lang_id)
						 {
							  $cj2="select * from tbl_jobposted where FIND_IN_SET('".$lang_id."', Job_Skill) "; 
							  $resultcj2 = mysqli_query($con,$cj2);  
							  while($result_cj2=mysqli_fetch_array($resultcj2))
							  {								  
							  $job_ids[]=$result_cj2['Job_Id'];
							  }
							  
						} 
						
						$jobs=array_unique($job_ids);
						$cc=count(array_filter($job_ids));
						 if($cc!='0')
                                {
                                foreach($jobs as $job_id)
			                     	{  
                                         $j_query="select * from tbl_jobposted where Job_Id=".$job_id;  
                                          $j_res=mysqli_query($con,$j_query);
                                          $j_data=mysqli_fetch_array($j_res);
										
                                        ?> 
                                    <li> <a class="txt-blue" href="job-detail-postlogin.php?uid=<?php echo $j_data['emp_id'] ?>&jid=<?php echo $j_data['Job_Id'] ?>"><?php echo $row2['Desig_Name'];?> <span><?php echo $j_data['Min_Exp'];?>-<?php echo $j_data['Max_Exp'];?> Years | <?php  $j_query1="select Loc_Name from tbl_location where Loc_Id=".$j_data['Loc_Id'];  
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
								<?php } }?>
                                </ul>
                            </div>
                        </div>
                        <!-- / similar jobs -->
                    </div>
                </div>
<?php } ?>
            </section>
            <!--/job detail -->
        </main>
        <!--/main-->
</body>

</html>
    