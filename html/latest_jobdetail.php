<?php 
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{ ?>
<script>alert("Please Login");
window.location.href="index.php";
</script>
<?php 
  //$user_home->redirect('index.php');
}
            
$stmt = $user_home->runQuery("SELECT * FROM tbl_jobseeker  WHERE JUser_Id=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
 $uid=$_GET['uid'];
$jid=$_GET['jid'];
$sql1= "SELECT J.*,qo.Qual_Name,Ed.contact_name,L.Loc_Name,I.Indus_Name,F.Func_Name,Ed.companyname,Ed.eLogo,Ed.company_type,Ed.address1,Ed.contact_num,Ed.emp_email
                  FROM tbl_jobposted J    
                  LEFT JOIN tbl_location L on J.Loc_Id=L.Loc_Id
                  LEFT JOIN tbl_industry I on J.PIndus_Id=I.Indus_Id
                  LEFT JOIN tbl_functionalarea F on J.PFunc_Id=F.Func_Id                  
                  LEFT JOIN tbll_emplyer Ed on J.emp_id= Ed.emp_id 
                  LEFT JOIN tbl_qualification qo on J.PEduc_Id=qo.Qual_Id
                  where J.emp_id='".$uid."' AND J.Job_Id='".$jid."'";     
$result1 = mysqli_query($con,$sql1); 
$cc=mysqli_num_rows($result1);   
$rowview2 = mysqli_fetch_array($result1);  
  
$jskills="SELECT Job_Skills,JTotalEy,cur_expl.ExpSalL,cur_expl.ExpMaxSalL from tbl_jobseeker INNER JOIN tbl_currentexperience as cur_expl on cur_expl.JUser_Id = tbl_jobseeker.JUser_Id where tbl_jobseeker.JUser_Id = '".$_SESSION['userSession']."'";
$jobfitresult = mysqli_query($con,$jskills);   
$jobfitmentrow = mysqli_fetch_array($jobfitresult);  

$jobfitskills=explode(',',$jobfitmentrow['Job_Skills']);
$empskills=explode(',',$rowview2['Job_Skill']);
$common_skills=array_intersect($jobfitskills,$empskills);
$skill_percent=(count($common_skills)/count($jobfitskills))*100;

if($jobfitmentrow['JTotalEy']>=$rowview2['Min_Exp'])
{
    $exp_percent=100;
}
else
{
    $exp_percent=($jobfitmentrow['JTotalEy']/$rowview2['Min_Exp'])*100;
}
if($jobfitmentrow['ExpMaxSalL']>=$rowview2['Sal_Range'])
{
    $ctc_percent=100;
}
else
{
    $ctc_percent=($jobfitmentrow['ExpMaxSalL']/$rowview2['Sal_Range'])*100;
}
$overall=($skill_percent+$exp_percent+$ctc_percent)/3;
if(isset($_SESSION['userSession']))
{
$jobseekerid=$_SESSION['userSession'];
$sqlinsert="INSERT INTO `tbl_jobseekerview` (`emp_id`, `JUser_Id`, `job_id`) VALUES ('$uid','$jobseekerid','$jid')";
mysqli_query($con,$sqlinsert);
}	  
$actual_link = "$_SERVER[REQUEST_URI]"; 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
 <script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>
     <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>

<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
    <style>
        body {
            font-family: "Arial", sans-serif;
        }
        
        .bar {
            fill: #5f89ad;
        }
        
        .axis {
            font-size: 10px;
        }
        
        .axis path,
        .axis line {
            fill: none;
            display: none;
        }
        
        .label {
            font-size: 10px;
        }
    </style> 
    <!-- css includes-->
    <?php include"source2.php" ?>
</head>

<body>
    <?php 
	include_once("analyticstracking.php");
	include "postlogin-header-jobseekar.php" ;?>
        <!-- main-->
        <main>
            <?php include "inner-menu.php" ;?>

            <?php $sql2 = "SELECT * FROM tbl_desigination where Desig_Id ='".$rowview2['Job_Name']."'";
												$query2 = mysqli_query($con, $sql2);
                                                $row2 = mysqli_fetch_array($query2);
                                                $design_name=$row2['Desig_Name'];

                                   ?>
            <!-- search results, job list -->
            <section class="job-list">
                <div class="container">
                    <ul class="bcrumb-listjobs">
                        <li> <a href="index.php">Home</a> </li>
                        <li> <a href="job-search-results-postlogin.php">Latest Jobs</a> </li>
                        <li> <a><?php echo $row2['Desig_Name']; ?></a> </li>
                    </ul>
                </div>
               
                <!-- row-->
                <div class="container">
                    <div class="row">
                      <div class="col-md-9 col-sm-8">
                            <div class="job-detail-block brdbg-white">
                                <!-- detial header -->
                                <div class="job-detail-header row">
                                    <div class="col-md-9 col-sm-8 col-xs-9">
                                        <div class="jobheader-title">
                                            <h4 class="txt-blue h4"><?php echo $row2['Desig_Name']; ?></h4>
                                            <h5 class="h5 comp-name"><?php echo $rowview2['Comp_Name']; ?> <span> <?php echo $rowview2['Comp_Url']; ?></span></h5>
                                            <div class="usermain-features">
                                                <ul>
                                                    <li><i class="fa fa-suitcase" aria-hidden="true"></i> <?php echo $rowview2['Min_Exp']; ?>-<?php echo $rowview2['Max_Exp']; ?> Years</li>
                                                    <li><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $rowview2['Loc_Name']; ?>  </li>
                                                    <li><i class="fa fa-calendar" aria-hidden="true"></i> 
								
													<?php $dateb=date_create($rowview2['created']); echo $dob= date_format($dateb,"M d,Y"); ?> Created </li>
                                                </ul>
                                            </div>
                                            <div id="graphic"></div>
                                            <div class = "row">
                                            <div id="container" class="col-md-6" style="width: 400px; height: 190px; margin-left: 5px "></div>
                                            <div id="container-speed" class="col-md-4" style="width: 220px; height: 190px; margin-bottom: 5px"></div> 
                                            </div>


                                            <script>
Highcharts.chart('container', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Job Fitment'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        max:100,
        title: {
            text: 'Percentage'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            pointWidth: 5,
            dataLabels: {
                enabled: true,
                format: '{point.y:.1f}%'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
    },

    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [{
            name: 'Salary',
            y: <?php echo intval($ctc_percent); ?>
           
        }, {
            name: 'Experience',
            y: <?php echo intval($exp_percent); ?>
           
        }, {
            name: 'Skills',
            y: <?php echo intval($skill_percent); ?>
        }]
    }],
   
});
</script>   
<?php
$overall =   ( intval($ctc_percent)+ intval($exp_percent)+  intval($skill_percent))/3;
  ?>    

 <script>
