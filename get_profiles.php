 <?php 
require_once 'class.user.php';
if($_GET['loc_id']!='0')
        {
            $notice = $_GET['notice'];
			 $loc_id = $_GET['loc_id'];
			 $exp = $_GET['exp'];
			$sal = $_GET['sal'];
			$langids = $_GET['skill_ids'];		
			$language_ids=explode(",",$langids);								
			
              $language_ids=explode(",",$_GET['skill_ids']);
              foreach($language_ids as $lang_id)
                     {
                    $cj22="select J.JUser_Id from tbl_jobseeker J JOIN tbl_currentexperience Jd ON J.JUser_Id = Jd.JUser_Id where FIND_IN_SET('".$lang_id."', J.Job_Skills)  AND J.JPLoc_Id='".$loc_id."' AND J.JuserStatus='A' AND jdndstatus='0'";
						  if($exp !="" || $exp !=0){
						 $cj22.=" AND J.JTotalEy>='".$exp."'";                          
						  }
						  if($sal!="" || $sal !=0)
						  {
							 $cj22.=" AND Jd.ExpSalL >= '".$sal."'";
						  } 														
						  if($notice!="" || $notice !=0)
						  {
							 
							  $cj22.=" AND Jd.NoticePeriod='".$notice."'";
						  }
						  $resultcj22 = mysqli_query($con,$cj22); 
						  
                          while($result_cj22=mysqli_fetch_array($resultcj22))
                          {  
                             $jobids[]=$result_cj22['JUser_Id'];
                           }
                     } 
                $job_ids=array_filter(array_unique($jobids));
                $cc=count(array_filter($job_ids)); 
        }
if($_GET['exp']!="")
        {
          $notice = $_GET['notice'];
			 $loc_id = $_GET['loc_id'];
		 $exp = $_GET['exp'];
			$sal = $_GET['sal'];
			 $langids = $_GET['skill_ids'];		
			$language_ids=explode(",",$langids);								
			
              $language_ids=explode(",",$_GET['skill_ids']);
              foreach($language_ids as $lang_id)
                     {
                      $cj22="select J.JUser_Id from tbl_jobseeker J JOIN tbl_currentexperience Jd ON J.JUser_Id = Jd.JUser_Id where FIND_IN_SET('".$lang_id."', J.Job_Skills) AND J.JTotalEy >= '".$_GET['exp']."' AND J.JuserStatus='A' AND jdndstatus='0'"; 
                         
						  if($loc_id !=0){
						$cj22.=" AND J.JPLoc_Id='".$loc_id."'";                          
						  }														 
						  if($sal!="" || $sal !=0)
						  {
							$cj22.=" AND Jd.ExpSalL >= '".$sal."'";
						  } 														
						  if($notice!="" || $notice !=0)
						  {
							
							$cj22.=" AND Jd.NoticePeriod='".$notice."'";
						  }
														  
						 $resultcj22 = mysqli_query($con,$cj22);  
                          while($result_cj22=mysqli_fetch_array($resultcj22))
                          {  
                             $jobids[]=$result_cj22['JUser_Id'];
                           }
                     } 
                $job_ids=array_filter(array_unique($jobids));
                $cc=count(array_filter($job_ids)); 
                                                  
        }
      if($_GET['sal']!="")
        {
           $notice = $_GET['notice'];
								 $loc_id = $_GET['loc_id'];
								$exp = $_GET['exp'];
						 $sal = $_GET['sal'];
								 $langids = $_GET['skill_ids'];		
								$language_ids=explode(",",$langids);								
							
              $language_ids=explode(",",$_GET['skill_ids']);
           
              foreach($language_ids as $lang_id)
                     {
                  $cj22="select J.JUser_Id from tbl_jobseeker J JOIN tbl_currentexperience Jd ON J.JUser_Id = Jd.JUser_Id where   FIND_IN_SET('".$lang_id."', J.Job_Skills) AND (Jd.ExpSalL >= '".$_GET['sal']."' ) and J.JuserStatus='A' AND jdndstatus='0'"; 
						 if($loc_id !=0){
							$cj22.=" AND J.JPLoc_Id='".$loc_id."'";                          
							  }
							  if($exp !="" || $exp !=0){
							$cj22.=" AND J.JTotalEy>='".$exp."'";                          
							  }
																					
							  if($notice!="" || $notice !=0)
							  {
						
							$cj22.=" AND Jd.NoticePeriod='".$notice."'";
							  }		
							$resultcj22 = mysqli_query($con,$cj22); 							  
                          while($result_cj22=mysqli_fetch_array($resultcj22))
                          {  
                             $jobids[]=$result_cj22['JUser_Id'];
                           }
                     } 
                $job_ids=array_filter(array_unique($jobids));
                $cc=count(array_filter($job_ids)); 
        }
      if($_GET['notice']!="")
        {
             $notice = $_GET['notice'];
								$loc_id = $_GET['loc_id'];
								$exp = $_GET['exp'];
								$sal = $_GET['sal'];
								$langids = $_GET['skill_ids'];		
								$language_ids=explode(",",$langids);								
							
                  $language_ids=explode(",",$_GET['skill_ids']);
           
              foreach($language_ids as $lang_id)
                     {
               
 $cj22="select J.JUser_Id from tbl_jobseeker J JOIN tbl_currentexperience Jd ON J.JUser_Id = Jd.JUser_Id where FIND_IN_SET('".$lang_id."', J.Job_Skills)  and J.JuserStatus='A' AND jdndstatus='0' and Jd.NoticePeriod ='".$notice."' ";			   
                      if($loc_id !=0){
						$cj22.=" AND J.JPLoc_Id='".$loc_id."'";                          
						  }
						  if($exp !="" || $exp !=0){
						 $cj22.=" AND J.JTotalEy>='".$exp."'";                          
						  }
						  if($sal!="" || $sal !=0)
						  {
							   $cj22.=" AND Jd.ExpSalL >= '".$sal."'";
						  } 														
						  
						 $resultcj22 = mysqli_query($con,$cj22);  
                          while($result_cj22=mysqli_fetch_array($resultcj22))
                          {  
                             $jobids[]=$result_cj22['JUser_Id'];
                           }
                     } 
                $job_ids=array_filter(array_unique($jobids));
                $cc=count(array_filter($job_ids)); 
        }
   
