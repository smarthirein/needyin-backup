<?php 
session_start();
header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire');
session_cache_limiter('public'); 
require_once 'class.user.php';
$user_home = new USER();

if(!isset($_SESSION['empSession']))
{
		 $user_home->redirect('index-recruiter.php');   
} 
$stmt = $user_home->runQuery("SELECT * FROM tbll_emplyer WHERE emp_id=:eid");
$stmt->execute(array(":eid"=>$_SESSION['empSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$cj21="SELECT Job_Skill,Loc_Id FROM tbl_jobposted WHERE emp_id = '".$row[emp_id]."' and Job_Status=1 "; 
			$resultcj12 = mysqli_query($con,$cj21);  			
			while($result_cj12=mysqli_fetch_array($resultcj12))
			{  
			$jobskills[]=$result_cj12['Job_Skill'];
			$loc[]=$result_cj12['Loc_Id'];
			}
			$jobskills1=array_filter(array_unique($jobskills));
			$loc1=array_filter(array_unique($loc));
			 $ids = join(",",$jobskills1);				
			$ids2 =array_unique(explode(",",$ids));
			$loc_id = join(",",$loc1); 
			$locids =explode(",",$loc_id);				
			foreach($ids2 as $idss)
			{		
				$query11s="select JUser_Id FROM tbl_jobseeker where JuserStatus='A' and jdndstatus='0' and FIND_IN_SET('$idss',Job_Skills)";
				$qu_ress=mysqli_query($con,$query11s);
						while ($qu_data = mysqli_fetch_array($qu_ress)) 
						{
							$juser_ids[]=$qu_data['JUser_Id'];
							
						}
			}	
			$suids=array_filter(array_unique($juser_ids));
			foreach($locids as $loc)	
			{	
			$query22="select JUser_Id FROM tbl_jobseeker where JuserStatus='A' and  JPLoc_Id='".$loc."'";
			$qu_res21=mysqli_query($con,$query22);
			   while($qu_data2 = mysqli_fetch_array($qu_res21))
			   {
				  $luser_ids[]=$qu_data2['JUser_Id'];
			   }
			}
			$luserids=array_filter(array_unique($luser_ids));
			$c_ids=array_intersect($suids,$luserids);
			
 if(isset($_POST['searchjobseek']))
 {
                                
		$lang_ids=$_POST['languages'];
		$langids=implode(",",$lang_ids);		
		$Loc=$_POST['location'];  
		$maxexp=$_POST['maxexp'];
		 $minexp=$_POST['minexp'];
  }
   else if($_GET['skills']!="")
    {
      $lang_ids=explode(",",$_GET['skills']);
      $Loc=$_GET['loc'];
      $langids=$_GET['skills'];
     
    }  
		// loop for  job seekers  search with all conditions 		 
		 foreach($lang_ids as $lang_id)
		 {
			 if($Loc==0 && $minexp==0 && $maxexp==0){
				  $cj2="select JUser_Id from  tbl_jobseeker  where FIND_IN_SET('".$lang_id."', Job_Skills) AND JuserStatus='A' AND jdndstatus='0'"; 
				 
			 }else if($Loc==0 && $maxexp==0){
			 $cj2="select JUser_Id from  tbl_jobseeker  where JTotalEy  >='$minexp' AND FIND_IN_SET('".$lang_id."', Job_Skills) AND JuserStatus='A' AND jdndstatus='0'"; 
			 }
			  
			 else if($minexp==0 && $maxexp==0){
			 $cj2="select JUser_Id from  tbl_jobseeker  where (JPLoc_Id='".$Loc."' OR nri_status='Y') AND FIND_IN_SET('".$lang_id."', Job_Skills) AND JuserStatus='A' AND jdndstatus='0'"; 
			 }
			  else if($maxexp==0){
			 $cj2="select JUser_Id from  tbl_jobseeker  where (JPLoc_Id='".$Loc."' OR nri_status='Y') AND JTotalEy  >='$minexp' AND FIND_IN_SET('".$lang_id."', Job_Skills) AND JuserStatus='A' AND jdndstatus='0'"; 
			 }
			 else if($Loc==0){
		     $cj2="select JUser_Id from  tbl_jobseeker  where (JTotalEy between '$minexp' and '$maxexp') AND FIND_IN_SET('".$lang_id."', Job_Skills) AND JuserStatus='A' AND jdndstatus='0'"; 
			 }
			 else if($minexp==0){
		    $cj2="select JUser_Id from  tbl_jobseeker  where (JPLoc_Id='".$Loc."' OR nri_status='Y') AND JTotalEy  <='$maxexp' AND FIND_IN_SET('".$lang_id."', Job_Skills) AND JuserStatus='A' AND jdndstatus='0'"; 
			 }			
			else{
		    $cj2="select JUser_Id from  tbl_jobseeker  where (JPLoc_Id='".$Loc."' OR nri_status='Y') AND (JTotalEy between '$minexp' and '$maxexp') AND FIND_IN_SET('".$lang_id."', Job_Skills) AND JuserStatus='A' AND jdndstatus='0'"; 
			}			 
			 $resultcj2 = mysqli_query($con,$cj2); 
					while($result_cj2=mysqli_fetch_array($resultcj2))
                          {  
                             $jobids[]=$result_cj2['JUser_Id'];
                           }
		} 	  
		  $jobs_ids=array_filter(array_unique($jobids));
		 $cc=count(array_filter($jobs_ids)); 
	  

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
    <!-- css includes-->
    <?php include "source.php" ?>
	<style>
	.hide{
  display: none;
}
</style>
<script>
 function GetProfiles(loc_id,skill_ids)
{
  document.getElementById("gloc").value=loc_id;
  var max_y=document.getElementById("maxy").value;
  var fre_id=document.getElementById("fre").value;
  var min_y=document.getElementById("miny").value;
  var gt_not=document.getElementById("gnotic").value;
  var gt_sal=document.getElementById("gsal").value;
  var gt_exp=document.getElementById("gexp").value;
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
        //alert(xmlhttp.responseText);
        document.getElementById("job-list").innerHTML=xmlhttp.responseText;
       document.getElementById("jobsal").checked = false;
       document.getElementById("exp").value="0";       
        }
      }
    xmlhttp.open("GET","get_profiless.php?loc_id="+loc_id+"&fre_id="+fre_id+"&skill_ids="+skill_ids+"&notice="+gt_not+"&sal="+gt_sal+"&exp="+gt_exp+"&max_exp="+max_y+"&min_exp="+min_y,true);
    xmlhttp.send();
}

function GetProfiles_Exp(exp,skill_ids)
{
	document.getElementById("gexp").value=exp;
    var max_y=document.getElementById("maxy").value;
	 var fre_id=document.getElementById("fre").value;
    var min_y=document.getElementById("miny").value;
    var gt_not=document.getElementById("gnotic").value;
    var gt_sal=document.getElementById("gsal").value;  
    var gt_loc=document.getElementById("gloc").value;
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
         document.getElementsByName("loc").checked = false;
        }
      }
    xmlhttp.open("GET","get_profiless.php?&skill_ids="+skill_ids+"&fre_id="+fre_id+"&notice="+gt_not+"&sal="+gt_sal+"&exp="+exp+"&loc_id="+gt_loc+"&max_exp="+max_y+"&min_exp="+min_y,true);
    xmlhttp.send();
}
function GetProfiles_Sal(min,max,skill_ids)
{
document.getElementById("gsal").value=min;
 var max_y=document.getElementById("maxy").value;
	 var min_y=document.getElementById("miny").value;
	  var fre_id=document.getElementById("fre").value;
var gt_not=document.getElementById("gnotic").value; 
  var gt_exp=document.getElementById("gexp").value;
  var gt_loc=document.getElementById("gloc").value;
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
        //alert(xmlhttp.responseText);
	   
        document.getElementById("job-list").innerHTML=xmlhttp.responseText;
        document.getElementById("test").checked = false;
       
        }
      }
    xmlhttp.open("GET","get_profiless.php?&skill_ids="+skill_ids+"&fre_id="+fre_id+"&notice="+gt_not+"&sal="+min+"&exp="+gt_exp+"&loc_id="+gt_loc+"&max_exp="+max_y+"&min_exp="+min_y,true);
    xmlhttp.send();
}
function GetProfiles_Act(notice,skill_ids)
{ 
document.getElementById("gnotic").value=notice;

 var fre_id=document.getElementById("fre").value;
 //alert(fre_id);
  var gt_loc=document.getElementById("gloc").value;
  var gt_sal=document.getElementById("gsal").value;
  var gt_exp=document.getElementById("gexp").value;
   var max_y=document.getElementById("maxy").value;
	 var min_y=document.getElementById("miny").value;
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
    xmlhttp.open("GET","get_profiless.php?notice="+notice+"&fre_id="+fre_id+"&skill_ids="+skill_ids+"&sal="+gt_sal+"&exp="+gt_exp+"&loc_id="+gt_loc+"&max_exp="+max_y+"&min_exp="+min_y,true);
    xmlhttp.send();
}
function GetProfiles_fre(fre_id,skill_ids)
{
	document.getElementById("fre").value=fre_id;  
  var max_y=document.getElementById("maxy").value;
  var min_y=document.getElementById("miny").value;  
  var gt_not=document.getElementById("gnotic").value;
  var gt_sal=document.getElementById("gsal").value;
  var gt_exp=document.getElementById("gexp").value;
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
        //alert(xmlhttp.responseText);
        document.getElementById("job-list").innerHTML=xmlhttp.responseText;
       document.getElementById("jobsal").checked = false;
       document.getElementById("exp").value="0";       
        }
      }
    xmlhttp.open("GET","get_profiless.php?fre_id="+fre_id+"&skill_ids="+skill_ids+"&notice="+gt_not+"&sal="+gt_sal+"&exp="+gt_exp+"&max_exp="+max_y+"&min_exp="+min_y,true);
    xmlhttp.send();
}
</script>
</head>
<body>
<input type="hidden" name="miny" id="miny" value="<?php echo $minexp; ?>">
<input type="hidden" name="maxy" id="maxy" value="<?php echo $maxexp; ?>">
<input type="hidden" name="gloc" id="gloc" value="<?php echo $Loc; ?>">
<!--<input type="hidden" name="gloc" id="gloc" value="">-->
<input type="hidden" name="gnotic" id="gnotic" value="">
<input type="hidden" name="gexp" id="gexp" value="">
<input type="hidden" name="gsal" id="gsal" value="">
<input type="hidden" name="fre" id="fre" value="">
    <?php 