var gaugeOptions = {

    chart: {
        type: 'solidgauge'
    },

    title: null,

    pane: {
        center: ['50%', '85%'],
        size: '85%',
        startAngle: -90,
        endAngle: 90,
        background: {
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
            innerRadius: '60%',
            outerRadius: '100%',
            shape: 'arc'
        }
    },

    tooltip: {
        enabled: false
    },

    // the value axis
    yAxis: {
        stops: [
            [0.1, '#DF5353'], // green
            [0.5, '#DDDF0D'], // yellow
            [0.9, '#55BF3B'] // red
        ],
        lineWidth: 2,
        minorTickInterval: null,
        tickAmount: 2,
        title: {
            y: -70
        },
        labels: {
            y: 16
        }
    },

    plotOptions: {
        solidgauge: {
            dataLabels: {
                y: 5,
                borderWidth: 0,
                useHTML: true
            }
        }
    }
};

// The speed gauge
var chartSpeed = Highcharts.chart('container-speed', Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: 0,
        max: 100,
        title: {
            text: '<span style="font-size:17px;color:black">Overall Average</span>'
        }
    },

    credits: {
        enabled: false
    },

    series: [{
        name: '<span style="font-size:20px;color:black">Overall Average</span>',
        data: [<?php echo intval($overall) ; ?>],
        dataLabels: {
            format: '<div style="text-align:center"><span style="font-size:15px;color:' +
                ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}%</span><br/>'/* +
                   '<span style="font-size:10px;color:silver">Overall Average</span></div>'*/
        },
        tooltip: {
            valueSuffix: 'Overall Average'
        }
    }]

}));


