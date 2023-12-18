<?php
//require_once("config.php");
require_once 'class.user.php';

		if(isset($_POST['search'])){
			$languages=$_POST['languages'];
			$PLoc=$_POST['PLoc'];	
            foreach($languages as $lang)	
            {	
			 $cj1="select skill_Id from tbl_masterskills where skill_Name='".$lang."'";
			$resultcj1 = mysqli_query($con,$cj1);
            $result_cj1=mysqli_fetch_array($resultcj1);
            $lang_ids[]=$result_cj1['skill_Id'];
            }      
             foreach($lang_ids as $lang_id)
             {
			      $cj2="select * from tbl_jobposted where Loc_Id='".$PLoc."' and FIND_IN_SET('".$lang_id."', Job_Skill) "; 
                  $resultcj2 = mysqli_query($con,$cj2);  
                  $result_cj2=mysqli_fetch_array($resultcj2); 
                  $job_ids[]=$result_cj2['Job_Id'];
            }        			
		}else if(isset($_POST['loc'])){
			
			
			  $sql1= "SELECT J.*,qo.Qual_Name,Ed.contact_name,L.Loc_Name
									FROM tbl_jobposted J		
									JOIN tbl_location L on J.Loc_Id=L.Loc_Id
									LEFT JOIN tbll_emplyer Ed on J.emp_id= Ed.emp_id 
									LEFT JOIN tbl_qualification qo on J.PEduc_Id=qo.Qual_Id
									where  J.Loc_Id='". $_POST['loc']."' " ;
					
									$resultcj2 = mysqli_query($con,$sql1);  
												  
		}  else if(isset($_POST['exp'])){
			
			
			  $sql1= "SELECT J.*,qo.Qual_Name,Ed.contact_name,L.Loc_Name
									FROM tbl_jobposted J		
									JOIN tbl_location L on J.Loc_Id=L.Loc_Id
									LEFT JOIN tbll_emplyer Ed on J.emp_id= Ed.emp_id 
									LEFT JOIN tbl_qualification qo on J.PEduc_Id=qo.Qual_Id
									where  J.Max_Exp<='".$_POST['exp']."' " ;
					
									$resultcj2 = mysqli_query($con,$sql1);  
												  
		} 
		else if(isset($_POST['sals'])){
			
			 $str=$_POST['sals'];
					 $str1=explode("-",$str);
			  $sql1= "SELECT J.*,qo.Qual_Name,Ed.contact_name,L.Loc_Name
									FROM tbl_jobposted J		
									JOIN tbl_location L on J.Loc_Id=L.Loc_Id
									LEFT JOIN tbll_emplyer Ed on J.emp_id= Ed.emp_id 
									LEFT JOIN tbl_qualification qo on J.PEduc_Id=qo.Qual_Id
									where  Jd.ExpSalL >='".$str1[0]."' and Jd.ExpSalL <='".$str1[1]."'GROUP BY J.emp_id	";
					
									$resultcj2 = mysqli_query($con,$sql1);  
												  
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
</head>

<body>
    <?php 
include_once("analyticstracking.php");
include "prelogin-header.php"; ?>
        <!-- main-->
        <main>
            <!-- search results, job list -->
            <section class="job-list">
                <!-- job list header -->
                <div class="job-list-header">
                    <div class="container">
                        <!-- search -->
                        <div class="row search-home nomrg">
                            <div class="search-home-in">
                                <div class="row">
                                <form method="post" action="">
                                    <!-- search by skills or titles -->
                                    <div class="col-md-5 searchskills">
                                        <?php   $sql3 = "SELECT skill_Id,skill_Name FROM tbl_masterskills";
                                                $query3 = mysqli_query($con, $sql3);
                                                if(!$query3)
                                                echo mysqli_error($con);
                                                ?>
                                                 <select id="languages" name="languages[]" multiple>
                                                    <?php
                                                    while ($row3 = mysqli_fetch_array($query3))
                                                    { 
                                                     extract($row3);
                                                    ?>
                                                    <option><?php echo $row3['skill_Name']; ?></option>
                                                    <?php } ?> 
                                                </select>option>
                                        </datalist>
                                    </div>
                                    <!-- / search by skills -->
                                    <!-- select city -->
                                    <div class="col-md-5 sel-city">
                                        <div class="input-field">
                                            <select name="PLoc">
                                                    <option value="0" disabled >Select Job Location</option>
                                                    <?php 
                                                    $q1 = "SELECT * FROM tbl_location ORDER BY Loc_Name";
                                                    $r1 = mysqli_query($con,$q1);
                                                    while($res1 = mysqli_fetch_array($r1)){
                                                    $locName = $res1['Loc_Name'];
                                                    $locId = $res1['Loc_Id'];
                                                    ?>
                                                    <option value="<?php echo $locId;?>" <?php if ($loctName==$locName){ echo 'selected';}?> ><?php echo $locName;?></option>;
                                                    <?php }
                                                    ?>       
                                                </select>
                                        </div>
                                    </div>
                                    <!-- / select city -->
                                    <!-- button -->
                                    <div class="col-md-2 btn-search">
                                        <input type="submit"  name="search" value="SEARCH" class="btn waves-effect waves-light fbold text-center"/>
                                    </div>
                                    <!--/ button -->
                                </div>
                            </div>
                        </div>
                        <!-- / search -->
                        </form>
                    </div>
                </div>
                <!-- / job list header -->
                <!-- job list navigatin -->
                <div class="job-list-nav">
                    <div class="container">
                        <ul id="dropdown1" class="dropdown-content">
                            <li><a href="javascript:void(0)">Software Developer</a></li>
                            <li><a href="javascript:void(0)">UI/UX Development </a></li>
                            <li><a href="javascript:void(0)">Mobile Development  </a></li>
                            <li><a href="javascript:void(0)">Microsoft Technologies</a></li>
                            <li><a href="javascript:void(0)">PHP Jobs</a></li>
                            <li><a href="javascript:void(0)">Adnroid Jobs</a></li>
                            <li><a href="javascript:void(0)">IOS </a></li>
                            <li><a href="javascript:void(0)">Testing</a></li>
                            <li><a href="javascript:void(0)">Management</a></li>
                            <li><a href="javascript:void(0)">Marketing</a></li>
                        </ul>
                        <nav>
                            <div class="nav-wrapper">
                                <ul class="">
                                    <li><a href="javascript:void(0)">Software Developer</a></li>
                                    <li><a href="javascript:void(0)">UI/UX Development </a></li>
                                    <li><a href="javascript:void(0)">Mobile Development  </a></li>
                                    <li><a href="javascript:void(0)">Microsoft Technologies</a></li>
                                    <li><a href="javascript:void(0)">Management Jobs </a></li>
                                </ul>
                                <ul class="right ">
                                    <li><a class="dropdown-button" href="#!" data-activates="dropdown1">More Categories <i class="fa fa-bars" aria-hidden="true"></i></a></li>
                                </ul>
                                <script>
                                    $(".dropdown-button").dropdown();
                                </script>
                            </div>
                        </nav>
                    </div>
                </div>
                <!-- job list navigation -->
                <!-- bread crumb-->
                <div class="container">
                    <ul class="bcrumb-listjobs">
                        <li> <a href="javascript:void(0)">Home</a> </li>
                        <li> <a href="javascript:void(0)">Search </a> </li>
                        <li> <a href="javascript:void(0)">Software developer</a> </li>
                    </ul>
                </div>
                <!--/bread crumb-->
                <!-- row-->
                <div class="container">
                    <div class="row">
                        <!-- left filters -->
                        <div class="col-md-3">
                            <div class="search-filter" id="search-left-block">
                                <h4 class="h4 search-filter-title">Filters results by</h4>
                                <div class="search-section">
                                    <h5 class="h5 subtitle-search-section txt-blue">BY LOCATION</h5>
                                    <ul>
                                        <form  method="post" >
									
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
										?> 
										  <li>
										
											<input type="checkbox" id="test<?php echo $row2['Loc_Id']; ?>" name="loc" value="<?php echo $row2['Loc_Id']; ?>" onclick="this.form.submit();"/>
											<label for="test<?php echo $row2['Loc_Id']; ?>"><?php echo $row2['Loc_Name']; ?> <span class="txt-blue">(240)</span></label>
										
										</li>
										<!--</a>-->
										<?php } ?>
									</form>
                                    </ul> <a href="javascript:void(0)" class="more-search" data-toggle="modal" data-target="#myModal3">More locations <i class="fa fa-arrow-right" aria-hidden="true"></i> </a> </div>
                                <!-- experience -->
                                <div class="search-section yrs-search">
                                    <h5 class="h5 subtitle-search-section txt-blue">EXPERIENCE <span class="txt-blue">(YEARS)</span></h5>
                                    <div class="input-field">
                                       <form name="" method="post" action="">
                                        <select name="exp" id="exp" onchange="this.form.submit();">
                                            <option value="" disabled selected>Select Experience</option>
                                             <?php for($i=1;$i<=30;$i++){?>
												<option value="<?php echo $i;?>"><?php echo $i;?></option>
											<?php }?>
                                        </select>
									</form>
                                    </div>
                                </div>
                                <!--/ experience -->
                                <!-- search by salary -->
                                <div class="search-section">
                                    <h5 class="h5 subtitle-search-section txt-blue">BY SALARY</h5>
                                    <ul>
                                        <form method="post" name="salss">
									<?php for($i=0;$i<=30;$i=$i+3){ $j=$i+3; ?>
										<li>																				   
											<input type="checkbox" id="test<?php echo $i; ?>-<?php echo $j; ?>" value="<?php echo $i; ?>-<?php echo $j; ?>" name="sals" onclick="this.form.submit();" />
											<label for="test<?php echo $i; ?>-<?php echo $j; ?>"><?php echo $i; ?>-<?php echo $j; ?> LAKHS <span class="txt-blue">(240)</span></label>
										</li>
									<?php }?>										
									</form>
                                    </ul> <a href="javascript:void(0)" class="more-search" data-toggle="modal" data-target="#morepackages">More packages <i class="fa fa-arrow-right" aria-hidden="true"></i> </a> </div>
                                <!-- / search by salary -->                                
                            </div>
                        </div>
                        <!--/ left filters -->
                        <!-- middle list jobs -->
                        <div class="col-md-6">
                            <!-- middle list jobs -->
                            <div class="job-list">
                                <div class="noofjobs brdbg-white">
                                    <p><span class="fbold txt-blue"><?php echo $counts=mysqli_num_rows($resultcj2);		 ?></span> Jobs found in Software Development</p>
                                </div>
                                <!-- job list block -->
								
								
								<?php  if($cc!='0')
                                { while($result_cj2=mysqli_fetch_array($resultcj2))
			                     	{  
                                        
                                        ?> 
                                <div class="brdbg-white list-block">
                                    <div class="row job-title-list">
									<?php $sql2 = "SELECT * FROM tbl_desigination where Desig_Id ='".$result_cj2['Job_Name']."'";
												$query2 = mysqli_query($con, $sql2);
												$row2 = mysqli_fetch_array($query2);?>
                                        <div class="col-md-8"> <a class="txt-blue" href="job-detail-prelogin.php?uid=<?php echo $result_cj2['emp_id'];?>&jid=<?php echo $result_cj2['Job_Id'];?>"><?php echo $row2['Desig_Name'];?> </a> <span><?php echo $result_cj2['Comp_Name'];?></span> </div>
                                        <div class="col-md-4 text-right">
                                            <figure>
                                                <a href="javascript:void(0)"><img src="<?php echo $result_cj2['eLogo'];?>"></a>
                                            </figure>
                                        </div>
                                    </div>
                                    <div class="usermain-features">
                                        <ul>
                                            <li><i class="fa fa-suitcase" aria-hidden="true"></i> <?php echo $result_cj2['Min_Exp'];?>-<?php echo $result_cj2['Max_Exp'];?> Years</li>
                                         <?php    $loc_query="select * from tbl_location where Loc_Id=".$result_cj2['Loc_Id'];  
                                          $loc_res=mysqli_query($con,$loc_query);
                                          $loc_data=mysqli_fetch_array($loc_res); ?>
                                            <li><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $loc_data['Loc_Name'];?></li>
                                            <li><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo $result_cj2['created'];?></li>
                                        </ul>
                                    </div>
                                    <div class=" list-emp-keyskills">
                                        <h6 class="h6">Key Skills</h6>
                                        <?php  $skill_ids=explode(",",$result_cj2['Job_Skill']); ?>

                                        <p> <?php foreach ($skill_ids as $skill_id) {

                                                     $s_query="select skill_Name from tbl_masterskills where skill_Id=".$skill_id;
                                                     $s_res=mysqli_query($con,$s_query);
                                                     $skill_name=mysqli_fetch_array($s_res);
                                                     ?> <span><?php echo $skill_name['skill_Name']; ?> </span><?php
                                                     
                                                   } ?></p>
                                    </div>
                                    <div class="sal-list-details">
                                    <?php    $emp_query="select * from tbll_emplyer where emp_id=".$result_cj2['emp_id'];  
                                          $emp_res=mysqli_query($con,$emp_query);
                                          $emp_data=mysqli_fetch_array($emp_res); ?>

                                        <p>Salary: <?php echo $result_cj2['Sal_Range'];?>,00,000 Lakhs PA <span class="pull-right">Posted by <?php echo $result_cj2['contact_name'];?> </span></p>
                                    </div>
                                </div>
                                <!--/ job list block -->
				<?php } <?php }else { ?>
                           <center>No Jobs</center>
                  <?php   }?>  ?> 
                            </div>
                            <!-- middle list jobs -->
                        </div>
                        <!--/ middle list jobs -->
                        <!-- right block -->
                        <div class="col-md-3">
                            <!-- right block page -->
                            <div class="right-block-list" id="right-list">
                                <!-- email letter-->
                                <div class="email-news brdbg-white">
                                    <h5 class="txt-blue h5">Get email alert for matching jobs</h5>
									<form  name="" method="post" action="subscriberinfo.php">
                                    <div class="mail-input brdbg-white">
                                        <div class="input-field ">
                                            <input name="subcribe-email" id="email-yours" type="text" class="validate" required>
                                            <label   for="email-yours">Enter your email</label>
                                        </div>
										<input type="submit" name="Subs" class="waves-effect waves-light btn btn-blue-sm btn-block" value="Subscribe">
										</div>
									</form>
                                </div>
                                <!--/ email letter-->
                                <!-- jobs with similar skills -->
                                <div class="email-news brdbg-white">
                                    <h5 class="txt-blue h5">Jobs with Similar skills</h5>
                                    <h6 class="h6">Click below here</h6>
                                    <ul class="similar-links-list">
                                       <ul class="similar-links-list">
										<?php $languages=$row['Job_Skills'];
										  $lang_ids =explode(",",$languages);
										  foreach($lang_ids as $lang_id)
										 {
											 $cj2="select * from tbl_jobposted where FIND_IN_SET('".$lang_id."', Job_Skill) "; 			  
											  $resultcj2 = mysqli_query($con,$cj2);  
											  $result_cj2=mysqli_fetch_array($resultcj2); 
											  $skill_ids1[]=$result_cj2['Job_Skill'];
											

										} 
										
										$skill_ids2=implode(",",$skill_ids1);
										$skill_ids3=explode(",",$skill_ids2);
										$skill_ids=array_unique($skill_ids3);										
										 $cc=count(array_filter($skill_ids)); 
										  if($cc!='0')
															{
                               

                                      foreach ($skill_ids as $skill_id) {

                                                     $s_query="select skill_Name from tbl_masterskills where skill_Id=".$skill_id;
                                                     $s_res=mysqli_query($con,$s_query);
                                                     $skill_name=mysqli_fetch_array($s_res);
                                                     ?><li><a href="job-search-results-prelogin1.php?skill_name=<?php echo $skill_name['skill_Name']; ?>"> <?php echo $skill_name['skill_Name']; ?> </a></li><?php
                                                     
                                                   } ?>
								<?php  }?>  
                                    </ul>
                                    </ul>
                                </div>
                                <!-- jobs with similar skills -->
                            </div>
                            <!-- / right block page -->
                        </div>
                        <!--/ right block -->
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
									<?php for($i=30;$i<=75;$i=$i+3){ $j=$i+3; ?>
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
</body>

</html>