?>
<div class="noofjobs brdbg-white">
                                <?php 
                                if($cc!="") { ?>
                                    <p> Showing <span class="fbold txt-blue"> <?php echo $cc; ?> </span>Jobseeker Profile Found </p>
                                    <?php } else { ?>
                                    <p><span class="fbold txt-blue"></span> No Job Seekers Found </p>
                                    <?php } ?>
                                </div>
 <?php 
                                if($cc!='0')
                                {
                                   
                                foreach($job_ids as $jobs_id)
                                    {  
                                        $sql="select * from  tbl_jobseeker  where JUser_Id=".$jobs_id;
                                        $sql_res=mysqli_query($con,$sql);
                                        $rowview2=mysqli_fetch_array($sql_res);
										
										$sql2="select * from  tbl_currentexperience  where JUser_Id=".$jobs_id;
                                        $sql_res2=mysqli_query($con,$sql2);
                                        $row2=mysqli_fetch_array($sql_res2);
											
                                         $sql3="select Qual_Name from  tbl_qualification  where Qual_Id in(select Qual_Id from  tbl_education  where JUser_Id='$jobs_id')";
                                         $sql_res3=mysqli_query($con,$sql3);
                                         $row3=mysqli_fetch_array($sql_res3);
										 $jnames=explode(" ",$rowview2['JFullName']);
                                        ?> 

                                <div class="brdbg-white list-block row">
                                  
                                    <div class="">
                                        <div class="col-md-2">
                                            <figure class="js-list-pic">
                                             <img class="img-cover" style="position:relative !important;" data-object-fit="cover" src="<?php if($rowview2['JPhoto']){  echo $rowview2['JPhoto']; }else if($rowview2['Gender']=="Male") {?>img/js-profile-list-pic.jpg <?php } else {?>img/female.png <?php }?>" >
                                            </figure>
                                        </div>
                                        <div class="col-md-4">
                                         
                                           <a href="javascript:confirm('Please Login to View Profile Details', '', modernAlertCallback);" class="names">
                                                <h4 class="h4 txt-blue"><?php echo $jnames[0];?></h4>
                                                <h5><?php echo $rowview2['Des']; ?></h5>
                                                <p><?php echo $rowview2['Company_Name']; ?></p>
                                            </a> <span class="notice-list"><?php if($row2['NoticePeriod']=='1'){echo "Immediate";}else {echo $row2['NoticePeriod']." days Notice"; }?>  </span>
                                        </div>
                                        <div class="col-md-6">
                                            <table width="100%" cellpadding="0" cellspacing="0" class="list-table">
                                                <tr>
                                                    <td><i class="fa fa-graduation-cap" aria-hidden="true"></i></td>
                                                    <td> Education</td>
                                                    <td><?php echo $row3['Qual_Name']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-user-o" aria-hidden="true"></i></td>
                                                    <td> Experience</td>
                                                    <td><?php echo $rowview2['JTotalEy']."    "; ?>Years         - <?php echo $rowview2['JTotalEm']." "; ?> Months</td>
                                                </tr>
                                                <tr>
                                                     <td> <i class="fa fa-inr" aria-hidden="true"></i></td>
                                                    <td>Exp CTC (Lacs)</td>
                                                    <td>Min: <?php echo $row2['ExpSalL'];?> - Max: <?php echo $row2['ExpMaxSalL'];?></td>
                                                </tr>
                                            </table>
                                           
                                    <div class="skills-tab">
                                        <div class="col-md-12">
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
                                 
                                        </div>
                                    </div>
                                  
                                   
                                </div>
                                <?php } 
                                } ?>