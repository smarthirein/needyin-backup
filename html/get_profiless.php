<?php 
session_start();

require_once 'class.user.php';
 $cj21="SELECT Job_Skill,Loc_Id FROM tbl_jobposted WHERE emp_id = '".$_SESSION['empSession']."' and Job_Status=1 "; 
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
		if($_GET['loc_id']!="0")
				{
					$job_ids=[];
            $notice = $_GET['notice'];
			 $loc_id = $_GET['loc_id'];
			 $fre_id = $_GET['fre_id'];
			 $exp = $_GET['exp'];
			$sal = $_GET['sal'];
			$langids = $_GET['skill_ids'];	
			$maxe=$_GET['max_exp'];	$mine=$_GET['min_exp'];			
			$language_ids=explode(",",$langids);
            $language_ids=explode(",",$_GET['skill_ids']);           
			//print_r($language_ids);
              foreach($language_ids as $lang_id)
                     {
                     $cj22l="select J.JUser_Id from tbl_jobseeker J JOIN tbl_currentexperience Jd ON J.JUser_Id = Jd.JUser_Id INNER JOIN tbl_recent_views rv on rv.userid = J.JUser_Id where FIND_IN_SET('".$lang_id."', J.Job_Skills)  AND J.JPLoc_Id='".$loc_id."' AND J.JuserStatus='A' AND jdndstatus='0'";
           
						  if($exp !="" || $exp !=0){
						$cj22l.=" AND J.JTotalEy>='".$exp."'";                          
						  }else if(($mine =="" || $mine =="0") &&($maxe =="" || $maxe =="0")){
							  $cj22l.=" ";
						  }else{
							  $cj22l.=" AND (JTotalEy between '$mine' and '$maxe')";
						  }
						  if($sal!="" || $sal !=0)
						  {
							 $cj22l.=" AND Jd.ExpSalL >= '".$sal."'";
						  } 														
						  if($notice!="" || $notice !=0)
						  {
							  
							  $cj22l.=" AND Jd.NoticePeriod ='".$notice."'";
						  }
						   if($fre_id!="" || $fre_id !=0)
						  {
							 $cj22l.=" AND rv.`Date&time` >= DATE_SUB(CURDATE(), INTERVAL '".$fre_id."' DAY) AND rv.empid=0";
						  } 
						 // echo $cj22l;
						  $resultcj22 = mysqli_query($con,$cj22l); 
						  
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
			$job_ids=[];
          $notice = $_GET['notice'];
			 $loc_id = $_GET['loc_id'];
		 $exp = $_GET['exp'];
			$sal = $_GET['sal'];
			$fre_id = $_GET['fre_id'];
			 $langids = $_GET['skill_ids'];		
			$language_ids=explode(",",$langids);
$maxe=$_GET['max_exp'];	$mine=$_GET['min_exp'];				
			
              $language_ids=explode(",",$_GET['skill_ids']);
           
              foreach($language_ids as $lang_id)
                     {
                      $cj22e="select J.JUser_Id from tbl_jobseeker J JOIN tbl_currentexperience Jd ON J.JUser_Id = Jd.JUser_Id INNER JOIN tbl_recent_views rv on rv.userid = J.JUser_Id where FIND_IN_SET('".$lang_id."', J.Job_Skills) AND J.JTotalEy>='".$_GET['exp']."' AND J.JuserStatus='A' AND jdndstatus='0'"; 
                         
						  if($loc_id !=0){
						 $cj22e.=" AND J.JPLoc_Id='".$loc_id."'";                          
						  }														 
						  if($sal!="" || $sal !=0)
						  {
						 $cj22e.=" AND Jd.ExpSalL >= '".$sal."'";
						  } 														
						  if($notice!="" || $notice !=0)
						  {
						
							  $cj22e.=" AND Jd.NoticePeriod ='".$notice."'";
						  }
						   if($fre_id!="" || $fre_id !=0)
						  {
							$cj22e.=" AND rv.`Date&time` >= DATE_SUB(CURDATE(), INTERVAL '".$fre_id."' DAY) AND rv.empid=0";
						  } 
							//echo $cj22e;			  
						 $resultcj22 = mysqli_query($con,$cj22e);  
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
			$job_ids=[];
           $notice = $_GET['notice'];
								 $loc_id = $_GET['loc_id'];
								$exp = $_GET['exp'];
								 $sal = $_GET['sal'];
								 $fre_id = $_GET['fre_id'];
								 $langids = $_GET['skill_ids'];		
								$language_ids=explode(",",$langids);
$maxe=$_GET['max_exp'];	$mine=$_GET['min_exp'];									
								$str1=explode(",",$notice);
              $language_ids=explode(",",$_GET['skill_ids']);
           
              foreach($language_ids as $lang_id)
                     {
                  $cj22s="select J.JUser_Id from tbl_jobseeker J JOIN tbl_currentexperience Jd ON J.JUser_Id = Jd.JUser_Id INNER JOIN tbl_recent_views rv on rv.userid = J.JUser_Id where FIND_IN_SET('".$lang_id."', J.Job_Skills) AND (Jd.ExpSalL >= '".$_GET['sal']."' ) AND J.JuserStatus='A' AND jdndstatus='0'"; 
						 if($loc_id !=0){
							 $cj22s.=" AND J.JPLoc_Id='".$loc_id."'";                          
							  }
							  if($exp !="" || $exp !=0){
							 $cj22s.=" AND J.JTotalEy>='".$exp."'";                          
							  }else if(($mine =="" || $mine =="0") &&($maxe =="" || $maxe =="0")){
							 $cj22s.=" ";
						  }else{
							  $cj22s.=" AND (JTotalEy between '$mine' and '$maxe')";
						  }
																					
							  if($notice!="" || $notice !=0)
							  {
							
							  $cj22s.=" AND Jd.NoticePeriod ='".$notice."'";
							  }	
						if($fre_id!="")
						  {
							 $cj22s.=" AND rv.`Date&time` >= DATE_SUB(CURDATE(), INTERVAL '".$fre_id."' DAY) AND rv.empid=0";
						  } 	
						//  echo $cj22s;
							$resultcj22 = mysqli_query($con,$cj22s); 							  
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
			$job_ids=[];
            $notice = $_GET['notice'];
			$loc_id = $_GET['loc_id'];
			$exp = $_GET['exp'];
			$sal = $_GET['sal'];
			$langids = $_GET['skill_ids'];	
			$maxe=$_GET['max_exp'];
			$mine=$_GET['min_exp'];		
			$fre_id = $_GET['fre_id'];			
			$languageids=explode(",",$langids);
              foreach($languageids as $lang_id)
                { 
				
				$cj22n="select J.JUser_Id from tbl_jobseeker J JOIN tbl_currentexperience Jd ON J.JUser_Id = Jd.JUser_Id INNER JOIN tbl_recent_views rv on rv.userid = J.JUser_Id where FIND_IN_SET('".$lang_id."', J.Job_Skills) and J.JuserStatus='A' AND jdndstatus='0' and (Jd.NoticePeriod ='".$notice."')";
                 if($loc_id !=0 || $loc_id !=""){
					 $cj22n.=" AND J.JPLoc_Id='".$loc_id."'";                          
						  }
						  if($exp !="" || $exp !=0){
						 $cj22n.=" AND J.JTotalEy>='".$exp."'";                          
						  }else if(($mine =="" || $mine =="0") &&($maxe =="" || $maxe =="0")){
							  $cj22n.=" ";
						  }else{
							 $cj22n.=" AND (JTotalEy between '$mine' and '$maxe')";
						  }
						  if($sal!="" || $sal !=0)
						  {
							  $cj22n.=" AND Jd.ExpSalL >= '".$sal."'";
						  } 														
						   if($fre_id!="" || $fre_id !=0)
						  {
							 $cj22n.=" AND rv.`Date&time` >= DATE_SUB(CURDATE(), INTERVAL '".$fre_id."' DAY) AND rv.empid=0";
						  } 
					  //echo  $cj22n;
						$resultcj22n = mysqli_query($con,$cj22n);  
                          while($result_cj22n=mysqli_fetch_array($resultcj22n))
                          {  
                            $jobidsn[]=$result_cj22n['JUser_Id'];
							
                           }
                     }
 					 
                $job_ids=array_filter(array_unique($jobidsn));
				
                $cc=count(array_filter($job_ids)); 
                                                  
        }
		 if($_GET['fre_id']!="")
        {
			 $job_ids=[];
			$fre_id = $_GET['fre_id'];
        $notice = $_GET['notice'];
			$loc_id = $_GET['loc_id'];
			$exp = $_GET['exp'];
			$sal = $_GET['sal'];
			$langids = $_GET['skill_ids'];	
			$maxe=$_GET['max_exp'];
			$mine=$_GET['min_exp'];									
			$languageids=explode(",",$langids);
            foreach($languageids as $lang_id)
                {  			
					// $cj22n="select J.JUser_Id from tbl_jobseeker J JOIN tbl_currentexperience Jd ON J.JUser_Id = Jd.JUser_Id where FIND_IN_SET('".$lang_id."', J.Job_Skills) AND (J.currentdate >= DATE_SUB(CURDATE(), INTERVAL '".$fre_id."' DAY)) and J.JuserStatus='A'  AND jdndstatus='0' ";
					$cj22f="select J.JUser_Id from tbl_jobseeker J JOIN tbl_currentexperience Jd ON J.JUser_Id = Jd.JUser_Id INNER JOIN tbl_recent_views rv on rv.userid = J.JUser_Id where FIND_IN_SET('".$lang_id."', J.Job_Skills) AND (rv.`Date&time` >= DATE_SUB(CURDATE(), INTERVAL '".$fre_id."' DAY)) and J.JuserStatus='A'  AND jdndstatus='0' AND rv.empid=0";
					if($loc_id !=0){
							 $cj22f.=" AND J.JPLoc_Id='".$loc_id."'";                          
									}
						  if($exp !="" || $exp !=0){
							 $cj22f.=" AND J.JTotalEy>='".$exp."'";                          
						  }
						 
						  if($notice!="" || $notice !=0)
							  {							
							 $cj22f.=" AND Jd.NoticePeriod ='".$notice."'";
							  }	
						  else if(($mine =="" || $mine =="0") &&($maxe =="" || $maxe =="0")){
							  $cj22f.=" ";	
							  }
						  else
						  {
							 $cj22f.=" AND (JTotalEy between '$mine' and '$maxe')";
						  }
						  if($sal!="" || $sal !=0)
						  {
							 $cj22f.=" AND Jd.ExpSalL >= '".$sal."'";
						  } 
						  $cj22f.=" Order by rv.`Date&time` DESC";
						//echo $cj22f;
						$resultcj22n = mysqli_query($con,$cj22f);  
                        while($result_cj22n=mysqli_fetch_array($resultcj22n))
                          {  
                            $jobidsn[]=$result_cj22n['JUser_Id'];							
                           }
                     } 					 
                $job_ids=array_filter(array_unique($jobidsn));				
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
                                        ?> 
                                <div class="brdbg-white list-block row">                                   
                                    <div class="">
                                        <div class="col-md-2">
                                            <figure class="js-list-pic">
                                                <a href="jobseeker-detail-recruiter.php?uid=<?php echo $rowview2['JUser_Id'] ?>">
												 <img class="img-cover" style="position:relative !important;" data-object-fit="cover" src="<?php if($rowview2['JPhoto']){  echo $rowview2['JPhoto']; }else if($rowview2['Gender']=="Male") {?>img/js-profile-list-pic.jpg <?php } else {?>img/female.png <?php }?>" >
												</a>
                                            </figure>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="jobseeker-detail-recruiter.php?uid=<?php echo $rowview2['JUser_Id'] ?>" class="name">
                                                <h4 class="h4 txt-blue"><?php echo $rowview2['JFullName']; ?></h4>
                                                <h5><?php echo $rowview2['Des']; ?></h5>
                                                <p><?php echo $rowview2['Company_Name']; ?></p>
                                            </a> <span class="notice-list"><?php //echo $row2['NoticePeriod']; ?><?php if($row2['NoticePeriod']=='1'){echo "Immediate";}else {echo $row2['NoticePeriod']." days Notice"; } ?> </span>
											 <span class="notice-list tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?php echo $rowview2['jReasonType'];?> " style="font-size:10px;">Reason:<?php  $reason = substr($rowview2['jReasonType'], 0, 10);if(strlen($reason)<10){echo $reason ;}else{echo $reason."...";}?> </span> 												
											<p class="profile-action">
											<?php $query11s="select count(JUser_Id) as ids FROM tbl_employerview where JUser_Id='".$row2['JUser_Id']."' and  emp_id='".$_SESSION['empSession']."'";
									$qu_ress=mysqli_query($con,$query11s);
									$ress = mysqli_fetch_array($qu_ress);if($ress['ids'] !=0){?>
									<?php if (in_array($row2['JUser_Id'], $c_ids)) {?>
							 <span> <a  href="jobseeker-detail-recruiter.php?uid=<?php echo $row2['JUser_Id'] ?>&pgid=1"><i class="fa fa-exchange" aria-hidden="true"></i> </a> </span>
							<?php } ?>
					 <span><a  href="jobseeker-detail-recruiter.php?uid=<?php echo $row2['JUser_Id'] ?>&pgid=6"><i class="fa fa-eye" aria-hidden="true"></i></a> </span>
					<?php }
					 $short_id="select count(JUser_Id) as sid FROM tbl_shortlisted where JUser_Id='".$row2['JUser_Id']."' and  emp_id='".$_SESSION['empSession']."'";
									$s_id=mysqli_query($con,$short_id);
									$short_res = mysqli_fetch_array($s_id);if($short_res['sid'] !=0){?>
					 <span><a  href="dbrecruiter-profles-shortlist.php"><i class="fa fa-heart" aria-hidden="true"></i> </a> </span>
					<?php }
					 $sche_id="select count(juser_id) as scheid FROM interviewscheduled where juser_id='".$row2['JUser_Id']."' and  emp_id='".$_SESSION['empSession']."'";
									$sc_id=mysqli_query($con,$sche_id);
									$sche_res = mysqli_fetch_array($sc_id);if($sche_res['scheid'] !=0){?>
					<span><a  href="dbrecruiter-sche-int.php"><i class="fa fa-calendar" aria-hidden="true"></i> </a></span>
					<?php }
					?>
					</p>
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

												<p class="skills-js-list"> 
													<?php foreach ($skill_ids as $skill_id) 
													{
														$s_query="select skill_Name from tbl_masterskills where skill_Id=".$skill_id;
														$s_res=mysqli_query($con,$s_query);
														$skill_name=mysqli_fetch_array($s_res);
														?>
														<span><?php echo $skill_name['skill_Name']; ?> </span>
														<?php														 
													} 
														   ?>
												</p>
												</div>
											</div>                                  
                                        </div>
                                    </div>                               
                                   
                                </div>
                                <?php } 
                                } ?>