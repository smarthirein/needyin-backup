<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
    <!-- css includes-->
    <?php include "source.php";
	session_start();
	?>
	<style>
	.hide{
  display: none;
}
</style>
        
</head>
    <?php 
include_once("analyticstracking.php");
  if(isset($_SESSION['userSession']))
        {
             include "postlogin-header-jobseekar.php"; 
        } else {
    include "prelogin-header1.php"; 
    } 

header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire');
session_cache_limiter('public'); 
$con_web_live = mysqli_connect("localhost","root","Prod@123");
mysqli_select_db($con_web_live, "needyin_phase1");

if(isset($_GET['cmpny_id'])) {
		 $job_list="SELECT * FROM tbl_jobposted WHERE Job_Status='1' AND emp_id = '".$_GET['cmpny_id']."' AND adm_status='A' ORDER BY created DESC";
		 
		$loc_list = "SELECT * FROM tbl_jobposted WHERE Job_Status='1' AND emp_id = '".$_GET['cmpny_id']."' AND adm_status='A' ORDER BY created DESC";
		$loc_list_res= mysqli_query($con_web_live, $loc_list);
		while($loc_id=mysqli_fetch_array($loc_list_res))
		{
			$locations[]=$loc_id['Loc_Id'];
			$jobids[]=$loc_id['Job_Id'];
            $experience[]=$loc_id['Max_Exp'];
            $salary[]=$loc_id['Sal_Range'];
		}
		$job_ids=array_filter(array_unique($jobids));
        $m_exp=array_filter(array_unique($experience));            
        $sal_range=array_filter(array_unique($salary));
		$locs=array_filter(array_unique($locations));    
		//print_r($locations);
		$job_list_res = mysqli_query($con_web_live,$job_list);
		if(mysqli_num_rows($job_list_res) == 0) { ?>
			<script>
				alert("No jobs found");
				window.location.href = "index.php";
			</script>
<?php	}

else { ?>
<script>
 function GetJobs(loc_id)
{
  document.getElementById("gloc").value=loc_id;
     var gt_exp= document.getElementById("gexp").value;
     var gt_sal= document.getElementById("gsal").value;
	 var cmpny_id = <?php echo $_GET['cmpny_id']; ?>;
   // alert(gt_exp);
     //  alert(gt_sal);
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
    xmlhttp.open("GET","get_jobs_company.php?loc_id="+loc_id+"&gt_exp="+gt_exp+"&gt_sal="+gt_sal+"&cmpny_id="+cmpny_id,true);
    xmlhttp.send();
}

function GetJobs_Exp(exp)
{
   document.getElementById("gexp").value=exp;
    var  gt_loc_radio= document.getElementById("gloc").value;
     var gt_sal= document.getElementById("gsal").value;
	 var cmpny_id = <?php echo $_GET['cmpny_id']; ?>;
	 if(gt_loc_radio=='') 
		 gt_loc=gt_loc_radio=0;
	 else
		 gt_loc=gt_loc_radio;
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
       // alert(xmlhttp.responseText);
        document.getElementById("job-list").innerHTML=xmlhttp.responseText;
      
       
        }
      }
    xmlhttp.open("GET","get_jobs_company.php?gt_exp="+exp+"&loc_id="+gt_loc+"&gt_sal="+gt_sal+"&cmpny_id="+cmpny_id,true);
    xmlhttp.send();
}
function GetJobs_Sal(sal)
{
  document.getElementById("gsal").value=sal;
     var gt_loc_radio= document.getElementById("gloc").value;
     var gt_exp= document.getElementById("gexp").value;
	 var cmpny_id = <?php echo $_GET['cmpny_id']; ?>;
	 /* if(gt_loc_radio=='' && gt_loc==0) 
		 gt_loc=0;
	 else
	 gt_loc=gt_loc_radio;*/
 if(gt_loc_radio=='') 
		 gt_loc=gt_loc_radio=0;
	 else
		 gt_loc=gt_loc_radio;
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
       // alert(xmlhttp.responseText);
        document.getElementById("job-list").innerHTML=xmlhttp.responseText;
      
       
        }
      }
    xmlhttp.open("GET","get_jobs_company.php?gt_sal="+sal+"&gt_exp="+gt_exp+"&loc_id="+gt_loc+"&cmpny_id="+cmpny_id,true);
    xmlhttp.send();
}


 </script>
  <main>
				    <input type="hidden" name="gloc" id="gloc" value="">
    <input type="hidden" name="gexp" id="gexp" value="">
    <input type="hidden" name="gsal" id="gsal" value="">
          
            <!-- search results, job list -->
            <section class="job-list">
                <!-- job list header -->
                <div class="job-list-header">
                    <div class="container">
                        <!-- search -->
                        <div class="row search-home nomrg" style="background:transparent;">
                            <div class="search-home-in">
                                <div class="row">
                 
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
                        <li> <a href="javascript:void(0)">Home</a> </li>
                        <li> <a href="javascript:void(0)">Search </a> </li>
                        <!--<li> <a href="javascript:void(0)">Software developer</a> </li>-->
                    </ul>
                </div>
                <!--/bread crumb-->
                <!-- row-->
                <div class="container">
                    <div class="row">
                                                <div class="col-md-3 col-sm-3">
                           <div class="fixedtopblock">
                           <div class="">
                            <div class="search-filter lefttop-filters <?php if(mysqli_num_rows($job_list_res)==0) echo 'hide';?>">
                                <h4 class="h4 search-filter-title">Filters Results By <button class="btn waves-effect waves-light fbold text-center " onclick="myFunction()"><i class="fa fa-refresh" aria-hidden="true"></i></button></h4>
									<script>
										function myFunction() {
											location.reload();
										}
									</script>
                                <div class="search-section">
                                    <h5 class="h5 subtitle-search-section txt-blue">Location</h5>
                                    <ul>
                                        <?php $lc=1;
                                        foreach($locs as $loc)
                                        { 
                                         $sql11 = "SELECT Loc_Id,Loc_Name FROM tbl_location where Loc_Id=".$loc;
                                        $query11 = mysqli_query($con_web_live, $sql11);
                                        $loc_data=mysqli_fetch_array($query11);
                                        ?> 
										<!--<a href="list-jobseekers-rec-db.php?loc=<?php //echo $row2['Loc_Id']; ?>">-->
                                          <li>                                        
                                            <input type="radio" id="test<?php echo $loc_data['Loc_Id']; ?>" name="loc" value="<?php echo $loc_data['Loc_Id']; ?>" onclick="GetJobs('<?php echo $loc_data['Loc_Id']; ?>');"/>
                                            <label for="test<?php echo $loc_data['Loc_Id']; ?>"><?php echo $loc_data['Loc_Name']; ?></label>
                                         
                                        </li>
                                        <!--</a>-->
                                        <?php $lc++; if($lc==5) { break;}
                                        }  ?>
                                    </ul> <?php  if($lc>=5) {?> <a href="javascript:void(0)" class="more-search" data-toggle="modal" data-target="#myModal3">More Locations <i class="fa fa-arrow-right" aria-hidden="true"></i> </a> 
                                    <?php } ?>
                                   </div>
                                <!-- experience -->
                                <div class="search-section yrs-search">
                                    <h5 class="h5 subtitle-search-section txt-blue">Min Experience </h5>
                                    <div class="form-group">
                                       <?php  $exp_max=max($m_exp);
                                            if($exp_max<5) $max_exp="5"; else $max_exp=$exp_max;?>
                                        <select name="exp" id="exp" onchange="GetJobs_Exp(this.value);" class="form-control classic">
                                         <option value="0" disabled selected></option>
                                             <?php 
                                             for($e=1;$e<=$max_exp;$e++){?>
                                                <option value="<?php echo $e;?>">&nbsp;&nbsp;<?php echo $e;if($e=="1"){echo " "."Year";}else { echo " "."Years";}?></option>
                                              <?php }?>
                                        </select>
                                       
                                    </div>
                                </div>
                                <!--/ experience -->
                                <!-- search by salary -->
                                <div class="search-section">
                                    <h5 class="h5 subtitle-search-section txt-blue">Min Salary</h5>
                                    <ul>
                                       
                                   <?php $sal_max=max($sal_range);
                                                if($sal_max<5) $max_sal="5"; else $max_sal=$sal_max;
                                                 for($s=1;$s<=$max_sal;$s++)  { 
                                                ?>
                                                    <li>
                                                        <input type="radio" id="jobsal<?php echo $s; ?>" value="<?php echo $s; ?>" name="sal" onclick="GetJobs_Sal('<?php echo $s;?>');" />
                                                        <label for="jobsal<?php echo $s; ?>"><?php echo $s;if($s=="1"){echo " "."Lac";}else { echo " "."Lacs";}?></label>
                                                    </li>
                                                    <?php if($s=='5') {  break; }
                                                    } 
                                                 ?>                            
                                   
                                    </ul>  <?php  if($sal_max > 5) {?>
                                    <a href="javascript:void(0)" class="more-search" data-toggle="modal" data-target="#morepackages">More Packages <i class="fa fa-arrow-right" aria-hidden="true"></i> </a> 
                                    <?php } ?>
                                    </div>
                                <!-- / search by salary -->
                                <!-- last active -->
                              <!--  <div class="search-section">
                                    <h5 class="h5 subtitle-search-section txt-blue">LAST ACTIVE</h5>
                                   <ul>
                                        <li>
                                                <input id="ltest7" name="group1" type="checkbox" onclick="GetJobs_Act('7','<?php echo $langids;?>');"/> <label for="ltest7">Active Last 7 days</label>
                                            </a>
                                        </li>
                                        <li>
                                                <input type="checkbox" name="group1" id="ltest30" onclick="GetJobs_Act('30','<?php echo $langids;?>');"/> <label for="ltest30">Active last 30 days</label>
                                            </a>
                                        </li>
                                        <li>
                                                <input type="checkbox" name="group1" id="ltest90" onclick="GetJobs_Act('90','<?php echo $langids;?>');"/> <label for="ltest90">Active in last 90 days</label>
                                            </a>
                                        </li>
                                    </ul>
                                </div> 
                                <!-- last active -->
                                
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
						                        <div class="col-md-6 col-sm-9">
                            <!-- middle list jobs -->
                             <div class="job-list" id="job-list">
                                <div class="noofjobs brdbg-white">
                                <?php $counts=mysqli_num_rows($job_list_res); 
                                if($counts!=0) { ?>
                                    <p><span class="fbold txt-blue"><?php echo $counts; ?></span> Jobs Found </p>
                                    <?php } else { ?>
                                    <p><span class="fbold txt-blue"></span> We could not find jobs matching your search criteria !!! </p>
                                    <?php } ?>
                                </div>
                                <!-- job list block -->
                                   <?php 
                              
                                if($counts!=0)
                                {
                                   // print_r($job_ids); 
                                foreach($job_ids as $job_id)
                                    {  
                                          $j_query="select * from tbl_jobposted where Job_Id='".$job_id."' and Job_Status='1'";  
                                          $j_res=mysqli_query($con_web_live,$j_query);
                                          $j_data=mysqli_fetch_array($j_res);

                                          $j_query1="select * from tbll_emplyer where emp_id='".$j_data['emp_id']."' ";  
                                          $j_res1=mysqli_query($con_web_live,$j_query1);
                                          $j_data1=mysqli_fetch_array($j_res1); ?>
										                                  <div class="brdbg-white list-block">
								<?php $sql2 = "SELECT * FROM tbl_desigination where Desig_Id ='".$j_data['Job_Name']."'";
										$query2 = mysqli_query($con_web_live, $sql2);
										$row2 = mysqli_fetch_array($query2); ?>
										 <div class="row job-title-list">
										         <div class="col-md-9 col-sm-8 col-xs-8">
									   <a class="txt-blue" href="<?php if(isset($_SESSION['userSession'])) echo "job-detail-postlogin.php?jid=".$j_data['Job_Id']."&uid=".$j_data['emp_id']; else echo "javascript:confirm('Please Login to View Job Details', '', );"; ?>"><?php echo $row2['Desig_Name'];?></a> 
									   <span><?php echo $j_data['Comp_Name'];?></span>  
									    <div class="usermain-features">
									    <ul>
                                            <li><i class="fa fa-suitcase" aria-hidden="true"></i> <?php echo $j_data['Min_Exp'];?>-<?php echo $j_data['Max_Exp'];?> Years</li>
                                         <?php    $loc_query="select * from tbl_location where Loc_Id=".$j_data['Loc_Id'];  
                                          $loc_res=mysqli_query($con_web_live,$loc_query);
                                          $loc_data=mysqli_fetch_array($loc_res); ?>
                                            <li><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $loc_data['Loc_Name'];?></li>
                                            <li><i class="fa fa-calendar" aria-hidden="true"></i> <?php $date=date_create($j_data['created']);echo date_format($date,"M d,Y");?></li>
                                        </ul>
                                         </div>
									   </div>
									      <div class="col-md-3 col-sm-4 col-xs-4 text-right">
                                            <figure class="prelogo">
                                                <?php if($j_data1['eLogo']!="") { ?> 
                                                    <img class="img-contain" data-object-fit="contain" src="<?php echo $j_data1['eLogo'];?>" > <?php } else { ?>
                                                     <img class="img-contain" data-object-fit="contain" src="img/your-logo.png" >
                                                    <?php } ?>
                                            </figure>
                                        </div>
										 </div>
										 
										                                     <div class=" list-emp-keyskills">
                                        <h6 class="h6">Key Skills</h6>
                                        <?php  $skill_ids=explode(",",$j_data['Job_Skill']); ?>

                                        <p> <?php foreach ($skill_ids as $skill_id) {

                                                     $s_query="select skill_Name from tbl_masterskills where skill_Id=".$skill_id;
                                                     $s_res=mysqli_query($con_web_live,$s_query);
                                                     $skill_name=mysqli_fetch_array($s_res);
                                                     ?> <span class="span-bgcol"><?php echo $skill_name['skill_Name']; ?> </span><?php
                                                     
                                                   } ?></p>
                                    </div>
									
									                                    <div class="sal-list-details">
                                    <?php    $emp_query="select * from tbll_emplyer where emp_id=".$j_data['emp_id'];  
                                          $emp_res=mysqli_query($con_web_live,$emp_query);
                                          $emp_data=mysqli_fetch_array($emp_res); ?>

                                       <p><b>CTC (Lacs) : </b>Min: <?php echo $j_data['Sal_Range']; ?> - Max: <?php echo $j_data['MSal_Range']; ?>
                                        <?php if($j_data['notshow_jobseeker']==0) { ?>

                                                        </span>
                                                        <?php } else { ?>
                                                        <span class="pull-right" ><b>Posted By : </b> Confidential  </span>
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
										</div> <?php
									}
								}
                                        ?> 
                                
                              
                            </div>
                            <!-- middle list jobs -->
                            <!-- page navigation -->
                            <!--<ul class="pagination">
                            <li class="disabled"><a href="#!"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li>
                            <li class="active"><a href="#!">1</a></li>
                            <li class="waves-effect"><a href="#!">2</a></li>
                            <li class="waves-effect"><a href="#!">3</a></li>
                            <li class="waves-effect"><a href="#!">4</a></li>
                            <li class="waves-effect"><a href="#!">5</a></li>
                            <li class="waves-effect"><a href="#!"><i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
                              </ul>-->
                            <!--/ page navigatin -->
                        </div>
						
						                        <div class="col-md-3 col-sm-3 hidden-sm">
                           <div class="rightfix">
                            <!-- right block page -->
                            <div class="right-block-list" id="right-list">
                              
                                <div class="email-news brdbg-white <?php if($cc==0) echo 'hide';?>">
                                    <h5 class="txt-blue h5 ">Jobs With Similar Skills</h5>
                                    <h6 class="h6">Click below here</h6>
                                   
                                        <ul class="similar-links-list mCustomScrollbar ">
                                        <?php 
                      foreach($language_ids as $lang_id)
                                          {
                                              $cf="select flag from tbl_masterskills where skill_Id='".$lang_id."'"; 
                                                  $resultcf = mysqli_query($con_web_live,$cf);  
                                                  $result_cf=mysqli_fetch_array($resultcf); 
                                                  $flags[]=$result_cf['flag'];

                                            } 
                                           // print_r($flags);
                                            $flag_ids=array_filter(array_unique($flags));
                                            foreach($flag_ids as $flag_id)
                                          {
                                              $cf1="select skill_Id from tbl_masterskills where flag='".$flag_id."'"; 
                                               $resultcf1 = mysqli_query($con_web_live,$cf1);  
                                                 while($result_cf1=mysqli_fetch_array($resultcf1))
                                                 {
                                                  $skills[]=$result_cf1['skill_Id'];
                                                 }
                                          }
                         $skill_ids=array_filter(array_unique($skills));
                      foreach ($skill_ids as $skill_id)
                                            {
                                             $cjs="select  Job_Skill from tbl_jobposted where Job_Status='1' and FIND_IN_SET('".$skill_id."', Job_Skill) "; 
                                                 $resultcjs = mysqli_query($con_web_live,$cjs);  
                                                 $result_count=mysqli_num_rows($resultcjs);
                                               
                                                 if($result_count>0)
                                                 {
                                                     $skillids[]=$skill_id;
                                                 }
                                                 
                                             }                  
                        $sc=count(array_filter($skillids)); 
                    
                        $new_skills1=array_diff($skillids,$language_ids);  
                        $new_skills2=array_diff($language_ids,$skillids);
                        $similar_skills=array_unique(array_merge($new_skills1,$new_skills2));
                    if($sc!='0')
                    {

                                      foreach ($similar_skills as $skill_id) {

                                                     $s_query="select skill_Name,skill_Id from tbl_masterskills where skill_Id=".$skill_id;
                                                     $s_res=mysqli_query($con_web_live,$s_query);
                                                     $skill_name=mysqli_fetch_array($s_res);
                                                     ?>
                                                    <li class="li-bgcol">
                                                        <a href="javascript:void(0)" onclick="GetJobs_skill('<?php echo $skill_name['skill_Id']; ?>');">
                                                            <?php echo $skill_name['skill_Name']; ?>
                                                        </a>
                                                    </li>
                                                    <?php
                                                     
                                                   } ?>
                                                        <?php  }?>
                                    </ul>
                                  
                                </div>
                                <!-- jobs with similar skills -->
                            </div>
                            <!-- / right block page -->
                            <!-- advertisement space-->
                            <div class="right-adspace-list">
                                <figure>
                                    <a href="javascript:void(0)"><img class="img-responsive" src="img/adv.jpg"></a>
                                </figure>
                                <figure>
                                    <a href="javascript:void(0)"><img class="img-responsive" src="img/adv1.jpg"></a>
                                </figure>
                            </div>
                            <!-- advertisement space -->
                        </div>
                        <!--/ right block -->
                        </div>
                     </div>
			</div>

		</section>
	</main>
			  <div class="modal left fade modal-search" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Locations</h4> </div>
                    <div class="modal-body">
                        <!-- more locations -->
                        <div class="search-section ">
                            <h5 class="h5 subtitle-search-section txt-blue">Location</h5>
                          
                                         <ul>                     
                                      <?php 
                                        foreach($locs as $loc)
                                        { 
                                        $sql11 = "SELECT Loc_Id,Loc_Name FROM tbl_location where Loc_Id=".$loc;
                                        $query11 = mysqli_query($con_web_live, $sql11);
                                        $loc_data=mysqli_fetch_array($query11);
                                        ?> <!--<a href="list-jobseekers-rec-db.php?loc=<?php //echo $row2['Loc_Id']; ?>">-->
                                          <li>
                                            <input type="radio" id="test<?php echo $loc_data['Loc_Id']; ?>" name="loc" value="<?php echo $loc_data['Loc_Id']; ?>" onclick="GetJobs('<?php echo $loc_data['Loc_Id']; ?>','<?php echo $langids;?>');"/>
                                            <label for="test<?php echo $loc_data['Loc_Id']; ?>"><?php echo $loc_data['Loc_Name']; ?></label>
                                         
                                        </li>
                                        <!--</a>-->
                                        <?php  }  ?>
                                    </ul>
                          
                            <!--<button class="btn waves-effect waves-light btn-xs btn-blue-sm" type="submit" name="action">APPLY FILTERS </button>-->
                        </div>
                        <!--/ more locations -->
                    </div>
                </div>
                <!-- modal-content -->
            </div>
            <!-- modal-dialog -->
        </div>
		 <div class="modal left fade modal-search" id="morepackages" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Packages</h4> </div>
                    <div class="modal-body">
                        <!-- more locations -->
                        <div class="search-section">
                            <h5 class="h5 subtitle-search-section txt-blue">Min Salary</h5>
                            <ul>
                                 
                                    <?php 
                                                if($sal_max<5) $max_sal="5"; else $max_sal=$sal_max;
                                                 for($s=6;$s<=$max_sal;$s++)  { 
                                                $i=1; ?>
                                                    <li>
                                                        <input type="radio" id="jobsal<?php echo $s; ?>" value="<?php echo $s; ?>" name="sal" onclick="GetJobs_Sal('<?php echo $s;?>','<?php echo $langids;?>','<?php echo $PLoc;?>');" />
                                                        <label for="jobsal<?php echo $s; ?>">
                                                                <?php echo $s; ?> Lacs </label>
                                                    </li>
                                                    <?php $i++; }
                                                 ?>                                      
                                    
                            </ul>
                            <!--<button class="btn waves-effect waves-light btn-xs btn-blue-sm" type="submit" name="action">APPLY FILTERS </button>-->
                        </div>
                        <!--/ more locations -->
                    </div>
                </div>
                <!-- modal-content -->
            </div>
            <!-- modal-dialog -->
        </div>
<?php }
}	 else {
		?><script>
				alert("No jobs found1");
				window.location.href = "index.php";
			</script>
			<?php
	}
?>

	
	?>
	
	