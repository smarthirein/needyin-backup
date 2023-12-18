<?php 
session_start();
header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire');
session_cache_limiter('public'); 
require_once 'class.user.php';
$servername = "localhost";
$username = "root";
$password = "N@edy1n.C0m_D";
$database = "ni_screening_db";
$conn = new mysqli($servername, $username, $password,$database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_home = new USER();
	
if(!isset($_SESSION['empSession']))
{
		 $user_home->redirect('index-recruiter.php');
   
} 
            
$stmt = $user_home->runQuery("SELECT * FROM tbll_emplyer WHERE emp_id=:rid");
$stmt->execute(array(":rid"=>$_SESSION['empSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
// $phase2_user_id_query="SELECT User_Id FROM tbl_users WHERE User_Email='".$row['JEmail']."'";
// $phase2_user_id_res=mysqli_query($con_phase2,$phase2_user_id_query);
// $phase2_user_id_row=mysqli_fetch_array($phase2_user_id_res);
$jsid = $_GET['jsid'];
$uid=$_GET['uid'];
$jid=$_GET['jid'];
$jname=$_GET['jname'];
        
$percent_query = "SELECT * FROM tbl_jobposted WHERE emp_id='".$row['emp_id']."' AND Job_Name=".$jid;
$query_percent = mysqli_query($conn, $percent_query);
$rowview2 = mysqli_fetch_array($query_percent);

$jskills="SELECT * FROM tbl_jobseeker WHERE upload_emplr_Id ='".$uid."' AND JUser_Id = '".$jsid."'";
// JFullName,Job_Skills,JTotalEy,JTotalEm,JLoc_Name
$jobfitresult = mysqli_query($conn,$jskills);   
$jobfitmentrow = mysqli_fetch_array($jobfitresult);  

$jobfitskills=explode(',',$jobfitmentrow['Job_Skills']);
$empskills=explode(',',$rowview2['Job_Skill']);
$common_skills=array_intersect($jobfitskills,$empskills);
$skill_percent=(count($common_skills)/count($jobfitskills))*100;
$jscnvrtintval = $jobfitmentrow['JTotalEm'];
$jsexp = (int) filter_var($jscnvrtintval, FILTER_SANITIZE_NUMBER_INT);

if($jsexp>=$rowview2['Min_Exp'])
{
    $exp_percent=100;
}
else
{
    $exp_percent=($jsexp/$rowview2['Min_Exp'])*100;
}
if($jobfitmentrow['JPLoc_Id']==$rowview2['Loc_Id'])
{
    $loc_percent=100;
}
else
{
    $loc_percent=0;
}
$overall=($skill_percent+$exp_percent+$loc_percent)/3;


//  $emp_id_query= "SELECT User_Id FROM tbl_users WHERE User_Email= '".$rowview2['emp_email']."' AND User_Type='Employer'";
// $emp_id_res=mysqli_query($con_phase2,$emp_id_query);

// $emp_id_phase2 = mysqli_fetch_array($emp_id_res);  

if(isset($_SESSION['empSession']))
{
$jobseekerid=$_SESSION['empSession'];
$sqlinsert="INSERT INTO `tbl_jobseekerview` (`emp_id`, `JUser_Id`, `job_id`) VALUES ('$uid','$jobseekerid','$jid')";
mysqli_query($conn,$sqlinsert);
}	  
$actual_link = "$_SERVER[REQUEST_URI]"; 
if($rowview2['eLogo'])
{
	$emp_logo=$rowview2['eLogo'];
}
else
{
	$emp_logo="http://needyin.com/ni_test.com/img/js-profile-list-pic.jpg" ;
}

if($row['JPhoto'])
{  
	$profile_pic= "http://needyin.com/ni_test/".$row['JPhoto'];
 }
else if($row['Gender']=="Male") {
	$profile_pic = "http://needyin.com/ni_test/img/js-profile-list-pic.jpg" ; 
}
	 else {
		$profile_pic="http://needyin.com/ni_test/img/female.png";
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
    <!-- <script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>
     <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script> -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<style>
.highcharts-figure, .highcharts-data-table table {
    min-width: 310px; 
    max-width: 800px;
    margin: 1em auto;
}

#container {
    height: 400px;
}

.highcharts-data-table table {
	font-family: Verdana, sans-serif;
	border-collapse: collapse;
	border: 1px solid #EBEBEB;
	margin: 10px auto;
	text-align: center;
	width: 100%;
	max-width: 500px;
}
.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}
.highcharts-data-table th {
	font-weight: 600;
    padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
    padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}
.highcharts-data-table tr:hover {
    background: #f1f7ff;
}
</style>
    <!-- css includes-->
    <!-- <script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
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
		.social-share {
			 position: absolute;
			right: -171px;
			top: 219px;
		}
		
		@media screen and (max-width: 425px ) {
			.social-share {
				right: -90px;
				top: 90px;
			}
		}
		
    </style>  -->

    <?php include"source2.php" ?> 
		<meta property="og:image:secure_url" content="https://needyin.com/img/share-social.png" />
	<meta property="og:image" content="http://test.needyin.com/img/share-social.png" />

</head>

<body>
    <?php 
    include_once("analyticstracking.php");
    
include'includes-recruiter/db-recruiter-header.php'; ?>
        <main>
            <?php 
            // include "inner-menu.php" ;
            ?>

            <?php $sql2 = "SELECT * FROM tbl_jobdesc where id ='".$rowview2['Job_Name']."'";
												$query2 = mysqli_query($conn, $sql2);
												$row2 = mysqli_fetch_array($query2);
                                                $jobName= $row2['Job_Role'];
                                                
                                   ?>
            <!-- search results, job list -->
            <section class="job-list">
                <div class="container">
                    <ul class="bcrumb-listjobs">
                        <li> <a href="dashboard-recruiter.php">Home</a> </li>
                        <li> <a href="screened-profles.php">Screened Profile</a> </li>
                        <li> <a href="#"><?php echo $row2['Job_Role']; ?></a> </li>
                        <!-- <li><a href="<?php if($jobfitmentrow['file_location']){ echo "view-profile.php?JUser_Id=".$jsid;}else { ?> ./img/profile-ic.png <?php } ?>"><i class="fa fa-list-alt" aria-hidden="true"></i> Resume Preview</a></li> -->
                    </ul>
                </div>
                <!-- row-->
                <div class="container">
                    <div class="row">
                    <!-- before values col-md-9 col-sm-8  -->
                      <div class="col-md-7 col-sm-7"> 
                            <div class="job-detail-block brdbg-white">
                                <!-- detial header -->
                                <div class="job-detail-header row">
                                    <div class="col-md-9 col-sm-8 col-xs-9">
                                        <div class="jobheader-title">
                                            <h4 class="txt-blue h4"><?php echo $row2['Job_Role']; ?></h4>
                                            <h5 class="h5 comp-name"><?php echo $rowview2['Comp_Name']; ?> <span> <?php echo $rowview2['Comp_Url']; ?></span></h5>
                                            <div class="usermain-features">
                                                <ul>
                                                    <!-- <li><i class="fa fa-suitcase" aria-hidden="true"></i> <?php echo $rowview2['Min_Exp']; ?>-<?php echo $rowview2['Max_Exp']; ?> Years</li> -->
                                                    <!-- <li><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $rowview2['Loc_Name']; ?>  </li> -->
                                                    <!-- <li><i class="fa fa-calendar" aria-hidden="true"></i>  -->
								
													<!-- <?php $dateb=date_create($rowview2['created']); echo $dob= date_format($dateb,"M d,Y"); ?> Created </li> -->
                                                </ul>
                                            </div>

                                               <!-- <div id="graphic"></div> -->
                                            <figure class="highcharts-figure">
                                            <!-- <div id="container"></div> -->
                                            <div class = "row">
                                            <div id="container" class="col-md-6 col-sm-8 col-xs-9" style="width: 600px; height: 500px; margin-left: 5px "></div>
                                            </figure>
                                            <!-- <div id="" class="col-md-4 col-sm-8" style="width: 600px; height: 500px; margin-bottom: 5px"> -->
                                            
                                            <!-- </div>  -->
                                            
<script>
Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Smart Ranking of <?php echo $jobfitmentrow['JFullName'];?>'
    },
    subtitle: {
        // text: 'Click the columns to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
    },
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        min: 0,
        max: 100,
        title: {
            text: 'Total Percent of SmartRanking'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
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

    series: [
        {
            name: "Percentage",
            colorByPoint: true,
            data: [
                {
                    name: "Location",
                    y: <?php echo intval($loc_percent); ?>,
                    drilldown: "Location"
                },
                {
                    name: "Skills",
                    y: <?php echo intval($skill_percent); ?>,
                    drilldown: "Skills"
                },
                {
                    name: "Experience",
                    y: <?php echo intval($exp_percent); ?>,
                    drilldown: "Experience"
                },
                {
                    name: "Sustainability",
                    y: 59,
                    drilldown: "Sustainability"
                },
                {
                    name: "Project-Culture",
                    y: 76,
                    drilldown: "Project-Culture"
                },
                {
                    name: "Domains",
                    // data:[4,5,6,7,8],
                    y: 10,
                    drilldown: "Domains"
                },
                {
                    name: "Chat",
                    y: 100,
                    drilldown: "Chat"
                },
                {
                    name: "Communication",
                    y: 80,
                    drilldown: "Communication"
                },
                {
                    name: "Smart-Ranking",
                    y: <?php echo $overall = (intval($loc_percent)+ intval($exp_percent)+  intval($skill_percent))/3;?>,
                    drilldown: "Smart-Ranking"
                }
            ]
        }
    ],
    drilldown: {
        series: [
            {
                name: "Domains",
                id: "Domains",
                data: [
                    [
                        "HR",
                        100
                    ],
                    [
                        "Telecome",
                        1.3
                    ],
                    [
                        "Insurance",
                        53.02
                    ],
                    [
                        "Banking",
                        1.4
                    ]
                ]
        
            }
        ]
    }
});
</script>   
<?php
// $overall =   ( intval($loc_percent)+ intval($exp_percent)+  intval($skill_percent))/3;
  ?>    

 <!-- <script>
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
}; -->