include_once("analyticstracking.php");
include "includes-recruiter/db-recruiter-header.php"; ?>

    <?php   ?>
        <!-- main-->
        <main class="db-needy">
            <!-- search results, job list -->
            <section class="job-list">
                <!-- job list header -->
                <div class="job-list-header jobseekersheader">
                    <div class="container">
                        <!-- search -->
                        <div class="row search-home nomrg">
                            <div class="search-home-in recruiter-search-top">
                                <div class="row">
                                <form name="searchjobseek" method="post" action="" id="searchjs">
                                    <!-- search by skills or titles -->
                                    <div class="col-md-3 col-sm-3 searchskills"> 
									<label class="masterlabel">Select Skills </label>
                                        <?php   $sql3 = "SELECT skill_Id,skill_Name FROM tbl_masterskills ORDER BY skill_Name  ";
                                                $query3 = mysqli_query($con, $sql3);
                                                if(!$query3)
                                                echo mysqli_error($con);
                                                ?>
                                            <select class="selectpicker" multiple data-live-search="true" data-live-search-placeholder="Search"  name="languages[]" id="languages">
                                                <option value="0" disabled >Select Skills</option>
                                                <?php
                                                while ($row3 = mysqli_fetch_array($query3))
                                                { 
                                                 extract($row3);
                                                ?>
                                                <option value="<?php echo $row3['skill_Id']; ?>" <?php if (in_array($row3['skill_Id'],$lang_ids)){ echo 'selected'; } ?> ><?php echo $row3['skill_Name']; ?></option>
                                                <?php } ?>
                                            </select>
                                            
                                    </div>
                                    <!-- / search by skills -->
                                    <!-- select city -->
                                    <div class="col-md-3 col-sm-3 sel-city">
									<label class="masterlabel">Select Location </label>
                                        <div class="form-group">
                                              <?php $sql3 = "SELECT Loc_Id,Loc_Name FROM tbl_location WHERE Cntry_Id=101 ORDER BY Loc_Name";
                                                $query3 = mysqli_query($con, $sql3);
                                                if(!$query3)
                                                echo mysqli_error($con);
                                                ?>
                                                <select class="selectpicker" data-live-search="true" data-live-search-placeholder="Search" data-actions-box="true" name="location" id="location" >
                                                <option value="0"></option>
                                                <?php
                                                while ($row4 = mysqli_fetch_array($query3))
                                                { 
                                                 extract($row4);
                                                ?>
                                                <option value="<?php echo $row4['Loc_Id']; ?>" <?php if ($row4['Loc_Id']==$Loc){ echo 'selected';}?> ><?php echo $row4['Loc_Name']; ?></option>
                                                <?php } ?>
                                                </select>
                                        </div>
                                    </div>
                                    <!-- / select city -->
                                    <!-- minimum experience -->
                                    <div class="col-md-2 col-sm-2 sel-city">
									<label class="masterlabel">Select Min Exp </label>
                                        <div class="form-group">
                                            <select class="selectpicker" data-live-search="true" data-live-search-placeholder="Search" data-actions-box="true" name="minexp" id="minexp">
                                                <option value="0"></option>
                                                 <?php for($i=1;$i<=30;$i++){?>
                                                    <option value="<?php echo $i;?>" <?php if ($i==$minexp){ echo 'selected';}?> ><?php echo $i;?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- / Minimum experience -->
                                    <!-- maximum experience -->
                                    <div class="col-md-2 col-sm-2 sel-city">
									<label class="masterlabel">Select Max Exp </label>
                                        <div class="form-group">
                                            <select class="selectpicker" data-live-search="true" data-live-search-placeholder="Search" data-actions-box="true" name="maxexp" id="maxexp">
                                                <option value="0"></option>
                                                 <?php for($i=1;$i<=30;$i++){?>
                                                    <option value="<?php echo $i;?>" <?php if ($i==$maxexp){ echo 'selected';}?> ><?php echo $i;?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                    <!--/ maximum experience -->
                                    <!-- button -->
                                    <div class="col-md-2 col-sm-2 btn-search">
                                       <!-- <button class="">SEARCH <i class="fa fa-search" aria-hidden="true"></i></button>-->
                                         <input type="submit"  name="searchjobseek" value="SEARCH" class="btn waves-effect waves-light fbold text-center " onclick="return validate();"/> 
                                    </div>
                                    <!--/ button -->
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- / search -->
                    </div>
                </div>
                <!-- / job list header -->
                <!-- bread crumb-->
                <div class="container">
                    <ul class="bcrumb-listjobs">
                        <li> <a href="dashboard-recruiter.php">Dashboard </a> </li>
                        <li> <a> Search </a> </li>
						<li style="float:right;font-size: 5px;height: 46px;margin-top: -24px;"><button type="button" class="btn navbar-toggle  btn-info collapsed" data-toggle="collapse" data-target="#demos"><span class="sr-only">Toggle navigation</span><i class="fa fa-filter" aria-hidden="true"></i> </button></li>
<script>					
					$(document).ready(function(){
    $("#collapsed").click(function(){
        $("div:first").addClass("collapse");

    });
});
</script>
                    </ul>
                </div>
                <!--/bread crumb-->
                <!-- row-->
                <div class="container">
                    <div class="row">
                      
                        <!-- middle list job seekers -->
                        <div class="col-md-9 col-sm-8 col-xs-12" style="float:right;">
                            <!-- middle list jobs -->
                            <div class="job-list" id="job-list">
                            
                                    <div class="noofjobs brdbg-white">
                                  <p>Showing  <?php echo $cc; ?> of <span class="fbold txt-blue"><?php echo $count; ?></span> Profiles Found </p>
                                   </div>    
                                  <?php   
                                
                                  if($cc!='0')
                                  {

                                  foreach($jobs_ids as $jobs_id){
								
                                $sql="select * from  tbl_jobseeker where JUser_Id=".$jobs_id;
                                        $sql_res=mysqli_query($con,$sql);
                                        $rowview2=mysqli_fetch_array($sql_res);
                                        $sql2="select * from  tbl_currentexperience  where JUser_Id=".$jobs_id;
                                        $sql_res2=mysqli_query($con,$sql2);
                                        $row2=mysqli_fetch_array($sql_res2);
                                         $sql3="select Qual_Name from  tbl_qualification  where Qual_Id in(select Qual_Id from  tbl_education  where JUser_Id='$jobs_id')";
                                         $sql_res3=mysqli_query($con,$sql3);
                                         $row3=mysqli_fetch_array($sql_res3);
                                        ?>

                               
                                <!-- block -->
                                <div class="brdbg-white list-block row">
                                    <!-- job seekers block top results -->
                                        <div class="col-md-2 col-sm-4">
                                            <figure class="js-list-pic">                                             
												 <img class="img-cover" data-object-fit="cover" src="<?php if($rowview2['JPhoto']){  echo $rowview2['JPhoto']; }else if($rowview2['Gender']=="Male") {?>img/js-profile-list-pic.jpg <?php } else {?>img/female.png <?php }?>" >
                                            </figure>
                                        </div>
                                        <div class="col-md-4 col-sm-8">
                                            <a href="jobseeker-detail-recruiter.php?uid=<?php echo $rowview2['JUser_Id'] ?>" class="name">
											<?php $locs1[] = $rowview2['JPLoc_Id'];//print_r($locs);
											$tot_exp_years[] = $rowview2['JTotalEy'];
											//$tot_sal_exp[] = $row2['ExpSalL'];
											 $tot_exp_years1 = max($tot_exp_years);
											$tot_sal_exp[] = $row2['ExpSalL'];
											 $tot_sal_exp1 = max($tot_sal_exp);
											
											?>
                                                <h4 class="h4 txt-blue"><?php echo $rowview2['JFullName']; ?></h4>
                                                <h5><?php echo $rowview2['Des']; ?></h5>
                                                <p><?php echo $rowview2['Company_Name']; ?></p>
                                            </a> <span class="notice-list"><?php if($row2['NoticePeriod']=='1'){echo "Immediate";}else {echo $row2['NoticePeriod']." days Notice"; }?>  </span>
											 <span class="notice-list tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?php echo $rowview2['jReasonType'];?> " style="font-size:10px;">Reason:<?php  $reason = substr($rowview2['jReasonType'], 0, 10);if(strlen($reason)<10){echo $reason ;}else{echo $reason."...";}?> </span> 												
											
											<p class="profile-action"><?php $query11s="select count(JUser_Id) as ids FROM tbl_employerview where JUser_Id='".$row2['JUser_Id']."' and  emp_id='".$row[emp_id]."'";
									$qu_ress=mysqli_query($con,$query11s);
									$ress = mysqli_fetch_array($qu_ress);if($ress['ids'] !=0){?>
									<?php if (in_array($row2['JUser_Id'], $c_ids)) {?>
							 <span> <a  href="jobseeker-detail-recruiter.php?uid=<?php echo $row2['JUser_Id'] ?>&pgid=1"><i class="fa fa-exchange" aria-hidden="true"></i> </a> </span>
							<?php } ?>
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
                                        <div class="col-md-6 col-sm-8">
                                            <table width="100%" cellpadding="0" cellspacing="0" class="list-table">
                                                <tr>
                                                    <td><i class="fa fa-graduation-cap" aria-hidden="true"></i></td>
                                                    <td> Education</td>
                                                    <td><?php echo $row3['Qual_Name']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-user-o" aria-hidden="true"></i></td>
                                                    <td> Experience</td>
                                                    <td><?php echo $rowview2['JTotalEy']."     "; ?>Years - <?php echo $rowview2['JTotalEm']." "; ?> Months</td>
                                                </tr>
                                                <tr>
                                                    <td> <i class="fa fa-inr" aria-hidden="true"></i></td>
                                                    <td> Exp CTC (Lacs)</td>
                                                    <td>Min : <?php echo $row2['ExpSalL'];?> - Max : <?php echo $row2['ExpMaxSalL'];?></td>
                                                </tr>
                                            </table>
                                            <!-- job seekers skills bottom -->
                                   
                                       <div class="skills-tab">
                                        <div class="col-md-12 col-sm-12">
                                            <h6 class="h6">Skills</h6>

                                        <?php  $skill_ids=explode(",",$rowview2['Job_Skills']); ?>

                                        <p class="skills-js-list"> <?php foreach ($skill_ids as $skill_id) {

                                                     $s_query="select skill_Name from tbl_masterskills where skill_Id=".$skill_id;
                                                     $s_res=mysqli_query($con,$s_query);
                                                     $skill_name=mysqli_fetch_array($s_res);
                                                     ?> <span><?php echo $skill_name['skill_Name']; ?> </span><?php
                                                     
                                                   } ?></p>
                                        </div>
                                        </div>
                                    
                                    <!--/ job seekers skills bottom -->
                                        </div>
                                    <!--/ job seekers block top results -->
                                </div>
                                <!--/ block -->
<?php } 
}                             else {
                                     ?>
                                         <figure class="text-center"><img src="img/nofound.svg"></figure>
                                     <?php 
                                  }
                                ?>
                                    
                            </div>
                        </div>
						  <!-- left filters -->
                        <div class="col-md-3 col-sm-4 col-xs-12" style="float:left;">
							<div class="fixedtopblock">
                            <div class="search-filter <?php if($cc==0) echo 'hide';?>" id="demos">
                                <h4 class="h4 search-filter-title">Filters results by  <button class="btn waves-effect waves-light fbold text-center " onclick="myFunction()"><i class="fa fa-refresh" aria-hidden="true"></i></button></h4>
                                <!-- Exploring, On Notice Period, Available now -->
								<script>
function myFunction() {
    location.reload();
}
</script>
                                <div class="search-section">
								<h5 class="h5 subtitle-search-section txt-blue">BY NOTICE PERIOD</h5>
                                    <ul>
									 <li>
                                            <a href="javascript:void(0)">
                                                <input type="radio" id="n8" name="notice" value="1" onclick="GetProfiles_Act(this.value,'<?php echo $langids;?>');"/>
                                                <label for="n8">Available Now </label>
                                            </a>
                                        </li>
									<li>
                                            <a href="javascript:void(0)">
                                                <input type="radio" id="n15" name="notice" value="15" onclick="GetProfiles_Act(this.value,'<?php echo $langids;?>');"/>
                                                <label for="n15">15 Days </label>
                                            </a>
                                        </li>
										 <li>
                                            <a href="javascript:void(0)">
                                                <input type="radio" id="n30" name="notice" value="30" onclick="GetProfiles_Act(this.value,'<?php echo $langids;?>');"/>
                                                <label for="n30">30 days </label>
                                            </a>
                                        </li>
										 <li>
                                            <a href="javascript:void(0)">
                                                <input type="radio" id="n60" name="notice" value="60" onclick="GetProfiles_Act(this.value,'<?php echo $langids;?>');"/>
                                                <label for="n60">60 days </label>
                                            </a>
                                        </li>
										
                                    </ul>
                                </div>
								<div class="search-section">
								<h5 class="h5 subtitle-search-section txt-blue">BY FRESHNESS</h5>
                                    <ul>
										<li>
                                            <a href="javascript:void(0)">
                                                <input type="radio" id="nf1" name="fress" value="1" onclick="GetProfiles_fre(this.value,'<?php echo $langids;?>');"/>
                                                <label for="nf1">1 Day </label>
                                            </a>
                                        </li>
										<li>
                                            <a href="javascript:void(0)">
                                                <input type="radio" id="nf7" name="fress" value="7" onclick="GetProfiles_fre(this.value,'<?php echo $langids;?>');"/>
                                                <label for="nf7">7 Days </label>
                                            </a>
                                        </li>
										<li>
                                            <a href="javascript:void(0)">
                                                <input type="radio" id="nf15" name="fress" value="15" onclick="GetProfiles_fre(this.value,'<?php echo $langids;?>');"/>
                                                <label for="nf15">15 Days </label>
                                            </a>
                                        </li>
										<li>
                                            <a href="javascript:void(0)">
                                                <input type="radio" id="nf30" name="fress" value="30" onclick="GetProfiles_fre(this.value,'<?php echo $langids;?>');"/>
                                                <label for="nf30">30 Days</label>
                                            </a>
                                        </li>
								<!--	<li>
                                            <a href="javascript:void(0)">
                                                <input type="radio" id="nf60" name="fress" value="60" onclick="GetProfiles_fre(this.value,'<?php echo $langids;?>');"/>
                                                <label for="nf60">60 Days</label>
                                            </a>
                                        </li>
										<li>
                                            <a href="javascript:void(0)">
                                                <input type="radio" id="nf90" name="fress" value="90" onclick="GetProfiles_fre(this.value,'<?php echo $langids;?>');"/>
                                                <label for="nf90">90 Days</label>
                                            </a>
                                        </li>
										-->
                                    </ul>
                                </div>
                                <!-- / Exploring, On Notice Period, Available now -->
                                <div class="search-section">
                                    <h5 class="h5 subtitle-search-section txt-blue">BY LOCATION</h5>
                                    <ul> 
									<!-- running loop for retreiving the locations based on result set -->
									
                                      <?php     foreach($locs1 as $locss)
                                             {    
											 
												   $sql2="SELECT Loc_Id ,Loc_Name FROM tbl_location where FIND_IN_SET('".$locss."',Loc_Id) ORDER By Loc_Name"; 
												   $query2 = mysqli_query($con,$sql2);  
                                                                                         ?>
                                        <?php
                                        while ($row2 = mysqli_fetch_array($query2))
                                        { 
                                      
										   $locids1[]=$row2['Loc_Id'];
										}										   
										   $loc_ids1=array_filter(array_unique($locids1));
										 
										   $loc_ids11=sort($loc_ids1);
                                             $cc1=count(array_filter($loc_ids11)); 	
                                        ?> 	 <?php }     foreach($loc_ids1 as $loc_id){ 
												 
										 $sqls="select Loc_Id,Loc_Name from  tbl_location  where Loc_Id='".$loc_id."' limit 10";
                                        $sql_ress=mysqli_query($con,$sqls);
                                        $rowview2s=mysqli_fetch_array($sql_ress);
												 
												 ?>
                                          <li>
                                        
                                            <input type="radio" id="test<?php echo $rowview2s['Loc_Id']; ?>" name="loc_id" value="<?php echo $rowview2s['Loc_Id']; ?>" onclick="GetProfiles('<?php echo $rowview2s['Loc_Id']; ?>','<?php echo $langids;?>');"/>
                                            <label for="test<?php echo $rowview2s['Loc_Id']; ?>"><?php echo $rowview2s['Loc_Name']; ?> </label>
                                        
                                        </li>
                                        <!--</a>-->
                                        <?php } ?>
                                  
                                    </ul> 
<?php if($cc1>10){  ?><a href="javascript:void(0)" class="more-search" data-toggle="modal" data-target="#myModal3">More Locations <i class="fa fa-arrow-right" aria-hidden="true"></i> </a><?php } ?> </div>
                                <!-- experience -->
                                
                                <div class="search-section yrs-search">
                                
                                    <h5 class="h5 subtitle-search-section txt-blue">Min Experience <span class="txt-blue">(YEARS)</span></h5>
                                    <div class="form-group">
                                    <!-- running loop for retreiving the experience based on result set -->
                                      <select name="exp" id="exp" class="form-control classic" onchange="GetProfiles_Exp(this.value,'<?php echo $langids;?>');">
                                            <option value="" disabled selected>Select Experience</option>
										
										<!-- OLD CODE for Locations -->
                                             <?php for($i=1;$i<=$tot_exp_years1+1;$i++){ ?>
                                                <option value="<?php echo $i;?>">&nbsp;&nbsp;<?php echo $i;?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <!--/ experience -->
                                <!-- search by salary -->
                                <div class="search-section">
                                    <h5 class="h5 subtitle-search-section txt-blue">Min Salary</h5>
                                    <ul>
											<?php for($i=1;$i<=$tot_sal_exp1;$i++){    
											if($i <=5)   {  
											?>                                         
												<li>  <input type="radio" id="tests<?php echo Round($i); ?>" value="<?php echo Round($i); ?>" name="sal" onclick="GetProfiles_Sal('<?php echo Round($i);?>','<?php echo Round($i);?>','<?php echo $langids;?>');"/>
												<label for="tests<?php echo Round($i); ?>"><?php echo Round($i); ?> Lacs </label>  </li>
										<?php } else { break; } } ?>    
                                    </ul>
<?php if($tot_sal_exp1>5){  ?><a href="javascript:void(0)" class="more-search" data-toggle="modal" data-target="#morepackages">More Packages <i class="fa fa-arrow-right" aria-hidden="true"></i> </a>
							<?php }?> </div>   
                                
                               <!--  filter by skills -->
                            </div>
                             <!-- advertisement space-->
                                            <!--<div class="left-adspace-list">
                                                <figure>
                                                    <a href="javascript:void(0)"><img class="img-responsive" src="img/adv.jpg"></a>
                                                </figure>
                                                <figure>
                                                    <a href="javascript:void(0)"><img class="img-responsive" src="img/adv1.jpg"></a>
                                                </figure>
                                            </div>-->
                                            <!-- advertisement space -->
                        </div>
                        <!--/ left filters -->
                       
                    </div>
                    
                    </div>
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
                         <!-- running loop for retreiving the locations based on result set -->
									
                                      <?php     foreach($locs1 as $locss)
                                             {    
											 
												$sql2="SELECT Loc_Id ,Loc_Name FROM tbl_location where FIND_IN_SET('".$locss."',Loc_Id)"; 
												   $query2 = mysqli_query($con,$sql2);  
                                                                                         ?>
                                        <?php
                                        while ($row2 = mysqli_fetch_array($query2))
                                        { 
                                      
										   $locids[]=$row2['Loc_Id'];
										}										   
										   $loc_ids=array_filter(array_unique($locids));
										   $loc_ids1=sort($loc_ids);
                                             $cc1=count(array_filter($loc_ids1)); 	
                                        ?>
                                            <?php }     foreach($loc_ids as $loc_id){ 
												 
												 $sqls="select Loc_Id,Loc_Name from  tbl_location  where Loc_Id='".$loc_id."' ORDER BY Loc_Name limit 10";
                                        $sql_ress=mysqli_query($con,$sqls);
                                        $rowview2s=mysqli_fetch_array($sql_ress);
												 
												 ?>
                                                <li>
                                                    <input type="radio" id="test<?php echo $rowview2s['Loc_Id']; ?>" name="loc_id" value="<?php echo $rowview2s['Loc_Id']; ?>" onclick="GetProfiles('<?php echo $rowview2s['Loc_Id']; ?>','<?php echo $langids;?>');" />
                                                    <label for="test<?php echo $rowview2s['Loc_Id']; ?>">
                                                        <?php echo $rowview2s['Loc_Name']; ?>
                                                    </label>
                                                </li>
                                                <!--</a>-->
                                                <?php } ?>
                                 
                            </ul>
                           
                        </div>
                        <!--/ more locations -->
                    </div>
                </div>
                <!-- modal-content -->
            </div>
            <!-- modal-dialog -->
        </div>
        <!-- modal for location -->
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
                            <h5 class="h5 subtitle-search-section txt-blue">By Salary</h5>
                            <ul>
                                                          <?php for($i=6;$i<=$tot_sal_exp1;$i++){              ?>                                         
                                                   <li>  <input type="radio" id="tests<?php echo Round($i); ?>" value="<?php echo Round($i); ?>" name="sal" onclick="GetProfiles_Sal('<?php echo Round($i);?>','<?php echo Round($i);?>','<?php echo $langids;?>');"/>
                                                    <label for="tests<?php echo Round($i); ?>"><?php echo Round($i); ?> Lacs </label>  </li>
										<?php } ?>
                            </ul>
                           
                        </div>
                        <!--/ more locations -->
                    </div>
                </div>
                <!-- modal-content -->
            </div>
            <!-- modal-dialog -->
        </div>
        <!-- / modal for more packages -->
        <!-- modal for more skills -->
        
       
        <!--/ modal for more skills -->
        <!--/ more search filters -->
</body>
<script>
function validate()
{
    var skill=document.getElementById("languages").value;
    if(skill==0)
    {
        alert("Please Select Skill Name");
        document.getElementById("languages").focus();
        return false;
    }

} 
</script>
</html>