<?php 
require_once("config.php");
require_once 'class.user.php';
$user_home = new USER();
if(!isset($_SESSION['empSession']))
{
$user_home->redirect('index-recruiter.php');  
} 
$stmt = $user_home->runQuery("SELECT * FROM tbll_emplyer WHERE emp_id=:eid");
$stmt->execute(array(":eid"=>$_SESSION['empSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
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
		
						 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
    <!-- css includes-->
    <?php include "source.php" ?>
</head>
<script>
$(document).ready(function(){
    $("li.dropbtn a").click(function(){
        $("li.dropbtn a").removeAttr("class");
    });
});

 function match_profiles(job_id,emp_id)
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
	
         document.getElementById("mp").innerHTML=xmlhttp.responseText;	 
		 var d = document.getElementById("mp"+job_id);
	     d.className += "nav-select-db";	
        }
      }
    xmlhttp.open("GET","get_matchedprofiles.php?JobId="+job_id+"&EmpId="+emp_id,true);	
    xmlhttp.send();
	}
</script>
<body>

    <?php 
		include_once("analyticstracking.php");					 
		include 'includes-recruiter/db-recruiter-header.php'; ?>
        <!-- main-->
        <main>
            <!--dashboard of profiles section -->
            <section class="db-recruiter">
                <div class="container">
                   <!--ad space -->
                
                  <!-- / ad space-->
                    <!-- title row-->
                    <div class="row">
                        <div class="col-md-12">
                            <article class="dbpage-title">
                                <h4 class="h4"> <i class="fa fa-users" aria-hidden="true"></i> Profiles</h4> </article>
                        </div>
                    </div>
                    <!--/ title row-->
                    <!-- profiles navigation -->                   
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-profiles nav-default">
								<li><a href="dbrecruiter-latest.php"><i class="fa fa-address-book" aria-hidden="true"></i> Latest Profiles <span></span> </a></li>
                                <li  class="dropbtn"><a class="nav-select-db" href="#!"><i class="fa fa-exchange" aria-hidden="true"></i> Matched Profiles <span class="dwarrow"><i class="fa fa-sort-desc" aria-hidden="true"></i></span> <span>(<?php $d_cnt=count($c_ids);$_SESSION['mcnt']=$d_cnt;  echo $d_cnt; ?>)</span> </a>
                                <div class="dropdown-tab">
                                <?php foreach($job_ids as $jn) { 
									$jname_query1="select Job_Name from tbl_jobposted where Job_Id=".$jn; 
									$jn_res1=mysqli_query($con,$jname_query1);
									$jn_data1=mysqli_fetch_array($jn_res1);								
									$jname_query="select Desig_Name from tbl_desigination where Desig_Id=".$jn_data1['Job_Name']; 
									$jn_res=mysqli_query($con,$jname_query);
									$jn_data=mysqli_fetch_array($jn_res);?>
									<a id="mp<?php echo $jn;?>" href="javascript:void(0);" onclick="this.removeAttribute('class'); return match_profiles('<?php echo $jn;?>','<?php echo $_SESSION['empSession'];?>');"><?php echo $jn_data['Desig_Name']; //if($_SESSION['mjid']==$jn){echo "(".$_SESSION['mjcnt'].")" ;}else {echo "(0)";}?></a>
								<?php } ?>
                                </div>
                                </li>
                                <li><a href="dbrecruiter-profles-shortlist.php"><i class="fa fa-heart" aria-hidden="true"></i> Shortlisted Profiles <span></span> </a></li>
                               <li><a href="dbrecruiter-sche-int.php"><i class="fa fa-calendar" aria-hidden="true"></i> Scheduled Interview <span></span> </a></li>
								<li><a href="job-viewed.php"><i class="fa fa-id-card-o" aria-hidden="true"></i> Jobs Viewed <span></span> </a></li>								
                            </ul>
                        </div>
                    </div>
                    <!-- profiles navigation -->
                    <?php
