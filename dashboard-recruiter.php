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

$tt_relv="SELECT Count(aId) as ID FROM tbl_applied WHERE emp_id='".$_SESSION['empSession']."' and relavent='yes' and user_status='A'";
$ttrelv_res=mysqli_query($con,$tt_relv);
$total_relv_cnt=mysqli_fetch_array($ttrelv_res);

$tt_irelv="SELECT Count(aId) as ID FROM tbl_applied WHERE emp_id='".$_SESSION['empSession']."' and relavent='no' and user_status='A'";
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

 $tt_mon_prof="SELECT Count(JUser_Id) as Id FROM tbl_jobseeker  WHERE JuserStatus='A' And jdndstatus='0' And date(currentdate) between '$before_date' and '$curr_date'";
$ttprofmon_res=mysqli_query($con,$tt_mon_prof);
$total_prof_mon_cnt=mysqli_fetch_array($ttprofmon_res);
 $this_cnt=$total_prof_mon_cnt['Id'];

 $tt_prev_prof="SELECT Count(JUser_Id) as Id FROM tbl_jobseeker  WHERE JuserStatus='A' And jdndstatus='0' And date(currentdate) between '$prev_date' and '$before_date'";
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
			 $query11s="select JUser_Id FROM tbl_jobseeker where JuserStatus='A' and jdndstatus='0' and (JPLoc_Id='".$loc."' || nri_status='Y' ) and  FIND_IN_SET('$idss',Job_Skills)";
				$qu_ress=mysqli_query($con,$query11s);
						while ($qu_data = mysqli_fetch_array($qu_ress)) 
						{
							$c_idss[]=$qu_data['JUser_Id'];
						}

				$query22s="select JUser_Id FROM tbl_jobseeker where date(currentdate) between '$before_date' and '$curr_date' and  JuserStatus='A' and jdndstatus='0' and (JPLoc_Id='".$loc."' || nri_status='Y' ) and  FIND_IN_SET('$idss',Job_Skills)";
				$qu_ress22=mysqli_query($con,$query22s);
						while ($qu_data22 = mysqli_fetch_array($qu_ress22)) 
						{
							$c_id22[]=$qu_data22['JUser_Id'];
						}

				$query33s="select JUser_Id FROM tbl_jobseeker where date(currentdate) between '$prev_date' and '$before_date' and  JuserStatus='A' and jdndstatus='0' and (JPLoc_Id='".$loc."' || nri_status='Y' ) and  FIND_IN_SET('$idss',Job_Skills)";
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

		class Location
		{
			public $lat;
			public $lng;
			public $locName;
		}
		$locationss = array();
		?>  <script>
			var locationsArray = [];
		
		</script>  <?php
//matched profiles
if($_GET['sk_id']=="")
{
	$rec_loc="select loc_id from tbll_emplyer where emp_id=".$_SESSION['empSession'];
	$rec_res=mysqli_query($con,$rec_loc);
	$rec_data=mysqli_fetch_array($rec_res);

	$rec_loc1="select Loc_Name, Lat, Lng from tbl_location where loc_id=".$rec_data['loc_id'];
    $rec_res1=mysqli_query($con,$rec_loc1);
	$rec_data1=mysqli_fetch_array($rec_res1);
	?> 
		<script>
		var targetSVG = "M9,0C4.029,0,0,4.029,0,9s4.029,9,9,9s9-4.029,9-9S13.971,0,9,0z M9,15.93 c-3.83,0-6.93-3.1-6.93-6.93S5.17,2.07,9,2.07s6.93,3.1,6.93,6.93S12.83,15.93,9,15.93 M12.5,9c0,1.933-1.567,3.5-3.5,3.5S5.5,10.933,5.5,9S7.067,5.5,9,5.5 S12.5,7.067,12.5,9z";
		locationsArray.push({
			svgPath: targetSVG,
            zoomLevel: 5,
			scale: 0.5,
			title: '<?php echo "You are here ".$rec_data1['Loc_Name']; ?>',
            latitude: <?php echo $rec_data1['Lat']; ?>,
			longitude: <?php echo $rec_data1['Lng']; ?>
		});
		</script>
	
	<?php
	} 