</script> 

                                          <form name="applyedJob" method="post" action="latestjob_applied.php">
											  <input type="hidden" name="juserid" value="<?php echo $row['JUser_Id']; ?>">
											  <input type="hidden" name="empid" value="<?php echo $uid; ?>">
											  <input type="hidden" name="jobid" value="<?php echo $jid; ?>">
											  <input type="hidden" name="skillsid" value="<?php echo $rowview2['Job_Skill'];?>">
											 <?php  $qq="select aId from tbl_applied where JUser_Id='".$row['JUser_Id']."' and emp_id='".$uid."' and JobId='".$jid."'";
												   $qq_res=mysqli_query($con,$qq);
												   $qq_data=mysqli_fetch_array($qq_res);
												   $a_id=$qq_data['aId'];
												   if($a_id==""){ ?>



                                                   
											  <input type="submit" name="apply" value="Apply Now" data-position="bottom" onClick= "return applyNow()" class="btn"  id="applybtn">
													<?php } else { ?>
											  <input type="" name="apply" value="Already Applied" data-position="bottom" class="btn tooltipped btn disabled" >
													<?php } ?>
                                                    
													<div style="
    position: absolute;
    right: -171px;
    top: 219px;
"> 
													 
													<a href="http://www.linkedin.com/shareArticle?mini=true&title=Designation:<?php echo $row2['Desig_Name']; ?>,Job Posted by:<?php echo $rowview2['contact_name']; ?>,Job Description:<?php echo htmlspecialchars_decode($rowview2['Job_Desc']);?>&url=http://www.dev.needyin.com/dev/share_job.php?jid=<?php echo $_GET['jid']; ?>"target="_blank"><img src="https://www.needyin.com/img/linkedin-icon.png" height="40"></a> 
							 
							 <a href="https://www.facebook.com/dialog/share?app_id=1469273143150597&display=popup&title=This+is+the+title+parameter&description=This+is+the+description+parameter
&quote=Designation:<?php echo $row2['Desig_Name']; ?>,Job Posted by:<?php echo $rowview2['contact_name']; ?>,Job Description:<?php echo htmlspecialchars_decode($rowview2['Job_Desc']);?>&caption=This+is+the+caption+parameter&href=http://www.dev.needyin.com/dev/share_job.php?jid=<?php echo $_GET['jid']; ?>&redirect_uri=https://www.needyin.com/share_job.php?jid=<?php echo $_GET['jid']; ?>" target="_blank"><img src="https://www.needyin.com/img/fb-icon.png" height="40"></a>

