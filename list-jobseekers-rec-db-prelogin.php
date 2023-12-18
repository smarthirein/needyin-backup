<?php 
header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire');
session_cache_limiter('public'); 
require_once 'class.user.php';
$user_home = new USER();

  if(isset($_POST['searchjobseek'])){
                                
                                            $lang_ids=$_POST['languages'];
											$langids=implode(",",$lang_ids);											
                                            $Loc=$_POST['location'];  
                                            $maxexp=$_POST['maxexp'];
                                             $minexp=$_POST['minexp'];
                                         
                                             foreach($lang_ids as $lang_id)
                                             {
												if(trim($_POST['location'])==0){ 
												$cj2="select JUser_Id from  tbl_jobseeker where JuserStatus='A' and (JPLoc_Id='".$Loc."' OR FIND_IN_SET('".$lang_id."', Job_Skills)) "; 
												} else {
													$cj2="select JUser_Id from  tbl_jobseeker where JuserStatus='A' and (JPLoc_Id='".$Loc."' AND FIND_IN_SET('".$lang_id."', Job_Skills)) "; 
												}
                                                  $resultcj2 = mysqli_query($con,$cj2);  
                                                  while( $result_cj2=mysqli_fetch_array($resultcj2) ){  
                                                  $jobids[]=$result_cj2['JUser_Id'];

 }
                                            }                                           
                                              $jobs_ids=array_filter(array_unique($jobids));
                                             $cc=count(array_filter($jobs_ids)); 

                                         }   
								
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Needyin</title>
        <!-- css includes-->
        <?php include "source.php"; ?>
		<style>
		.hide{
				display: none;
			}
		</style>
            <script>
                function GetProfiles(loc_id, skill_ids) {
                    document.getElementById("gloc").value = loc_id;
                    var gt_not = document.getElementById("gnotic").value;
                    var gt_sal = document.getElementById("gsal").value;
                    var gt_exp = document.getElementById("gexp").value;
                    var xmlhttp;
                    if (window.XMLHttpRequest) {
                        xmlhttp = new XMLHttpRequest();
                    }
                    else {
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function () {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            //alert(xmlhttp.responseText);
                            document.getElementById("job-list").innerHTML = xmlhttp.responseText;
                            document.getElementById("jobsal").checked = false;
                            document.getElementById("exp").value = "0";
                        }
                    }
                    xmlhttp.open("GET", "get_profiles.php?loc_id=" + loc_id + "&skill_ids=" + skill_ids + "&notice=" + gt_not + "&sal=" + gt_sal + "&exp=" + gt_exp, true);
                    xmlhttp.send();
                }

                function GetProfiles_Exp(exp, skill_ids) {
                    document.getElementById("gexp").value = exp;
                    var gt_not = document.getElementById("gnotic").value;
                    var gt_sal = document.getElementById("gsal").value;
                    var gt_loc = document.getElementById("gloc").value;
                    var xmlhttp;
                    if (window.XMLHttpRequest) {
                        xmlhttp = new XMLHttpRequest();
                    }
                    else {
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function () {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                          
                            document.getElementById("job-list").innerHTML = xmlhttp.responseText;
                            document.getElementsByName("loc").checked = false;
                            
                        }
                    }
                    xmlhttp.open("GET", "get_profiles.php?&skill_ids=" + skill_ids + "&notice=" + gt_not + "&sal=" + gt_sal + "&exp=" + exp + "&loc_id=" + gt_loc, true);
                    xmlhttp.send();
                }

                function GetProfiles_Sal(min, max, skill_ids) {
                    document.getElementById("gsal").value = min;
                    var gt_not = document.getElementById("gnotic").value;
                    var gt_exp = document.getElementById("gexp").value;
                    var gt_loc = document.getElementById("gloc").value;
                    var xmlhttp;
                    if (window.XMLHttpRequest) {
                        xmlhttp = new XMLHttpRequest();
                    }
                    else {
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function () {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                              
                            document.getElementById("job-list").innerHTML = xmlhttp.responseText;
                            document.getElementById("test").checked = false;
                        }
                    }
                    xmlhttp.open("GET", "get_profiles.php?&skill_ids=" + skill_ids + "&notice=" + gt_not + "&sal=" + min + "&exp=" + gt_exp + "&loc_id=" + gt_loc, true);
                    xmlhttp.send();
                }

                function GetProfiles_Act(notice, skill_ids) {
                    document.getElementById("gnotic").value = notice;
                    var gt_loc = document.getElementById("gloc").value;
                    var gt_sal = document.getElementById("gsal").value;
                    var gt_exp = document.getElementById("gexp").value;
                    var xmlhttp;
                    if (window.XMLHttpRequest) {
                        xmlhttp = new XMLHttpRequest();
                    }
                    else {
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function () {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                         
                            document.getElementById("job-list").innerHTML = xmlhttp.responseText;
                         
                        }
                    }
                    xmlhttp.open("GET", "get_profiles.php?notice=" + notice + "&skill_ids=" + skill_ids + "&sal=" + gt_sal + "&exp=" + gt_exp + "&loc_id=" + gt_loc, true);
                    xmlhttp.send();
                }
            </script>
            
            <script>
			
		</script>
    </head>

    <body>
        <input type="hidden" name="gloc" id="gloc" value="">
        <input type="hidden" name="gnotic" id="gnotic" value="">
        <input type="hidden" name="gexp" id="gexp" value="">
        <input type="hidden" name="gsal" id="gsal" value="">
        <?php include "includes-recruiter/prelogin-header-recruiter.php"; ?>
            <!-- main-->
            <main>
                <!-- search results, job list -->
                <section class="job-list">
                    <!-- job list header -->
                    <div class="job-list-header jobseekersheader">
                        <div class="container">
                            <!-- search -->
                            <div class="row search-home nomrg">
                                <div class="search-home-in recruiter-search-top">
                                    <div class="row">
                                        <form name="searchjobseek" method="post" action="">
                                            <!-- search by skills or titles -->
                                            <div class="col-md-6 col-sm-5 searchskills">
											 <label class="masterlabel">Select Skills </label>
                                                <div class="form-group">
                                                    <?php   $sql3 = "SELECT skill_Id,skill_Name FROM tbl_masterskills ORDER BY skill_Name ASC";
                                                $query3 = mysqli_query($con, $sql3);
                                                if(!$query3)
                                                echo mysqli_error($con);
                                                ?>
                                                        <select class="selectpicker" multiple data-live-search="true" data-live-search-placeholder="Search"  name="languages[]" id="languages">
                                                            <option value="0" disabled>Select Skills</option>
                                                            <?php
                                                while ($row3 = mysqli_fetch_array($query3))
                                                { 
                                                 extract($row3);
                                                ?>
                                                                <option value="<?php echo $row3['skill_Id']; ?>" <?php if (in_array($row3[ 'skill_Id'],$lang_ids)){ echo 'selected'; } ?> >
                                                                    <?php echo $row3['skill_Name']; ?>
                                                                </option>
                                                                <?php } ?>
                                                        </select>
                                                </div>
                                            </div>
                                            <!-- / search by skills -->
                                            <!-- select city -->
                                            <div class="col-md-4 col-sm-4 sel-city">
											 <label class="masterlabel">Select Location </label>
                                                <div class="form-group">
                                                    <?php     $sql3 = "SELECT Loc_Id,Loc_Name FROM tbl_location WHERE Cntry_Id=101 ORDER BY Loc_Name ";
                                                $query3 = mysqli_query($con, $sql3);
                                                if(!$query3)
                                                echo mysqli_error($con);
                                                ?>
                                                        <select class="selectpicker" data-live-search="true" data-live-search-placeholder="Search" data-actions-box="true" name="location" id="location">
                                                            <option value="0"></option>
                                                            <?php
                                                while ($row4 = mysqli_fetch_array($query3))
                                                { 
                                                 extract($row4);
                                                ?>
                                                                <option value="<?php echo $row4['Loc_Id']; ?>" <?php if ($row4[ 'Loc_Id']==$Loc){ echo 'selected';}?> >
                                                                    <?php echo $row4['Loc_Name']; ?>
                                                                </option>
                                                                <?php } ?>
                                                        </select>
                                                </div>
                                            </div>
                                            <!-- / select city -->
                                            <!-- minimum experience -->
                                            <!-- / Minimum experience -->
                                            <!--/ maximum experience -->
                                            <!-- button -->
                                            <div class="col-md-2 col-sm-3 btn-search">
                                                <!-- <button class="">SEARCH <i class="fa fa-search" aria-hidden="true"></i></button>-->
                                                <input type="submit" name="searchjobseek" value="SEARCH PROFILES" class="btn waves-effect waves-light fbold text-center " onclick="return validate();" /> </div>
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
                            <!-- left filters -->
                            <!--/ left filters -->
                            <!-- middle list job seekers -->
                            <div class="col-md-9 mob-lt col-sm-8" style="float:right;">
                                <!-- middle list jobs -->
                                <div class="job-list" id="job-list">
                                    <div class="noofjobs brdbg-white">
                                        <p>Showing
                                            <?php echo $cc; ?> of <span class="fbold txt-blue"><?php echo $count; ?></span> Job Seekers Found 
											</p>
											
                                    </div>
                                    <?php   
                             
                                  if($cc!='0')
                                  {

                                  foreach($jobs_ids as $jobs_id){
									
                                      $sql="select * from  tbl_jobseeker where JUser_Id=".$jobs_id;
                                        $sql_res=mysqli_query($con,$sql);
                                        $rowview2=mysqli_fetch_array($sql_res);
									
                                  $sql2="select * from  tbl_currentexperience where JUser_Id=".$jobs_id;
                                        $sql_res2=mysqli_query($con,$sql2);
                                        $row2=mysqli_fetch_array($sql_res2);
										
                                         $sql3="select Qual_Name from  tbl_qualification  where Qual_Id in(select Qual_Id from  tbl_education  where JUser_Id='$jobs_id')";
                                         $sql_res3=mysqli_query($con,$sql3);
                                         $row3=mysqli_fetch_array($sql_res3);

                                        ?>
                                        <!-- block -->
                                        <div class="brdbg-white list-block row">
                                            <!-- job seekers block top results -->
                                            <div class="">
											<?php echo $rowview2['JPhoto'];?>
                                                <div class="col-md-2 col-sm-4">                                             
													<figure> <img class="img-cover" style="position:relative !important;" data-object-fit="cover" src="<?php if($rowview2['JPhoto']){  echo $rowview2['JPhoto']; }else if($rowview2['Gender']=="Male") {?>img/js-profile-list-pic.jpg <?php } else {?>img/female.png <?php }?>" ></figure>
                                                </div>
                                                <div class="col-md-4 col-sm-8">
                                                    <a href="javascript:confirm('Please Login to View Profile Details', '', modernAlertCallback);" class="names">
                                                        <?php 
															$locs[] = $rowview2['JPLoc_Id'];											
															$tot_exp_years[] = $rowview2['JTotalEy'];											
															$tot_exp_years1 = max($tot_exp_years);
															$tot_sal_exp[] = $row2['ExpMaxSalL'];
															
															$tot_sal_exp1 = max($tot_sal_exp);
															$jnames=explode(" ",$rowview2['JFullName']);
														?>
                                                            <h4 class="h4 txt-blue"><?php echo $jnames[0];?></h4>
                                                            <h5><?php echo $rowview2['Des']; ?></h5>
                                                            <p>
                                                                <?php echo $rowview2['Company_Name']; ?>
                                                            </p>
                                                    </a> <span class="notice-list"><?php if($row2['NoticePeriod']=='1'){echo "Immediate";}else {echo $row2['NoticePeriod']." days Notice"; }?>  </span> </div>
                                                <div class="col-md-6 col-sm-8">
                                                    <table width="100%" cellpadding="0" cellspacing="0" class="list-table">
                                                        <tr>
                                                            <td><i class="fa fa-graduation-cap" aria-hidden="true"></i></td>
                                                            <td> Education</td>
                                                            <td>
                                                                <?php echo $row3['Qual_Name']; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa fa-user-o" aria-hidden="true"></i></td>
                                                            <td> Experience</td>
                                                            <td>
                                                                <?php echo $rowview2['JTotalEy']." "; ?>Years -
                                                                    <?php echo $rowview2['JTotalEm']." "; ?> Months</td>
                                                        </tr>
                                                        <tr>
                                                            <td> <i class="fa fa-inr" aria-hidden="true"></i></td>
                                                            <td> Exp CTC (Lacs)</td>
                                                            <td>Min:
                                                                <?php echo $row2['ExpSalL'];?> - Max:
                                                                    <?php echo $row2['ExpMaxSalL'];?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- job seekers skills bottom -->
                                                    <div class="skills-tab">
                                                        <div class="col-md-12 col-sm-12">
                                                            <h6 class="h6">Skills</h6>
                                                            <?php  $skill_ids=explode(",",$rowview2['Job_Skills']); ?>
                                                                <p class="skills-js-list">
                                                                    <?php foreach ($skill_ids as $skill_id) {

                                                     $s_query="select skill_Name from tbl_masterskills where skill_Id=".$skill_id;
                                                     $s_res=mysqli_query($con,$s_query);
                                                     $skill_name=mysqli_fetch_array($s_res);
                                                     ?> <span><?php echo $skill_name['skill_Name']; ?> </span>
                                                                        <?php
                                                     
                                                   } ?>
                                                                </p>
                                                        </div>
                                                    </div>
                                                    <!--/ job seekers skills bottom -->
                                                </div>
                                            </div>
                                            <!--/ job seekers block top results -->
                                        </div>
                                        <!--/ block -->
                                        <?php } 
} 
                                     
                                     
                                     
                                     else {
                                         
                                         echo "no records";
                                     }
                                    ?>
                                </div>
                            </div>
							<!--<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demos">Simple collapsible</button>-->
							  <!--<div id="demos" class="collapse">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit,
								sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
								quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
							  </div>-->
                            <div class="col-md-3 col-xs-12 col-sm-4" style="float:left;">
                               <div class="fixedtopblock" >
                                <div class="search-filter <?php if($cc==0) echo 'hide';?>" id="demos">
                                    <h4 class="h4 search-filter-title">Filters results by <button class="btn waves-effect waves-light fbold text-center " onclick="myFunction()"><i class="fa fa-refresh" aria-hidden="true"></i></button></h4>
                                    <script>
                                        function myFunction() {
                                            location.reload();
                                        }
                                    </script>
                                    <!-- Exploring, On Notice Period, Available now -->
                                    <div class="search-section">
                                        <ul>
										  <li> <a href="javascript:void(0)">
                                                <input type="radio" id="n8" name="notice" value="1" onclick="GetProfiles_Act(this.value,'<?php echo $langids;?>');"/>
                                                <label for="n8">Available Now </label>
                                            </a> </li>
                                            <li> <a href="javascript:void(0)">
                                                <input type="radio" id="n15" name="notice" value="15" onclick="GetProfiles_Act(this.value,'<?php echo $langids;?>');"/>
                                                <label for="n15">15 days Notice Period </label>
                                            </a> </li>
                                            <li> <a href="javascript:void(0)">
                                                <input type="radio" id="n30" name="notice" value="30" onclick="GetProfiles_Act(this.value,'<?php echo $langids;?>');"/>
                                                <label for="n30">30 days Notice Period </label>
                                            </a> </li>
                                            <li> <a href="javascript:void(0)">
                                                <input type="radio" id="n60" name="notice" value="60" onclick="GetProfiles_Act(this.value,'<?php echo $langids;?>');"/>
                                                <label for="n60"> 60 Days Notice Period </label>
                                            </a> </li>
                                          
                                        </ul>
                                    </div>
                                    <!-- / Exploring, On Notice Period, Available now -->
                                    <div class="search-section">
                                        <h5 class="h5 subtitle-search-section txt-blue">BY LOCATION</h5>
                                        <ul>
                                            <!-- running loop for retreiving the locations based on result set -->
                                            <?php     foreach($locs as $locss)
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
                                         }     foreach($loc_ids as $loc_id){ 
												 
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
                                        <?php if($cc1>10){  ?><a href="javascript:void(0)" class="more-search" data-toggle="modal" data-target="#myModal3">More Locations <i class="fa fa-arrow-right" aria-hidden="true"></i> </a>
                                            <?php } ?>
                                    </div>
                                    <!-- experience -->
                                    <div class="search-section yrs-search">
                                        <h5 class="h5 subtitle-search-section txt-blue">MIN EXPERIENCE <span class="txt-blue">(YEARS)</span></h5>
                                        <div class="form-group">
                                            <select class="form-control classic" name="exp" id="exp" onchange="GetProfiles_Exp(this.value,'<?php echo $langids;?>');">
                                                <option value="" disabled selected>Select Experience</option>
                                                <!-- OLD CODE for Locations -->
                                                <?php for($i=1;$i<=$tot_exp_years1+1;$i++){ ?>
                                                    <option value="<?php echo $i;?>">
                                                       &nbsp;&nbsp; <?php echo $i;?>
                                                    </option>
                                                    <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                    <!--/ experience -->
                                    <!-- search by salary -->
                                    <div class="search-section">
                                        <h5 class="h5 subtitle-search-section txt-blue">BY MIN SALARY</h5>
                                        <ul>
                                           
                                                        <?php for($i=1;$i<=$tot_sal_exp1;$i++){               if($i <=5)   {       ?>
                                                            <li>
                                                                <input type="radio" id="tests<?php echo Round($i); ?>" value="<?php echo Round($i); ?>" name="sal" onclick="GetProfiles_Sal('<?php echo Round($i);?>','<?php echo Round($i);?>','<?php echo $langids;?>');" />
                                                                <label for="tests<?php echo Round($i); ?>">
                                                                    <?php echo Round($i); ?> Lacs </label>
                                                            </li>
                                                            <?php }else{ break;}} ?>
                                                               
                                        </ul>
                                        <?php if($tot_sal_exp1>5){  ?><a href="javascript:void(0)" class="more-search" data-toggle="modal" data-target="#morepackages">More packages <i class="fa fa-arrow-right" aria-hidden="true"></i> </a>
                                            <?php }?>
                                    </div>
                                    <!-- / search by salary -->
                                    <!-- filter by skills -->
                                    <!--  <div class="search-section">
                                    <h5 class="h5 subtitle-search-section txt-blue">FILTER BY SKILLS</h5>
                                    <ul>
                                    <form method="post">
                                     <?php                                          
                                        $sql2 = "SELECT Loc_Id,Loc_Name FROM tbl_location limit 10";
                                        $query2 = mysqli_query($con, $sql2);
                                        if(!$query2)
                                        echo mysqli_error($con);
                                        ?>
                                        <?php
                                        while ($row2 = mysqli_fetch_array($query2))
                                        { 
                                         extract($row2);
                                        ?>
                                        <li>
                                            <a href="javascript:void(0)">
                                            <input type="checkbox" id="sk<?php echo $row2['Loc_Id']; ?>" name="loc" value="<?php echo $row2['Loc_Id']; ?>" onclick="this.form.submit();"/>                                              
                                            <label for="sk<?php echo $row2['Loc_Id']; ?>"><?php echo $row2['Loc_Name']; ?><span class="txt-blue">(240)</span></label>
                                            </a>
                                        </li>
                                        <?php } ?>
                                    </form>
                                    </ul> <a href="javascript:void(0)" class="more-search" data-toggle="modal" data-target="#moreskills">More Skills <i class="fa fa-arrow-right" aria-hidden="true"></i> </a> </div>-->
                                    <!--/ filter by skills -->
                                </div>
                                 <!-- advertisement space-->
                                            <div class="left-adspace-list">
                                                <figure>
                                                    <a href="javascript:void(0)"><img class="img-responsive" src="img/adv.jpg"></a>
                                                </figure>
                                                <figure>
                                                    <a href="javascript:void(0)"><img class="img-responsive" src="img/adv1.jpg"></a>
                                                </figure>
                                            </div>
                                            <!-- advertisement space -->
                            </div>
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
                                    <?php     foreach($locs as $locss)
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
                                <ul>
                                    <!-- running loop for retreiving the locations based on result set -->
                                  
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
                                <h5 class="h5 subtitle-search-section txt-blue">BY MIN Salary</h5>
                                <ul>
                                    <?php for($i=6;$i<=$tot_sal_exp1;$i++){              ?>
                                        <li>
                                            <input type="radio" id="tests<?php echo Round($i); ?>" value="<?php echo Round($i); ?>" name="sal" onclick="GetProfiles_Sal('<?php echo Round($i);?>','<?php echo Round($i);?>','<?php echo $langids;?>');" />
                                            <label for="tests<?php echo Round($i); ?>">
                                                <?php echo Round($i); ?> Lacs </label>
                                        </li>
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
            <div class="modal left fade modal-search" id="moreskills" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">By Skills</h4> </div>
                        <div class="modal-body">
                            <!-- more locations -->
                            <div class="search-section">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <input type="checkbox" id="sk6" />
                                            <label for="sk6">Javascript <span class="txt-blue">(240)</span></label>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <input type="checkbox" id="sk7" />
                                            <label for="sk7">Jquery<span class="txt-blue">(120)</span></label>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <input type="checkbox" id="sk8" />
                                            <label for="sk8">HTML<span class="txt-blue">(75)</span></label>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <input type="checkbox" id="sk9" />
                                            <label for="sk9">Java <span class="txt-blue">(85)</span></label>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <input type="checkbox" id="sk10" />
                                            <label for="sk10">Ajax<span class="txt-blue">(50)</span></label>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <input type="checkbox" id="sk11" />
                                            <label for="sk11">Bootstrap<span class="txt-blue">(240)</span></label>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <input type="checkbox" id="sk12" />
                                            <label for="sk12">CSS <span class="txt-blue">(120)</span></label>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <input type="checkbox" id="sk13" />
                                            <label for="sk13">HTML 5<span class="txt-blue">(75)</span></label>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <input type="checkbox" id="sk14" />
                                            <label for="sk14">CSS 3<span class="txt-blue">(85)</span></label>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <input type="checkbox" id="sk15" />
                                            <label for="sk15">Angular JS <span class="txt-blue">(50)</span></label>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!--/ more locations -->
                        </div>
                    </div>
                    <!-- modal-content -->
                </div>
                <!-- modal-dialog -->
            </div>
            <!--/ modal for more skills -->
            <!--/ more search filters -->
    </body>
    <script>
        function validate() {
            var skill = document.getElementById("languages").value;
            if (skill == 0) {
                alert("Please Select Skill Name");
                document.getElementById("languages").focus();
                return false;
            }
           
            var minexp = document.getElementById("minexp").value;
            if (minexp == 0) {
                alert("Please Select Minimum Experience");
                document.getElementById("minexp").focus();
                return false;
            }
            var maxexp = document.getElementById("maxexp").value;
            if (maxexp == 0) {
                alert("Please Select Maximum Experience");
                document.getElementById("maxexp").focus();
                return false;
            }
        }

        function login_alert() {
            alert("Please Login");
            window.location.href = "index-recruiter.php";
        }

        function modernAlertCallback(input) {
            if (typeof input === 'boolean') {
                if (input === true) {
                    var loc = '<?php echo $Loc ?>';
                    var lang_ids = '<?php echo $langids;?>';
                 
                    window.location.href = "index-recruiter.php?loc=" + loc + "&sids=" + lang_ids;
                }
                else {
                    return false;
                }
            }
        }
    </script>

    </html>