?>
<div id="mp">
<?php if($d_cnt>0)
{
	 $x=1;
foreach($c_ids as $cid)
{
$sql1= "SELECT J.JFullName,J.jReasonType,J.Gender,J.JUser_Id,J.currentdate,J.JPhoto,J.JTotalEy,J.JTotalEm,J.JPLoc_Id,Jd.Company_Name,Jd.NoticePeriod,Jd.Des,Jd.NoticePeriod,L.Loc_Name,Jd.CurrentSalL,Jd.CurrentSalT,
Jd.ExpSalL,Jd.ExpMaxSalL,qo.Qual_Name
FROM tbl_jobseeker J
JOIN tbl_currentexperience Jd ON J.JUser_Id = Jd.JUser_Id
JOIN tbl_location L on J.JpLoc_Id=L.Loc_Id
LEFT JOIN tbl_education Ed on J.JUser_Id= Ed.JUser_Id 
LEFT JOIN tbl_qualification qo on Ed.Qual_Id=qo.Qual_Id  where J.JuserStatus='A' AND J.JUser_Id='".$cid."'
Group by J.JUser_Id 
ORDER BY J.currentdate DESC ";
$sql1_res=mysqli_query($con,$sql1);
$row2 = mysqli_fetch_array($sql1_res);
?>
    <!-- block -->
    <div class="mb15" >
        <div class="brdbg-white list-block-db row">
            <!-- job seekers block top results -->
            <div class="col-md-5 col-sm-12">
                <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <figure class="js-list-pic">
                        <img class="img-cover" data-object-fit="cover" src="<?php if($row2['JPhoto']){  echo $row2['JPhoto']; }else if($row2['Gender']=="Male") {?>img/js-profile-list-pic.jpg <?php } else {?>img/female.png <?php }?>" >
                    </figure>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-12 mobcenter">
                    <a href="jobseeker-detail-recruiter.php?uid=<?php echo $row2['JUser_Id'] ?>&pgid=2" class="name">
                        <h4 class="h4 txt-blue"><?php echo $row2['JFullName']; ?></h4>
                        <h5><?php echo $row2['Des']; ?></h5>
                        <p><?php echo $row2['Company_Name']; ?></p>
                    </a> <span class="notice-list"><?php?><?php if($row2['NoticePeriod']=='1'){echo "Immediate";}else {echo $row2['NoticePeriod']." days"; }?>   Notice</span> 
					<span class="notice-list tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?php echo $row2['jReasonType'];?> " style="font-size:10px;">Reason:<?php  $reason = substr($row2['jReasonType'], 0, 15);if(strlen($reason)<15){echo $reason ;}else{echo $reason."...";}?> </span> 												
					<p class="profile-action"><?php $query11s="select count(JUser_Id) as ids FROM tbl_employerview where JUser_Id='".$row2['JUser_Id']."' and  emp_id='".$_SESSION['empSession']."'";
									$qu_ress=mysqli_query($con,$query11s);
									$ress = mysqli_fetch_array($qu_ress);if($ress['ids'] !=0){?>
					 <span><a  href="jobseeker-detail-recruiter.php?uid=<?php echo $row2['JUser_Id'] ?>&pgid=6"><i class="fa fa-eye" aria-hidden="true"></i></a> </span>
					<?php }
					 $short_id="select count(JUser_Id) as sid FROM tbl_shortlisted where JUser_Id='".$row2['JUser_Id']."' and  emp_id='".$row[emp_id]."'";
									$s_id=mysqli_query($con,$short_id);
									$short_res = mysqli_fetch_array($s_id);if($short_res['sid'] !=0){?>
					 <span><a  href="dbrecruiter-profles-shortlist.php"><i class="fa fa-heart" aria-hidden="true"></i> </a> </span>
					<?php }
					 $sche_id="select count(juser_id) as scheid FROM interviewscheduled where juser_id='".$row2['JUser_Id']."' and  emp_id='".$row[emp_id]."'";
									$sc_id=mysqli_query($con,$sche_id);
									$sche_res = mysqli_fetch_array($sc_id);if($sche_res['scheid'] !=0){?>
					<span><a  href="dbrecruiter-sche-int.php"><i class="fa fa-calendar" aria-hidden="true"></i> </a></span>
					<?php }

					?>
					</p>
</div>
					
            </div>
            </div>
            <div class="col-md-7">
                 <!--/ job seekers block top results -->
            <div class="row">
                <div class="col-md-12">
                    <table width="100%" cellpadding="0" cellspacing="0" class="list-table">
                        <tr>
                            <td><i class="fa fa-black-tie" aria-hidden="true"></i></td>
                            <td class="grtxt"> Prof. Experience </td>
                            <td><?php echo $row2['JTotalEy']; ?> Years - <?php echo $row2['JTotalEm']; ?> Months</td>   
                            <td><i class="fa fa-map-marker" aria-hidden="true"></i></td>
                            <td class="grtxt"> Preferred Location </td>
                            <td><?php echo $row2['Loc_Name']; ?></td>
                        </tr> 
                        <tr>
                            <td><i class="fa fa-inr" aria-hidden="true"></i></td>
                            <td class="grtxt"> Current CTC (Lacs)</td>
                            <td><?php echo $row2['CurrentSalL']; ?></td>
                            <td><i class="fa fa-inr" aria-hidden="true"></i></td>
                            <td class="grtxt">Exp CTC (Lacs)</td>
                            <td>Min: <?php echo $row2['ExpSalL']; ?> - Max: <?php echo $row2['ExpMaxSalL']; ?>
							</td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-graduation-cap" aria-hidden="true"></i></td>
                            <td class="grtxt"> Education </td>
                            <td><?php echo $row2['Qual_Name']; ?></td>
                            <td><i class="fa fa-calendar" aria-hidden="true"></i></td>
                           	<td class="grtxt"> Last Active:</td>
								<td>
									<?php 
									 $nt_querys="select `Date&time` from tbl_recent_views where userid='".$row2['JUser_Id']."' order by `Date&time` DESC";
									$nt_ress=mysqli_query($con,$nt_querys);
									$datas_sws=mysqli_fetch_array($nt_ress);
									
									$date=date_create($datas_sws['Date&time']);
									echo date_format($date,"M d,Y");
									?>
								</td>
                        </tr>
                    </table>
                    <!-- job seekers skills bottom -->
                 <div class="skills-tab">
                <div class="col-md-12">
                    <h6 class="h6">Skills</h6><p class="skills-js-list">
					<?php 
                        $sql = "SELECT * FROM tbl_jobseeker WHERE JUser_Id=".$row2['JUser_Id'];
                                                                            $result = mysqli_query($con,$sql);
                                                                            $row1 = mysqli_fetch_array($result);
                                                                            $skills=$row1['Job_Skills'];
                                                                            $skill_ids=explode(",",$skills);?>
					<p class="skills-js-list"><?php foreach($skill_ids as $skillid)  
                    { 
                        $ms_sql1="select * from tbl_masterskills where skill_Id=".$skillid;
                                           $ms_result1 = mysqli_query($con,$ms_sql1);
                                           $ms_data1 = mysqli_fetch_array($ms_result1);?>      
                    <span><?php echo $ms_data1['skill_Name']; ?></span> 
                    <?php } ?> </p>
                </div>
            </div>
            <!--/ job seekers skills bottom -->
                </div>
                 
            </div>
           
            </div>
            
            
           
           
        </div>
    </div><?php    if(isset($_POST['Subs'])=="" && $x=="10") {
								  	if($d_cnt>=10){ 
							?><form method="post" action="">
								<input type="submit" name="Subs" class="btn waves-effect waves-light fbold text-center waves-input-wrapper" value="Load More">
							</form>
							<?php } 
								 exit();
							  }else{  
							  
							   }
							  
							  
                            $x++; ?>
    <!--/ block -->

 <?php 
                           
 } 
} else {?>
    
  
    <div class="noprofiles-available text-center">
<h3 class="h3">Sorry we couldn't find any Matches Profiles </h3>

<figure><img src="img/nofound.svg"></figure>
</div> 
	  </div>
<?php } 
?>
 <?php if($count >=10){ ?>
	<form method="post" action="dbrecruiter-latest.php">
	
	<input type="submit" name="Subs" class="btn waves-effect waves-light fbold text-center waves-input-wrapper" value="Load More">
	</form>
	<?php  } ?>                 <!-- top profiles list -->
                        <!-- top profiles list <a class="load-more btn" href="#!">Load More</a> </div> -->
			</div>
		</section>
            <!--/ dtashboard of profiles section -->
        </main>
        <!--/main-->
      
</body>

</html>