else
{ 
		 $cloc_qq="select cu.Loc_Id,jb.nri_status from tbl_jobseeker as jb , tbl_currentexperience as cu where FIND_IN_SET('".$_GET['sk_id']."',jb.Job_Skills) and jb.JUser_Id=cu.JUser_Id and JuserStatus='A' and jdndstatus=0";
		 $cloc_res=mysqli_query($con,$cloc_qq);
		 while($clocs=mysqli_fetch_array($cloc_res))
		{
			 
			if($clocs['nri_status'] == 'N')
			{
				$locations_j="select Loc_Name, Lat, Lng from tbl_location where Loc_Id=".$clocs['Loc_Id'];
				$location_res=mysqli_query($con,$locations_j);
				$locations_g=mysqli_fetch_array($location_res);
				$lcnt="SELECT count(jb.JUser_Id) as cnt_ID  from tbl_jobseeker jb LEFT JOIN tbl_currentexperience cu on jb.JUser_Id=cu.JUser_Id LEFT JOIN tbl_location lo on cu.Loc_Id=lo.Loc_Id WHERE cu.Loc_Id='".$clocs['Loc_Id']."' and FIND_IN_SET('".$_GET['sk_id']."',Job_Skills) and jb.JuserStatus='A' and jb.jdndstatus=0";
				$lcnt_res=mysqli_query($con,$lcnt);
				$profs=mysqli_fetch_array($lcnt_res);
				   $prof_cnt=$profs['cnt_ID'];
				   if($prof_cnt == 0) {
					  $details = "";
				   } else {
					   $details = " Total Profiles are ".$prof_cnt;
				   }
				?> 
		<script>
		var targetSVG = "M9,0C4.029,0,0,4.029,0,9s4.029,9,9,9s9-4.029,9-9S13.971,0,9,0z M9,15.93 c-3.83,0-6.93-3.1-6.93-6.93S5.17,2.07,9,2.07s6.93,3.1,6.93,6.93S12.83,15.93,9,15.93 M12.5,9c0,1.933-1.567,3.5-3.5,3.5S5.5,10.933,5.5,9S7.067,5.5,9,5.5 S12.5,7.067,12.5,9z";
		locationsArray.push({
			svgPath: targetSVG,
            zoomLevel: 5,
			scale: 0.5,
			title: '<?php echo $locations_g['Loc_Name'].$details; ?>',
            latitude: <?php echo $locations_g['Lat']; ?>,
			longitude: <?php echo $locations_g['Lng']; ?>
		});
		</script>
	
	<?php
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
		 $lcnt="SELECT count(jb.JUser_Id) as cnt_ID  from tbl_jobseeker jb LEFT JOIN tbl_currentexperience cu on jb.JUser_Id=cu.JUser_Id LEFT JOIN tbl_location lo on cu.Loc_Id=lo.Loc_Id WHERE cu.Loc_Id='".$locat_g['Loc_Id']."' and FIND_IN_SET('".$_GET['sk_id']."',Job_Skills) and jb.JuserStatus='A' and jb.jdndstatus=0";
	 $address = $locg.', India'; 
	}
	else
	{
		$locat="select Cntry_Id from tbl_country where Cntry_Name='".$locg."'";
    $locat_res=mysqli_query($con,$locat);
    $locat_g=mysqli_fetch_array($locat_res);
		 $lcnt="SELECT count(jb.JUser_Id) as cnt_ID  from tbl_jobseeker jb LEFT JOIN tbl_currentexperience cu on jb.JUser_Id=cu.JUser_Id LEFT JOIN tbl_country lo on cu.Loc_Id=lo.Cntry_Id WHERE cu.Loc_Id='".$locat_g['Cntry_Id']."' and FIND_IN_SET('".$_GET['sk_id']."',Job_Skills) and jb.JuserStatus='A' and jb.jdndstatus=0";
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
			
					// echo 'Addres to find: ' . $address . '<br>';
						// $address = urlencode($address);
						// $key = "AIzaSyACtaURTpTUu5QqYvqmPkdERzNiMurgr4g";
						// $geo = "http://maps.google.com/maps/geo?q=".$address."&output=json&key=".$key;
						// echo 'URL: ' . $geo . '<br>';
						// $ch = curl_init();

						// curl_setopt($ch, CURLOPT_URL, $geo);
						// curl_setopt($ch, CURLOPT_HEADER,0);
						// curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
						// // Comment out the line below if you receive an error on certain hosts that have security restrictions
						// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
						// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						
						// $data = curl_exec($ch);
						// curl_close($ch);
						
	// 		$geo_json = json_decode($data, true);
	// 		$user_array = array();	 
	// 		if ($geo_json['Status'] == 'OK') {
	//  $latitude = $geo_json['results'][1]['geometry']['location']['lat'];
	// $longitude = $geo_json['results'][1]['geometry']['location']['lng'];	
	// 			}			

			//  $pat = " M 652.09 150.04 L 655.04 152.81 L 655.15 154.73 L 656.27 155.94 L 656.4 157.14 L 654.71 156.82 L 655.79 159.42 L 658.28 160.91 L 661.75 162.56 L 660.45 163.63 L 659.9 165.83 L 662.27 166.72 L 664.62 167.88 L 667.83 169.2 L 671.04 169.51 L 672.56 170.7 L 674.37 170.92 L 677.25 171.48 L 679.16 171.44 L 679.29 170.5 L 678.75 169.01 L 678.77 168 L 680.1 167.5 L 680.59 169.35 L 680.71 169.82 L 682.95 170.72 L 684.35 170.35 L 686.33 170.51 L 688.21 170.44 L 688.14 168.99 L 687.07 168.24 L 688.88 167.94 L 690.68 166.2 L 693.07 164.7 L 695.11 165.27 L 696.57 164.28 L 697.92 165.74 L 697.32 166.74 L 699.87 167.09 L 700.21 167.98 L 699.47 168.41 L 699.91 169.86 L 698.19 169.43 L 695.46 171.06 L 695.75 172.41 L 694.78 174.39 L 694.83 175.54 L 694.08 177.48 L 692.19 176.94 L 692.44 179.37 L 692.03 180.18 L 692.41 181.18 L 691.33 181.74 L 689.61 178 L 688.96 178.01 L 688.78 179.52 L 687.35 178.29 L 687.87 176.95 L 688.9 176.81 L 689.68 174.82 L 688.28 174.42 L 686.13 174.46 L 683.88 174.14 L 683.43 172.5 L 682.3 172.38 L 680.32 171.36 L 679.74 172.96 L 681.59 174.2 L 680.27 175.08 L 679.87 175.94 L 681.39 176.57 L 681.19 177.99 L 682.23 179.76 L 682.84 181.7 L 682.61 182.56 L 681.03 182.53 L 678.2 183.02 L 678.55 184.79 L 677.45 186.18 L 674.26 187.77 L 671.92 190.54 L 670.3 192.02 L 668.1 193.56 L 668.2 194.64 L 667.08 195.23 L 665.03 196.06 L 663.94 196.19 L 663.37 197.98 L 664.08 201.05 L 664.34 202.99 L 663.49 205.23 L 663.7 209.23 L 662.48 209.35 L 661.5 211.13 L 662.25 211.91 L 660.13 212.58 L 659.4 214.18 L 658.48 214.86 L 656.16 212.66 L 654.91 209.36 L 653.88 206.99 L 652.99 205.88 L 651.61 203.62 L 650.85 200.68 L 650.34 199.21 L 647.97 195.97 L 646.64 191.42 L 645.68 188.4 L 645.43 185.56 L 644.76 183.35 L 641.5 184.76 L 639.83 184.47 L 636.51 181.62 L 637.55 180.77 L 636.76 179.85 L 633.83 177.85 L 635.21 176.27 L 640.32 176.28 L 639.63 174.26 L 638.19 173.07 L 637.72 171.26 L 636.07 170.2 L 638.31 167.73 L 641.01 167.91 L 643.09 165.44 L 644.2 163.04 L 646.08 160.68 L 645.79 159 L 647.52 157.64 L 645.48 156.47 L 644.43 154.88 L 643.28 152.81 L 644.22 151.8 L 647.78 152.38 L 650.25 152.02 Z ";
	// 				$images_array = array();
	// 				$pat = " M 652.09 150.04 L 655.04 152.81 L 655.15 154.73 L 656.27 155.94 L 656.4 157.14 L 654.71 156.82 L 655.79 159.42 L 658.28 160.91 L 661.75 162.56 L 660.45 163.63 L 659.9 165.83 L 662.27 166.72 L 664.62 167.88 L 667.83 169.2 L 671.04 169.51 L 672.56 170.7 L 674.37 170.92 L 677.25 171.48 L 679.16 171.44 L 679.29 170.5 L 678.75 169.01 L 678.77 168 L 680.1 167.5 L 680.59 169.35 L 680.71 169.82 L 682.95 170.72 L 684.35 170.35 L 686.33 170.51 L 688.21 170.44 L 688.14 168.99 L 687.07 168.24 L 688.88 167.94 L 690.68 166.2 L 693.07 164.7 L 695.11 165.27 L 696.57 164.28 L 697.92 165.74 L 697.32 166.74 L 699.87 167.09 L 700.21 167.98 L 699.47 168.41 L 699.91 169.86 L 698.19 169.43 L 695.46 171.06 L 695.75 172.41 L 694.78 174.39 L 694.83 175.54 L 694.08 177.48 L 692.19 176.94 L 692.44 179.37 L 692.03 180.18 L 692.41 181.18 L 691.33 181.74 L 689.61 178 L 688.96 178.01 L 688.78 179.52 L 687.35 178.29 L 687.87 176.95 L 688.9 176.81 L 689.68 174.82 L 688.28 174.42 L 686.13 174.46 L 683.88 174.14 L 683.43 172.5 L 682.3 172.38 L 680.32 171.36 L 679.74 172.96 L 681.59 174.2 L 680.27 175.08 L 679.87 175.94 L 681.39 176.57 L 681.19 177.99 L 682.23 179.76 L 682.84 181.7 L 682.61 182.56 L 681.03 182.53 L 678.2 183.02 L 678.55 184.79 L 677.45 186.18 L 674.26 187.77 L 671.92 190.54 L 670.3 192.02 L 668.1 193.56 L 668.2 194.64 L 667.08 195.23 L 665.03 196.06 L 663.94 196.19 L 663.37 197.98 L 664.08 201.05 L 664.34 202.99 L 663.49 205.23 L 663.7 209.23 L 662.48 209.35 L 661.5 211.13 L 662.25 211.91 L 660.13 212.58 L 659.4 214.18 L 658.48 214.86 L 656.16 212.66 L 654.91 209.36 L 653.88 206.99 L 652.99 205.88 L 651.61 203.62 L 650.85 200.68 L 650.34 199.21 L 647.97 195.97 L 646.64 191.42 L 645.68 188.4 L 645.43 185.56 L 644.76 183.35 L 641.5 184.76 L 639.83 184.47 L 636.51 181.62 L 637.55 180.77 L 636.76 179.85 L 633.83 177.85 L 635.21 176.27 L 640.32 176.28 L 639.63 174.26 L 638.19 173.07 L 637.72 171.26 L 636.07 170.2 L 638.31 167.73 L 641.01 167.91 L 643.09 165.44 L 644.2 163.04 L 646.08 160.68 L 645.79 159 L 647.52 157.64 L 645.48 156.47 L 644.43 154.88 L 643.28 152.81 L 644.22 151.8 L 647.78 152.38 L 650.25 152.02 Z ";
	// 				// $pat="M9,0C4.029,0,0,4.029,0,9s4.029,9,9,9s9-4.029,9-9S13.971,0,9,0z M9,15.93 c-3.83,0-6.93-3.1-6.93-6.93S5.17,2.07,9,2.07s6.93,3.1,6.93,6.93S12.83,15.93,9,15.93 M12.5,9c0,1.933-1.567,3.5-3.5,3.5S5.5,10.933,5.5,9S7.067,5.5,9,5.5 S12.5,7.067,12.5,9z";
	// 				$loct[]=array("svgPath"=>$pat,
	// 				"zoomLevel"=>5,
	// 				"scale"=>0.5,				
	// 				"title"=>$tit,
	// 				"latitude"=>$latitude,
	// 				"longitude"=>$longitude);
	// 				$loct1=json_encode($loct);
	// 					if($aa==$loc_count) { $loct1.=""; } else { $loct1.=","; }

	//  $aa++;
				}

			
						

// $ss='[{
// 	"svgPath": targetSVG,
// 	"zoomLevel": 5,
// 	"scale": 0.5,
// 	"title": "Andhra Pradesh",
// 	"latitude": 15.7504291,
// 	"longitude": 79.57002559
// 	},{
// 	"svgPath": targetSVG,
// 	"zoomLevel": 5,
// 	"scale": 0.5,
// 	"title": "New Delhi",
// 	"latitude": 28.6353,
// 	"longitude": 77.2250
// 		}]';

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
	 include_once("analyticstracking.php");
	 include'includes-recruiter/db-recruiter-header.php' ?>
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
									<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
									<?php
								

$results_c="SELECT Months.id AS `calen`, COUNT(`tbl_jobseeker`.currentdate) AS `sample` FROM ( SELECT 1 AS ID UNION SELECT 2 AS ID UNION SELECT 3 AS ID UNION SELECT 4 AS ID UNION SELECT 5 AS ID UNION SELECT 6 AS ID UNION SELECT 7 AS ID UNION SELECT 8 AS ID UNION SELECT 9 AS ID UNION SELECT 10 AS ID UNION SELECT 11 AS ID UNION SELECT 12 AS ID) AS Months LEFT JOIN tbl_jobseeker ON Months.id = MONTH(`tbl_jobseeker`.currentdate) WHERE YEAR(`tbl_jobseeker`.currentdate) = YEAR(CURRENT_TIMESTAMP) GROUP BY Months.id ORDER BY Months.id ASC";
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
			$query11s="select JUser_Id FROM tbl_jobseeker where JuserStatus='A' and jdndstatus='0' and (JPLoc_Id='".$loc."' || nri_status='Y' ) and  FIND_IN_SET('$idss',Job_Skills)";
				$qu_ress=mysqli_query($con,$query11s);
						while ($qu_data = mysqli_fetch_array($qu_ress)) 
						{
							$c_idss[]=$qu_data['JUser_Id'];
						}
			 }
		   }
		   $c_ids=array_filter(array_unique($c_idss));		  
 count($c_ids);
