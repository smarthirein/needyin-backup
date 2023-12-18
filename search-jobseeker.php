<?php
header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire');
session_cache_limiter('public'); 
require_once 'class.user.php';
$user_home = new USER();
$actual_link = "$_SERVER[REQUEST_URI]";
if(!$user_home->is_logged_in())
{
    $user_home->redirect('index.php');
}


	if(isset($_POST['search']))
   {
			$lang_ids=$_POST['languages'];
			$PLoc=$_POST['PLoc'];
          $langids=implode(",",$lang_ids);
	  
  
    if($PLoc == "" || $PLoc == 0)
    {
      foreach($lang_ids as $lang_id)
           {
             $cj2="select * from tbl_jobposted where Job_Status='1' and  FIND_IN_SET('".$lang_id."', Job_Skill) "; 
                $resultcj2 = mysqli_query($con,$cj2);  
               while($result_cj2=mysqli_fetch_array($resultcj2))
               {
                $jobids[]=$result_cj2['Job_Id'];
                $experience[]=$result_cj2['Max_Exp'];
                $salary[]=$result_cj2['Sal_Range'];
            }

          } 
           $job_ids=array_filter(array_unique($jobids));
             $m_exp=array_filter(array_unique($experience));

             $sal_range=array_filter(array_unique($salary));

  
             $cc=count(array_filter($job_ids)); 
     
    } 	
    else
    { 
      foreach($lang_ids as $lang_id)
           {
            $cj2="select * from tbl_jobposted where Loc_Id='".$PLoc."' and   Job_Status='1' and  FIND_IN_SET('".$lang_id."', Job_Skill) ";
                $resultcj2 = mysqli_query($con,$cj2);  
               while($result_cj2=mysqli_fetch_array($resultcj2))
               {
                $jobids[]=$result_cj2['Job_Id'];
                $experience[]=$result_cj2['Max_Exp'];
                $salary[]=$result_cj2['Sal_Range'];
            }

          } 
             $job_ids=array_filter(array_unique($jobids));
             $m_exp=array_filter(array_unique($experience));
             $sal_range=array_filter(array_unique($salary));  
             $cc=count(array_filter($job_ids)); 
	    }
	  }
       
 ?>
 

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Needyin</title>
       
        <?php include "source.php"; ?>
    </head>

    <body>
                       
                        <input type="hidden" name="gexp" id="gexp" value="">
                        <input type="hidden" name="gsal" id="gsal" value="">
                         <input type="hidden" name="gday" id="gday" value="">
        <?php 
