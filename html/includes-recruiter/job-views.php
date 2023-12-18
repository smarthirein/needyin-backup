<!-- block -->
	<?php if($count ==0){ ?>
	
	<div class="noprofiles-available text-center">
<h3 class="h3">Sorry we couldn't find any matches </h3>
<figure><img src="img/nofound.svg"></figure>
</div>
	
	<?php } else	{ while ($row2 = mysqli_fetch_assoc($resultv1)) { ?>
    <div class="mb15">
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
                    <a href="jobseeker-detail-recruiter.php?uid=<?php echo $row2['JUser_Id'] ?>&pgid=5" class="name">
                        <h4 class="h4 txt-blue"><?php echo $row2['JFullName']; ?></h4>
                        <h5><?php echo $row2['Des']; ?></h5>
                        <p><?php echo $row2['Company_Name']; ?></p>
                    </a> <span class="notice-list"><?php if($row2['NoticePeriod']=='1'){echo "Immediate";}else {echo $row2['NoticePeriod']." days"; }?>  Notice</span>
                    <!-- shortlisted for job highlet-->
                    <div class="form-group profile-drop">
                        <label>Job Viewed For </label> 
						
						<?php $sql2 = "SELECT * FROM tbl_desigination where Desig_Id ='".$row2['Job_Name']."'";
												$query2 = mysqli_query($con, $sql2);
												$row3 = mysqli_fetch_array($query2);?><?php echo $row3['Desig_Name']; ?>
					
						         <?php
									$sql4 = "SELECT * FROM tbl_jobseekerview WHERE emp_id='".$row2['emp_id']."' and JUser_Id='".$row2['JUser_Id']."'Group By job_id"; 
									$query4 = mysqli_query($con, $sql4);
									if(!$query4)
									echo mysqli_error($con);
									?>
                                    <select class="form-control classic" data-live-search="true" data-show-subtext="true" onchange="return scheduledjobs_list(this.value,'<?php echo $row2['JUser_Id']?>','<?php echo $row2['emp_id']?>');">
									<option value="0" selected="selected" disabled>Select Job Name</option>
                                     <?php
									while ($row4 = mysqli_fetch_array($query4))
									{ 
									 extract($row4);
									?>
									<?php 
									$sql2 = "SELECT * FROM tbl_jobposted where emp_id='".$row2['emp_id']."' and Job_Id ='".$job_id."'";
												$query2 = mysqli_query($con, $sql2);
												$row3 = mysqli_fetch_array($query2);?><?php echo $row3['Job_Name']; 
									$sqlj = "SELECT * FROM tbl_desigination where Desig_Id ='".$row3['Job_Name']."'";
												$queryj = mysqli_query($con, $sqlj);
												$rowj = mysqli_fetch_array($queryj);?><?php echo $rowj['Desig_Name'];																																			
									?>
									<option value="<?php echo $job_id; ?>" data-subtext="<?php echo $rowj['Desig_Name']; ?>"><?php echo $rowj['Desig_Name']; ?></option>
                                    <?php } ?>
                                    </select>
                    </div>
				</div>
            </div>
            </div>
            <div class="col-md-7 col-sm-12">
                 <!--/ job seekers block top results -->
            <div class="row">
                <div class="col-md-12">
                    <table width="100%" cellpadding="0" cellspacing="0" class="list-table">
                        <tr>
                            <td><i class="fa fa-black-tie" aria-hidden="true"></i></td>
                            <td class="grtxt">Prof. Experience </td>
                            <td><?php echo $row2['JTotalEy']; ?> Years - <?php echo $row2['JTotalEm']; ?> Months</td>
                            <td><i class="fa fa-map-marker" aria-hidden="true"></i></td>
                            <td class="grtxt"> Preferred Location </td>
                            <td><?php echo $row2['Loc_Name']; ?></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-inr" aria-hidden="true"></i></td>
                            <td class="grtxt"> Current CTC (Lacs)</td>
                            <td><?php echo $row2['CurrentSalL']; ?>  </td>
                            <td><i class="fa fa-inr" aria-hidden="true"></i></td>
                            <td class="grtxt">Exp CTC (Lacs)</td>
                            <td>Min: <?php echo $row2['ExpSalL']; ?> - Max: <?php echo $row2['ExpMaxSalL']; ?></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-graduation-cap" aria-hidden="true"></i></td>
                            <td class="grtxt"> Education </td>
                            <td><?php echo $row2['Qual_Name']; ?></td>
                            <td><i class="fa fa-calendar" aria-hidden="true"></i></td>
                            <td class="grtxt"> Viewed On</td>
                            <td>
								
								<div class="form-group">
									<select class="form-control classic" id="dates_list<?php echo $row2['JUser_Id'];?>" data-live-search="true" data-show-subtext="true">
									<option value="0" selected="selected" disabled>Viewed Date</option>
									</select>
								</div>
									
							
							</td>
                        </tr>
                    </table>
                     <!-- job seekers skills bottom -->
            <div class="skills-tab nopad-top">
                <div class="col-md-12">
                    <h6 class="h6">Skills</h6><p class="skills-js-list">
					<?php 
                      $skill_ids=explode(",",$row2['Job_Skills']); 
                       foreach ($skill_ids as $skill_id) {

                             $s_query="select skill_Name from tbl_masterskills where skill_Id=".$skill_id;
                             $s_res=mysqli_query($con,$s_query);
                             $skill_name=mysqli_fetch_array($s_res);
                             ?> <span><?php echo $skill_name['skill_Name']; ?> </span><?php
                                                     
                        } ?>

                 
					 </p>
                </div>
            </div>
            <!--/ job seekers skills bottom -->  
                </div>
                
                 
                
            
            </div>
            
            </div>
            
        
        </div>
    </div>
	<?php  }} ?>
	<?php if($count >=10){ ?>
	<form method="post" action="job-viewed.php">
	<input type="submit" name="Subs" class="btn waves-effect waves-light fbold text-center waves-input-wrapper" value="Load More">
	</form>
	<?php } ?>
	<script>
 function scheduledjobs_list(job_id,juser_id,emp_id)
{
	//alert(emp_id);
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
        document.getElementById("dates_list"+juser_id).innerHTML=xmlhttp.responseText;
        }
      }
    xmlhttp.open("GET","getJobviewed.php?JobId="+job_id+"&JuserId="+juser_id+"&EmpId="+emp_id,true);
    xmlhttp.send();
}
</script>