<!-- // The speed gauge -->
<!-- var chartSpeed = Highcharts.chart('container-speed', Highcharts.merge(gaugeOptions, {
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
            format: '<div style="text-align:center"><span style="font-size:15px;color:' + -->
                <!-- ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}%</span><br/>'/* +
                   '<span style="font-size:10px;color:silver">Overall Average</span></div>'*/
        },
        tooltip: {
            valueSuffix: 'Overall Average'
        }
    }]

}));
</script>                                             -->

                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-3 text-right">
                                         <!-- <figure class="prelogo-detail">
											<?php if($rowview2['eLogo']!="") { ?> 
											<img src="<?php echo $rowview2['eLogo'];?>" ><?php } else {?><img src="img/your-logo.png" ><?php } ?>
                                         </figure>										 -->
                                    </div>
                                </div>
                                <!--/detail header -->
                                <!-- detail body -->
                                <!-- basic detail -->
                                <div class="basic-detailstab">
                                  
                                   
                                   <!-- <ul>
                                       <li><span class="txt-blue">Job Title</span> <span><?php echo $row2['Job_Role']; ?></span></li>
                                       
                                       <li><span class="txt-blue">Position Type</span> <?php echo $rowview2['PJobtype']; ?></li>
                                       
                                        <li><span class="txt-blue">Experience</span> <?php echo $rowview2['Min_Exp']; ?>-<?php echo $rowview2['Max_Exp']; ?> Years</li>
                                       
                                       <li><span class="txt-blue">Location</span> <?php echo $jobfitmentrow['JLoc_Name']; ?></li>
                                   </ul> -->
                                   
                                   
                                   
                                </div>
                                <!--/ basic details -->
                                <!-- list description -->
                                <div class="list-description">
								<!-- <h4 class="h4 txt-blue">Job Description: </h4>                                                           -->
								<!-- <p><?php echo htmlspecialchars_decode($rowview2['Job_Desc']); ?></p> -->
                                </div>
                                <!--/ list description -->
                                <!-- list description -->
                                <div class="list-description">
                                   <!-- <h4 class="h4 txt-blue">Qualification</h4>
                                         <ul>
										<?php
											$sql2 = "SELECT * FROM tbl_university where University_Id ='".$rowview2['PUniver_Id']."'";
													$query2 = mysqli_query($conn, $sql2);
													$row2 = mysqli_fetch_array($query2);
											$sql3 = "SELECT * FROM tbl_specialization where Speca_Id ='".$rowview2['PSpeci_Id']."'";
													$query3 = mysqli_query($conn, $sql3);
													$row3 = mysqli_fetch_array($query3);
                                                
                                                   ?>
                                        	 <li> Course :  <?php if($rowview2['Qual_Name'] =="") { echo "Not Available";}else{echo $rowview2['Qual_Name'];} ?> -  Specialization : <?php if($row3['Speca_Name'] =="") { echo "Not Available";}else{ echo $row3['Speca_Name'];} ?></li>
                                                   
            
                                                   <?php if($row2['University_Name']){?>
                                                        <li>University : <?php echo $row2['University_Name']; ?></li>
                                               <?php    }
                                                    else{?>
                                                        <li>University : Not Available</li>
                                                <?php    }
                                                    ?>
                                    </ul>
                                    <table class="subtable">
                                         <tr>
                                         <td>CTC Range(Lacs)</td>
                                           <?php  if( $rowview2['Sal_Range'] || $rowview2['MSal_Range']){?>
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
                                            <?php if($rowview2['Func_Name'] != "")
                                            {?>
                                                <td>: <?php echo $rowview2['Func_Name']; ?></td>
                                       <?php     } else{ ?>
                                        <td>: Not Available</td>
                                      <?php } ?>
                                      </tr> -->
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
                                <!-- <div class="keyskills-detail">
                                    <h4 class="h4 txt-blue">Keyskills</h4>
                                    <div class=" list-emp-keyskills">
                                    <?php  $skill_ids=explode(",",$rowview2['Job_Skill']); ?>
                                        <p><?php foreach ($skill_ids as $skill_id) {

                                                     $s_query="select skill_Name from tbl_masterskills where skill_Id=".$skill_id;
                                                     $s_res=mysqli_query($conn,$s_query);
                                                     $skill_name=mysqli_fetch_array($s_res);
                                                     ?> <span><?php echo $skill_name['skill_Name']; ?> </span><?php
                                                     
                                                   } ?></p>
                                    </div>
                                </div> -->
                                <!--/ key skills -->
                                <!-- view contact details -->
								 <?php if($rowview2['notshow_jobseeker']==0) {?> 
                                <!-- <div class="keyskills-detail">
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
                 
                                </div> -->
								 <?php } ?>
                                <!--/ view contact details -->
                               <!-- <button  type="submit"  data-delay="50"  > </button>-->
                 <form name="" method="post" action="latestjob_applied.php">
                 <input type="hidden" name="juserid" value="<?php echo $row['JUser_Id']; ?>">
                 <input type="hidden" name="empid" value="<?php echo $uid; ?>">
                 <input type="hidden" name="jobid" value="<?php echo $jid; ?>">
				  <input type="hidden" name="skillsid" value="<?php echo $rowview2['Job_Skill'];?>">
                </form>
                                <!-- / detail body -->
                            </div>
                        </div>
                      


                     <!-- right block -->
                        <div class="col-md-5 col-sm-6 col-xs-18">
                            
                            <div class="right-block-list" id="right-list">
                                
                                <!-- <div class="brdbg-white"> -->
                                    <h5 class="txt-blue h5">Resume of  <?php echo $jobfitmentrow['JFullName'];?></h5>
<!-- echo "<iframe src="<iframe src=https://view.officeapps.live.com/op/embed.aspx?src=http://dev.needyin.com/".$row1['file_location']. style="width:500px; height:500px;" frameborder="0"></iframe> -->
    <?php echo "<iframe src=https://view.officeapps.live.com/op/embed.aspx?src=http://dev.needyin.com".$jobfitmentrow['file_location']." width=500 height=500></iframe>";?>
                                <!-- </div> -->
                            <!-- </div> -->
                            <!-- / right block page -->
                        <!-- </div> -->
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
                                        $query2 = mysqli_query($conn, $sql2);
                                        if(!$query2)
                                        echo mysqli_error($conn);
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
                                        $query2 = mysqli_query($conn, $sql2);
                                        if(!$query2)
                                        echo mysqli_error($conn);
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
 </script>



	</script>
</body>

</html> 