$matched_profile=array(0,0,0,0,0,0,0,0,0,0,0,0);
foreach($c_ids as $cmp){
	
 $mp="SELECT Month(currentdate) as month from tbl_jobseeker Where JUser_Id='$cmp' AND year(currentdate) =year(CURDATE());";
	$mp_res=mysqli_query($con,$mp);
	while ($mp_row=mysqli_fetch_array($mp_res)) {
	$month_match=$mp_row['month']-1;
	$matched_profile[$month_match]=$matched_profile[$month_match]+1;
	}
	
}
 $q=implode(",",$matched_profile);
$month_irrelevant=array(0,0,0,0,0,0,0,0,0,0,0,0);
		 $irrelevant_sql="Select Count(b) as cnt,e,d, a, Month(d) as month from (SELECT ap.emp_id as a, ap.JUser_Id as b,ap.JobId as c,ap.created as d,ap.relavent as e FROM tbl_applied ap LEFT JOIN tbl_jobposted jp ON ap.JobId=jp.Job_Id LEFT JOIN tbll_emplyer E ON ap.emp_id = E.emp_id Where ap.emp_id='".$_SESSION['empSession']."' and ap.relavent='no') AND YEAR(d) = YEAR(CURRENT_TIMESTAMP) Main Group by Month(d),e,a Order By a,d,e";
		 $irrelevant_res=mysqli_query($con,$irrelevant_sql);
			while($irrelevant_row=mysqli_fetch_array($irrelevant_res))
			{
				 $i=intval($irrelevant_row['month'])-1;
				$month_irrelevant[$i]=$irrelevant_row['cnt'];
			}
			$irrelevant=implode(',',$month_irrelevant);
			$month_relevant=array(0,0,0,0,0,0,0,0,0,0,0,0);
  $relevant_sql="Select Count(b) as cnt,e,d, a, Month(d) as month from (SELECT ap.emp_id as a, ap.JUser_Id as b,ap.JobId as c,ap.created as d,ap.relavent as e FROM tbl_applied ap LEFT JOIN tbl_jobposted jp ON ap.JobId=jp.Job_Id LEFT JOIN tbll_emplyer E ON ap.emp_id = E.emp_id Where ap.emp_id='".$_SESSION['empSession']."' and ap.relavent='yes') AND YEAR(d) = YEAR(CURRENT_TIMESTAMP) Main Group by Month(d),e,a Order By a,d,e";
		 $relevant_res=mysqli_query($con,$relevant_sql);
			while($relevant_row=mysqli_fetch_array($relevant_res))
			{
				
				 $i=intval($relevant_row['month'])-1;
				 $month_relevant[$i]=$relevant_row['cnt'];
			}
			
			$relevant=implode(',',$month_relevant);
		   $c_ids=array_filter(array_unique($c_idss));	  $ccs=count($c_ids);								
										?>
								
									<script>
										Highcharts.chart('container', {
												chart: {
												type: 'column'
												},
												title: {
												text: 'Profiles Statistics '
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
												name: 'Total Matched Profiles',
												data: [<?php echo $q;?>]

												}, {
												name: 'Relevant Profiles',
												data: [<?php echo $total_relv_cnt['ID']; ?>]

												}, {
												name: 'Irrelevant Profiles',
												data: [<?php echo $total_irelv_cnt['ID']; ?>]

												}]

												});		
									</script>
								</div>
							</div>
							<!--/ stacked chart for jobs-->
							<!--Total Post Jobs Doughnut-->
							<div class="col-md-4">
								<div class="posted-jobs-db">
									<div id="container-jobs" style="height:450px;"></div>
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
							</div>
							</div>
							<div class="container">
							<div class="row padtopbot">
							<div class="col-md-12">
							<div class="stack-chart">
								<div class="row">
									<div class="col-md-8">
										<h4 class="h4">Job Seekers Profiles Available in India : <?php echo $total_prof_cnt['Id'];?> </h4>
										<div id="chartdiv" style="width: 100%; height: 300px;"></div>
									