include_once("analyticstracking.php");
  if(isset($_SESSION['userSession']))
        {
             include "postlogin-header-jobseekar.php"; 
        } else {
    include "prelogin-header.php"; 
    } ?>
           
            <main>
                
                <section class="job-list">
                   
                    <div class="job-list-header">
                        <div class="container">
                          
                        <div class="row search-home nomrg">
                            <div class="search-home-in">
                                <div class="row">
                                <form method="post" action="">
                                  
                                    <div class="col-md-5 searchskills">
                                        <?php   $sql3 = "SELECT skill_Id,skill_Name FROM tbl_masterskills ORDER BY skill_Name";
                                                $query3 = mysqli_query($con, $sql3);
                                                if(!$query3)
                                                echo mysqli_error($con);
                                                ?>
                                                 <select id="languages" name="languages[]" multiple>
                                                  <option value="0" disabled>Select Skill</option>

                                                    <?php
                                                    while ($row3 = mysqli_fetch_array($query3))
                                                    { 
                                                     extract($row3);
                                                    ?>
                                                    <option value="<?php echo $row3['skill_Id']; ?>" <?php if (in_array($row3['skill_Id'],$lang_ids)){ echo 'selected'; } ?>><?php echo $row3['skill_Name']; ?></option>
                                                    <?php } ?> 
                                                </select>

                                       
                                    </div>
                                   
                                    <div class="col-md-5 sel-city">
                                        <div class="input-field">
                                        <?php 
                                                    $q1 = "SELECT * FROM tbl_location where Cntry_Id='101' ORDER BY Loc_Name";
                                                    $r1 = mysqli_query($con,$q1);?>
                                            <select name="PLoc" id="PLoc">
                                                     <option value="0" >Select Job Location</option>
                                                    <?php 
                                                    while($res1 = mysqli_fetch_array($r1)){
                                                    $locName = $res1['Loc_Name'];
                                                    $locId = $res1['Loc_Id'];
                                                    ?>
                                                    <option value="<?php echo $locId;?>" <?php if ($locId==$PLoc){ echo 'selected';}?> ><?php echo $locName;?></option>;
                                                    <?php }
                                                    ?>       
                                            </select>
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-2 btn-search">
                                        <input type="submit"  name="search" value="SEARCH" class="btn waves-effect waves-light fbold text-center" onclick="return validate();"/>
                                    </div>
                                  
                                </div>
                            </div>
                        </div>
                      
                            </form>
                        </div>
                    </div>
                  
                    <div class="container">
                        <ul class="bcrumb-listjobs">
                            <li> <a href="index.php">Home</a> </li>
                           <li> <a href="javascript:void(0)">Search </a> </li>
                         
                        </ul>
                    </div>
                  
                    <div class="container">
                        <div class="row">
                           
                            <div class="col-md-3">
                                <div class="search-filter" id="search-left-block">
                                    <h4 class="h4 search-filter-title">Filters results by</h4>
                                    <div class="search-section">
                                        <h5 class="h5 subtitle-search-section txt-blue">BY LOCATION</h5>
                                        <ul>
                                        <?php 											
										$sql2 = "SELECT Loc_Id,Loc_Name FROM tbl_location where Loc_Id=".$PLoc;
										$query2 = mysqli_query($con, $sql2);
                                        $row2 = mysqli_fetch_array($query2); ?>
										
                                                        <li>
                                                            
                                                            <label for="test<?php echo $row2['Loc_Id']; ?>">
                                                                <?php echo $row2['Loc_Name']; ?> </label>
                                                        </li>
                                                        
                                        </ul> 
                                 </div>
                                   
                                    
                                     <div class="search-section yrs-search">
                                    <h5 class="h5 subtitle-search-section txt-blue">MAX EXPERIENCE <span class="txt-blue">(YEARS)</span></h5>
                                    <div class="input-field">
                                       <?php  $exp_max=max($m_exp);
                                            if($exp_max<5) $max_exp="5"; else $max_exp=$exp_max;?>
                                       <select name="exp" id="exp" onchange="GetJobs_Exp(this.value,'<?php echo $langids;?>','<?php echo $PLoc;?>');">
                                            <option value="0" disabled selected>Select Experience</option>
                                             <?php 
                                             for($e=1;$e<=$max_exp;$e++){?>
                                                <option value="<?php echo $e;?>"><?php echo $e;?></option>
                                              <?php }?>
                                        </select>
                                       
                                    </div>
                                </div>
                                  
                                    <div class="search-section">
                                        <h5 class="h5 subtitle-search-section txt-blue">MAX SALARY</h5>
                                        <ul>
                                           
                                                <?php $sal_max=max($sal_range);
                                                if($sal_max<5) $max_sal="5"; else $max_sal=$sal_max;
                                                 for($s=1;$s<=$max_sal;$s++)  { 
                                                ?>
                                                    <li>
                                                        <input type="radio" id="jobsal<?php echo $s; ?>" value="<?php echo $s; ?>" name="sal" onclick="GetJobs_Sal('<?php echo $s;?>','<?php echo $langids;?>','<?php echo $PLoc;?>');" />
                                                        <label for="jobsal<?php echo $s; ?>">
                                                                <?php echo $s; ?> LAKHS </label>
                                                    </li>
                                                    <?php 
                                                    } 
                                                 ?>
                                            
                                        </ul> 
                                        <?php  if($sal_max>5) {?>
                                        <a href="javascript:void(0)" class="more-search" data-toggle="modal" data-target="#morepackages">More packages <i class="fa fa-arrow-right" aria-hidden="true"></i> </a>
                                        <?php } ?> </div>
                                  
                                    <div class="search-section">
                                        <h5 class="h5 subtitle-search-section txt-blue">LAST ACTIVE</h5>
                                        <ul>
                                            <li>
                                                <a href="javascript:void(0)">
                                                    <input class="with-gap" name="loc" type="radio" id="ltest3" onclick="GetJobs_Act('7','<?php echo $langids;?>','<?php echo $PLoc;?>');"/>
                                                    <label for="ltest3">Active Last 7 days</label>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)">
                                                    <input class="with-gap" name="loc" type="radio" id="ltest4" onclick="GetJobs_Act('30','<?php echo $langids;?>','<?php echo $PLoc;?>');"/>
                                                    <label for="ltest4">Active last 30 days</label>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)">
                                                    <input class="with-gap" name="loc" type="radio" id="ltest5" onclick="GetJobs_Act('90','<?php echo $langids;?>','<?php echo $PLoc;?>');"/>
                                                    <label for="ltest5">Active in last 90 days</label>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                  
                                </div>
                            </div>
                           
                            <div class="col-md-6">
                               
                                <div class="job-list" id="job-list">
                                    <div class="noofjobs brdbg-white">
                                        <?php $counts=mysqli_num_rows($resultcj2); 
                                if($cc!="") { ?>
                                            <p><span class="fbold txt-blue"><?php echo $cc; ?></span> Jobs found </p>
                                            <?php } else { ?>
                                                <p><span class="fbold txt-blue"></span> No Jobs </p>
                                                <?php } ?>
                                    </div>
                                   
                                    
                                    <?php  
                                if($cc!='0')
                                {
                                foreach($job_ids as $job_id)
			                        	{  
                                          $j_query="select * from tbl_jobposted where Job_Id='".$job_id."' and Job_Status='1'";  
                                          $j_res=mysqli_query($con,$j_query);
                                          $j_data=mysqli_fetch_array($j_res);

                                          $j_query1="select * from tbll_emplyer where emp_id='".$j_data['emp_id']."' ";  
                                          $j_res1=mysqli_query($con,$j_query1);
                                          $j_data1=mysqli_fetch_array($j_res1);


                                        ?>
                                        <div class="brdbg-white list-block">
                                            <div class="row job-title-list">
                                                <div class="col-md-8 col-xs-8">
                                                    <a class="txt-blue" href="job-detail-postlogin.php?uid=<?php echo $j_data['emp_id'];?>&jid=<?php echo $j_data['Job_Id'];?>&skills=<?php echo $langids;?>&loc=<?php echo $PLoc;?>">
                                                        <?php $sql2 = "SELECT * FROM tbl_desigination where Desig_Id ='".$j_data['Job_Name']."'";
										$query2 = mysqli_query($con, $sql2);
										$row2s = mysqli_fetch_array($query2);?>
									
										<?php echo $row2s['Desig_Name'];?>
                                                    </a> <span><?php echo $j_data['Comp_Name'];?></span> </div>
                                                <div class="col-md-4 col-xs-4 text-right">
                                                    <figure class="prelogo"><?php if($j_data1['eLogo']!="") { ?> 
                                                    <img src="<?php echo $j_data1['eLogo'];?>" > <?php } else { ?>
                                                     <img src="img/your-logo.png" >
                                                    <?php } ?>
                                                    </figure>
                                                </div>
                                            </div>
                                            <div class="usermain-features">
                                                <ul>
                                                    <li><i class="fa fa-suitcase" aria-hidden="true"></i>
                                                        <?php echo $j_data['Min_Exp'];?>-
                                                            <?php echo $j_data['Max_Exp'];?> Years</li>
                                                    <?php    $loc_query="select * from tbl_location where Loc_Id=".$j_data['Loc_Id'];  
                                          $loc_res=mysqli_query($con,$loc_query);
                                          $loc_data=mysqli_fetch_array($loc_res); ?>
                                                        <li><i class="fa fa-map-marker" aria-hidden="true"></i>
                                                            <?php echo $loc_data['Loc_Name'];?>
                                                        </li>
                                                        <li><i class="fa fa-calendar" aria-hidden="true"></i>
                                                            <?php echo $j_data['created'];?>
                                                        </li>
                                                </ul>
                                            </div>
                                            <div class=" list-emp-keyskills">
                                                <h6 class="h6">Key Skills</h6>
                                                <?php  $skill_ids=explode(",",$j_data['Job_Skill']); ?>
                                                    <p>
                                                        <?php foreach ($skill_ids as $skill_id) {

                                                     $s_query="select skill_Name from tbl_masterskills where skill_Id=".$skill_id;
                                                     $s_res=mysqli_query($con,$s_query);
                                                     $skill_name=mysqli_fetch_array($s_res);
                                                     ?> <span><?php echo $skill_name['skill_Name']; ?> </span>
                                                            <?php
                                                     
                                                   } ?>
                                                    </p>
                                            </div>
                                            <div class="sal-list-details">
                                                <?php    $emp_query="select * from tbll_emplyer where emp_id=".$j_data['emp_id'];  
                                          $emp_res=mysqli_query($con,$emp_query);
                                          $emp_data=mysqli_fetch_array($emp_res); ?>
                                                    <p>Salary:
                                                        <?php echo $j_data['Sal_Range'];?>,00,000 Lakhs PA <span class="pull-right"><?php if($j_data['notshow_jobseeker']==0) { ?>
                                                        <span class="pull-right  tooltipped" data-tooltip="email:<?php echo $emp_data['emp_email']."\n Contact No:".$emp_data['contact_num'];  ?>">Posted by <?php echo $emp_data['contact_name'];?> 
                                                        </span>
                                                        <?php } else { ?>
                                                        <span class="pull-right" >Posted by Confedential  </span>
                                                        <?php } ?> </p>
														
														
                                            </div>
                                        </div>
                                       
                                        <?php } 
                } else { ?>
                                            <center>No Jobs</center>
                                            <?php   }?>
                                </div>
                             
                            </div>
                           
                            <div class="col-md-3">
                               
                                <div class="right-block-list" id="right-list">
                                 
                                    <?php  foreach($lang_ids as $lang_id)
                                          {
                                              $cf="select flag from tbl_masterskills where skill_Id='".$lang_id."'"; 
                                                  $resultcf = mysqli_query($con,$cf);  
                                                  $result_cf=mysqli_fetch_array($resultcf); 
                                                  $flags[]=$result_cf['flag'];

                                            } 
                                           
                                            $flag_ids=array_filter(array_unique($flags));
                                            foreach($flag_ids as $flag_id)
                                          {
                                              $cf1="select skill_Id from tbl_masterskills where flag='".$flag_id."'"; 
                                               $resultcf1 = mysqli_query($con,$cf1);  
                                                 while($result_cf1=mysqli_fetch_array($resultcf1))
                                                 {
                                                  $skills[]=$result_cf1['skill_Id'];
                                                 }
                                          }
                                          $skill_ids=array_filter(array_unique($skills));
                                      

                                          $new_skills=array_diff($skill_ids,$lang_ids);   
                                      
                                          if($PLoc == "" || $PLoc == 0)
                                          {
                                               foreach ($new_skills as $skill_id)
                                            {
                                             $cjs="select  Job_Skill from tbl_jobposted where  Job_Status='1' and FIND_IN_SET('".$skill_id."', Job_Skill) "; 
                                                 $resultcjs = mysqli_query($con,$cjs);  
                                                 $result_count=mysqli_num_rows($resultcjs);
                                               
                                                 if($result_count>0)
                                                 {
                                                 
                                               
                                                    $skillids[]=$skill_id;
                                                 }
                                                 
                                             }        
                                          }
                                          else {
                                           foreach ($new_skills as $skill_id)
                                            {
                                             $cjs="select  Job_Skill from tbl_jobposted where Loc_Id='".$PLoc."' and Job_Status='1' and FIND_IN_SET('".$skill_id."', Job_Skill) "; 
                                                 $resultcjs = mysqli_query($con,$cjs);  
                                                 $result_count=mysqli_num_rows($resultcjs);
                                               
                                                 if($result_count>0)
                                                 {
                                                   
                                               
                                                    $skillids[]=$skill_id;
                                                 }
                                                 
                                             }  
                                         }
                                        $sc=count(array_filter($skillids)); ?>
                                   
                                    <div class="email-news brdbg-white">
                                        <h5 class="txt-blue h5">Jobs with Similar skills</h5>
                                        <h6 class="h6"><?php if($sc!='0'){ ?>Click below here<?php } else { ?>No Skills<?php } ?></h6>
                                        <ul class="similar-links-list">
                                            <ul class="similar-links-list">
                                         <?php 
										                      
										                    if($sc!='0')
									                     	{
                               

                                      foreach ($skillids as $skill_id) {

                                                     $s_query="select skill_Name,skill_Id from tbl_masterskills where skill_Id=".$skill_id;
                                                     $s_res=mysqli_query($con,$s_query);
                                                     $skill_name=mysqli_fetch_array($s_res);
                                                     ?>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="GetJobs_skill('<?php echo $PLoc;?>','<?php echo $skill_name['skill_Id']; ?>');">
                                                            <?php echo $skill_name['skill_Name']; ?>
                                                        </a>
                                                    </li>
                                                    <?php
                                                     
                                                   } ?>
                                <?php  }?>
                                            </ul>
                                        </ul>
                                    </div>
                                    
                                </div>
                               
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
                           
                        </div>
                    </div>
                  
                </div>
                
            </div>
          
            <div class="modal left fade modal-search" id="morepackages" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Packages</h4> </div>
                        <div class="modal-body">
                           
                            <div class="search-section">
                                <h5 class="h5 subtitle-search-section txt-blue">BY Salary</h5>
                                <ul>
                                    
                                        <?php 
                                                if($sal_max<5) $max_sal="5"; else $max_sal=$sal_max;
                                                 for($s=6;$s<=$max_sal;$s++)  { 
                                                $i=1; ?>
                                                    <li>
                                                        <input type="radio" id="jobsal<?php echo $s; ?>" value="<?php echo $s; ?>" name="loc" onclick="GetJobs_Sal('<?php echo $s;?>','<?php echo $langids;?>','<?php echo $PLoc;?>');" />
                                                        <label for="jobsal<?php echo $s; ?>">
                                                                <?php echo $s; ?> LAKHS </label>
                                                    </li>
                                                    <?php $i++; }
                                                 ?>
                                    
                                </ul>
                                
                            </div>
                          
                        </div>
                    </div>
                    
                </div>
                
            </div>
          
    </body>
    <script>
        function validate() {
            var skill = document.getElementById("languages").value;
            if (skill == 0) {
                alert("Please Select your Preferred Skill");
                document.getElementById("languages").focus();
                return false;
            }
            var PLoc = document.getElementById("PLoc").value;
            if (PLoc == 0) {
                alert("Please Select Location");
                document.getElementById("PLoc").focus();
                return false;
            }
           
        }
    </script>
