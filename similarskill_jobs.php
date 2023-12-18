<?php require_once 'class.user.php';
include "source.php";

        if($_GET['skill_id']!="")
        {
           
                        $cj22="select Job_Id from tbl_jobposted where Loc_Id='".$_GET['loc_id']."' and Job_Status='1' and FIND_IN_SET('".$_GET['skill_id']."', Job_Skill) and adm_status='A' ORDER BY Job_Id"; 
                          $resultcj22 = mysqli_query($con,$cj22);  
                          while($result_cj22=mysqli_fetch_array($resultcj22))
                          {  
                             $jobids[]=$result_cj22['Job_Id'];
                           }
                     
                $job_ids=array_filter(array_unique($jobids));
                $cc=count(array_filter($job_ids)); 
                                                  
        }
?>

                                <div class="noofjobs brdbg-white">
                                    <p><span class="fbold txt-blue"><?php echo $cc;?></span> Jobs found </p>
                                </div>
                               
                            
                                <?php  
                                if($cc!='0')
                                {
                                foreach($job_ids as $job_id)
                                    {  
                                          $j_query="select * from tbl_jobposted where Job_Id=".$job_id;  
                                          $j_res=mysqli_query($con,$j_query);
                                          $j_data=mysqli_fetch_array($j_res);

                                           $j_query1="select * from tbll_emplyer where emp_id='".$j_data['emp_id']."' ";  
                                          $j_res1=mysqli_query($con,$j_query1);
                                          $j_data1=mysqli_fetch_array($j_res1);
                                        ?> 
                                <div class="brdbg-white list-block">
                                    <div class="row job-title-list">
									<?php $sql2 = "SELECT * FROM tbl_desigination where Desig_Id ='".$j_data['Job_Name']."'";
												$query2 = mysqli_query($con, $sql2);
												$row2 = mysqli_fetch_array($query2);?>
                                        <div class="col-md-9"> <a class="txt-blue" href="latest_jobdetail.php?uid=<?php echo $j_data['emp_id'];?>&jid=<?php echo $j_data['Job_Id'];?>"><?php echo $row2['Desig_Name'];?> 
                                           <?php
                                              $sche_id="select count(JUser_Id) as appliedId FROM tbl_applied where JUser_Id='".$_SESSION['userSession']."' and  JobId='".$job_id."'";
                                              $sc_id=mysqli_query($con,$sche_id);
                                              $sche_res = mysqli_fetch_array($sc_id);
                                              if($sche_res['appliedId'] !=0){?>
                                                 <span class="green-tag"> Applied</span> 
                                              <?php } 
                                              else {
                                                     $jobViewed="select count(JUser_Id) as viewJob FROM tbl_jobseekerview where JUser_Id='".$_SESSION['userSession']."' and  job_id='".$job_id."'";
                                                      $viewedId=mysqli_query($con,$jobViewed);
                                                      $viewedCount = mysqli_fetch_array($viewedId);
                                                      if($viewedCount['viewJob'] !=0){?>
                                                       <span class="viewed-rec">Viewed</span>
                                                    <?php }
                                               } ?>   
                                        </a> <span><?php echo $j_data['Comp_Name'];?></span>
                                         <div class="usermain-features">
                                        <ul>
                                            <li><i class="fa fa-suitcase" aria-hidden="true"></i> <?php echo $j_data['Min_Exp'];?>-<?php echo $j_data['Max_Exp'];?> Years</li>
                                         <?php    $loc_query="select * from tbl_location where Loc_Id=".$j_data['Loc_Id'];  
                                          $loc_res=mysqli_query($con,$loc_query);
                                          $loc_data=mysqli_fetch_array($loc_res); ?>
                                            <li><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $loc_data['Loc_Name'];?></li>
                                            <li><i class="fa fa-calendar" aria-hidden="true"></i> <?php $dateb=date_create($j_data['created']); echo $dob= date_format($dateb,"M d,Y")?></li>
                                        </ul>
                                    </div>
                                          </div>
                                        <div class="col-md-3 text-right">
                                            <figure class="prelogo">
                                               <?php if($j_data1['eLogo']!="") { ?> 
                                                    <img class="img-contain" data-object-fit="contain" src="<?php echo $j_data1['eLogo'];?>"> <?php } else { ?>
                                                     <img class="img-contain" data-object-fit="contain" src="img/your-logo.png">
                                                    <?php } ?>
                                            </figure>
                                        </div>
                                    </div>
                                   
                                    <div class=" list-emp-keyskills">
                                        <h6 class="h6">Key Skills</h6>
                                        <?php  $skill_ids=explode(",",$j_data['Job_Skill']); ?>

                                        <p> <?php foreach ($skill_ids as $skill_id) {

                                                     $s_query="select skill_Name from tbl_masterskills where skill_Id=".$skill_id;
                                                     $s_res=mysqli_query($con,$s_query);
                                                     $skill_name=mysqli_fetch_array($s_res);
                                                     ?> <span><?php echo $skill_name['skill_Name']; ?> </span><?php
                                                     
                                                   } ?></p>
                                    </div>
														
                                    <div class="sal-list-details">
                                    <?php    $emp_query="select * from tbll_emplyer where emp_id=".$j_data['emp_id'];  
                                          $emp_res=mysqli_query($con,$emp_query);
                                          $emp_data=mysqli_fetch_array($emp_res); ?>

                                       <p><b>CTC (Lacs) : </b>Min: <?php echo $j_data['Sal_Range']; ?> - Max: <?php echo $j_data['MSal_Range']; ?>
                                        <?php if($j_data['notshow_jobseeker']==0) { ?>
                                          <span class="pull-right " title="Email:<?php echo $emp_data['emp_email']."&nbsp; Contact No:".$emp_data['contact_num'];  ?>"><b>Posted by : </b> <?php echo $emp_data['contact_name'];?> 
                                          </span>
                                          <?php } else { ?>
                                          <span class="pull-right" ><b>Posted by : </b> Confidential  </span>
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
								
                                </div>
                            
                            <?php } 
                            } 
                         
                                    ?>
                          