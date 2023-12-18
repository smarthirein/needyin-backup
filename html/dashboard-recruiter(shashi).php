<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();
if(!isset($_SESSION['empSession']))
{
$user_home->redirect('index-recruiter.php');   
}                  
$stmt = $user_home->runQuery("SELECT * FROM tbll_emplyer Re WHERE Re.emp_id=:rid");
$stmt->execute(array(":rid"=>$_SESSION['empSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$tt_prof="SELECT Count(JUser_Id) as Id FROM tbl_jobseeker J WHERE J.JuserStatus='A' And J.jdndstatus='0'";
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

$counts_jobs="SELECT Count(JUser_Id) as cid FROM tbl_jobseeker WHERE FIND_IN_SET(2, Job_Skills) and JuserStatus='Y' and jdndstatus=0";
$countsjobs_res=mysqli_query($con,$counts_jobs);
$counts_jobs_cnt=mysqli_fetch_array($countsjobs_res);
echo $counts_jobs_cnt['cid'];



$locations_j="select Loc_Name from tbl_location where Cntry_Id=101 limit 2";
$location_res=mysqli_query($con,$locations_j);
while($locations_g=mysqli_fetch_array($location_res))
{
	$locationss[]=$locations_g['Loc_Name'];
}
foreach($locationss as $locg){
 $address = $locg.',india'; 
$user_array = array();
$geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false');


$geo = json_decode($geo, true);

if ($geo['status'] == 'OK') {
  
  $latitude = $geo['results'][0]['geometry']['location']['lat'];
  $longitude = $geo['results'][0]['geometry']['location']['lng'];
}
$loct=array("$locg","$latitude","$longitude");

$loct1=json_encode($loct,JSON_FORCE_OBJECT);
$loct1 .= ", ";

}


 $ss='{
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
		}';
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
				
			</style>
	</head>

	<body>
		<?php include 'includes-recruiter/db-recruiter-header.php' ?>
			
			<main>
				
				<section class="db-recruiter">
					<div class="container">
						
						<div class="row">
							<div class="col-md-12">
								<article class="dbpage-title">
									<h4 class="h4"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</h4> </article>
							</div>
						</div>
						
						<div class="row padtopbot">
							<div class="col-md-4">
								<div class="profile-div">
									<figure><img src="img/total-profiles-icon.png"></figure>
									<article class="text-right">
										<h3>AVAILABLE PROFILES</h3>
										<h4><span><i class="fa fa-long-arrow-up" aria-hidden="true"></i></span><?php echo $total_prof_cnt['Id'];?></h4>
										<h3>Jan 17 - <?php echo date("M d");?></h3>
									</article>
								</div>
							</div>
							<div class="col-md-4">
								<div class="profile-div">
									<figure><img src="img/matched-profiles-icon.png"></figure>
									<article class="text-right">
										<h3>MATCHED PROFILES</h3>
										<h4><span><i class="fa fa-long-arrow-up" aria-hidden="true"></i></span>5</h4>
										<h3>Jan 17 - June 17</h3>
									</article>
								</div>
							</div>
							<div class="col-md-4">
								<div class="profile-div">
									<figure><img src="img/shortlisted-profiles-icon.png"></figure>
									<article class="text-right">
										<h3>SHORTLISTED PROFILES</h3>
										<h4><span><i class="fa fa-long-arrow-up" aria-hidden="true"></i></span>2</h4>
										<h3>Jan 17 - June 17</h3>
									</article>
								</div>
							</div>
						</div>
						
						<div class="row padtopbot">
							<div class="col-md-8">
								<div class="stack-chart">
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
								<!--<div id="container-bar" style="min-width: 310px; max-width: 1000px; height: 300px; margin: 0 auto"></div>-->
									<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
									<?php
								

$results_c="SELECT Months.id AS `calen`, COUNT(`tbl_jobseeker`.currentdate) AS `sample` FROM ( SELECT 1 AS ID UNION SELECT 2 AS ID UNION SELECT 3 AS ID UNION SELECT 4 AS ID UNION SELECT 5 AS ID UNION SELECT 6 AS ID UNION SELECT 7 AS ID UNION SELECT 8 AS ID UNION SELECT 9 AS ID UNION SELECT 10 AS ID UNION SELECT 11 AS ID UNION SELECT 12 AS ID) AS Months LEFT JOIN tbl_jobseeker ON Months.id = MONTH(`tbl_jobseeker`.currentdate) GROUP BY Months.id ORDER BY Months.id ASC";
										$r1 = mysqli_query($con,$results_c);					                   
									   while($j_data = mysqli_fetch_array($r1)){ 
										  $counts[]=$j_data['calen'];	
										 $months[]=$j_data['sample'];							
													}
									$q=implode(",",$months);
									$jb_query="select Job_Id,Job_Name from tbl_jobposted where emp_id='".$_SESSION['empSession']."' and Job_Status=1";
		   $jb_res=mysqli_query($con,$jb_query);
		   while($jb_result=mysqli_fetch_array($jb_res))
		   {
			  
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
			 }
		   }
		   $c_ids=array_filter(array_unique($c_idss));		  
echo  count($c_ids);
$matched_profile=array(0,0,0,0,0,0,0,0,0,0,0,0);
foreach($c_ids as $cmp){
	
	$mp="SELECT Month(currentdate) as month from tbl_jobseeker Where JUser_Id='$cmp'";
	$mp_res=mysqli_query($con,$mp);
	$mp_row=mysqli_fetch_array($mp_res);
	$month_match=$mp_row['month']-1;
	$matched_profile[$month_match]=$matched_profile[$month_match]+1;
	
}
$q=implode(",",$matched_profile);
$month_irrelevant=array(0,0,0,0,0,0,0,0,0,0,0,0);
		 $irrelevant_sql="Select Count(b) as cnt,e,d, a, Month(d) as month from (SELECT ap.emp_id as a, ap.JUser_Id as b,ap.JobId as c,ap.created as d,ap.relavent as e FROM tbl_applied ap LEFT JOIN tbl_jobposted jp ON ap.JobId=jp.Job_Id LEFT JOIN tbll_emplyer E ON ap.emp_id = E.emp_id Where ap.emp_id='".$_SESSION['empSession']."' and ap.relavent='no')  Main Group by Month(d),e,a Order By a,d,e";
		 $irrelevant_res=mysqli_query($con,$irrelevant_sql);
			while($irrelevant_row=mysqli_fetch_array($irrelevant_res))
			{
				 $i=intval($irrelevant_row['month'])-1;
				$month_irrelevant[$i]=$irrelevant_row['cnt'];
			}
			$irrelevant=implode(',',$month_irrelevant);
			$month_relevant=array(0,0,0,0,0,0,0,0,0,0,0,0);
  $relevant_sql="Select Count(b) as cnt,e,d, a, Month(d) as month from (SELECT ap.emp_id as a, ap.JUser_Id as b,ap.JobId as c,ap.created as d,ap.relavent as e FROM tbl_applied ap LEFT JOIN tbl_jobposted jp ON ap.JobId=jp.Job_Id LEFT JOIN tbll_emplyer E ON ap.emp_id = E.emp_id Where ap.emp_id='".$_SESSION['empSession']."' and ap.relavent='yes')  Main Group by Month(d),e,a Order By a,d,e";
		 $relevant_res=mysqli_query($con,$relevant_sql);
			while($relevant_row=mysqli_fetch_array($relevant_res))
			{
				
				 $i=intval($relevant_row['month'])-1;
				 $month_relevant[$i]=$relevant_row['cnt'];
			}
			
			echo $relevant=implode(',',$month_relevant);
		   $c_ids=array_filter(array_unique($c_idss));	 $ccs=count($c_ids);								
										?>
									<script>
										Highcharts.chart('container', {
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

												}, {
												name: 'Relevant Profiles',
												data: [<?php echo $relevant; ?>]

												}, {
												name: 'Irrelevant Profiles',
												data: [<?php echo $irrelevant; ?>]

												}]

												});		
									</script>
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="posted-jobs-db">
									<div id="container-jobs" style="height:350px;"></div>
									
									<script>
										$(document).ready(function () {
											
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
														name: 'Active Jobs',
														y: <?php echo $act_jobs_cnt['Id'] ?>
											}, {
														name: 'In-Active Jobs',
														y: <?php echo $inact_jobs_cnt['Id'] ?>,
														sliced: true,
														selected: true
											}, {
														name: 'Closed Jobs',
														y: <?php echo $close_jobs_cnt['Id'] ?>
											}]
										}]
											});
										});
									</script>
								</div>
							</div>
							

						</div>
						

						
						<div class="padtopbot">
							<div class="stack-chart">
								<div class="row">
									<div class="col-md-8">
										<h4 class="h4">Job Seekers Profiles Available in India : 1050 </h4>
										<div id="chartdiv" style="width: 100%; height: 300px;"></div>
										
										<!-- map relevant script files -->
										<script src="js/ammap.js"></script>
										<script src="js/worldLow.js"></script>
										<script src="js/export.min.js"></script>
										<script src="js/light.js"></script>
																
										<script>
											
											var targetSVG = "M9,0C4.029,0,0,4.029,0,9s4.029,9,9,9s9-4.029,9-9S13.971,0,9,0z M9,15.93 c-3.83,0-6.93-3.1-6.93-6.93S5.17,2.07,9,2.07s6.93,3.1,6.93,6.93S12.83,15.93,9,15.93 M12.5,9c0,1.933-1.567,3.5-3.5,3.5S5.5,10.933,5.5,9S7.067,5.5,9,5.5 S12.5,7.067,12.5,9z";

											
											var map = AmCharts.makeChart("chartdiv", 
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
													"images": [{"svgPath":"targetSVG","zoomLevel":10,"scale":1.5,"title":"Port Blair","latitude":11.6233774,"longitude":92.7264828},{"svgPath":"targetSVG","zoomLevel":10,"scale":1.5,"title":"Anantapur","latitude":14.6818877,"longitude":77.6005911}]
												},
												"export": {
													"enabled": true
												}
											});
										</script>
									</div>
									
									<script type="text/javascript" src="js/jquery.bootstrap-responsive-tabs.min.js"></script>
									<div class="col-md-4">
										<div class="js-detail-filter">
											<div class="title-jdf">
												<h4 class="h4" style="font-weight:normal;">Job Seekers available in Andhra Pradesh</h4>
												
												<div class="tab-jdf">
													<ul class="nav nav-tabs responsive-tabs">
														<!--<li class="active"><a href="#salary">Salary</a></li>-->
														<li class="active"><a href="#skills">Skills</a></li>
														<li><a href="#experience">Experience</a></li>
													</ul>

													<div class="tab-content">
													
														<div class="tab-pane active" id="skills">
															<div class="tdfcontent mCustomScrollbar" style="height:200px;">
																<table class="table table-bordered" width="100%" cellpadding="0" cellspacing="0">
																	<thead>
																		<td>Skill</td>
																		<td>No of Profiles</td>
																	</thead>
																	<tbody>
																		<tr>
																			<td>1 Lacs</td>
																			<td>25</td>
																		</tr>
																		<tr>
																			<td>ASP</td>
																			<td>50</td>
																		</tr>
																		<tr>
																			<td>HTML</td>
																			<td>55</td>
																		</tr>
																		<tr>
																			<td>CSS</td>
																			<td>28</td>
																		</tr>
																		<tr>
																			<td>Java Script</td>
																			<td>20</td>
																		</tr>
																		<tr>
																			<td>Jquery</td>
																			<td>8</td>
																		</tr>
																		<tr>
																			<td>PHP</td>
																			<td>10</td>
																		</tr>
																		<tr>
																			<td>.Net</td>
																			<td>25</td>
																		</tr>
																		<tr>
																			<td>Node JS</td>
																			<td>10</td>
																		</tr>
																		<tr>
																			<td>Angular Js</td>
																			<td>22</td>
																		</tr>
																	</tbody>
																</table>
															</div>
														</div>
														
														<div class="tab-pane" id="experience">
															<div class="tdfcontent mCustomScrollbar">
																<table class="table table-bordered" width="100%" cellpadding="0" cellspacing="0">
																	<thead>
																		<td>Exp Years</td>
																		<td>No of Profiles</td>
																	</thead>
																	<tbody>
																		<tr>
																			<td>1-2 Years</td>
																			<td>25</td>
																		</tr>
																		<tr>
																			<td>2-4 Years</td>
																			<td>50</td>
																		</tr>
																		<tr>
																			<td>5-6 Years</td>
																			<td>55</td>
																		</tr>
																		<tr>
																			<td>6-7 Years</td>
																			<td>28</td>
																		</tr>
																		<tr>
																			<td>7-8 Years</td>
																			<td>20</td>
																		</tr>
																		<tr>
																			<td>8-9 Years</td>
																			<td>8</td>
																		</tr>
																		<tr>
																			<td>9-10 Years</td>
																			<td>10</td>
																		</tr>
																		<tr>
																			<td>10-11 Years</td>
																			<td>25</td>
																		</tr>
																		<tr>
																			<td>11-12 Years</td>
																			<td>10</td>
																		</tr>
																		<tr>
																			<td>12-15 Years</td>
																			<td>22</td>
																		</tr>
																	</tbody>
																</table>
															</div>
														</div>

													</div>
												</div>
												
												<script>
													$('.responsive-tabs').responsiveTabs({
														accordionOn: ['xs', 'sm']
													});
												</script>
											</div>
										</div>
									</div>
									

								</div>
							</div>
						</div>
					

					</div>
				</section>
			
			</main>
			
			<?php include"footer.php"; ?>
	</body>

	</html>