<script>
 function GetJobs_Exp(exp,skill_ids,loc_id)
{
      document.getElementById("gexp").value=exp;
   
     var gt_sal= document.getElementById("gsal").value;
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
        document.getElementById("ltest3").checked = false;
        document.getElementById("jobsal").checked = false;
        
       
        }
      }
    xmlhttp.open("GET","get_jobslogin.php?exp="+exp+"&skill_ids="+skill_ids+"&loc_id="+loc_id+"&gt_sal="+gt_sal,true);
    xmlhttp.send();
}
 function GetJobs_Sal(sal,skill_ids,loc_id)
{
     document.getElementById("gsal").value=sal;
     var gt_exp= document.getElementById("gexp").value;
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
        document.getElementById("ltest3").checked = false;
        document.getElementById("exp").value=" ";
        }
      }
    xmlhttp.open("GET","get_jobslogin.php?sal="+sal+"&skill_ids="+skill_ids+"&loc_id="+loc_id+"&exp="+gt_exp,true);
    xmlhttp.send();
}
function GetJobs_Act(day,skill_ids,loc_id)
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
     
        document.getElementById("job-list").innerHTML=xmlhttp.responseText;
        document.getElementById("jobsal").checked = false;
       
        }
      }
    xmlhttp.open("GET","get_jobslogin.php?day="+day+"&skill_ids="+skill_ids+"&loc_id="+loc_id,true);
    xmlhttp.send();
}
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
      
        document.getElementById("job-list").innerHTML=xmlhttp.responseText;
      
       
        }
      }
    xmlhttp.open("GET","get_jobslogin.php?loc_id="+loc_id+"&skill_ids="+skill_id,true);
    xmlhttp.send();
}
 </script>
    </html>