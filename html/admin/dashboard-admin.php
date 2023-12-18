<?php
session_start();
require_once '../class.user.php';
$user_home = new USER();
if(!isset($_SESSION['adminSession']))
{
$user_home->redirect('index-recruiter.php');   
}                  
$stmt = $user_home->runQuery("SELECT * FROM tbll_emplyer Re WHERE Re.emp_id=:rid");
$stmt->execute(array(":rid"=>$_SESSION['empSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$tt_prof="SELECT Count(JUser_Id) as Id FROM tbl_jobseeker J WHERE J.JuserStatus='Y' And J.jdndstatus='0'";
$ttprof_res=mysqli_query($con,$tt_prof);
$total_prof_cnt=mysqli_fetch_array($ttprof_res);

$tt_relv="SELECT Count(aId) as ID FROM tbl_applied WHERE emp_id='".$_SESSION['empSession']."' and relavent='yes'";
$ttrelv_res=mysqli_query($con,$tt_relv);
$total_relv_cnt=mysqli_fetch_array($ttrelv_res);

$tt_irelv="SELECT Count(aId) as ID FROM tbl_applied WHERE emp_id='".$_SESSION['empSession']."' and relavent='no'";
$ttirelv_res=mysqli_query($con,$tt_irelv);
$total_irelv_cnt=mysqli_fetch_array($ttirelv_res);

$tt_jobs="SELECT Count(Job_Id) as Id FROM tbl_jobposted WHERE emp_id='".$_SESSION['empSession']."' ";
$ttjobs_res=mysqli_query($con,$tt_jobs);
$total_jobs_cnt=mysqli_fetch_array($ttjobs_res);

$act_jobs="SELECT Count(Job_Id) as Id FROM tbl_jobposted WHERE emp_id='".$_SESSION['empSession']."' and Job_Status=1";
$actjobs_res=mysqli_query($con,$act_jobs);
$act_jobs_cnt=mysqli_fetch_array($actjobs_res);

$inact_jobs="SELECT Count(Job_Id) as Id FROM tbl_jobposted WHERE emp_id='".$_SESSION['empSession']."' and Job_Status=0";
$inactjobs_res=mysqli_query($con,$inact_jobs);
$inact_jobs_cnt=mysqli_fetch_array($inactjobs_res);

$close_jobs="SELECT Count(Job_Id) as Id FROM tbl_jobposted WHERE emp_id='".$_SESSION['empSession']."' and Job_Status=2";
$closejobs_res=mysqli_query($con,$close_jobs);
$close_jobs_cnt=mysqli_fetch_array($closejobs_res);
//available profiles
 $curr_date=date('Y-m-d');
$before_date= date('Y-m-d', strtotime('-30 days'));
 $prev_date=date('Y-m-d', strtotime('-60 days'));

 $tt_mon_prof="SELECT Count(JUser_Id) as Id FROM tbl_jobseeker  WHERE JuserStatus='Y' And jdndstatus='0' And date(currentdate) between '$before_date' and '$curr_date'";
$ttprofmon_res=mysqli_query($con,$tt_mon_prof);
$total_prof_mon_cnt=mysqli_fetch_array($ttprofmon_res);
 $this_cnt=$total_prof_mon_cnt['Id'];

 $tt_prev_prof="SELECT Count(JUser_Id) as Id FROM tbl_jobseeker  WHERE JuserStatus='Y' And jdndstatus='0' And date(currentdate) between '$prev_date' and '$before_date'";
$ttprofprev_res=mysqli_query($con,$tt_prev_prof);
$total_prof_prev_cnt=mysqli_fetch_array($ttprofprev_res);
 $prev_cnt=$total_prof_prev_cnt['Id'];
if($this_cnt>$prev_cnt)
{
	$act_cnt=$this_cnt-$prev_cnt;
	$arrow='up';
}
else
{
	$act_cnt=$prev_cnt-$this_cnt;
	$arrow='down';
}
//available profiles

//shortlisted profiles
 $short_prof="SELECT Count(sId) as ID FROM tbl_shortlisted WHERE status='yes' and emp_id='".$_SESSION['empSession']."'";
$short_res=mysqli_query($con,$short_prof);
$short_data=mysqli_fetch_array($short_res);
$short_prof_cnt=$short_data['ID'];

 $shortmon_prof="SELECT Count(sId) as ID FROM tbl_shortlisted WHERE status='yes' and emp_id='".$_SESSION['empSession']."' and  date(created) between '$before_date' and '$curr_date'";
$shortmon_res=mysqli_query($con,$shortmon_prof);
$shortmon_data=mysqli_fetch_array($shortmon_res);
 $short_this_cnt=$shortmon_data['ID'];

$shortprev_prof="SELECT Count(sId) as ID FROM tbl_shortlisted WHERE status='yes' and emp_id='".$_SESSION['empSession']."' and  date(created) between '$prev_date' and '$before_date'";
$shortprev_res=mysqli_query($con,$shortprev_prof);
$shortprev_data=mysqli_fetch_array($shortprev_res);
 $short_prev_cnt=$shortprev_data['ID'];

if($short_this_cnt>$short_prev_cnt)
{
	$shact_cnt=$short_this_cnt-$short_prev_cnt;
	$sharrow='up';
}
else
{
	$shact_cnt=$short_prev_cnt-$short_this_cnt;
	$sharrow='down';
}

//shortlisted profiles

//matched profiles
$jb_query="select Job_Id,Job_Name from tbl_jobposted where emp_id='".$_SESSION['empSession']."' and Job_Status=1";
		   $jb_res=mysqli_query($con,$jb_query);
		   while($jb_result=mysqli_fetch_array($jb_res))
		   {
			  // $job_name[]=$jb_result['Job_Name'];
			  $job_ids[]=$jb_result['Job_Id'];							         
			$cj21="SELECT Job_Skill,Loc_Id FROM tbl_jobposted WHERE emp_id = '".$_SESSION['empSession']."' and Job_Id='".$jb_result['Job_Id']."' and Job_Status=1 "; 							
			$resultcj12 = mysqli_query($con,$cj21);  
			$result_cj12=mysqli_fetch_array($resultcj12);
			 $jobskills=$result_cj12['Job_Skill'];
			 $loc=$result_cj12['Loc_Id'];
			 $ids2=explode(",",$jobskills);						  
			  foreach($ids2 as $idss)
			 {
			 $query11s="select JUser_Id FROM tbl_jobseeker where JuserStatus='Y' and jdndstatus='0' and (JPLoc_Id='".$loc."' || nri_status='Y' ) and  FIND_IN_SET('$idss',Job_Skills)";
				$qu_ress=mysqli_query($con,$query11s);
						while ($qu_data = mysqli_fetch_array($qu_ress)) 
						{
							$c_idss[]=$qu_data['JUser_Id'];
						}

				$query22s="select JUser_Id FROM tbl_jobseeker where date(currentdate) between '$before_date' and '$curr_date' and  JuserStatus='Y' and jdndstatus='0' and (JPLoc_Id='".$loc."' || nri_status='Y' ) and  FIND_IN_SET('$idss',Job_Skills)";
				$qu_ress22=mysqli_query($con,$query22s);
						while ($qu_data22 = mysqli_fetch_array($qu_ress22)) 
						{
							$c_id22[]=$qu_data22['JUser_Id'];
						}

				$query33s="select JUser_Id FROM tbl_jobseeker where date(currentdate) between '$prev_date' and '$before_date' and  JuserStatus='Y' and jdndstatus='0' and (JPLoc_Id='".$loc."' || nri_status='Y' ) and  FIND_IN_SET('$idss',Job_Skills)";
				$qu_ress33=mysqli_query($con,$query33s);
						while ($qu_data33 = mysqli_fetch_array($qu_ress33)) 
						{
							$c_id33[]=$qu_data33['JUser_Id'];
						}
			 }
		   }
		   $c_ids=array_filter(array_unique($c_idss));
		   $matc_prof_cnt=count($c_ids);

            $mat_mon=array_filter(array_unique($c_id22));
	       $matc_mon_cnt=count($mat_mon);

		   $mat_prev=array_filter(array_unique($c_id33));
	      $matc_prev_cnt=count($mat_prev);

		if($matc_mon_cnt>$matc_prev_cnt)
		{
			$mact_cnt=$matc_mon_cnt-$matc_prev_cnt;
			$marrow='up';
		}
		else
		{
			$mact_cnt=$matc_prev_cnt-$matc_mon_cnt;
			$marrow='down';
		}


//matched profiles
if($_GET['sk_id']=="")
{
	$rec_loc="select loc_id from tbll_emplyer where emp_id=".$_SESSION['empSession'];
	$rec_res=mysqli_query($con,$rec_loc);
	$rec_data=mysqli_fetch_array($rec_res);

	$rec_loc1="select Loc_Name from tbl_location where loc_id=".$rec_data['loc_id'];
    $rec_res1=mysqli_query($con,$rec_loc1);
    $rec_data1=mysqli_fetch_array($rec_res1);
	$locationss[]=$rec_data1['Loc_Name'];
} else
{ 
		 $cloc_qq="select cu.Loc_Id,jb.nri_status from tbl_jobseeker as jb , tbl_currentexperience as cu where FIND_IN_SET('".$_GET['sk_id']."',jb.Job_Skills) and jb.JUser_Id=cu.JUser_Id and JuserStatus='Y' and jdndstatus=0";
		 $cloc_res=mysqli_query($con,$cloc_qq);
		 while($clocs=mysqli_fetch_array($cloc_res))
		{
			 
			if($clocs['nri_status'] == 'N')
			{
				$locations_j="select Loc_Name from tbl_location where Loc_Id=".$clocs['Loc_Id'];
				$location_res=mysqli_query($con,$locations_j);
				$locations_g=mysqli_fetch_array($location_res);
				$locationss[]=$locations_g['Loc_Name'];
			}
			else
			{
				 $locations_j="select Cntry_Name from tbl_country where Cntry_Id=".$clocs['Loc_Id'];
				$location_res=mysqli_query($con,$locations_j);
				$locations_g=mysqli_fetch_array($location_res);
				$locationss[]=$locations_g['Cntry_Name'];
			}
			$nri_status[]=$clocs['nri_status'];
			
		}
}

 $loc_count=count($locationss);
$aa=1;
$count=0;
foreach($locationss as $locg)
{
	if($nri_status[$count]=='N')
	{
	 $locat="select Loc_Id from tbl_location where Loc_Name='".$locg."'";
    $locat_res=mysqli_query($con,$locat);
    $locat_g=mysqli_fetch_array($locat_res);
		 $lcnt="SELECT count(jb.JUser_Id) as cnt_ID  from tbl_jobseeker jb LEFT JOIN tbl_currentexperience cu on jb.JUser_Id=cu.JUser_Id LEFT JOIN tbl_location lo on cu.Loc_Id=lo.Loc_Id WHERE cu.Loc_Id='".$locat_g['Loc_Id']."' and FIND_IN_SET('".$_GET['sk_id']."',Job_Skills) and jb.JuserStatus='Y' and jb.jdndstatus=0";
	 $address = $locg.',india'; 
	}
	else
	{
		$locat="select Cntry_Id from tbl_country where Cntry_Name='".$locg."'";
    $locat_res=mysqli_query($con,$locat);
    $locat_g=mysqli_fetch_array($locat_res);
		 $lcnt="SELECT count(jb.JUser_Id) as cnt_ID  from tbl_jobseeker jb LEFT JOIN tbl_currentexperience cu on jb.JUser_Id=cu.JUser_Id LEFT JOIN tbl_country lo on cu.Loc_Id=lo.Cntry_Id WHERE cu.Loc_Id='".$locat_g['Cntry_Id']."' and FIND_IN_SET('".$_GET['sk_id']."',Job_Skills) and jb.JuserStatus='Y' and jb.jdndstatus=0";
		 $address=$locg;
	}
$count=$count+1;
  
  $lcnt_res=mysqli_query($con,$lcnt);
  $profs=mysqli_fetch_array($lcnt_res);
 $prof_cnt=$profs['cnt_ID'];
            if($prof_cnt=='0'){
	        $tit="You are here ".$locg;
	        } else {
	        	$tit=$locg."</br>Total Profiles : ".$prof_cnt;
	        }
			
			$user_array = array();
			$geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false');

			// Convert the JSON to an array
			$geo = json_decode($geo, true);

			if ($geo['status'] == 'OK') 
				{
				  // Get Lat & Long
				  $latitude = $geo['results'][0]['geometry']['location']['lat'];
				  $longitude = $geo['results'][0]['geometry']['location']['lng'];
				}
			$images_array = array();
			$pat="M9,0C4.029,0,0,4.029,0,9s4.029,9,9,9s9-4.029,9-9S13.971,0,9,0z M9,15.93 c-3.83,0-6.93-3.1-6.93-6.93S5.17,2.07,9,2.07s6.93,3.1,6.93,6.93S12.83,15.93,9,15.93 M12.5,9c0,1.933-1.567,3.5-3.5,3.5S5.5,10.933,5.5,9S7.067,5.5,9,5.5 S12.5,7.067,12.5,9z";
			$loct[]=array("svgPath"=>$pat,
				"zoomLevel"=>5,
				"scale"=>0.5,				
				"title"=>"$tit",
				"latitude"=>$latitude,
				"longitude"=>$longitude);
					$loct1=json_encode($loct);

             if($aa==$loc_count) { $loct1.=""; } else { $loct1.=","; }
			
		
$aa++;	
} 

$ss='[{
	"svgPath": targetSVG,
	"zoomLevel": 5,
	"scale": 0.5,
	"title": "Andhra Pradesh",
	"latitude": 14.7504291,
	"longitude": 78.57002559
		}, {
	"svgPath": targetSVG,
	"zoomLevel": 5,
	"scale": 0.5,
	"title": "New Delhi",
	"latitude": 28.6353,
	"longitude": 77.2250
		}]';

 
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title> Needyin</title>
		<!-- css includes-->
		<?php include"source.php" ?>
			<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
			<script type="text/javascript" src="js/exporting.js"></script>
			<script type="text/javascript" src="js/highcharts.js"></script>
			<style>
				#mapdiv {
					background: #eee;
				}
				.amcharts-export-menu-top-right,.export-main{
					display: none !important;
				}
			</style>
	</head>

	<body>
		<?php 
	 include_once("../analyticstracking.php");
	 include'../includes-recruiter/admin_header.php' ?>
			<!-- main-->
			<main>
				<!--dashboard of recruiter section -->
				<section class="db-recruiter">
					<div class="container">
						<!-- title row-->
						<div class="row">
							<div class="col-md-12">
								<article class="dbpage-title">
									<h4 class="h4"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</h4> </article>
							</div>
						</div>
						<!--/ title row-->
						<!-- Dashboard objects  -->
						<?php  $pr_date=date('M d', strtotime('-30 days'));?>
						<div class="row padtopbot">
							<div class="col-md-4 col-sm-4">
								<div class="profile-div">
									<figure><img src="img/total-profiles-icon.png"></figure>
									<article class="text-right">
										<h3><span class="sec-span"><?php echo $total_prof_cnt['Id'];?></span>AVAILABLE PROFILES</h3>
										<h4><span class="subspan">(M on M)</span><?php if($arrow=='up') { ?>
											<span><i class="fa fa-long-arrow-up" aria-hidden="true"></i></span> <?php } else { ?>
											<span><i class="fa fa-long-arrow-down" aria-hidden="true"></i></span><?php } 
											 echo $act_cnt;?>
										</h4>
										<h3><?php echo $pr_date;?> - <?php echo date("M d");?></h3>
									</article>
								</div>
							</div>
							<div class="col-md-4 col-sm-4">
								<div class="profile-div">
									<figure><img src="img/matched-profiles-icon.png"></figure>
									<article class="text-right">
										<h3><span class="sec-span"><?php echo $matc_prof_cnt;?></span>MATCHED PROFILES</h3>
										<h4><span class="subspan">(M on M)</span><?php if($marrow=='up') { ?>
											<span><i class="fa fa-long-arrow-up" aria-hidden="true"></i></span> <?php } else { ?>
											<span><i class="fa fa-long-arrow-down" aria-hidden="true"></i></span><?php }  echo $mact_cnt;?></h4>
										<h3><?php echo $pr_date;?> - <?php echo date("M d");?></h3>
									</article>
								</div>
							</div>
							<div class="col-md-4 col-sm-4">
								<div class="profile-div">
									<figure><img src="img/shortlisted-profiles-icon.png"></figure>
									<article class="text-right">
										<h3><span class="sec-span"><?php echo $short_prof_cnt;?></span>SHORTLISTED PROFILES</h3>
										<h4><span class="subspan">(M on M)</span><?php if($sharrow=='up') { ?>
											<span><i class="fa fa-long-arrow-up" aria-hidden="true"></i></span> <?php } else { ?>
											<span><i class="fa fa-long-arrow-down" aria-hidden="true"></i></span><?php }  echo $shact_cnt;?></h4>
										<h3><?php echo $pr_date;?> - <?php echo date("M d");?></h3>
									</article>
								</div>
							</div>
						</div>
						<!--/ row for profiles -->

						<!-- Stacked chart for Jobs -->
						<div class="row padtopbot">
							<div class="col-md-8">
							<div class="stack-chart">
								<div class="row">
									<div class="col-md-8">
										<h4 class="h4">Job Seekers Profiles Available in India : <?php echo $total_prof_cnt['Id'];?> </h4>
										<div id="chartdiv" style="width: 100%; height: 300px;"></div>
										
										<!-- map relevant script files -->
										<script src="js/ammap.js"></script>
										<script src="js/worldLow.js"></script>
										<script src="js/export.min.js"></script>
										<script src="js/light.js"></script>
										<!-- map relevant script files -->										
										<script>
											/**
											 * Define SVG path for target icon
											 */
											var targetSVG = "M9,0C4.029,0,0,4.029,0,9s4.029,9,9,9s9-4.029,9-9S13.971,0,9,0z M9,15.93 c-3.83,0-6.93-3.1-6.93-6.93S5.17,2.07,9,2.07s6.93,3.1,6.93,6.93S12.83,15.93,9,15.93 M12.5,9c0,1.933-1.567,3.5-3.5,3.5S5.5,10.933,5.5,9S7.067,5.5,9,5.5 S12.5,7.067,12.5,9z";
											/**
											 * Create the map
											 */
											var map = AmCharts.makeChart("chartdiv", {
												"type": "map",
												"projection": "winkel3",
												"theme": "light",
												"imagesSettings": {
													"rollOverColor": "#089282",
													"rollOverScale": 3,
													"selectedScale": 3,
													"selectedColor": "#089282",
													"color": "#13564e"
												},

												"areasSettings": {
													"unlistedAreasColor": "#15A892",
													"outlineThickness": 0.1
												},

												"dataProvider": {
													"map": "worldLow",
													"images":<?php echo $loct1;?>
												},
												"export": {
													"enabled": true
												}
											});
										</script>
									</div>
									<!--div for available profiles detail-->
									<script type="text/javascript" src="js/jquery.bootstrap-responsive-tabs.min.js"></script>
									<?php $skil_qq="select Job_Skills from tbl_jobseeker where JuserStatus='Y' and jdndstatus=0";
										  $skil_res=mysqli_query($con,$skil_qq);
										  while($skils_data=mysqli_fetch_array($skil_res))
										  {
									     	  $skil_data[]=$skils_data['Job_Skills'];
									     	}
										  $sk=implode(",",$skil_data);
										  $sks=explode(",",$sk);
										  $emp_skills=array_filter(array_unique($sks));
										?>
									<div class="col-md-4">
										<div class="<!--js-detail-filter-->">
											<div class="title-jdf">
												<h4 class="h4" style="font-weight:normal;">Available Job Seekers </h4>
												<!-- tab start-->
												<div class="tab-jdf">
													<ul class="nav nav-tabs responsive-tabs">
														<!--<li class="active"><a href="#salary">Salary</a></li>-->
														<li class="active"><a href="#skills">Skills</a></li>
														<!--<li><a href="#experience">Experience</a></li>-->
													</ul>

													<div class="tab-content">
														<!-- experience tab content -->
														
														<!-- skills tab content -->
														<div class="tab-pane active" id="skills">
															<div class="tdfcontent mCustomScrollbar" style="height:237px;">
																<table class="table table-bordered" width="100%" cellpadding="0" cellspacing="0">
																	<thead>
																		<td style="text-align:left;">Skill</td>
																		<td>No of Profiles</td>
																	</thead>
																	<tbody>
																	<?php foreach($emp_skills as $emp_skill)
																	{
																		$ww="select skill_Name from tbl_masterskills where skill_Id=".$emp_skill;
																		$ww_res=mysqli_query($con,$ww);
																		$skill_name=mysqli_fetch_array($ww_res);

																		$counts_jobs="SELECT Count(JUser_Id) as cid FROM tbl_jobseeker WHERE FIND_IN_SET('".$emp_skill."', Job_Skills) and JuserStatus='Y' and jdndstatus=0";
                                                                         $countsjobs_res=mysqli_query($con,$counts_jobs);
                                                                         $counts_jobs_cnt=mysqli_fetch_array($countsjobs_res);
                                                                        
																		?>
																		<tr>
																			<td ><a href="dashboard-recruiter.php?sk_id=<?php echo $emp_skill;?>"><?php echo $skill_name['skill_Name'];?></a></td>
																			<td style="color:#8c8686;text-align:center;"><?php echo $counts_jobs_cnt['cid'];?></td>
																		</tr>
																		<?php } ?>
																	</tbody>
																</table>
															</div>
														</div>
														<!-- / skills tab content -->
														
													</div>
												</div>
												<!-- / tab start-->
												<script>
													$('.responsive-tabs').responsiveTabs({
														accordionOn: ['xs', 'sm']
													});
												</script>
											</div>
										</div>
									</div>
									<!--/ div for available profiles details -->

								</div>
							</div>
								<!--<div class="stack-chart">
									<div class="row statsrow">
										<div class="col-md-4 text-center jobs-stats">
											<h3>Total Profiles</h3>
											<h5><?php echo $total_prof_cnt['Id'];?></h5>
										</div>
										<div class="col-md-4 text-center jobs-stats">
											<h3>Relevant Profiles</h3>
											<h5><?php echo $total_relv_cnt['ID'];?></h5>
										</div>
										<div class="col-md-4 text-center jobs-stats">
											<h3>Irrelevant Profiles</h3>
											<h5><?php echo $total_irelv_cnt['ID'];?></h5>
										</div>
									</div>
									<?php 
									/*$results_c="SELECT Months.id AS `mn`, COUNT(`tbl_jobseeker`.currentdate) AS `c_jobseeker` FROM ( SELECT 1 AS ID UNION SELECT 2 AS ID UNION SELECT 3 AS ID UNION SELECT 4 AS ID UNION SELECT 5 AS ID UNION SELECT 6 AS ID UNION SELECT 7 AS ID UNION SELECT 8 AS ID UNION SELECT 9 AS ID UNION SELECT 10 AS ID UNION SELECT 11 AS ID UNION SELECT 12 AS ID) AS Months LEFT JOIN tbl_jobseeker ON Months.id = MONTH(`tbl_jobseeker`.currentdate) where JuserStatus='Y' And jdndstatus='0' GROUP BY Months.id ORDER BY Months.id ASC";						
									$r1 = mysqli_query($con,$results_c);					                   
									while($j_data = mysqli_fetch_array($r1)){ 
									$counts[]=$j_data['mn'];	
									$months[]=$j_data['c_jobseeker'];			
													}
									$q=implode(",",$months);	*/					
										?>
									<div id="container-bar" style="min-width: 310px; max-width: 1000px; height: 300px; margin: 0 auto"></div>
									<script>
										Highcharts.chart('container-bar', {
											chart: {
												type: 'column'
											},
											title: {
												text: 'Profiles Stastics '
											},

											xAxis: {
												categories: [
												'Jan',
												'Feb',
												'Mar',
												'Apr',
												'May',
												'Jun',
												'Jul',
												'Aug',
												'Sep',
												'Oct',
												'Nov',
												'Dec'
											],
												crosshair: true
											},
											yAxis: {
												min: 0,
												title: {
													text: 'Percentage in Monthly'
												}
											},
											tooltip: {
												headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
												pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
													'<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
												footerFormat: '</table>',
												shared: true,
												useHTML: true
											},
											plotOptions: {
												column: {
													pointPadding: 0.2,
													borderWidth: 0
												}
											},
											series: [{
												name: 'Total Profiles',
												data: [<?php echo $q;?>]

										}, 
											{
												name: 'Irrelevant Profiles',
												data: [0, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]

										}, {
												name: 'Relevant Profiles',
												data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]

										}]
										});
									</script>
								</div>-->
							</div>
							<!--/ stacked chart for jobs-->
							<!--Total Post Jobs Doughnut-->
							<div class="col-md-4">
								<div class="posted-jobs-db">
									<div id="container-jobs" style="height:350px;"></div>
									<script>
										$(document).ready(function () {
											// Build the chart
											Highcharts.chart('container-jobs', {
												chart: {
													plotBackgroundColor: null,
													plotBorderWidth: null,
													plotShadow: false,
													type: 'pie'
												},
												title: {
													text: 'Total Posted Jobs <?php echo $total_jobs_cnt['Id'] ?>'
												},
												tooltip: {
													pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
												},
												plotOptions: {
													pie: {
														allowPointSelect: true,
														cursor: 'pointer',
														dataLabels: {
															enabled: false
														},
														showInLegend: true
													}
												},
												series: [{
													name: 'Percentage',
													colorByPoint: true,
													data: [{

														name: 'In-Active Jobs',
														y: <?php echo $inact_jobs_cnt['Id'] ?>
											}, {
														name: 'Closed Jobs',
														y: <?php echo $close_jobs_cnt['Id'] ?>,
														sliced: true,
														selected: true
											}, {
														name: 'Active Jobs',
														y: <?php echo $act_jobs_cnt['Id'] ?>
											}]
										}]
											});
										});
									</script>
								</div>
							</div>
							<!--/ Total post jobs Doughnut-->

						</div>
						<!--/ Dashboard Objects  -->

						<!-- map-->
						<!--<div class="padtopbot">
							<div class="stack-chart">
								<div class="row">
									<div class="col-md-8">
										<h4 class="h4">Job Seekers Profiles Available in India : <?php //echo $total_prof_cnt['Id'];?> </h4>
										<div id="chartdiv" style="width: 100%; height: 300px;"></div>
										
										<!-- map relevant script files -->
										<!--<script src="js/ammap.js"></script>
										<script src="js/worldLow.js"></script>
										<script src="js/export.min.js"></script>
										<script src="js/light.js"></script>
										<!-- map relevant script files -->										
									<!--	<script>
											/**
											 * Define SVG path for target icon
											 */
											var targetSVG = "M9,0C4.029,0,0,4.029,0,9s4.029,9,9,9s9-4.029,9-9S13.971,0,9,0z M9,15.93 c-3.83,0-6.93-3.1-6.93-6.93S5.17,2.07,9,2.07s6.93,3.1,6.93,6.93S12.83,15.93,9,15.93 M12.5,9c0,1.933-1.567,3.5-3.5,3.5S5.5,10.933,5.5,9S7.067,5.5,9,5.5 S12.5,7.067,12.5,9z";
											/**
											 * Create the map
											 */
											var map = AmCharts.makeChart("chartdiv", {
												"type": "map",
												"projection": "winkel3",
												"theme": "light",
												"imagesSettings": {
													"rollOverColor": "#089282",
													"rollOverScale": 3,
													"selectedScale": 3,
													"selectedColor": "#089282",
													"color": "#13564e"
												},

												"areasSettings": {
													"unlistedAreasColor": "#15A892",
													"outlineThickness": 0.1
												},

												"dataProvider": {
													"map": "worldLow",
													"images":<?php echo $loct1;?>
												},
												"export": {
													"enabled": true
												}
											});
										</script>
									</div>
									<!--div for available profiles detail-->
									<script type="text/javascript" src="js/jquery.bootstrap-responsive-tabs.min.js"></script>
									<?php/* $skil_qq="select Job_Skills from tbl_jobseeker where JuserStatus='Y' and jdndstatus=0";
										  $skil_res=mysqli_query($con,$skil_qq);
										  while($skils_data=mysqli_fetch_array($skil_res))
										  {
									     	  $skil_data[]=$skils_data['Job_Skills'];
									     	}
										  $sk=implode(",",$skil_data);
										  $sks=explode(",",$sk);
										  $emp_skills=array_filter(array_unique($sks));*/
										 // print_r($emp_skills);?>
									<!--<div class="col-md-4">
										<div class="js-detail-filter">
											<div class="title-jdf">
												<h4 class="h4" style="font-weight:normal;">Available Job Seekers </h4>
												<!-- tab start-->
												<!--<div class="tab-jdf">
													<ul class="nav nav-tabs responsive-tabs">
														<!--<li class="active"><a href="#salary">Salary</a></li>-->
													<!--	<li class="active"><a href="#skills">Skills</a></li>
														<!--<li><a href="#experience">Experience</a></li>-->
											<!--	</ul>

													<div class="tab-content">
														<!-- experience tab content -->
														
														<!-- skills tab content -->
														<!--<div class="tab-pane active" id="skills">
															<div class="tdfcontent mCustomScrollbar" style="height:237px;">
																<table class="table table-bordered" width="100%" cellpadding="0" cellspacing="0">
																	<thead>
																		<td style="text-align:left;">Skill</td>
																		<td>No of Profiles</td>
																	</thead>
																	<tbody>
																	<?php //foreach($emp_skills as $emp_skill)
																	//{
																		/*$ww="select skill_Name from tbl_masterskills where skill_Id=".$emp_skill;
																		$ww_res=mysqli_query($con,$ww);
																		$skill_name=mysqli_fetch_array($ww_res);

																		$counts_jobs="SELECT Count(JUser_Id) as cid FROM tbl_jobseeker WHERE FIND_IN_SET('".$emp_skill."', Job_Skills) and JuserStatus='Y' and jdndstatus=0";
                                                                         $countsjobs_res=mysqli_query($con,$counts_jobs);
                                                                         $counts_jobs_cnt=mysqli_fetch_array($countsjobs_res);
                                                                          //echo $counts_jobs_cnt['cid'];*/
																		?>
																		<!--<tr>
																			<td ><a href="dashboard-recruiter.php?sk_id=<?php echo $emp_skill;?>"><?php echo $skill_name['skill_Name'];?></a></td>
																			<td style="color:#8c8686;text-align:center;"><?php echo $counts_jobs_cnt['cid'];?></td>
																		</tr>
																		<?php //} ?>
																<!--	</tbody>
																</table>
															</div>
														</div>
														<!-- / skills tab content -->
														
												<!--	</div>
												</div>
												<!-- / tab start-->
												<!--<script>
													$('.responsive-tabs').responsiveTabs({
														accordionOn: ['xs', 'sm']
													});
												</script>
											</div>
										</div>
									</div>
									<!--/ div for available profiles details -->

								<!--</div>
							</div>
						</div>-->
						<!--/ map -->

					</div>
				</section>
				<!--/ dashboard of recruiter section -->
			</main>
			<!--/main-->
			
	</body>

	</html>