<a href="https://plus.google.com/share?url=http://www.dev.needyin.com/dev/share_job.php?jid=<?php echo $_GET['jid']; ?>&text=Designation:<?php echo $row2['Desig_Name']; ?>,Job Posted by:<?php echo $rowview2['contact_name']; ?>,Job Description:<?php echo htmlspecialchars_decode($rowview2['Job_Desc']);?>." target="_blank"><img src="https://www.needyin.com/img/google-icon.png" height="40"></a>

       
							<a href="https://twitter.com/share?url=http://www.dev.needyin.com/dev/share_job.php?jid=<?php echo $_GET['jid']; ?>&text=Designation:<?php echo $row2['Desig_Name']; ?>,Job Posted by:<?php echo $rowview2['contact_name']; ?>,Job Description:<?php echo htmlspecialchars_decode($rowview2['Job_Desc']);?>." target="_blank"><img src="https://www.needyin.com/img/tweet-icon.jpg" height="40"></a>
							</div>
											</form>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-3 text-right">
                                         <figure class="prelogo-detail">
											<?php if($rowview2['eLogo']!="") { ?> 
											<img src="<?php echo $rowview2['eLogo'];?>" ><?php } else {?><img src="img/your-logo.png" ><?php } ?>
                                         </figure>										
                                    </div>
                                </div>
                                <!--/detail header -->
                                <!-- detail body -->
                                <!-- basic detail -->
                                <div class="basic-detailstab">
                                  
                                   
                                   <ul>
                                       <li><span class="txt-blue">Job Title</span> <span><?php echo $row2['Desig_Name']; ?></span></li>
                                       
                                       <li><span class="txt-blue">Position Type</span> <?php echo $rowview2['PJobtype']; ?></li>
                                       
                                        <li><span class="txt-blue">Experience</span> <?php echo $rowview2['Min_Exp']; ?>-<?php echo $rowview2['Max_Exp']; ?> Years</li>
                                       
                                       <li><span class="txt-blue">Location</span> <?php echo $rowview2['Loc_Name']; ?></li>
                                   </ul>
                                   
                                   
                                   
                                </div>
                                <!--/ basic details -->
                                <!-- list description -->
                                <div class="list-description">
								<h4 class="h4 txt-blue">Job Description: </h4>                                                          
								<p><?php echo htmlspecialchars_decode($rowview2['Job_Desc']); ?></p>
                                </div>
                                <!--/ list description -->
                                <!-- list description -->
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
									</ul>
                                    <table class="subtable">
                                         <tr>
                                            <td>CTC Range(Lacs)</td>
                                           <?php if( $rowview2['Sal_Range'] || $rowview2['MSal_Range']){?>
                                            <td>: Min: <?php echo $rowview2['Sal_Range']; ?> - Max: <?php echo $rowview2['MSal_Range']; ?></td>
                                       <?php     } else{ ?>
                                        <td>: Not Available</td>
                                      <?php } ?>
                                     
                                        </tr>
                                        <tr>
                                            <td>Industry</td>
                                           
                                            <?php if($rowview2['Indus_Name'] != ""){?>
                                                <td>: <?php echo $rowview2['Indus_Name']; ?></td>
                                       <?php     } else{ ?>
                                        <td>: Not Available</td>
                                      <?php } ?>
                                            
                                        </tr>
                                        <tr>
                                            <td>Functional Area</td>
                                    
                                            <?php if($rowview2['Func_Name'] != ""){?>
                                                <td>: <?php echo $rowview2['Func_Name']; ?></td>
                                       <?php     } else{ ?>
                                        <td>: Not Available</td>
                                      <?php } ?>
                                          
                                        </tr>
                                      <!--  <tr>
                                            <td>Role Category</td>
                                            <td>: <?php //echo $rowview2['Sal_Range']; ?></td>
                                        </tr
                    
                                        <tr>
                                            <td>Role</td>
                                            <td>: Software Developer</td>
                                        </tr>-->
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
								 <?php if($rowview2['notshow_jobseeker']==0) {?> 
                                <div class="keyskills-detail">
                                    <h5 class="h5 txt-blue" id="rec-cont-det">Recruiter Contact Details</h5>
                 
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
                                <!--/ view contact details -->
                               <!-- <button  type="submit"  data-delay="50"  > </button>-->
<br>
                 <form name="" method="post" action="latestjob_applied.php">
                 <input type="hidden" name="juserid" value="<?php echo $row['JUser_Id']; ?>">
                 <input type="hidden" name="empid" value="<?php echo $uid; ?>">
                 <input type="hidden" name="jobid" value="<?php echo $jid; ?>">
				  <input type="hidden" name="skillsid" value="<?php echo $rowview2['Job_Skill'];?>">
              <?php   
               if($a_id==""){ ?>
                      <input type="submit" name="apply" value="Apply Now" data-position="bottom" class="btn"  id="applybtn">
                            <?php } else { ?>
                      <input type="" name="apply" value="Already Applied" data-position="bottom" class="btn tooltipped btn disabled">
                            <?php } ?>
<div style="
    position: absolute;
    right: 56px;
    top: 745px;
">                           
						   <a href="http://www.linkedin.com/shareArticle?mini=true&title=Designation:<?php echo  $design_name; ?>,Job Posted by:<?php echo $rowview2['contact_name']; ?>,Job Description:<?php echo htmlspecialchars_decode($rowview2['Job_Desc']);?>&url=http://www.dev.needyin.com/share_job.php?jid=<?php echo $_GET['jid']; ?>" target="_blank"><img src="https://www.needyin.com/img/linkedin-icon.png" height="40"></a> 
							 
							 <a href="https://www.facebook.com/dialog/share?app_id=1469273143150597&display=popup&title=This+is+the+title+parameter&description=This+is+the+description+parameter
&quote=Designation:<?php echo $design_name; ?>,Job Posted by:<?php echo $rowview2['contact_name']; ?>,Job Description:<?php echo htmlspecialchars_decode($rowview2['Job_Desc']);?>&caption=This+is+the+caption+parameter&href=https://www.needyin.com/dev/share_job.php?jid=<?php echo $_GET['jid']; ?>&redirect_uri=http://www.dev.needyin.com/share_job.php?jid=<?php echo $_GET['jid']; ?>"target="_blank"><img src="https://www.needyin.com/img/fb-icon.png" height="40"></a>

<a href="https://plus.google.com/share?url=http://www.dev.needyin.com/share_job.php?jid=<?php echo $_GET['jid']; ?>&text=Designation:<?php echo  $design_name; ?>,Job Posted by:<?php echo $rowview2['contact_name']; ?>,Job Description:<?php echo htmlspecialchars_decode($rowview2['Job_Desc']);?>." target="_blank"><img src="https://www.needyin.com/img/google-icon.png" height="40"></a>

       
							<a href="https://twitter.com/share?url=http://www.dev.needyin.com/share_job.php?jid=<?php echo $_GET['jid']; ?>&text=Designation:<?php echo $design_name; ?>,Job Posted by:<?php echo $rowview2['contact_name']; ?>,Job Description:<?php echo htmlspecialchars_decode($rowview2['Job_Desc']);?>."target="_blank"><img src="https://www.needyin.com/img/tweet-icon.jpg" height="40"></a>
							
							<!-- <a href="https://twitter.com/share?url=https://www.needyin.com/dev/share_job.php?jid=<?php echo $_GET['jid']; ?>&text=."target="_blank" class="twitcount-button" data-count="vertical" data-size="" data-url="" data-text="" data-related="" data-hashtag="" data-via="Designation:<?php echo $design_name; ?>,Job Posted by:<?php echo $rowview2['contact_name']; ?>,Job Description:<?php echo htmlspecialchars_decode($rowview2['Job_Desc']);?>">TwitCount Button</a><script type="text/javascript" src="https://static1.twitcount.com/js/button.js"></script> -->
						    
							<!-- opensharecount-->
							<!--<script type="text/javascript" src="//opensharecount.com/bubble.js"></script>
                           <a href="https://twitter.com/share?url=https://www.needyin.com/dev/share_job.php?jid=<?php echo $_GET['jid']; ?>&text=Designation:<?php echo $design_name; ?>,Job Posted by:<?php echo $rowview2['contact_name']; ?>,Job Description:<?php echo htmlspecialchars_decode($rowview2['Job_Desc']);?>." target="_blank" class="osc-counter" data-dir="left" title="Powered by Lead Stories' OpenShareCount">0</a>-->

							</div>
                </form>
                
                                <!-- / detail body -->
                            </div>
                        </div>



                     <!-- right block -->
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <!-- right block page -->
                            <div class="right-block-list" id="right-list">
                                <!-- email letter-->
                                <div class="email-news brdbg-white">
                                    <h5 class="txt-blue h5">Get email alert for matching jobs</h5>
                                    <form  name="" method="post" action="subscriberinfo.php">
                                    <div class="mail-input brdbg-white">
                                        <div class="input-field ">
                                            <input name="subcribe-email" id="email-yours" type="email" class="validate" required>
                                            <label for="email-yours">Enter your email</label>
                                        </div>  <input type="hidden" name="current_page" value="<?php echo $actual_link;?>">
                                        <input type="submit" name="Subs" class="waves-effect waves-light btn btn-blue-sm btn-block" value="Subscribe">
                                        
                                        </div>
                                    </form>
                                </div>
                                <!--/ email letter-->
                               

                                <?php  $skillids=explode(",",$_GET['skill']);
                                        $sc=count(array_filter($skillids)); ?>

                                <!-- jobs with similar skills -->
                                  <!--  <div class="email-news brdbg-white">
                                        <h5 class="txt-blue h5">Jobs with Similar skills</h5>
                                        <h6 class="h6"><?php if($sc!='0') { ?>Click below here <?php } else { ?>No skills <?php } ?> </h6>
                                        <ul class="similar-links-list">
                                            <ul class="similar-links-list">
                                        
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
                                        </ul>
                                    </div>-->
                                    <!-- jobs with similar skills -->
                            </div>
                            <!-- / right block page -->
                        </div>
                        <!--/ right block -->
                </div>
                <!--/ row-->
            </section>
            <!--/search results, job list -->
        </main>
        <!--/main-->
        <!-- more search filters  -->
        <!-- Modal for by location -->
        <div class="modal left fade modal-search" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Locations</h4> </div>
                    <div class="modal-body">
                        <!-- more locations -->
                        <div class="search-section">
                            <h5 class="h5 subtitle-search-section txt-blue">BY LOCATION</h5>
                            <ul>
                               <form  method="post">                                    
                                      <?php                                             
                                        $sql2 = "SELECT Loc_Id,Loc_Name FROM tbl_location ORDER BY Loc_Name";
                                        $query2 = mysqli_query($con, $sql2);
                                        if(!$query2)
                                        echo mysqli_error($con);
                                        ?>
                                        <?php
                                        while ($row2 = mysqli_fetch_array($query2))
                                        { 
                                         extract($row2);
                                        ?> <!--<a href="list-jobseekers-rec-db.php?loc=<?php //echo $row2['Loc_Id']; ?>">-->
                                          <li>
                                        
                                            <input type="checkbox" id="test<?php echo $row2['Loc_Id']; ?>" name="loc" value="<?php echo $row2['Loc_Id']; ?>" onclick="this.form.submit();"/>
                                            <label for="test<?php echo $row2['Loc_Id']; ?>"><?php echo $row2['Loc_Name']; ?> <span class="txt-blue">(240)</span></label>
                                        
                                        </li>
                                        <!--</a>-->
                                        <?php } ?>
                                    </form>
                            </ul>
                            <button class="btn waves-effect waves-light btn-xs btn-blue-sm" type="submit" name="action">APPLY FILTERS </button>
                        </div>
                        <!--/ more locations -->
                    </div>
                </div>
                <!-- modal-content -->
            </div>
            <!-- modal-dialog -->
        </div>
        <!-- modal for location -->
        <!--modal for education -->
        <div class="modal left fade modal-search" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Locations</h4> </div>
                    <div class="modal-body">
                        <!-- more locations -->
                        <div class="search-section">
                            <h5 class="h5 subtitle-search-section txt-blue">BY Education</h5>
                            <ul>
                                 <form  method="post" >                                 
                                      <?php                                             
                                        $sql2 = "SELECT Qual_Id,Qual_Name FROM tbl_qualification limit 10";
                                        $query2 = mysqli_query($con, $sql2);
                                        if(!$query2)
                                        echo mysqli_error($con);
                                        ?>
                                        <?php
                                        while ($row2 = mysqli_fetch_array($query2))
                                        { 
                                         extract($row2);
                                        ?> <!--<a href="list-jobseekers-rec-db.php?loc=<?php //echo $row2['Loc_Id']; ?>">-->
                                    <!--      <li>
                                        
                                            <input type="checkbox" id="test<?php echo $row2['Qual_Id']; ?>" name="loc" value="<?php echo $row2['Qual_Id']; ?>" onclick="this.form.submit();"/>
                                            <label for="test<?php echo $row2['Qual_Id']; ?>"><?php echo $row2['Qual_Name']; ?> <span class="txt-blue">(240)</span></label>
                                        
                                        </li>
                                        <!--</a>-->
                                        <?php } ?>
                                    </form>
                                
                            </ul>
                            <button class="btn waves-effect waves-light btn-xs btn-blue-sm" type="submit" name="action">APPLY FILTERS </button>
                        </div>
                        <!--/ more locations -->
                    </div>
                </div>
                <!-- modal-content -->
            </div>
            <!-- modal-dialog -->
        </div>
        <!--/ modal for education -->
        <!-- modal for more packages-->
        <div class="modal left fade modal-search" id="morepackages" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Packages</h4> </div>
                    <div class="modal-body">
                        <!-- more locations -->
                        <div class="search-section">
                            <h5 class="h5 subtitle-search-section txt-blue">BY Salary</h5>
                            <ul>
                               <form method="post" name="salss">
                                    <?php for($i=30;$i<=70;$i=$i+3){ $j=$i+3; ?>
                                        <li>                                                                                   
                                            <input type="checkbox" id="test<?php echo $i; ?>-<?php echo $j; ?>" value="<?php echo $i; ?>-<?php echo $j; ?>" name="sals" onclick="this.form.submit();" />
                                            <label for="test<?php echo $i; ?>-<?php echo $j; ?>"><?php echo $i; ?>-<?php echo $j; ?> LAKHS <span class="txt-blue">(240)</span></label>
                                        </li>
                                    <?php }?>                                       
                                </form>
                            </ul>
                            <button class="btn waves-effect waves-light btn-xs btn-blue-sm" type="submit" name="action">APPLY FILTERS </button>
                        </div>
                        <!--/ more locations -->
                    </div>
                </div>
                <!-- modal-content -->
            </div>
            <!-- modal-dialog -->
        </div>
        <!-- / modal for more packages -->
        <!--/ more search filters -->
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
     //  alert(xmlhttp.responseText);
        document.getElementById("job-list").innerHTML=xmlhttp.responseText;
       //document.getElementById("test"+loc_id).checked = false;
       
        }
      }
    xmlhttp.open("GET","similarskill_jobs.php?loc_id="+loc_id+"&skill_id="+skill_id,true);
    xmlhttp.send();
}

function applyNow(){
    
    var skill_percent = 20;   //<?php echo $skill_percent; ?>;
   

    if(skill_percent>50) {
        return true;
    }
    else
    {
		
        if(confirm('Skills percentage is less than 50%. Do you want to continue?')) {
               return true;
         } else {
			 return false;
		 } 
     }

   
}

 </script>




</body>

</html>