<!-- map relevant script files -->
<!-- <div id="chartdiv"></div>-->
<!-- <script src="js/ammap.js"></script> -->
 <link href="https://www.amcharts.com/lib/3/ammap.css" rel="stylesheet">
<script src="https://www.amcharts.com/lib/3/ammap.js"></script>
<script src="https://www.amcharts.com/lib/3/maps/js/indiaHigh.js"></script>
<script src="https://www.amcharts.com/lib/3/maps/js/indiaLow.js"></script> 
<script src="https://www.amcharts.com/lib/3/maps/js/worldLow.js"></script>
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<script type="text/javascript" src="http://www.amcharts.com/lib/3/themes/none.js"></script>
<style>html, body {
  width: 100%;
  height: 100%;
  margin: 0px;
}
#chartdiv {
  width: 100%;
  height: 500%;
}</style>						
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACtaURTpTUu5QqYvqmPkdERzNiMurgr4g"></script> -->
<script>
//var targetSVG = "M16,8 L14,8 L14,16 L10,16 L10,10 L6,10 L6,16 L2,16 L2,8 L0,8 L8,0 L16,8 Z M16,8";
var map = AmCharts.makeChart("chartdiv", {
    type: "map",
		"theme": "none",
        "titles": [{
		"text": "",
            "size": 10
    }],
    imagesSettings: {
        rollOverColor: "#089282",
        rollOverScale: 3,
        selectedScale: 3,
        selectedColor: "#089282",
        color: "#13564e"
    },

    zoomControl: {
        buttonFillColor: "#15A892"
    },

    areasSettings: {
        unlistedAreasColor: "#15A892"
    },
    dataProvider: {
        map: "worldLow",
        images: locationsArray,
    }
});
// console.log(locationsArray);
//map.dataProvider = dataProvider;

map.write("chartdiv");
</script>

	
									</div>
									<!--div for available profiles detail-->
									<script type="text/javascript" src="js/jquery.bootstrap-responsive-tabs.min.js"></script>
									<?php $skil_qq="select Job_Skills from tbl_jobseeker where JuserStatus='A' and jdndstatus=0";
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

																		$counts_jobs="SELECT Count(JUser_Id) as cid FROM tbl_jobseeker WHERE FIND_IN_SET('".$emp_skill."', Job_Skills) and JuserStatus='A' and jdndstatus=0";
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
				
					
				</section>
		
			</main>
		
			
	</body>
	</html>